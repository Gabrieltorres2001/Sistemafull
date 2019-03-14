<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//Primero leo el campo costo unitario (leido del presupuesto, no del articulo)
	if(!$resultLect = mysqli_query($conexion_sp, "select Cantidad from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."' limit 1")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la consulta de actualizacion");
	}
//luego lo multiplico por la cantidad que acabo de modificar en el formulario
	$rowresultLect = mysqli_fetch_array($resultLect);
	$Subtot=number_format($rowresultLect['Cantidad'],2,'.','')*number_format($_REQUEST['valor'],2,'.','');
//generamos la consulta de actualizacion del subtotal
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set ".$_REQUEST['campo']." = '".number_format($_REQUEST['valor'],2,'.','')."', SubTotal = '".$Subtot."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};
