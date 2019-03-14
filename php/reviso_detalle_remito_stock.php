<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
//busco la cantidad de items
	if(!$resultlect = mysqli_query($conexion_sp, "select IdProducto from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."' limit 1")){
		die("Problemas con la consulta de lectura detallecomprobante");
	};
	$row = mysqli_fetch_array($resultlect);
	if(!$resultArt = mysqli_query($conexion_sp, "select EnStock, StockMinimo, tangible from productos where IdProducto = '".$row['IdProducto']."' limit 1")){
			die("Problemas con la consulta de lectura detallecomprobante");};		
	$art = mysqli_fetch_array($resultArt);
	$nuevaCantidad='#abf1ab';
	if ($art['EnStock']<=$art['StockMinimo']) {$nuevaCantidad='yellow';}	
	if ($art['EnStock']<1) {$nuevaCantidad='#FA5858';}
	if ($art['tangible']<1) {$nuevaCantidad='white';}	
	echo $nuevaCantidad;
