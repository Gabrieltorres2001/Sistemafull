<?php
/**
 * En el archivo php.ini se deben habilitar las siguientes extensiones
 *
 * extension=php_openssl (.dll / .so)
 * extension=php_soap    (.dll / .so)
 *
 */
 
//------------
//274
//------------ 
//Creamos la conexión
	include_once '../../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");

//Busco el CUIT del cliente	
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select NonmbreEmpresa, NumeroComprobante from comprobantes where TipoComprobante=3 and IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
		$reg = mysqli_fetch_array($resultComprobante); 
		
		//Agrego un intermedio con el cambio de la tabla contactos a contactos2
		if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regContEmp = mysqli_fetch_array($resultContEmp);
		
		if(!$resultEmp = mysqli_query($conexion_sp, "select CUIT from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
		$regEmp = mysqli_fetch_array($resultEmp);

error_reporting(E_ALL);
ini_set('display_errors','Yes');

//Cargando archivo de configuracion
include_once "../config.php";
include_once LIB_PATH."functions.php";

//Cargando modelos de conexion a WebService
include_once MDL_PATH."AfipWsaa.php";
include_once MDL_PATH."AfipWsfev1.php";


//Datos correspondiente a la empresa que emite la factura
    //CUIT (Sin guiones)
	//BUSCO miCuit EN CONTROLPANEL.
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miCuit' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
    $empresaCuit = str_replace("-","", $rowresultDatosAux['ContenidoValor']);
    //El alias debe estar mencionado en el nombre de los archivos de certificados y firmas digitales
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'empresaAlias' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
    $empresaAlias = $rowresultDatosAux['ContenidoValor'];
	//BUSCO miPuntoVenta EN CONTROLPANEL.
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
	$PtoVta=$rowresultDatosAux['ContenidoValor'];
	//Defino el numero de comprobante a enviar a la AFIP
	if ($_REQUEST['tipoFactura']=="A"){
		if ($_REQUEST['tipoComprobante']=="FC"){$CbteTipo=1;}
			else {if($_REQUEST['tipoComprobante']=="NC"){$CbteTipo=3;}
	else {$CbteTipo=2;}}}
	if ($_REQUEST['tipoFactura']=="B"){
		if ($_REQUEST['tipoComprobante']=="FC"){$CbteTipo=6;}
			else {if($_REQUEST['tipoComprobante']=="NC"){$CbteTipo=8;}
	else {$CbteTipo=7;}}}
	


//Obtener los datos de la factura que se desea generar
//    if ($_REQUEST['ref']=='tipo_a')
//        include "data/TestRegistrarFe_ejemplo_Factura_tipo_A.php";
//    elseif ($_REQUEST['ref']=='tipo_b')
//        include "data/TestRegistrarFe_ejemplo_Factura_tipo_B.php";
//    elseif ($_REQUEST['ref']=='tipo_c')
//        include "data/TestRegistrarFe_ejemplo_Factura_tipo_C.php";
//    elseif ($_REQUEST['ref']=='tipo_a_multi_iva')
//        include "data/TestRegistrarFe_ejemplo_Factura_tipo_A_MultiIVA.php";
//    else
//        die('ERROR CRITICO! - Se debe especificar el parametro: ref.');


//WebService que utilizara la autenticacion
$webService   = 'wsfe';
//Creando el objeto WSAA (Web Service de Autenticación y Autorización)
$wsaa = new AfipWsaa($webService,$empresaAlias);


//Creando el TA (Ticket de acceso)
if ($ta = $wsaa->loginCms())
{
    $token      = $ta['token'];
    $sign       = $ta['sign'];
    $expiration = $ta['expiration'];
    $uniqueid   = $ta['uniqueid'];

    //Conectando al WebService de Factura electronica (WsFev1)
    $wsfe = new AfipWsfev1($empresaCuit,$token,$sign);

    //Obteniendo el ultimo numero de comprobante autorizado
    $CompUltimoAutorizado = $wsfe->FECompUltimoAutorizado($PtoVta,$CbteTipo);
    //echo "<h3>wsfe->FECompUltimoAutorizado(PtoVta,CbteTipo)</h3>";
    //pr($CompUltimoAutorizado);
    
    /**
     * Aca se puede hacer una comparacion del Ultimo Comprobante Autorizado
     * y el ultimo comprobante que se registro en la base de datos.
     */

    $CbteDesde = $CompUltimoAutorizado['CbteNro'] + 1;
    $CbteHasta = $CbteDesde;

	$CbteFch = intval(date('Ymd'));
    $FchServDesde = intval(date('Ymd'));
    $FchServHasta = intval(date('Ymd'));
    $FchVtoPago = intval(date('Ymd'));
	//Año 2017, solo en pesos!!
    $MonId = 'PES'; // Pesos (AR) - Ver - AfipWsfev1::FEParamGetTiposMonedas()
    
	//Año 2018, pesos, dolares y euros
	if ($_REQUEST['monedaFactura']==60) {					
					$MonId = '060'; 
					$MonCotiz = $_REQUEST['tipoCambio'];
					} elseif ($_REQUEST['monedaFactura']==1) {
							$MonId = 'DOL'; 
							$MonCotiz = $_REQUEST['tipoCambio'];
							} else {
								$MonId = 'PES'; 
								$MonCotiz = 1.00;}
	
	//echo "Moneda: ".$MonId;
	//echo "TipoCambio: ".$MonCotiz;
	//268
	//exit;
	
	
    $Concepto = 1; //Productos
    $DocTipo = 80; //CUIT
    $DocNro = str_replace("-","", $regEmp['CUIT']);
	//$DocNro = 3030303043454; //Lo escribo mal asi da error

	$ImpTotal = $_REQUEST['impTotal'];
    $ImpTotConc = 0.00;
    $ImpNeto = $_REQUEST['subTotal'];
    $ImpOpEx = 0.00;
    $ImpIVA = $_REQUEST['ivaTotal'];
    $ImpTrib = 0.00;
	
    //Informacion para agregar al array Tributos
    /** 
     * Esto aplica si las facturas tienen tributos agregados
     */
	$tributoId = null; // Ver - AfipWsfev1::FEParamGetTiposTributos()
	$tributoDesc = null;
	$tributoBaseImp = null;
	$tributoAlic = null;
	$tributoImporte = null;
		
    //Informacion para agregar al array IVA
	if (($_REQUEST['iva4']>0)&&($_REQUEST['iva5']>0)){
		//Tengo 2 IVAS
		//Informacion para agregar al array IVA
		$IvaAlicuotaId_1 = 4; // 10.5% Ver - AfipWsfev1::FEParamGetTiposIva()
		$IvaAlicuotaBaseImp_1 = $_REQUEST['iva4Alicuota'];
		$IvaAlicuotaImporte_1 = $_REQUEST['iva4AlicuotaBase'];   

		$IvaAlicuotaId_2 = 5; // 21% Ver - AfipWsfev1::FEParamGetTiposIva()
		$IvaAlicuotaBaseImp_2 = $_REQUEST['iva5Alicuota'];
		$IvaAlicuotaImporte_2 = $_REQUEST['iva5AlicuotaBase'];   

		$Iva = array(
			'AlicIva' => array ( 
					array (
						'Id' => $IvaAlicuotaId_1,
						'BaseImp' => number_format(abs($IvaAlicuotaBaseImp_1),2,'.',''),
						'Importe' => number_format(abs($IvaAlicuotaImporte_1),2,'.','')
					),
					array (
						'Id' => $IvaAlicuotaId_2,
						'BaseImp' => number_format(abs($IvaAlicuotaBaseImp_2),2,'.',''),
						'Importe' => number_format(abs($IvaAlicuotaImporte_2),2,'.','')
					)
				)
			);	
	}
	else {
		//Tengo 1 IVA
		$IvaAlicuotaBaseImp = $_REQUEST['subTotal'];
		$IvaAlicuotaImporte = $_REQUEST['ivaTotal']; 
		//ahora veo cual IVA es
		if ($_REQUEST['iva4']>0){
			//Tengo solo iva del 10,5%
			$IvaAlicuotaId = 4; // 10,5% Ver - AfipWsfev1::FEParamGetTiposIva()
		} else {
				$IvaAlicuotaId = 5; // 21% Ver - AfipWsfev1::FEParamGetTiposIva(
		}		
	}

    //Armando el array para el Request
    //La estructura de este array esta diseñada de acuerdo al registro XML del WebService y utiliza las variables antes declaradas.
        $FeCAEReq = array (
            'FeCAEReq' => array (
                'FeCabReq' => array (
                    'CantReg' => 1,
                    'CbteTipo' => $CbteTipo,
                    'PtoVta' => $PtoVta
                    ),
                'FeDetReq' => array (
                    'FECAEDetRequest' => array(
                        'Concepto' => $Concepto,
                        'DocTipo' => $DocTipo,
                        'DocNro' => $DocNro,
                        'CbteDesde' => $CbteDesde,
                        'CbteHasta' => $CbteHasta,
                        'CbteFch' => $CbteFch,
                        'ImpTotal' => number_format(abs($ImpTotal),2,'.',''),
                        'ImpTotConc' => number_format(abs($ImpTotConc),2,'.',''),
                        'ImpNeto' => number_format(abs($ImpNeto),2,'.',''),
                        'ImpOpEx' => number_format(abs($ImpOpEx),2,'.',''),
                        'ImpIVA' => number_format(abs($ImpIVA),2,'.',''),
                        'ImpTrib' => number_format(abs($ImpTrib),2,'.',''),
                        'MonId' => $MonId,
                        'MonCotiz' => $MonCotiz
                        )
                    )
                ),
            );


        if (isset($Tributos) || isset($tributoBaseImp) || isset($tributoImporte))
        {
            if (empty($Tributos))
            {
                $Tributos = array(
                    'Tributo' => array (
                        'Id' => $tributoId,
                        'Desc' => $tributoDesc,
                        'BaseImp' => number_format(abs($tributoBaseImp),2,'.',''),
                        'Alic' => number_format(abs($tributoAlic),2,'.',''),
                        'Importe' => number_format(abs($tributoImporte),2,'.','')
                        )
                );
            }
            $FeCAEReq['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Tributos'] = $Tributos;
        }

        if (isset($Iva) || isset($IvaAlicuotaBaseImp) || isset($IvaAlicuotaImporte))
        {
            if (empty($Iva))
            {
                $Iva = array(
                    'AlicIva' => array (
                        'Id' => $IvaAlicuotaId,
                        'BaseImp' => number_format(abs($IvaAlicuotaBaseImp),2,'.',''),
                        'Importe' => number_format(abs($IvaAlicuotaImporte),2,'.','')
                        )
                    );
            }
            $FeCAEReq['FeCAEReq']['FeDetReq']['FECAEDetRequest']['Iva'] = $Iva;
        }

    //echo '
    //<table>
    //    <caption>wsfe->FECAESolicitar(Request)</caption>
    //    <tr>
    //        <th >Request</th>
    //        <th >Response</th>
    //    </tr>
    //    <tr>
    //        <td>
    //';
    //pr($FeCAEReq);

    //echo "
    //        </td>
    //        <td>
    //";

    //Registrando la factura electronica (OJO!!!)
    $FeCAEResponse = $wsfe->FECAESolicitar($FeCAEReq, $reg['NumeroComprobante']);

    /**
     * Tratamiento de errores
     */
        
        if (!$FeCAEResponse)
        {
            /* Procesando ERRORES */

            //echo '<h2 class="err">NO SE HA GENERADO EL CAE</h2>
            //      <h3 class="err">ERRORES DETECTADOS</h3>';

            $errores = $wsfe->getErrLog();
            if (isset($errores))
            {
                foreach ($errores as $v)
                {
                    //pr($v);
					
                }
            }
            //echo "<hr/><h3>Response</h3>";

        }
        elseif (!$FeCAEResponse['FeDetResp']['FECAEDetResponse']['CAE'])
        {
            /* Procesando OBSERVACIONES */

            //echo '<h2 class="msg">NO SE HA GENERADO EL CAE</h2>
            //      <h3 class="msg">OBSERVACIONES INFORMADAS</h3>';

            if (isset($FeCAEResponse['FeDetResp']['FECAEDetResponse']['Observaciones']))
            {
                foreach ($FeCAEResponse['FeDetResp']['FECAEDetResponse']['Observaciones'] as $v)
                {
                    //pr($v);
					
                }
            }
            //echo "<hr/><h3>Response</h3>";
        }    

	if ($FeCAEResponse['FeDetResp']['FECAEDetResponse']['CAE'])
	{
	$NumeroFactura = $FeCAEResponse['FeDetResp']['FECAEDetResponse']['CbteDesde'];
//2018 voy a cambiar el uso del registro IdEnviado, que en el sistema nuevo estaba al pedo (en el sistema Access se usaba pero luego ya no)
//ahora lo voy a usar para identificar la moneda de la factura realizada
//0 es pesos, 1 es dolares, 60 es Euro (como la AFIP)
	$idEnviado = $_REQUEST['monedaFactura'];
	$CAE = $FeCAEResponse['FeDetResp']['FECAEDetResponse']['CAE'];
	$VtoCAE = $FeCAEResponse['FeDetResp']['FECAEDetResponse']['CAEFchVto'];
    
    //El numero completo de la factura
    $pVtayFac=$_REQUEST['tipoComprobante'].$_REQUEST['tipoFactura'].str_pad($PtoVta, 4,"0", STR_PAD_LEFT)."-".str_pad($NumeroFactura, 8,"0", STR_PAD_LEFT);

	echo "{
		\"NumeroFactura\":\"$NumeroFactura\",
		\"idEnviado\":\"$idEnviado\",
		\"CAE\":\"$CAE\",
        \"VtoCAE\":\"$VtoCAE\",
        \"PtoVtayfac\":\"$pVtayFac\"
		}";
	}
	else
	{
	 echo "Error";
	}
    //pr($FeCAEResponse);
	

    
    //echo "
    //        </td>
    //    </tr>
    //</table>
    //";



}
else
{
    //echo '
    //<hr/>
    //<h3>Errores detectados al generar el Ticket de Acceso</h3>';
    //pr($wsaa->getErrLog());
	file_put_contents(TMP_PATH.$empresaCuit."_log_error.xml",$wsaa->getErrLog());
	file_put_contents(TMP_PATH.$empresaCuit."_log_response_loginCms.xml",$wsaa->__getLastResponse());
	die($wsaa->getErrLog());
}

