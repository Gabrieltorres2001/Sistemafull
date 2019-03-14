<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta para los datos de CAEAFIP (Tiene que ser order id desc)
		if(!$resultAfip = mysqli_query($conexion_sp, "select NumeroFactura, TipoFactura from caeafip where CAE='".$_REQUEST['numCAE']."' limit 1")) die("Problemas con la consulta2");
		$regresultAfip = mysqli_fetch_array($resultAfip);	
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update comprobantes set UsuarioModificacion = '".$regresultAfip['TipoFactura'].$regresultAfip['NumeroFactura']."',  actualiz = now() where IdComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"Articulo NO actualizado";
		 die("Problemas con la consulta de actualizacion");
	} else {
		echo"OkOko";
	};
