<?php
function llenar_listado_Comprobantes_emitidos() {
   //Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta por año
   if(!$resultAnno = mysqli_query($conexion_sp, "SELECT DISTINCT year(caeafip.FechaFactura) FROM caeafip")) die("Problemas con la consulta Año");
echo "<table class='display' id='tablaContactos'>";  
while ($rowAnno = mysqli_fetch_array($resultAnno)){   
	echo "<tr>";  
	echo "<th width='320'>".$rowAnno['year(caeafip.FechaFactura)']."</th>";  
	echo "</tr>";  
	if(!$resultMes = mysqli_query($conexion_sp, "SELECT DISTINCT month(caeafip.FechaFactura) FROM `caeafip` where year(caeafip.FechaFactura)='".$rowAnno['year(caeafip.FechaFactura)']."'")) die("Problemas con la consulta Año");
	while ($rowMes = mysqli_fetch_array($resultMes)){   
		 //echo "<tr id=".$row['id'].">";  
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	echo "<td id=".$rowAnno['year(caeafip.FechaFactura)'].$rowMes['month(caeafip.FechaFactura)'].">".$meses[$rowMes['month(caeafip.FechaFactura)']-1]."</td>"; 
    	echo "</tr>";  
	};
};  
echo "</table>";
}

