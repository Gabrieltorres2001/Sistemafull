<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "insert into cotizacionesnew (Dolar, Euro, Fecha) values ('".$_REQUEST['dolar']."','".$_REQUEST['euro']."', '".$_REQUEST['fecha']."')")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar item");
	}	else {
		echo"OkOko";
	};


		
