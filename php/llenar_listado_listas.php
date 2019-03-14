<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	echo"Lista: ";
	echo"<select id='listaNombre' name='listaNombre' tabindex='-1' title='' class='select2-offscreen'>";
	
	if(!$result = mysqli_query($conexion_sp, "select * from ListasContactos ORDER BY Nombre asc")) die("Problemas con la consulta");
	while ($reg = mysqli_fetch_array($result)){
		  echo"<option value=".$reg['id'].">".substr($reg['Nombre'],0,33)."</option>";
	}  

	echo"</select>";
	//echo"  ";
	//echo"<input type='checkbox' id='checkMostrarCanceladas' value='checkMostrarCanceladas'/>Mostrar canceladas";
	echo"  ";
	echo"<input type='button' id='seleccionaEmpresa' value='Listo'>";
	echo"  ";
	echo"<input type='button' id='nuevaLista' value='Nueva lista de contactos'>";
	//echo"  ";
	//echo"<input type='button' id='imprimirDeudores' value='Informe de deudores'>";
	//echo"</br>";
	
	
