<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//Primero busco en las tablas auxiliares los datos auxiliares de plazo entrega, forma de pago, responsable de solicito y transporte
		if(!$idComprobante = mysqli_query($conexion_sp, "select IdComprobante from comprobantes where (NumeroComprobante = '".$_REQUEST['numpresupuesto']."' and TipoComprobante='9') limit 1")) die("Problemas con la comprobantes");
	$regIdComprobante = mysqli_fetch_array($idComprobante);
	$elIdComprobante=$regIdComprobante['IdComprobante'];

	if ($_REQUEST['numCcPago']!=0){
		//ESto no va mas! Ya no tengo que buscar el texto en función del id, ahora directamente guardo el id
	$laFormaPago=$_REQUEST['numCcPago'];
	}
	else {
	$laFormaPago='';}
	
	if ($_REQUEST['numPpEntrega']!=0){
		//ESto no va mas! Ya no tengo que buscar el texto en función del id, ahora directamente guardo el id
		$elPlazoEntrega=$_REQUEST['numPpEntrega'];}
	else {
	$elPlazoEntrega='';}
	
	if ($_REQUEST['numTtransp']!=0){
		if(!$transportes = mysqli_query($conexion_sp, "select Transporte from z_transportes where idTransporte='".$_REQUEST['numTtransp']."' limit 1")) die("Problemas con la z_transportes");
	$regTransportes = mysqli_fetch_array($transportes);
	$elTransporte=$regTransportes['Transporte'];}
	else {
	$elTransporte='';}

//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "update comprobantes set CondicionesPago = '".$laFormaPago."', Notas = '".$_REQUEST['textNotas']."', Transporte = '".$elTransporte."', PlazoEntrega = '".$elPlazoEntrega."', CondicionesPago = '".$laFormaPago."', Solicito = '".$_REQUEST['solicitaa']."', NumeroComprobante01 = '".$_REQUEST['textPetOfer']."', actualiz = now() where (NumeroComprobante = '".$_REQUEST['numpresupuesto']."' and TipoComprobante='9')")){
		echo"OC NO actualizado";
		 die("Problemas con la consulta de actualizacion");
	}
	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>OC actualizado</label>";
		echo"<label id='NumeroOCRecienActualizado' style='font-size:1em; font-weight:bold; color:red; visibility: hidden;'>".$elIdComprobante."</label>";
		echo"<br />";
	};

