<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta

	if(!$resultc = mysqli_query($conexion_sp, "select * from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productos");  

imprimir_detalle_articulos($resultc, $conexion_sp);