	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

//generamos la consulta
	if(!$resultact = mysqli_query($conexion_sp, "update comprobantes set Confecciono = '".$_REQUEST['sesses']."', actualiz = now() where IdComprobante = '".$_REQUEST['idpresup']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};