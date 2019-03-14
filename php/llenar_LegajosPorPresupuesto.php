<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select idLegajo, idComprobante from detallelegajos where tipoComprobante=5 ORDER BY IdComprobante desc")) die("Problemas con la consulta1");
	
echo"<li>  Filtrar por:  </li>";
echo"<input type='button' id='listarPresupuestos' value='Presupuestos' Disabled>";
echo"<input type='button' id='listarRemitos' value='Remitos'>";
echo"<input type='button' id='listarOCs' value='OCs'>";
echo"<br>";
echo"<ul class='nav navbar-nav'>";
echo"<li>  Legajos ya realizados filtrados por presupuesto:  </li>";
echo"</ul>";
echo "<br>";
echo "<table class='display' id='tablaPrespuestosLegajeados'>";  
echo "<tr>";  
echo "<th width='55'>Numero</th>";  
echo "<th width='80'>Fecha</th>";  
echo "<th>Organizacion</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
	if(!$resultPresup = mysqli_query($conexion_sp, "select NumeroComprobante, NonmbreEmpresa, FechaComprobante from comprobantes where IdComprobante='".$row[1]."' Limit 1")) die("Problemas con la consulta 2");  
	$rowResultPresup = mysqli_fetch_row($resultPresup);
    echo "<tr id=$row[0]>";  
    echo "<td name='xxxxrt' id=$row[0]>$rowResultPresup[0]</td>";   
    echo "<td name='xxxxrt' id=$row[0]>".substr($rowResultPresup[2],8,2)."/".substr($rowResultPresup[2],5,2)."/".substr($rowResultPresup[2],0,4)."</td>";
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$rowResultPresup[1]."' limit 1")) die("Problemas con la consulta 3");
	$regContEmp = mysqli_fetch_array($resultContEmp);
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta 4");
	while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td name='xxxxrt' id=$row[0]>$rowEmp[0]</td>";  
	}
    echo "</tr>";  
}  
echo "</table>";
