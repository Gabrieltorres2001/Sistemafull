<?php

	//Creamos la conexión
	include_once '../includes/db_connect.php';

	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tener asociado un usuario de sistemaplus PERO ADEMAS tengo que tener permiso para Modificar Articulos
		if(!$sesionSistPlus = mysqli_query($conexion_db, "select PuedeModificarArticulos from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la consulta3");
		$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
		$PuedoModificarArticulos=" disabled";
		if($rowSesionSistPlus['PuedeModificarArticulos']!=0)$PuedoModificarArticulos="";
		echo"<input type='button' id='nuevoAjusteStock' value='Nuevo ajuste'".$PuedoModificarArticulos.">";
		echo "<label id='accionesInforme'></label>";
