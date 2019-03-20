<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	//Primero la factura segun el cae
	if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "select Id from caeafip where CAE='".$_REQUEST['numCAE']."'")) die("Problemas con la consulta caeafip");
	$regFondosyFacturas = mysqli_fetch_array($resultFondosyFacturas);
	echo $regFondosyFacturas['Id'];
