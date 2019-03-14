<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   $textoBusqueda=$_REQUEST['busqueda'];
   switch ($_REQUEST['orden']) {
    case "1":
        $ordenBusqueda="IdProducto asc";
        break;
    case "2":
        $ordenBusqueda="descricpcion asc";
        break;
    case "3":
        $ordenBusqueda="idProveedor asc";
        break;
	case "4":
        $ordenBusqueda="ValorVenta asc";
        break;
    case "5":
        $ordenBusqueda="ValorVenta desc";
        break;
    case "6":
        $ordenBusqueda="EnStock asc";
        break;
    case "7":
        $ordenBusqueda="EnStock desc";
        break;
}
   if ($textoBusqueda=="")
   {
   	if(!$result = mysqli_query($conexion_sp, "select IdProducto,descricpcion,idProveedor,MonedaOrigen,ValorVenta,EnStock from productos ORDER BY ".$ordenBusqueda." limit 500")) die("Problemas con la consulta");  
   }
   else
   {
	   if (substr_count($textoBusqueda, '*') > 0) $textoBusqueda=str_replace("*", "%", $textoBusqueda);

		if(!$result = mysqli_query($conexion_sp, "select IdProducto,descricpcion,idProveedor,MonedaOrigen,ValorVenta,EnStock from productos where (IdProducto like '%".$textoBusqueda."%') or (descricpcion like '%".$textoBusqueda."%') or (idProveedor like '%".$textoBusqueda."%') or (CodigoProveedor like '%".$textoBusqueda."%') ORDER BY ".$ordenBusqueda." limit 500")) die("Problemas con la consulta");     
   }
//echo ($textoBusqueda);
echo "<table class='display' width='450' style='table-layout:fixed'>";
if (mysqli_num_rows($result) > 499){
	echo "<caption>Listado limitado a los primeros 500 resultados</caption>";
	}
	else {
			echo "<caption>Resultados encontrados: ".mysqli_num_rows($result)."</caption>";
	}
echo "<tr>";
echo "<th width='30'>Cod</th>";  
echo "<th width='100'>Descripción</th>";  
echo "<th width='140'>Proveedor</th>";  
echo "<th width='80'>ValorVenta</th>"; 
echo "<th width='50'>EnStock</th>"; 
echo "</tr>";  
while ($row = mysqli_fetch_array($result)){   
    echo "<tr id=".$row['IdProducto'].">";  
    echo "<td name='xxxxb' id=".$row['IdProducto'].">".$row['IdProducto']."</td>";   
    echo "<td name='xxxxb' width='80' id=".$row['IdProducto'].">".$row['descricpcion']."</td>";
    echo "<td name='xxxxb' id=".$row['IdProducto'].">".$row['idProveedor']."</td>"; 
	if(!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen where IdRegistroCambio='".$row['MonedaOrigen']."'")) die("Problemas con la consulta monedaorigen"); 
		$regTM = mysqli_fetch_array($resultTM); 
    echo "<td name='xxxxb' id=".$row['IdProducto'].">".$regTM['Simbolo']." ".$row['ValorVenta']."</td>";
    echo "<td name='xxxxb' id=".$row['IdProducto'].">".$row['EnStock']."</td>"; 
    echo "</tr>";  
};

echo "</table>";
