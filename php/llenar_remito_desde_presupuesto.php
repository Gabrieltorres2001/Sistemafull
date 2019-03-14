	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';


$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	if(!$resultComprobante = mysqli_query($conexion_sp, "select IdComprobante from comprobantes where NumeroComprobante='".$_REQUEST['presup']."' and TipoComprobante='5' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);  
	
	if(!$resultDetComprobante = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$reg['IdComprobante']."'")) die("Problemas con la consulta1");
	while ($row = mysqli_fetch_row($resultDetComprobante)){
		//Nueva Junio 2018. Tengo que ver si el producto es tangible para ver si lo tildo o no en el detallecomprobante
		if(!$resultArticulo = mysqli_query($conexion_sp, "select EnStock, tangible from productos where IdProducto='".$row[2]."' limit 1")) die("Problemas con la consulta productos");
		$rowProd = mysqli_fetch_array($resultArticulo);		
		
	//generamos la consulta de agregar detallecomprobante	
		if(!$resultcopia = mysqli_query($conexion_sp, "insert into detallecomprobante (IdComprobante, IdProducto, Cantidad, CostoUnitario, NumeroSerie, SubTotal, Orden, Destino, DestinoSalida, DestinoEntrada, Descuento, IVA, Moneda, desc1, desc2, Cumplido, Observaciones, Inversion, Previsto, Anulado, Imprimir, PlazoEntrega, FSolicitud, Fcotizacion, FConfirmacion, FEntrega, actualiz) values (".$_REQUEST['idremit'].", '".$row[2]."', '".$row[3]."', '".$row[4]."', '".$row[5]."', '".$row[6]."', '".$row[7]."', '".$row[8]."', '".$row[9]."', '".$row[10]."', '".$row[11]."', '".$row[12]."', '".$row[13]."', '".$row[14]."', '".$row[15]."', '".$rowProd['tangible']."', '".$row[17]."', '".$row[18]."', '".$row[19]."', '".$row[20]."', '".$row[21]."', '".$row[22]."', '".$row[23]."', '".$row[24]."', '".$row[25]."', '".$row[26]."', now())")){
		 die("Problemas con la consulta de nuevo item");
	} else {echo"Agregado";}
	
		//Nueva Junio 2018. por ultimo queda ajustar el stock del producto (siempre y cuando sea tangible)
		if ($rowProd['tangible'] == '1'){
			$nuevaCantidad=$rowProd['EnStock']-$row[3];
			if(!$resultact = mysqli_query($conexion_sp, "update productos set EnStock = '".$nuevaCantidad."', actualiz = now() where IdProducto = '".$row[2]."'")){
				echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
				die("Problemas con la consulta de actualizacion");
			};
		};
	}		
	

