<?php

	//Creamos la conexión
	include_once '../includes/db_connect.php';
	
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tener asociado un usuario de sistemaplus PERO ADEMAS tengo que tener permiso para COMPRAR
		if(!$sesionSistPlus = mysqli_query($conexion_db, "select PuedeComprar from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la consulta3");
		$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
		$puedoCotizar=0;
		if($rowSesionSistPlus['PuedeComprar']!=0)$puedoCotizar=1;
		
		if ($puedoCotizar==0) {echo"<input type='button' id='nuevaOrdenCompra' value='Nueva OC' disabled>";} else {echo"<input type='button' id='nuevaOrdenCompra' value='Nueva OC'/>";}
		
