<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$result = mysqli_query($conexion_sp, "select * from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta de lectura");

	$regCopio = mysqli_fetch_array($result); 
	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into productos (TipoProducto, MonedaOrigen, ValorVenta, IVA, descricpcion, OfrecerAdemas, Notas, ComposicionyDescirpcion, IdProveedor, CodigoProveedor, IdRubro, IdSubRubro, StockMinimo, UnidadMedida, CodigoInterno, Numerodeserie, IdCostoProveedor, IdImagen, tangible, HojaFabricante, HojaOtra, UsuarioCreacion, UsuarioModificacion, UsuarioFC, UsuarioFM, Imagen, FechaActualizacion, EnStock, actualiz) values ('".$regCopio['TipoProducto']."', '".$regCopio['MonedaOrigen']."', '".$regCopio['ValorVenta']."', '".$regCopio['IVA']."', '".$regCopio['descricpcion']."', '".$regCopio['OfrecerAdemas']."', '".$regCopio['Notas']."', '".$regCopio['ComposicionyDescirpcion']."', '".$regCopio['IdProveedor']."', '".$regCopio['CodigoProveedor']."', '".$regCopio['IdRubro']."', '".$regCopio['IdSubRubro']."', '".$regCopio['StockMinimo']."', '".$regCopio['UnidadMedida']."', '".$regCopio['CodigoInterno']."', '".$regCopio['Numerodeserie']."', '".$regCopio['IdCostoProveedor']."', '".$regCopio['IdImagen']."', '".$regCopio['tangible']."', '".$regCopio['HojaFabricante']."', '".$regCopio['HojaOtra']."', '".$regCopio['UsuarioCreacion']."', '".$regCopio['UsuarioModificacion']."', '".$regCopio['UsuarioFC']."', '".$regCopio['UsuarioFM']."', '".$regCopio['Imagen']."', '".$regCopio['FechaActualizacion']."', '0', now())")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo NO copiado</label>";
		 die("Problemas con la consulta de copia");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo copiado del id Nº ".$regCopio['IdProducto']."</label>";
		echo"<br />";
	};	
	$id=mysqli_insert_id($conexion_sp);

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from productos where IdProducto = '".$id."' limit 1")) die("Problemas con la consulta");  

	imprimir_detalle_articulos($resultc, $conexion_sp);