<?php
	//Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tenerpermiso para modificar
		if(!$permisoModificar = mysqli_query($conexion_db, "select PuedeModificarArticulos from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la consultamembers");
		$rowPermisoModificar = mysqli_fetch_array($permisoModificar);
		$puedoModificar=" disabled";
		if($rowPermisoModificar['PuedeModificarArticulos']!=0)$puedoModificar="";
		
		echo "<p>";
		echo"<input type='button' id='botonActualizaArticulo' value='Actualizar datos'".$puedoModificar.">";
		echo " ";
		echo"<input type='button' id='botonCopiaArticulo' value='Duplicar artículo'".$puedoModificar.">";
		echo " ";
		echo"<input type='button' id='botonNuevoArticulo' value='Nuevo artículo'".$puedoModificar.">";
		echo"</br>";
		echo"</br>";
		echo"<input type='checkbox' id='checkMostrarMovimientos' value='MostrarMovimientos'/>Mostrar movimientos del producto";
		echo"</p>";