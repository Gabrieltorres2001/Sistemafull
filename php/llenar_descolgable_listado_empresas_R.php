<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	
	echo"<input type='button' id='nuevoRemito' value='Nueva venta'/>";
	echo"Seleccione empresa|contacto";
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	echo"<select name='empresa' id='empresa' tabindex='-1' title='' class='select2-offscreen'>";
		
	if(!$result = mysqli_query($conexion_sp, "select organizaciones.Organizacion, contactos2.NombreCompleto, contactos2.IdContacto from contactos2 INNER JOIN  organizaciones ON contactos2.idOrganizacion = organizaciones.id ORDER BY organizaciones.Organizacion asc")) die("Problemas con la consulta"); 
	while ($reg = mysqli_fetch_array($result)){
		  echo"<option value=".$reg['IdContacto'].">".substr($reg['Organizacion'],0,38)." | ".substr($reg['NombreCompleto'],0,38)."</option>";
	}  
	echo"</select>";
	
	echo"<input type='button' id='listoNuevoPre' value='Agregar'>";
	
