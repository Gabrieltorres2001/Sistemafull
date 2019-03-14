<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	//Primero busco el ultimo orden de este legajo para saber donde estoy
	if(!$resultOrdenLeg = mysqli_query($conexion_sp, "select orden from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' order by orden desc Limit 1")) die("Problemas con la consulta comprobantes");  
	$rowResultOrdenLeg = mysqli_fetch_row($resultOrdenLeg);	
	$mayorOrden=$rowResultOrdenLeg[0];
	
	//Ahora va a depender de que orden tenga y cual sea la accion solicitada
	//Subir siempre y cuando no sea el primero
	if (($_REQUEST['ordenItem']>0)&&($_REQUEST['accion']=='subir')){
		//Primero busco los 2 items que debo modificar
		$nuevoOrden=$_REQUEST['ordenItem']-1;
		if(!$resultOrden1 = mysqli_query($conexion_sp, "select idDetalle from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and orden='".$nuevoOrden."' Limit 1")) die("Problemas con la consulta de busqueda 1");  
		$primerItem = mysqli_fetch_row($resultOrden1);	
		if(!$resultOrden2 = mysqli_query($conexion_sp, "select idDetalle from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and orden='".($_REQUEST['ordenItem'])."' Limit 1")) die("Problemas con la consulta de busqueda 2");  
		$segundoItem = mysqli_fetch_row($resultOrden2);	
		//Luego intercambio los ordenes
		if(!$resultact = mysqli_query($conexion_sp, "update detallelegajos set orden = '".$_REQUEST['ordenItem']."' where idDetalle = '".$primerItem[0]."'")){
			echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
			 die("Problemas con la PRIMERA consulta de actualizacion");
		};	
		if(!$resultact = mysqli_query($conexion_sp, "update detallelegajos set orden = '".$nuevoOrden."' where idDetalle = '".$segundoItem[0]."'")){
			echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
			 die("Problemas con la SEGUNDA consulta de actualizacion");
		};		
	}
	
	//Bajar siempre y cuando no sea el ultimo
	if (($_REQUEST['ordenItem']<$mayorOrden)&&($_REQUEST['accion']=='bajar')){
		//Primero busco los 2 items que debo modificar
		$nuevoOrden=$_REQUEST['ordenItem']+1;
		if(!$resultOrden1 = mysqli_query($conexion_sp, "select idDetalle from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and orden='".$nuevoOrden."' Limit 1")) die("Problemas con la consulta de busqueda 3");  
		$primerItem = mysqli_fetch_row($resultOrden1);	
		if(!$resultOrden2 = mysqli_query($conexion_sp, "select idDetalle from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and orden='".($_REQUEST['ordenItem'])."' Limit 1")) die("Problemas con la consulta de busqueda 4");  
		$segundoItem = mysqli_fetch_row($resultOrden2);	
		//Luego intercambio los ordenes
		if(!$resultact = mysqli_query($conexion_sp, "update detallelegajos set orden = '".$_REQUEST['ordenItem']."' where idDetalle = '".$primerItem[0]."'")){
			echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
			 die("Problemas con la TERCERA consulta de actualizacion");
		};	
		if(!$resultact = mysqli_query($conexion_sp, "update detallelegajos set orden = '".$nuevoOrden."' where idDetalle = '".$segundoItem[0]."'")){
			echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
			 die("Problemas con la CUARTA consulta de actualizacion");
		};		
	}
echo "actualizado";

 

