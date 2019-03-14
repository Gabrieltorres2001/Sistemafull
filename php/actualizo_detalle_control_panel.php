<?php
   //Creamos la conexión
include_once '../includes/db_connect.php';
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_db, "update members set ".$_REQUEST['campo']." = '".$_REQUEST['valor']."' where id = '".$_REQUEST['idUsuario']."'")){
		echo"No actualizado";
		 die("Problemas con la consulta de actualizacion");
	};
	echo "Cambio guardado";
