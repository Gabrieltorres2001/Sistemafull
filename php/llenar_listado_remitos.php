<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa,IdComprobante, NumeroComprobante02 from comprobantes where TipoComprobante=3 ORDER BY IdComprobante desc")) die("Problemas con la consulta1");
 
echo"<input type='button' id='listarTodos' value='Todos' Disabled>";
echo"<input type='button' id='listarMios' value='Mios'>";
echo"<br>";	
echo"<ul class='nav navbar-nav'>";
echo"<li>  Remitos ya realizados:  </li>";
echo"</ul>";
echo "<br>";
echo "<table class='display' id='tablaRemitosRealizados'>";  
echo "<tr>";  
echo "<th width='55'>Nº Id (Remito)</th>";  
echo "<th width='60'>Fecha</th>"; 
echo "<th>Organizacion</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr id=$row[3]>";  
    echo "<td name='xxxxrt' id=$row[3]>$row[0] ($row[4])</td>";   
    echo "<td name='xxxxrt' id=$row[3]>".substr($row[1],8,2)."/".substr($row[1],5,2)."/".substr($row[1],0,4)."</td>";
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td name='xxxxrt' id=$row[3]>$rowEmp[0]</td>";  
	}
    echo "</tr>";  
}  
echo "</table>";
