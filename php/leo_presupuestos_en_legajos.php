<?php
   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	//BUSCO EL VALOR DEL PRODUCTO EN LA TABLA DE PRODUCTOS
	if(!$resultLectEmp = mysqli_query($conexion_sp, "select idLegajo from detallelegajos where idComprobante = '".$_REQUEST['IdComprobante']."'")){
		 die("Problemas con la primera consulta de actualizacion");
	}
	$legajos=0;
	while ($reg = mysqli_fetch_array($resultLectEmp)){
		$legajos++;
	}
	
	echo "{
		\"legajos\":\"$legajos\"
		}";
