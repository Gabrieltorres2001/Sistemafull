<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	echo"<fieldset style='width:95%'>";
	echo"<legend>Historial de cotizaciones</legend>";
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Dolar, Euro, Fecha from cotizacionesnew ORDER BY Id desc")) die("Problemas con la consulta");
	echo "<table class='display'>";  
	echo "<tr>";  
	echo "<th width='300'>Fecha</th>";  
	echo "<th width='120'>Dolar</th>";  
	echo "<th>Euro</th>";  
	echo "</tr>"; 
	while ($reg = mysqli_fetch_array($result)){  
		echo "<tr>";  
		echo "<td>". $reg['Fecha']."</td>"; 
		echo "<td> $ ". number_format($reg['Dolar'],2,',','.')."</td>";
		echo "<td> $ ". number_format($reg['Euro'],2,',','.')."</td>";
		echo "</tr>"; 
	}
	echo "</table>"; 
	echo"</fieldset>";	
