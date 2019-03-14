<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_spc=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_spc,"set names 'utf8'");
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_spc, "insert into detallecomprobante (IdComprobante,".$_REQUEST['campo'].", actualiz) values ('".$_REQUEST['idcomprobante']."','".$_REQUEST['valor']."', now())")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar item");
	}	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>comprobante agregado</label>";
	};	;
