<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$_REQUEST['numempresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);
	
//grabo EL VALOR DE la condicion de pago EN LA TABLA DE contacto
	if(!$resultCP = mysqli_query($conexion_sp, "update organizaciones set tipoComprobante=".$_REQUEST['tipoComprobante']." where id = '".$regContEmp['idOrganizacion']."'")) die("Problemas con la consulta contactos Organizacion"); 
	
