<?php
//Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
	die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
	die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
	//tengo que tenerpermiso para modificar
	if(!$permisoModificar = mysqli_query($conexion_db, "select PuedeModificarArticulos from members where id='".$_REQUEST['estaSesion']."' limit 1")) die("Problemas con la consultamembers");
	$rowPermisoModificar = mysqli_fetch_array($permisoModificar);
	$puedoModificar=" disabled";
	if($rowPermisoModificar['PuedeModificarArticulos']!=0)$puedoModificar="";

	//Hago 3 div
	//Para ver cual DIV va, tengo que saber si el articulo es publico o privado
	if(!$productoPublico = mysqli_query($conexion_sp, "select Id from productospublicos where IdProducto='".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productospublicos");
	$esPublico=mysqli_num_rows($productoPublico);
	$rowProductoPublico = mysqli_fetch_array($productoPublico);

	//Div 1. Boton agregar a Publicos
	if ($esPublico>0) {
		//Es publico
		echo "<div style='left:0px;
		top:0px;
		height:100%;
		border-width:1px;
		border-style:solid;
		border-color:#000;
		background-color:green; 
		width:28%; 
		float:left; 
		border:1px solid #555; 
		overflow: auto;
		text-align:center;
		visibility:hidden; '>";
	} else {
		//Es privado
		echo "<div style='left:0px;
		top:0px;
		height:100%;
		border-width:1px;
		border-style:solid;
		border-color:#000;
		background-color:green; 
		width:28%; 
		float:left; 
		border:1px solid #555; 
		overflow: auto;
		text-align:center; '>";
	}
	
	echo "<p>";
	echo"</br>";

	echo"<input type='button' id='botonHacerPublico' value='Hacer público'".$puedoModificar.">";
	
	echo"</br>";
	echo"</p>";

	echo "</div>";

	//Div 2. Actualizar artículos y mostrar movimientos
	echo "<div style='left:0px;
	top:0px;
	height:100%;
	border-width:1px;
	border-style:solid;
	border-color:#000;
	width:44%; 
	float:left; 
	border:1px solid #555; 
	overflow: auto;
	text-align:center; '>";
	echo "<p>";
	echo"<input type='button' id='botonActualizaArticulo' value='Actualizar datos'".$puedoModificar.">";
	
	echo"</br>";
	echo"</br>";
	echo"<input type='checkbox' id='checkMostrarMovimientos' value='MostrarMovimientos'/>Mostrar movimientos del producto";
	echo"</p>";
	echo "</div>";

	//Div 3. Boton quitar de Publicos
	if ($esPublico>0) {
		//Es publico
		echo "<div style='left:0px;
		top:0px;
		height:100%;
		border-width:1px;
		border-style:solid;
		border-color:#000;
		background-color:red; 
		width:28%; 
		float:left; 
		border:1px solid #555; 
		overflow: auto;
		text-align:center; '>";
	} else {
		//Es privado
		echo "<div style='left:0px;
		top:0px;
		height:100%;
		border-width:1px;
		border-style:solid;
		border-color:#000;
		background-color:red; 
		width:28%; 
		float:left; 
		border:1px solid #555; 
		overflow: auto;
		text-align:center;
		visibility:hidden; '>";		
	}

	echo "<p>";
	echo"</br>";
	echo"<input type='button' id='botonHacerPrivado' value='Hacer privado'".$puedoModificar.">";
	echo"</br>";
	echo"</p>";

	echo "</div>";
