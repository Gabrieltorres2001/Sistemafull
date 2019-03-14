<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
	if(!$resultDetalle = mysqli_query($conexion_sp, "select * from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1' order by ID")) die("Problemas con la consulta2");

echo "Movimientos asociados a este comprobante:";
echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetallePagos'>";  
echo "<tr>";   
echo "<th width='10'>Fecha</th>";   
echo "<th width='12'>Forma de pago</th>"; 
echo "<th width='4'>Moneda</th>"; 
echo "<th width='4'>Importe</th>"; 
echo "<th width='16'>Descripcion</th>";
echo "<th width='1'>Borrar</th>";
echo "</tr>";   
while ($row = mysqli_fetch_row($resultDetalle)){  
	if(!$monedaPago = mysqli_query($conexion_sp, "select Origen from monedaorigen where IdRegistroCambio='".$row[6]."' limit 1")) die("Problemas con la consulta2");
	$rowmonedaPago = mysqli_fetch_array($monedaPago);
	if(!$formaPago = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$row[5]."' limit 1")) die("Problemas con la consulta3");
	$rowformaPago = mysqli_fetch_array($formaPago);
    echo "<tr id='pago&$row[0]'>";    
    echo "<td name='xxxx' id='pago&$row[0]' height='50'>".substr($row[2],8,2)."/".substr($row[2],5,2)."/".substr($row[2],0,4)."</td>";  
    echo "<td name='xxxx' id='pago&$row[0]'>".$rowformaPago['Descripcion']."</td>";	
    echo "<td name='xxxx' id='pago&$row[0]'>".$rowmonedaPago['Origen']."</td>";
    echo "<td name='xxxx' id='pago&$row[0]'>".number_format($row[7],2)."</td>";
    echo "<td name='xxxx' id='pago&$row[0]'>$row[3]</td>";
	echo "<td id='$row[0]&action'><img name='xxxxx' id='$row[0]&$row[2]&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";
    echo "</tr>";	
}  
echo "</table>";

//ahora la ultima fila en blanco para agregar item

	echo "<img name='xxxxz' src='./images/Agregar.jpg' width='35' height='35'>";
	echo "<img name='xxxxy' id='$row[0]&$row[2]&imagenOk' src='./images/recargar.png' width='32' height='32'>";
