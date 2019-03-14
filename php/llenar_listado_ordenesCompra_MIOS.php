<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa,IdComprobante from comprobantes where TipoComprobante=9 and Confecciono='".$_REQUEST['sesses']."' ORDER BY IdComprobante desc")) die("Problemas con la consulta1");

echo"<input type='button' id='listarTodos' value='Todos'>";
echo"<input type='button' id='listarMios' value='Mios' Disabled>";
echo"<br>";	
echo"<ul class='nav navbar-nav'>";
echo"<li>  Ordenes de compra MIAS ya realizadas:  </li>";
echo"</ul>";
echo "<br>";
echo "<table class='display' id='tablaPrespuestosRealizados'>";  
echo "<tr>";  
echo "<th width='55'>Numero</th>";  
echo "<th width='80'>Fecha</th>";  
echo "<th>Organizacion</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_array($result)){   
    echo "<tr id=".$row['IdComprobante'].">"; 
    echo "<td name='xxxxrt' id=".$row['IdComprobante'].">$row[0]</td>";	
    echo "<td name='xxxxrt' id=".$row['IdComprobante'].">".substr($row['FechaComprobante'],8,2)."/".substr($row['FechaComprobante'],5,2)."/".substr($row['FechaComprobante'],0,4)."</td>";
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$row['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	while ($rowEmp = mysqli_fetch_array($resultEmp)){  
		echo "<td name='xxxxrt' id=".$row['IdComprobante'].">".$rowEmp['Organizacion']."</td>";
	}
    echo "</tr>";  
}  
echo "</table>";
