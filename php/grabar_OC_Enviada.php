	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "update comprobantes set OCEnviada='1' where IdComprobante='".$_REQUEST['idcomprobante']."'")) die("Problemas con la consulta grabar OCEnviada");
 
