	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
echo"<ul class='nav navbar-nav'>";
echo"<li>  Detalle:  </li>";
echo"</ul>";
echo"<br>";
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa from comprobantes where TipoComprobante=5 ORDER BY IdComprobante desc limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);  
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regEmp = mysqli_fetch_array($resultEmp);
	
	echo"<label for='NumeroComprobante'>Numero de presupuesto:</label>";
	echo"<input id='NumeroComprobante' class='input' name='NumeroComprobante' type='text' size='4' value=".$reg['NumeroComprobante']." disabled>";
	echo"<label for='FechaComprobante'>Fecha del presupuesto:</label>";
	echo"<input id='FechaComprobante' class='input' name='FechaComprobante' type='text' size='9' value=".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4)." disabled>";
	echo"<br>";
	echo"<label for='Organizacion'>Organizacion:</label>";
	echo"<input id='Organizacion' class='input' name='Organizacion' type='text' size='60' value='".$regEmp['Organizacion']."'  disabled>";
 

