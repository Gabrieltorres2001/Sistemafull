<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultcopia = mysqli_query($conexion_sp, "INSERT INTO productos( TipoProducto, MonedaOrigen, ValorVenta, IVA, descricpcion, OfrecerAdemas, Notas, ComposicionyDescirpcion, IdProveedor, CodigoProveedor, IdRubro, IdSubRubro, StockMinimo, UnidadMedida, CodigoInterno, Numerodeserie, IdCostoProveedor, IdImagen, tangible, HojaFabricante, HojaOtra, UsuarioCreacion, UsuarioModificacion, UsuarioFC, UsuarioFM, Imagen, FechaActualizacion, EnStock, actualiz ) VALUES( '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NOW())")){
		echo"Articulo NO creado";
		 die("Problemas con la consulta de nuevo");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo creado</label>";
		echo"<br />";
	};	
	$id=mysqli_insert_id($conexion_sp);

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from productos where IdProducto = '".$id."' limit 1")) die("Problemas con la consulta");  

	imprimir_detalle_articulos($resultc, $conexion_sp);
			
	echo"<input type='button' id='botonActualizaArticuloNuevo' value='Actualizar datos'/><br />";

 

