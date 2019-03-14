	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select NonmbreEmpresa, CondicionesPago from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);  
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

	if(!$resultEmp = mysqli_query($conexion_sp, "select CUIT, CondicionIVA, tipoComprobante from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regEmp = mysqli_fetch_array($resultEmp);
	
	//Enero 2019. Multiples direcciones en la factura, al igual que en remitos
	//if(!$resultEmpDir = mysqli_query($conexion_sp, "select Provoestado from direcciones where CUIT='".$regContEmp['idOrganizacion']."' and Direccion Not Like '%@%' order by id asc limit 1")) die("Problemas con la consulta2");
	//$regEmpDir = mysqli_fetch_array($resultEmpDir);	
	if(!$resultEmpDir = mysqli_query($conexion_sp, "select Provoestado from direcciones where id='".$_REQUEST['diRemito']."' and Direccion Not Like '%@%' limit 1")) die("Problemas con la consulta diRemito");
	$regEmpDir = mysqli_fetch_array($resultEmpDir);	
	
	$CondicionesPago=substr($reg['CondicionesPago'],0,31);
	$Provoestado=substr($regEmpDir['Provoestado'],0,31);
	$CUIT=substr($regEmp['CUIT'],0,31);
	$CondicionIVA=substr($regEmp['CondicionIVA'],0,31);
	$tipoComprobante=substr($regEmp['tipoComprobante'],0,31);
	
	echo "{
		\"CondicionesPago\":\"$CondicionesPago\",
		\"Provoestado\":\"$Provoestado\",
		\"CUIT\":\"$CUIT\",
		\"CondicionIVA\":\"$CondicionIVA\",
		\"tipoComprobante\":\"$tipoComprobante\"
		}";
	
	