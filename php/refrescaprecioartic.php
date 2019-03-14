<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//Primero busco en la tabla DETALLECOMPROBANTES el codigo del articulo que esta guardado en ese registro (el que acabo de modificar o no)
//tambien leo los descuentos y la cantidad para despues hacer los calculos
	if(!$resultLect = mysqli_query($conexion_sp, "select IdProducto, Cantidad, Descuento, desc1, desc2 from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idart']."' limit 1")){
		 die("Problemas con la consulta de lectura previa 1");
	}
	$rowresultLect = mysqli_fetch_array($resultLect);
	
//luego busco el precio y la moneda de ese producto en la tabla productos
	if(!$resultPrecio = mysqli_query($conexion_sp, "select MonedaOrigen, ValorVenta from productos where IdProducto = '".$rowresultLect['IdProducto']."' limit 1")){
		 die("Problemas con la consulta de lectura previa 2");
	}
	$rowresultPrecio = mysqli_fetch_array($resultPrecio);

//luego calculo en unitario (por los descuentos) y el subtotal (por la cantidad)
	//unitario
		$costoUnit=((number_format($rowresultPrecio['ValorVenta'],2,'.','')*(1-number_format($rowresultLect['Descuento'],4,'.','')))*(1-number_format($rowresultLect['desc1'],4,'.','')))*(1-number_format($rowresultLect['desc2'],4,'.',''));
	//subtotal
		$Subtot=number_format($costoUnit,2,'.','')*number_format($rowresultLect['Cantidad'],2,'.','');
		
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set CostoUnitario = '".$costoUnit."', SubTotal = '".$Subtot."', Moneda = '".$rowresultPrecio['MonedaOrigen']."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idart']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};
