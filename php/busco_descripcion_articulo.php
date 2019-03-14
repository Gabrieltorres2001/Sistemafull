<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//LUEGO BUSCO EL PRODUCTO EN LA TABLA DE PRODUCTOS
	if(!$resultLectProd = mysqli_query($conexion_sp, "select descricpcion from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")){
		 die("Problemas con la consulta de lectura");
	}
	if ($rowresultLectProd = mysqli_fetch_array($resultLectProd)) {echo $rowresultLectProd['descricpcion'];} else {echo "Artículo no encontrado";}

