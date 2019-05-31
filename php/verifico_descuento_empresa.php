<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion
	if(!$resultact = mysqli_query($conexion_sp, "select Id from descuentos where (Empresa = '".$_REQUEST['Empresa']."' and Porcentaje = '".$_REQUEST['Porcentaje']."' and Tipo = '".$_REQUEST['Tipo']."')")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de buscar descuento");
	};
	$row_cnt = mysqli_num_rows($resultact);
	if ($row_cnt > 0) {echo "Existe";} else {echo "No existe";}
