<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");


//Primero el Select para buscar un articulo (y la cruz para limpiar)
echo"<select name='articulosAjustados' id='articulosAjustados' tabindex='-1' title='' class='select2-offscreen'>";
//generamos la consulta
if(!$result = mysqli_query($conexion_sp, "select distinct IdProducto from ajustesstock ORDER BY id desc")) die("Problemas con la consulta1");
while ($reg = mysqli_fetch_array($result)){
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, EnStock from productos where IdProducto='".$reg['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$regArticulo = mysqli_fetch_array($resultArticulo); 	
	  echo"<option value=".$reg['IdProducto'].">".substr($reg['IdProducto'],0,6)." | ".$regArticulo['descricpcion']."</option>";
}  
echo"</select>";
//el boton limpiar
echo"<input type='button' id='listoNuevoPre' value='x'>";
//Despues el listado de articulos
//Volemos a generar LA MISMA la consulta
if(!$result = mysqli_query($conexion_sp, "select distinct IdProducto from ajustesstock ORDER BY id desc")) die("Problemas con la consulta1");
echo"<br>";	
echo"<ul class='nav navbar-nav'>";
echo"<li>  Artículos ya controlados:  </li>";
echo"</ul>";
echo "<br>";
echo "<table class='display' id='tablaProductosAjustadosStock'>";  
echo "<tr>";  
echo "<th width='10'>Cod</th>";  
echo "<th width='100'>Descripción</th>";  ;  
echo "<th width='10'>EnStock</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr id=$row[0]>";  
    echo "<td name='xxxxrt' id=$row[0]>$row[0]</td>";   
	//Busco los datos del articulo
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, EnStock from productos where IdProducto='".$row[0]."' limit 1")) die("Problemas con la consulta2");
	$regArticulo = mysqli_fetch_array($resultArticulo); 
    echo "<td name='xxxxrt' id=$row[0]>".$regArticulo['descricpcion']."</td>";  
	echo "<td name='xxxxrt' id=$row[0]>".$regArticulo['EnStock']."</td>";  
    echo "</tr>";  
}  
echo "</table>";
