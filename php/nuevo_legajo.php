<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';

	echo"<input type='button' id='nuevoLegajo' value='Nuevo legajo'/>";

include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//Cargo un nuevo legajo
	if(!$resultLegajo = mysqli_query($conexion_sp, "insert into legajos (Confecciono, fechaLegajo) values ('".$_REQUEST['sesses']."', '".date('Y-m-d')."')")){
		echo"Legajo NO creado";
		 die("Problemas con la consulta de nuevo Legajo");
	}
	else {
		$id=mysqli_insert_id($conexion_sp);
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Legajo creado</label>";
		echo"<label id='NumeroLegajoRecienCreado' style='font-size:1em; font-weight:bold; color:red; visibility:hidden;'>".$id."</label>";
	};	
//Leo detalles del comprobante a agregar	
	if(!$resultPresup = mysqli_query($conexion_sp, "select NumeroComprobante, TipoComprobante from comprobantes where IdComprobante='".$_REQUEST['idComprob']."' Limit 1")) die("Problemas con la consulta 2");  
	$rowResultPresup = mysqli_fetch_row($resultPresup);
	
//Cargo el detalle del legajo
	if(!$resultDetLegajo = mysqli_query($conexion_sp, "insert into detallelegajos (idLegajo, idComprobante, numComprobante, tipoComprobante) values ('".$id."', '".$_REQUEST['idComprob']."', '".$rowResultPresup[0]."', '".$rowResultPresup[1]."')")){
		echo"Detalle Legajo NO creado";
		 die("Problemas con la consulta de nuevo Detalle Legajo");
	}
	else {
		//$id=mysqli_insert_id($conexion_sp);
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Legajo creado</label>";
		//echo"<label id='NumeroLegajoRecienCreado' style='font-size:1em; font-weight:bold; color:red; visibility:hidden;'>".$id."</label>";
		echo"<br />";
	};
	
