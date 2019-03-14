<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	echo"<input type='button' id='nuevoRecibo' value='Nuevo recibo'/>";
	echo"Empresa: ";
	echo"<select id='empresaNombre' name='empresaNombre' tabindex='-1' title='' class='select2-offscreen'>";
	
	//Primero busco los CUITs cargados en la tabla de pagosyfacturas, así solo listo los que tienen factura registrada
	if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "select distinct CUIT from fondosyfacturas")) die("Problemas con la consulta FondosyFacturas");
	while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){
		if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT, id from organizaciones where CUIT='".$rowFyF[0]."' ORDER BY Organizacion asc")) die("Problemas con la consulta");
		while ($reg = mysqli_fetch_array($result)){
			  echo"<option value=".$reg['id'].">".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")</option>";
		}  
	}
	echo"</select>";
	echo"<input type='button' id='listoNuevoRe' value='Agregar'>";
	
	
