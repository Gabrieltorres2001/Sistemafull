<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//Primero busco el articulo, para tomarle el precio
	if(!$resultArticulo = mysqli_query($conexion_sp, "select MonedaOrigen, ValorVenta, IVA, tangible from productos where IdProducto='".$_REQUEST['IdProducto']."' limit 1")) die("Problemas con la consulta productos");
	$rowProd = mysqli_fetch_array($resultArticulo);
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "insert into detallecomprobante (IdComprobante, Orden, IdProducto, Imprimir, actualiz, CostoUnitario, IVA, Moneda, Cumplido) values ('".$_REQUEST['idcomprobante']."','".$_REQUEST['Orden']."', '".$_REQUEST['IdProducto']."', '1', now(), '".$rowProd['ValorVenta']."','".$rowProd['IVA']."','".$rowProd['MonedaOrigen']."', '".$rowProd['tangible']."')")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar item al comprobante");
	}	else {
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo agregado</label>";
	};
