<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
//generamos la consulta
	if(!$resultc = mysqli_query($conexion_sp, "select * from ajustesstock where IdProducto = '".$_REQUEST['idart']."'")) die("Problemas con la consulta productos");  

//La tabla
echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetalleAjustes'>";  
echo "<tr>";  
echo "<th width='1' style='text-align:center'>Fecha</th>";  
echo "<th width='1' style='text-align:center'>Stock anterior</th>"; 
echo "<th width='15' style='text-align:center'>Stock nuevo</th>";  
echo "<th width='4' style='text-align:center'>Responsable</th>"; 
echo "</tr>"; 

while ($row = mysqli_fetch_array($resultc)){  
echo "<tr id='".$row['id']."'>";  
	echo "<td height='50' style='text-align:center' ><input class='input' type='text' size='22' style='text-align:center' value=".$row['Fecha']." Disabled></td>";
	echo "<td height='50' style='text-align:center' ><input class='input' type='text' size='12' style='text-align:center' value=".$row['stockAnterior']." Disabled></td>";
	echo "<td height='50' style='text-align:center' ><input class='input' type='text' size='12' style='text-align:center' value=".$row['stockContado']." Disabled></td>";
	if(!$sesionSistPlus = mysqli_query($conexion_db, "select username from members where id='".$row['Responsable']."' limit 1")) die("Problemas con la members");
	$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
	echo "<td height='50' style='text-align:center' ><input class='input' type='text' size='55' style='text-align:center' value=".$rowSesionSistPlus['username']." Disabled></td>";
echo "</tr>";  
}