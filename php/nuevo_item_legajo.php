<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	//Primero busco el numero de comprobante desde el idcomprrobante
	if(!$resultPresup = mysqli_query($conexion_sp, "select NumeroComprobante from comprobantes where IdComprobante='".$_REQUEST['idComp']."' Limit 1")) die("Problemas con la consulta comprobantes");  
	$rowResultPresup = mysqli_fetch_row($resultPresup);
	
	//Luego busco el mayor numero de orden para el legajo al que voy a agregarle un item
	if(!$resultOrdenLeg = mysqli_query($conexion_sp, "select orden from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' order by orden desc Limit 1")) die("Problemas con la consulta comprobantes");  
	$rowResultOrdenLeg = mysqli_fetch_row($resultOrdenLeg);	
	$nuevoOrden=$rowResultOrdenLeg[0]+1;
	
//generamos la consulta de actualizacion	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into detallelegajos (idLegajo, idComprobante, tipoComprobante, textoComprobante, PDF, orden, numComprobante) values ('".$_REQUEST['idlegajo']."', '".$_REQUEST['idComp']."', '".$_REQUEST['tipoComp']."', '".$_REQUEST['txtComp']."', '".$_REQUEST['pdfComp']."', '".$nuevoOrden."', '".$rowResultPresup[0]."')")){
		echo"Item de legajo NO creado";
		 die("Problemas con la consulta de nuevo");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Item de legajo creado</label>";
		echo"<br />";
	};	
	$id=mysqli_insert_id($conexion_sp);


 

