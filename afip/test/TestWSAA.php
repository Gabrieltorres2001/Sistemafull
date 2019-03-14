<?php

/**
 * En el archivo php.ini se deben habilitar las siguientes extensiones
 *
 * extension=php_openssl (.dll / .so)
 * extension=php_soap    (.dll / .so)
 *
 */

//Cargando archivo de configuracion
include_once "../config.php";
include_once LIB_PATH."functions.php";


//Cargando modelos de conexion a WebService
include_once MDL_PATH."AfipWsaa.php";
include_once MDL_PATH."AfipWsfev1.php";

//Datos correspondiente a la empresa 1
    //CUIT (Sin guiones)
    //Octubre 2018. Tomo este valor de la base de datos. Tabla controlpanel
//Creamos la conexión
    include_once '../../includes/sp_connect.php';
    $conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
    mysqli_query($conexion_sp,"set names 'utf8'");
	//BUSCO miCuit EN CONTROLPANEL.
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miCuit' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
    $empresaCuit = str_replace("-","", $rowresultDatosAux['ContenidoValor']);    
    //El alias debe estar mencionado en el nombre de los archivos de certificados y firmas digitales
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'empresaAlias' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
    $empresaAlias = $rowresultDatosAux['ContenidoValor'];

//WebService que utilizara la autenticacion (A modo de ejemplo para este test)
$webService   = 'wsfe';


//Creando el objeto WSAA (Web Service de Autenticación y Autorización)

$wsaa = new AfipWsaa($webService,$empresaAlias);


//Creando el TA (Ticket de acceso)
if ($ta = $wsaa->loginCms())
{
    echo 'OkOko Ticket de Acceso generado [Entorno: '.SERVER_ENTORNO.']. Mostrando el setup del WSAA mediante: AfipWsaa::getSetUp()';
    pr($wsaa->getSetUp());
    echo '
    <hr/>';

    echo 'Ticket de Acceso generado [Entorno: '.SERVER_ENTORNO.']. Mostrando el TA (Ticket de Acceso)';
    pr($ta);
    echo '
    <hr/>';

    //Conectando al WebService de Factura electronica (WsFev1)
    $wsfe = new AfipWsfev1($empresaCuit,$ta['token'],$ta['sign']);

    $ret = $wsfe->FEParamGetPtosVenta();
    echo "AfipWsfev1::FEParamGetPtosVenta()";
    pr($ret);    
    echo '
    <hr/>';
}
else
{
    echo 'Error (es) detectados al generar el Ticket de Acceso. Vea el log.
    <pre>';
    print_r($wsaa->getErrLog());
    echo '
    </pre>';
	file_put_contents(TMP_PATH.$empresaCuit."_log_error.xml",$wsaa->getErrLog());
}

?>