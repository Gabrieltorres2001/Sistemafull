<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	//Primero busco datos del articulo para reponer el stock (si es tangible)
	if(!$resultDetComprobante = mysqli_query($conexion_sp, "select IdProducto, Cantidad, Cumplido from detallecomprobante where IdDetalleComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$rowDet = mysqli_fetch_array($resultDetComprobante);
	if ($rowDet['Cumplido'] == '1'){
		//Tenia el cumplido, pero tambien hay que ver si el producto es tangible
		if(!$resultArticulo = mysqli_query($conexion_sp, "select EnStock, tangible from productos where IdProducto='".$rowDet['IdProducto']."' limit 1")) die("Problemas con la consulta productos");
		$rowProd = mysqli_fetch_array($resultArticulo);	
		if ($rowProd['tangible'] == '1'){
			//Es tangible. Le repongo el stock que voy a borrar.
			$nuevaCantidad=$rowProd['EnStock']+$rowDet['Cantidad'];
			if(!$resultact = mysqli_query($conexion_sp, "update productos set EnStock = '".$nuevaCantidad."', actualiz = now() where IdProducto = '".$rowDet['IdProducto']."'")){
				echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
				die("Problemas con la consulta de actualizacion");
			};				
		}
	} 
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "delete from detallecomprobante where IdDetalleComprobante=".$_REQUEST['idcomprobante']."")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No borrado</label>";
		 die("Problemas con la consulta de borrar item");
	}	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo eliminado del remito</label>";
	};
