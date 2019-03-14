<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set ".$_REQUEST['campo']." = '".$_REQUEST['valor']."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la consulta de actualizacion");
	};
