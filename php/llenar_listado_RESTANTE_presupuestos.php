<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa,IdComprobante from comprobantes where TipoComprobante=5 ORDER BY IdComprobante desc limit 25 , 100000")) die("Problemas con la consulta1");
echo "<table class='display' id='tablaPrespuestosRealizados'>";  
echo "<th width='55'></th>";  
echo "<th width='80'></th>";  
echo "<th></th>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td id=$row[3]>$row[0]</td>";   
    echo "<td id=$row[3]>".substr($row[1],8,2)."/".substr($row[1],5,2)."/".substr($row[1],0,4)."</td>";
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from contactos2 where IdContacto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
	while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td id=$row[3]>$rowEmp[0]</td>";  
	}
    echo "</tr>";  
}  
echo "</table>";
