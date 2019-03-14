<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcEmpresas.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultact = mysqli_query($conexion_sp, "update organizaciones set CUIT = '".$_REQUEST['CUIT']."', Organizacion = '".$_REQUEST['Organizacion']."', Informacion = '".$_REQUEST['Informacion']."', Observaciones = '".$_REQUEST['Observaciones']."', CondDePago = '".$_REQUEST['CondDePago']."', DiasDePago = '".$_REQUEST['DiasDePago']."', Horarios = '".$_REQUEST['Horarios']."', EntregaFactura = '".$_REQUEST['EntregaFactura']."', ActividEmpresa = '".$_REQUEST['ActividEmpresa']."', IdTipoContacto = '".$_REQUEST['IdTipoContacto']."', CondicionIVA = '".$_REQUEST['CondicionIVA']."', tipoComprobante = '".$_REQUEST['tipocomprobantesafip']."' where id = '".$_REQUEST['idemp']."'")){
		echo"Empresa NO actualizada";
		 die("Problemas con la consulta de actualizacion");
	}
	else {
		echo"OkOKo";
	};
