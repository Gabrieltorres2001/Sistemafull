<?php
    //Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tenerpermiso para modificar
		if(!$permisoModificar = mysqli_query($conexion_db, "select PuedeModificarContactos from members where id='".$_REQUEST['idsesion']."' limit 1")) die("Problemas con la consultamembers");
		$rowPermisoModificar = mysqli_fetch_array($permisoModificar);
		$puedoModificar=0;
		if($rowPermisoModificar['PuedeModificarContactos']!=0)$puedoModificar=1;
		
		echo "<p>";
		if ($puedoModificar==0) {echo"<input type='button' id='botonActualizaEmpresa' value='Actualizar datos' disabled>";} else {echo"<input type='button' id='botonActualizaEmpresa' value='Actualizar datos'/>";}
		echo " ";
		if ($puedoModificar==0) {echo"<input type='button' id='botonNuevaEmpresa' value='Nueva empresa' disabled>";} else {echo"<input type='button' id='botonNuevaEmpresa' value='Nueva empresa'/>";}
		echo " ";
		if ($puedoModificar==0) {echo"<input type='button' id='botonNuevoDescuento' value='Nuevo descuento / recargo' disabled>";} else {echo"<input type='button' id='botonNuevoDescuento' value='Nuevo descuento / recargo'/>";}
		echo"</br>";
		echo"</br>";
		echo"<input type='checkbox' id='checkMostrarAFIP' value='MostrarAFIP'/>Mostrar datos en AFIP";
		echo"</p>";
