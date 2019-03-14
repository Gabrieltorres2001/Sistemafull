<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
		
   if(!$resultCuit = mysqli_query($conexion_sp, "select Organizacion, id from organizaciones where CUIT='".$_REQUEST['cuitemp']."' limit 1")) die("Problemas con la consulta");
   $regresultCuit = mysqli_fetch_array($resultCuit); 
   
	if(!$resultEmpDir = mysqli_query($conexion_sp, "select Direccion, Ciudad, Codigopostal from direcciones where CUIT='".$regresultCuit['id']."' and Direccion Not Like '%@%' order by id asc limit 1")) die("Problemas con la consulta2");
	$regEmpDir = mysqli_fetch_array($resultEmpDir);		
		
   echo"INFORMACION REGISTRADA EN NUESTRA BASE</BR></BR>";
   echo"Nombre: ".$regresultCuit['Organizacion']."</BR>";	
   echo"Domicilio Fiscal: ".$regEmpDir['Direccion']."</BR>";
   echo"Localidad: (".$regEmpDir['Codigopostal'].") ";   
   echo $regEmpDir['Ciudad']."</BR>";			
