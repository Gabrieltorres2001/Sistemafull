<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion	
	if(!$resultcopia = mysqli_query($conexion_sp, "update detallelegajos set PDF = '".$_REQUEST['pdfComp']."' where idDetalle = '".$_REQUEST['idcomprobante']."'")){
		echo"Item de legajo NO modificado";
		 die("Problemas con la consulta de update");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Item de legajo modificado</label>";
		echo"<br />";
	};	


 

