<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion DEL CAMPO QUE RECIBI MODIFICADO. No importa cual DE LOS DESCUENTOS es, ya que despues los voy a leer a todos de nuevo y voy a actualizar los precios unitarios y subtotal.
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set ".$_REQUEST['campo']." = '".number_format(($_REQUEST['valor']/100),4,'.','')."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};
	
//LUEGO RELEO LOS CAMPOS QUE PUEDAN AFECTAR AL COSTO UNITARIO (COSTO UNITARIO DEL ARTICULO ya que aca no cambia porque es identidad del articulo, Y DESCUENTOS.
	if(!$resultLect = mysqli_query($conexion_sp, "select IdProducto,Descuento,desc1,desc2,Cantidad from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."' limit 1")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la SEGUNDA consulta de actualizacion");
	}
	$rowresultLect = mysqli_fetch_array($resultLect);
//LUEGO BUSCO EL VALOR DEL PRODUCTO EN LA TABLA DE PRODUCTOS
	if(!$resultLectProd = mysqli_query($conexion_sp, "select ValorVenta from productos where IdProducto = '".$rowresultLect['IdProducto']."' limit 1")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la TERCERA consulta de actualizacion");
	}
	$rowresultLectProd = mysqli_fetch_array($resultLectProd);
//LUEGO CALCULO EL VALOR DEL PRODUCTO PARA ESTE PRESUPUESTO EN FUNCION DE LOS DESCUENTOS
	$costoUnit=((number_format($rowresultLectProd['ValorVenta'],2,'.','')*(1-number_format($rowresultLect['Descuento'],4,'.','')))*(1-number_format($rowresultLect['desc1'],4,'.','')))*(1-number_format($rowresultLect['desc2'],4,'.',''));
	$Subtot=number_format($rowresultLect['Cantidad'],2,'.','')*number_format($costoUnit,2,'.','');
//generamos la consulta de actualizacion de los campos que cambian en consecuencia de los descuentos (costo unitario y subtotal)
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set CostoUnitario = '".$costoUnit."', SubTotal = '".$Subtot."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la ULTIMA consulta de actualizacion");
	};
