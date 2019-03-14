<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//BUSCO EL VALOR DEL PRODUCTO EN LA TABLA DE PRODUCTOS
	if(!$resultTipoPago = mysqli_query($conexion_sp, "select ID, Descripcion from tipos where Tipo = '".$_REQUEST['tipo']."'")){
		 die("Problemas con la primera consulta de actualizacion");
	}
	echo "{ ";
	while ($row = mysqli_fetch_row($resultTipoPago)){ 

		echo $row[0]." : \"$row[1]\" , ";

	//$vec[]=$row;
	}
	echo " }";
	//$cad=json_encode($vec);
	//echo $cad;