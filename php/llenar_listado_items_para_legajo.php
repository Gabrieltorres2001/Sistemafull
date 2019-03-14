<?php
		//Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';


	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
if (($_REQUEST['tipoComp']=='3')||($_REQUEST['tipoComp']=='5')||($_REQUEST['tipoComp']=='9')) {	
	echo"</br>";
	echo"Comprobantes encontrados";
	echo"<select name='itemsAAgregarALegajo' id='itemsAAgregarALegajo' tabindex='-1' title='' class='select2-offscreen'>";
		
	if(!$resultPresup = mysqli_query($conexion_sp, "select IdComprobante, NumeroComprobante, NonmbreEmpresa, ApellidoContacto, FechaComprobante, NumeroComprobante02 from comprobantes where TipoComprobante='".$_REQUEST['tipoComp']."' ORDER BY IdComprobante desc")) die("Problemas con la consulta");  
	while ($reg = mysqli_fetch_array($resultPresup)){
		if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regContEmp = mysqli_fetch_array($resultContEmp);
		if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
		$regEmp = mysqli_fetch_array($resultEmp);
		if ($_REQUEST['tipoComp']=='3') {
			//Remito (pongo el numero de preimpreso)
		echo"<option value=".$reg['IdComprobante'].">(".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4).") ".$reg['NumeroComprobante']." (".$reg['NumeroComprobante02'].") - ".substr($regEmp['Organizacion'],0,33)." | ".substr($reg['ApellidoContacto'],0,27)."</option>";}
		else {
			//Cualquiera menos remito (no hace falta el preimpreso)
		echo"<option value=".$reg['IdComprobante'].">(".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4).") ".$reg['NumeroComprobante']." - ".substr($regEmp['Organizacion'],0,33)." | ".substr($reg['ApellidoContacto'],0,27)."</option>";}			
	}  
	echo"</select>";
}
	echo"</br>";
	echo"</br>";
	echo"Descripcion:";
	echo"<textarea id='NuevaDescripcionitem' class='input' overflow='scroll' name='xxxxt' resize='none' cols='38' rows='1'> </textarea>";
	echo"</br>";
	echo'<form accept-charset="utf-8" method="POST" id="enviarimagenes" enctype="multipart/form-data" >
	<br>
	<p>Adjunto: <input type="file" id="files" name="imagen" accept=".pdf"/></p>
	</form>';
	//echo"<input type='button' id='nuevoAdjunto' value='Adjunto'>"; 
	//echo"</br>";
	echo"<input type='button' id='listoNuevoLegVent' value='Agregar'>";
		//echo"</br>";
		//echo"<div id='aviso'></div>";
	
