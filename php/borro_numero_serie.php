<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "delete from numerosserie where idNumeroSerie=".$_REQUEST['idserie']."")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No borrado</label>";
		 die("Problemas con la consulta de borrar item");
	}	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Numero de serie borrado del comprobante</label>";
	};
