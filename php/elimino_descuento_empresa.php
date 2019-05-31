<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de borrado
	if(!$resultact = mysqli_query($conexion_sp, "delete from descuentos where Id='".$_REQUEST['IdDesc']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No borrado</label>";
		 die("Problemas con la consulta de borrar descuento");
	}	else {
		echo"<label>Descuento eliminado de la empresa</label>";
	};
