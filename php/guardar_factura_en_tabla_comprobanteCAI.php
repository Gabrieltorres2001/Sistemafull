<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");	
	
	//Primero busco el punto de venta
	if(!$resultcPV = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre=1 limit 1")) die("Problemas con la consulta controlpanel");
	$regPV = mysqli_fetch_array($resultcPV);
	
	if ($_REQUEST['tipoComprobante']=='FC'){$cadenaFactura='';}
	if ($_REQUEST['tipoComprobante']=='NC'){$cadenaFactura='NC';}
	if ($_REQUEST['tipoComprobante']=='ND'){$cadenaFactura='ND';}
	if ($_REQUEST['tipoFactura']=='A'){$cadenaFactura=$cadenaFactura.'A';}
	if ($_REQUEST['tipoFactura']=='B'){$cadenaFactura=$cadenaFactura.'B';}
	$cadenaFactura=$cadenaFactura.str_pad($regPV['ContenidoValor'], 4,"0", STR_PAD_LEFT);
	$cadenaFactura=$cadenaFactura.'-'.str_pad($_REQUEST['numFactura'], 8,"0", STR_PAD_LEFT);
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update comprobantes set UsuarioModificacion = '".$cadenaFactura."',  actualiz = now() where IdComprobante = '".$_REQUEST['idcomprobante']."'")){
		echo"Factura NO registrada.";
		 die("Problemas con la consulta de actualizacion");
	} else {
		echo"OkOko".$cadenaFactura;
	};
