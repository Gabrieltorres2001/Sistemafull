<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de actualizacion DEL CAMPO QUE RECIBI MODIFICADO. No importa cual DE LOS DESCUENTOS es, ya que despues los voy a leer a todos de nuevo y voy a actualizar los precios unitarios y subtotal.
	if(!$resultact = mysqli_query($conexion_sp, "update fondos set ".$_REQUEST['campo']." = '".$_REQUEST['valor']."', actualiz = now() where ID = '".$_REQUEST['idcomprobante']."'")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
		 die("Problemas con la PRIMERA consulta de actualizacion");
	};
	
