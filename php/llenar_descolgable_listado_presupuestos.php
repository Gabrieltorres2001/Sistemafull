<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	
	echo"<input type='button' id='nuevoLegajo' value='Nuevo legajo'/>";
	echo"Seleccione presupuesto";
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	echo"<select name='Presupuestos' id='Presupuestos' tabindex='-1' title='' class='select2-offscreen'>";
		
	if(!$resultPresup = mysqli_query($conexion_sp, "select IdComprobante, NumeroComprobante, NonmbreEmpresa, ApellidoContacto, FechaComprobante from comprobantes where TipoComprobante='5' ORDER BY IdComprobante desc")) die("Problemas con la consulta");  
	while ($reg = mysqli_fetch_array($resultPresup)){
		if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regContEmp = mysqli_fetch_array($resultContEmp);
		if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
		$regEmp = mysqli_fetch_array($resultEmp);
		  echo"<option value=".$reg['IdComprobante'].">(".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4).") ".$reg['NumeroComprobante']." - ".substr($regEmp['Organizacion'],0,33)." | ".substr($reg['ApellidoContacto'],0,27)."</option>";
	}  
	echo"</select>";
	
	echo"<input type='button' id='listoNuevoLeg' value='Agregar'>";
	
