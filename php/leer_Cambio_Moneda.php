<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Euro, Dolar from cotizacionesnew ORDER BY Id desc limit 1")) die("Problemas con la consulta");
	$reg = mysqli_fetch_array($result);  
	$euro=$reg['Euro'];	
	$Dolar=$reg['Dolar'];	

		echo "{
		\"Dolar\":\"$Dolar\",
		\"euro\":\"$euro\"
		}";
	
