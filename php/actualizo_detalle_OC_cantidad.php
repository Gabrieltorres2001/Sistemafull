<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//Primero leo el campo costo unitario (leido del presupuesto, no del articulo)
//Tambien leo el campo cantidad existente, para actualizar correctamente el stock del articulo
	if(!$resultLect = mysqli_query($conexion_sp, "select CostoUnitario, Cantidad, IdProducto from detallecomprobante where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."' limit 1")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la consulta de actualizacion");
	}
//luego lo multiplico por la cantidad que acabo de modificar en el formulario
	$rowresultLect = mysqli_fetch_array($resultLect);
	$cantVieja=$rowresultLect['Cantidad'];
	$Subtot=number_format($rowresultLect['CostoUnitario'],2,'.','')*number_format($_REQUEST['valor'],2,'.','');
//generamos la consulta de actualizacion del subtotal
	if(!$resultact = mysqli_query($conexion_sp, "update detallecomprobante set ".$_REQUEST['campo']." = '".$_REQUEST['valor']."', SubTotal = '".$Subtot."', actualiz = now() where IdDetalleComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};

//por ultimo generamos la consulta de actualizacion de stock de productos
		if(!$resultArt = mysqli_query($conexion_sp, "select EnStock from productos where IdProducto = '".$rowresultLect['IdProducto']."' limit 1")){
			die("Problemas con la consulta de lectura detallecomprobante");
		};
		if ($cant = mysqli_fetch_array($resultArt)){
			if ($_REQUEST['chkstk'] == '1'){
				//Aca es donde cambia respecto a actualizo_detalle_remito_cantidad (en + por -)
				$nuevaCantidad=$cant['EnStock']+$_REQUEST['valor']-$cantVieja;
				echo $nuevaCantidad.'='.$cant['EnStock'].'+'.$_REQUEST['valor'].'-'.$cantVieja;
				if(!$resultact = mysqli_query($conexion_sp, "update productos set EnStock = '".$nuevaCantidad."', actualiz = now() where IdProducto = '".$rowresultLect['IdProducto']."'")){
				echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
				 die("Problemas con la consulta de actualizacion");
			};
			} else {
				//no hago nada porque no tiene tilde
			}	
		}	
	
	
	