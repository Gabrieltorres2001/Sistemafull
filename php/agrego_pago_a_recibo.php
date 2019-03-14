<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$pagos=0;
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "insert into fondos (Tipo, IDComprobante, Fecha, Descripcion, TipoValor, MonedaPago, Importe, actualiz) values ('2', '".$_REQUEST['idcomprobante']."', '".substr($_REQUEST['Fecha'],6,4)."-".substr($_REQUEST['Fecha'],3,2)."-".substr($_REQUEST['Fecha'],0,2)."', '".$_REQUEST['Descripcion']."', '".$_REQUEST['TipoValor']."', '".$_REQUEST['MonedaPago']."', '".$_REQUEST['Importe']."', now())")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar pago");
	}	else {
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Pago agregado</label>";
		$idresultact=mysqli_insert_id($conexion_sp);
	};
	