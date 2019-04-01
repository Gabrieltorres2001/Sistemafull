<?php
//Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
	die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

	$productoPublicado=1;

	if(!$resultact = mysqli_query($conexion_sp, "delete from productospublicos where IdProducto='".$_REQUEST['idart']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No borrado</label>";
		 die("Problemas con la consulta de hacer privado");
	}	else {
		$productoPublicado=0;
	};