<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
//busco la cantidad de items
	if(!$resultlect = mysqli_query($conexion_sp, "select IdProducto, Cantidad from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."' limit 1")){
		die("Problemas con la consulta de lectura detallecomprobante");
	};
	if ($row = mysqli_fetch_array($resultlect)){
		if(!$resultArt = mysqli_query($conexion_sp, "select EnStock from productos where IdProducto = '".$row['IdProducto']."' limit 1")){
			die("Problemas con la consulta de lectura detallecomprobante");
		};
		if ($cant = mysqli_fetch_array($resultArt)){
			if ($_REQUEST['valor'] == '1'){	
				$nuevaCantidad=$cant['EnStock']+$row['Cantidad'];
			} else {
				$nuevaCantidad=$cant['EnStock']-$row['Cantidad'];
			}	
		}	
	}
	
	if(!$resultact = mysqli_query($conexion_sp, "update productos set EnStock = '".$nuevaCantidad."', actualiz = now() where IdProducto = '".$row['IdProducto']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la consulta de actualizacion");
	};
