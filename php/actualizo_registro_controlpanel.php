<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion
$valor = mysqli_real_escape_string($conexion_sp, $_REQUEST['nuevoValor']);
	if(!$resultact = mysqli_query($conexion_sp, "update controlpanel set ContenidoValor = '".$valor."' where id = '".$_REQUEST['numeroID']."'")){
		echo"Registro NO actualizado";
		 die("Problemas con la consulta de actualizacion");
	}
	else {
		echo"Registro actualizado";
		//echo"<label id='NumeroPresupuestoRecienActualizado' style='font-size:1em; font-weight:bold; color:red; visibility: hidden;'>".$elIdComprobante."</label>";
	};

