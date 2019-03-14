<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//primero traducimos el valor a el numero equivalente
//$moneda=0;
//switch ($_REQUEST['valor']){
//	case '$':
//		$moneda=1;
//		break;
//	case 'USD':
//		$moneda=2;
//		break;
//	case '€':
//		$moneda=3;
//		break;
//}		
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set ".$_REQUEST['campo']." = '".$_REQUEST['valor']."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la consulta de actualizacion");
	};
