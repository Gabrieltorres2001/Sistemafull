<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta

    if(!$resultart = mysqli_query($conexion_sp, "select IdProveedor from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productos");  
    $rowArt = mysqli_fetch_array($resultart);

	if(!$resultOrg = mysqli_query($conexion_sp, "select id from organizaciones where id = '".$rowArt['IdProveedor']."' limit 1")) die("Problemas con la consulta organizaciones");  
    if ($rowOrg = mysqli_fetch_array($resultOrg)){echo $rowOrg['id'];} else {echo "0";}
