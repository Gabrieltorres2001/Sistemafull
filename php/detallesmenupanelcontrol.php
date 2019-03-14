<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcionesPanel.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta

	if(!$resultc = mysqli_query($conexion_sp, "select * from controlpanel where padre = '".$_REQUEST['idmenu']."' order by id")) die("Problemas con la consulta controlpanel");  

imprimir_detalle_menu_panel($resultc, $conexion_sp, '', $_REQUEST['sesses'], $_REQUEST['idmenu']);