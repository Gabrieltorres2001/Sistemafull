<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into ListasContactos (Nombre) values ('".$_REQUEST['nombre']."')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Lista NO creada. Error en tabla ListasContactos.</label>";
		 die("Problemas con la consulta de creacion");
	}
	else {
		$id=mysqli_insert_id($conexion_sp);
	};
