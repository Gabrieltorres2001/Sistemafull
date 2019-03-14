<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//BUSCO EL VALOR DEL PRODUCTO EN LA TABLA DE PRODUCTOS
	if(!$resultLectProd = mysqli_query($conexion_sp, "select descricpcion,ValorVenta,MonedaOrigen, IVA from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")){
		 die("Problemas con la primera consulta de actualizacion");
	}
	$rowresultLectProd = mysqli_fetch_array($resultLectProd);
	
//busco la moneda correspondiente a la del articulo (en el articulo es numerico)
	if(!$resultLectMoned = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio = '".$rowresultLectProd['MonedaOrigen']."' limit 1")){
		 die("Problemas con la segunda consulta de actualizacion");
	}
	$rowresultLectMoned = mysqli_fetch_array($resultLectMoned);
	
//busco el IVA correspondiente a la del articulo (en el articulo es numerico)
	if(!$resultLectIva = mysqli_query($conexion_sp, "select IVA from z_ivas where IdRegistro = '".$rowresultLectProd['IVA']."' limit 1")){
		 die("Problemas con la tercera consulta de actualizacion");
	}
	$rowresultLectIva = mysqli_fetch_array($resultLectIva);

	//$descripIt=$rowresultLectProd['descricpcion'];
	$findMe='"';
	$pos = strpos($rowresultLectProd['descricpcion'],$findMe);
	if ($pos !== false){
		$descripIt=substr($rowresultLectProd['descricpcion'],0,$pos)."...";
	} else {
			$descripIt=$rowresultLectProd['descricpcion'];
	}
	$monedaVent=$rowresultLectMoned['Simbolo'];
	$valorVent=$rowresultLectProd['ValorVenta'];
	$valorIva=$rowresultLectIva['IVA'];
	echo "{
		\"descripIt\":\"$descripIt\",
		\"monedaVent\":\"$monedaVent\",
		\"valorVent\":\"$valorVent\",
		\"valorIva\":\"$valorIva\"
	}";
