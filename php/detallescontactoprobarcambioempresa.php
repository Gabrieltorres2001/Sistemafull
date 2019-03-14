<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta

	if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$_REQUEST['idcto']."' limit 1")) die("Problemas con la consulta");  

imprimir_detalle_contactos($resultc, $conexion_sp, $_REQUEST['empresatemp']);