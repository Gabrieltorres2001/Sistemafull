<?php
//============================================================+
	   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");

	   if(!$resultCodigo = mysqli_query($conexion_sp, "select Codigo from Informes where Descripcion='".$_REQUEST['tipoInforme']."' limit 1")) die("Problemas con la consulta Informes");
		$regCodigo = mysqli_fetch_array($resultCodigo);  
	
		$rowcount=mysqli_num_rows($resultCodigo);

		if ($rowcount>0) {
			eval($regCodigo['Codigo']);
		} else {
			echo "El cliente no tiene creado este formulario";
		}
	