<?php
   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select Organizacion, CondDePago, tipoComprobante from organizaciones where id='".$_REQUEST['numempresa']."' limit 1")) die("Problemas con la consulta organizaciones");
	$regContEmp = mysqli_fetch_array($resultContEmp);

	$nombreComp=substr($regContEmp['Organizacion'],0,31);
	$nombreOrg=substr($regContEmp['Organizacion'],0,31);
	$CondDePagoOrg=substr($regContEmp['CondDePago'],0,31);
	$tipoComprobanteOrg=substr($regContEmp['tipoComprobante'],0,31);
	
	echo "{
		\"nombreComp\":\"$nombreComp\",
		\"nombreOrg\":\"$nombreOrg\",
		\"CondDePagoOrg\":\"$CondDePagoOrg\",
		\"tipoComprobanteOrg\":\"$tipoComprobanteOrg\"
		}";
