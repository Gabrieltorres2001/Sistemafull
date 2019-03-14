<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
	echo"<fieldset style='width:95%'>";
	echo"<legend>Historial de novedades</legend>";
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Fecha,Novedad,responsable from novedades ORDER BY IdNovedad desc")) die("Problemas con la consulta");
	echo "<table class='display'>";  
	echo "<tr>";  
	echo "<th width='30'>Fecha</th>";  
	echo "<th width='660'>Novedad</th>";  
	echo "<th width='220'>Responsable</th>";  
	echo "</tr>"; 
	while ($reg = mysqli_fetch_array($result)){  
		echo "<tr>";  
		echo "<td>". $reg['Fecha']."</td>"; 
		echo "<td>". $reg['Novedad']."</td>";
		if(!$sesionSistPlus = mysqli_query($conexion_db, "select username from members where id='".$reg['responsable']."' limit 1")) die("Problemas con la consulta3");
		$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
		echo "<td>". $rowSesionSistPlus['username']."</td>";
		echo "</tr>"; 
	}
	echo "</table>"; 
	echo"</fieldset>";	
