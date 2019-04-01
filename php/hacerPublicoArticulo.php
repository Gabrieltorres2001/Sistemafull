<?php
//Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcArticulos.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
	die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

	$productoPublicado=0;
	//Busco el stock actual del articulo
	if(!$producto = mysqli_query($conexion_sp, "select EnStock from productos where IdProducto='".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productos");
	$rowProducto = mysqli_fetch_array($producto);
	//cargo el id del articulo en la tabla productospublicos
	if(!$productoPublico = mysqli_query($conexion_sp, "select Id from productospublicos where IdProducto='".$_REQUEST['idart']."' limit 1")) die("Problemas con la consulta productospublicos");
	$esPublico=mysqli_num_rows($productoPublico);
	$rowProductoPublico = mysqli_fetch_array($productoPublico);

	if ($esPublico>0) {
		//el articulo ya estaba en la tabla
		//solo le actualizo (por las dudas) el stock
		//actualizo el stock
		if(!$resultact = mysqli_query($conexion_sp, "update productospublicos set enStock = '".$rowProducto['EnStock']."', actualiz = now() where Id = '".$rowProductoPublico['Id']."'")){
			echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
			 die("Problemas con la ULTIMA consulta de actualizacion");}
		$productoPublicado=1;
		} else {
			//el articulo no estaba en la tabla
			if(!$resultact = mysqli_query($conexion_sp, "insert into productospublicos (IdProducto, enStock, actualiz) values ('".$_REQUEST['idart']."','".$rowProducto['EnStock']."', now())")){
				 die("Problemas con la consulta de agregar productospublicos");
			}
			$productoPublicado=1;
		}
	echo $productoPublicado;
		