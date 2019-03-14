<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta

	if(!$resultc = mysqli_query($conexion_sp, "select IdComprobante,NumeroComprobante,FechaComprobante,TipoComprobante from comprobantes where NonmbreEmpresa = '".$_REQUEST['idcto']."' order by IdComprobante")) die("Problemas con la consulta comprobantes");
	
	if (mysqli_num_rows($resultc) > 0){  
		imprimir_movimientos_contacto($resultc, $conexion_sp);
	} else
		{ 	echo "<table class='display' width='650' style='table-layout:fixed'>"; 
	//echo "<caption>Resultados encontrados: ".mysqli_num_rows($resultc)."</caption>";
	echo "<caption>Sin movimientos</caption>";

		}