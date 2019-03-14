<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	//echo $_REQUEST['IdProveedor'];
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$_REQUEST['IdProveedor']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);		
		
	if(!$resultCP = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id = '".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta contactos Organizacion"); 
	$regCP = mysqli_fetch_array($resultCP);
	//echo $regCP['Organizacion'];	
	//echo $_REQUEST['Notas'];
	if(!$resultact = mysqli_query($conexion_sp, "update productos set TipoProducto = '".$_REQUEST['TipoProducto']."',  MonedaOrigen = '".$_REQUEST['MonedaOrigen']."', ValorVenta = '".$_REQUEST['ValorVenta']."', IVA = '".$_REQUEST['IVA']."', descricpcion = '".$_REQUEST['descricpcion']."', OfrecerAdemas = '".$_REQUEST['OfrecerAdemas']."', Notas = '".$_REQUEST['Notas']."', ComposicionyDescirpcion = '".$_REQUEST['ComposicionyDescirpcion']."', IdProveedor = '".$regCP['Organizacion']."', CodigoProveedor = '".$_REQUEST['CodigoProveedor']."', IdRubro = '".$_REQUEST['IdRubro']."', IdSubRubro = '".$_REQUEST['IdSubRubro']."', StockMinimo = '".$_REQUEST['StockMinimo']."', UnidadMedida = '".$_REQUEST['UnidadMedida']."', CodigoInterno = '".$_REQUEST['CodigoInterno']."', Numerodeserie = '".$_REQUEST['Numerodeserie']."', IdCostoProveedor = '".$_REQUEST['IdCostoProveedor']."', IdImagen = '".$_REQUEST['IdImagen']."', tangible = '".$_REQUEST['tangible']."', HojaFabricante = '".$_REQUEST['HojaFabricante']."', HojaOtra = '".$_REQUEST['HojaOtra']."', UsuarioCreacion = '".$_REQUEST['UsuarioCreacion']."', UsuarioModificacion = '".$_REQUEST['UsuarioModificacion']."', UsuarioFC = '".$_REQUEST['UsuarioFC']."', UsuarioFM = '".$_REQUEST['UsuarioFM']."', Imagen = '".$_REQUEST['Imagen']."', FechaActualizacion = '".$_REQUEST['FechaActualizacion']."', actualiz = now() where IdProducto = '".$_REQUEST['idart']."'")){
		echo"Articulo NO actualizado";
		 die("Problemas con la consulta de actualizacion");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo actualizado</label>";
		echo"<br />";
	};

	//Actualizar (o cargar por primera vez, si no existen) los datos de ubicacion de Deposito
	if(!$resultUbicacion = mysqli_query($conexion_sp, "select id from Stock where Producto='".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta Stock 28");
	if ($rowUbic = mysqli_fetch_array($resultUbicacion)) {
		if(!$resultactDeposito = mysqli_query($conexion_sp, "update Stock set Deposito = '".$_REQUEST['Deposito']."', Estanteria = '".$_REQUEST['Estanteria']."', Estante = '".$_REQUEST['Estante']."'where Producto = '".$_REQUEST['idart']."'")){ echo"Articulo NO actualizado"; die("Problemas con la consulta de actualizacion");}
	} else {
		if(!$resultactDeposito = mysqli_query($conexion_sp, "insert into Stock (id, Producto, Deposito, Estanteria, Estante) values (NULL, '".$_REQUEST['idart']."', '".$_REQUEST['Deposito']."', '".$_REQUEST['Estanteria']."', '".$_REQUEST['Estante']."')")){ echo"Articulo NO agregado"; die("Problemas con la consulta de agregar");}		
	}
	
//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productos");  

	imprimir_detalle_articulos($resultc, $conexion_sp);