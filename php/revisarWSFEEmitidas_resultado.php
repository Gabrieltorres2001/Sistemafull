<?php

include_once '../includes/functions.php';
//Cargando modelos de conexion a WebService
//Cargando archivo de configuracion

include_once "../afip/config.php";
include_once LIB_PATH."functions.php";

//Cargando modelos de conexion a WebService
include_once MDL_PATH."AfipWsaa.php";
include_once MDL_PATH."AfipWsfev1.php";

//Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
		

//No se que mierda pasa que no anda
	$tipoComp=$_REQUEST['cbteTipo'];
	$numComp=$_REQUEST['cbteNro'];
	$puntoVenta=$_REQUEST['ptoVta'];
	
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

	
//WebService que utilizara la autenticacion
$webService   = 'wsfe';
//Creando el objeto WSAA (Web Service de Autenticación y Autorización)
$wsaa = new AfipWsaa($webService,$empresaAlias);
	echo "</br>";
 
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
	echo "FECompConsultar(".$tipoComp.",".$numComp.",".$puntoVenta.")";
    $CompQueQuieroAveriguar = $wsfe->FECompConsultar($tipoComp,$numComp,$puntoVenta);
	echo "</br>";
	echo "Respuesta DUMP: ";
	var_dump($CompQueQuieroAveriguar);
	echo "</br>";
	echo "</br>";
	echo "Respuesta ARRAY: ";
	print_r($CompQueQuieroAveriguar);
	echo "</br>";
}

