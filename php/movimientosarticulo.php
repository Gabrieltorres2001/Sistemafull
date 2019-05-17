<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
	$sql = "SELECT 
	detalle.IdDetalleComprobante,detalle.IdComprobante,detalle.IdProducto,detalle.Cantidad,detalle.CostoUnitario,detalle.SubTotal,detalle.Cumplido,detalle.Moneda, 
	monedaorigen.Simbolo,
	comprobantes.TipoComprobante,comprobantes.FechaComprobante,comprobantes.NonmbreEmpresa,comprobantes.NumeroComprobante,
	z_tipocomprobante.TipoComprobante,
	organizaciones.Organizacion
	FROM detallecomprobante as detalle 
	LEFT JOIN monedaorigen on monedaorigen.IdRegistroCambio =  detalle.Moneda 
	LEFT JOIN comprobantes on comprobantes.IdComprobante = detalle.IdComprobante
	LEFT JOIN z_tipocomprobante on z_tipocomprobante.IdTipoComprobante = comprobantes.TipoComprobante
	LEFT JOIN contactos2 ON contactos2.IdContacto = comprobantes.NonmbreEmpresa
	LEFT JOIN organizaciones ON organizaciones.id = contactos2.idOrganizacion
	WHERE IdProducto = '".$_REQUEST['idart']."' order by IdComprobante";
	
	if(!$resultc = mysqli_query($conexion_sp,$sql)) die("Problemas con la consulta detallecomprobante");
		
		if (mysqli_num_rows($resultc) > 0){  
			imprimir_movimientos_articulos($resultc, $conexion_sp);
		}else
		{ 	echo "<table class='display' width='650' style='table-layout:fixed'>"; 
	//echo "<caption>Resultados encontrados: ".mysqli_num_rows($resultc)."</caption>";
	echo "<caption>Sin movimientos</caption>";

		}