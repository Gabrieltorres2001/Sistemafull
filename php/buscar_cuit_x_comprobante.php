<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
		
   if(!$resultEmpresa = mysqli_query($conexion_sp, "select NonmbreEmpresa from comprobantes where IdComprobante='".$_REQUEST['idcomp']."' limit 1")) die("Problemas con la consulta comprobantes");
   $regresultEmpresa = mysqli_fetch_array($resultEmpresa); 
   
	if(!$resultOrganiz = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$regresultEmpresa['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta contactos2");
	$regOrganiz = mysqli_fetch_array($resultOrganiz);		
      
   if(!$resultCuit = mysqli_query($conexion_sp, "select CUIT from organizaciones where id='".$regOrganiz['idOrganizacion']."' limit 1")) die("Problemas con la consulta organizaciones");
   $regCuit = mysqli_fetch_array($resultCuit);	
   
   echo $regCuit['CUIT'];	
   