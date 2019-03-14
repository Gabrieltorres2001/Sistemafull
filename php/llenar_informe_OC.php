<?php 

   //Creamos la conexión
//include_once '../includes/sp_connect.php';
//$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
//    die("Problemas con la conexión");
//	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
//   if(!$resultComprobante = mysqli_query($conexion_sp, "select OCEnviada from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
//	$reg = mysqli_fetch_array($resultComprobante);  

echo"<fieldset style='width:99%'>";
	echo"<legend>Opciones de impresion de ORDEN DE COMPRA:</legend>";
		echo"<fieldset style='width:150px'>";
			echo"<legend>Descripción extendida:</legend>";	
			echo"<input type='radio' id='radio11' name='descrip'>Automática</option>";
			echo"<br>";
			echo"<input type='radio' id='radio12' name='descrip' checked>Ninguna</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:180px'>";
			echo"<legend>Precios (para el proveedor):</legend>";	
			echo"<input type='radio' id='radio21' name='iva'>Sin precios</option>";
			echo"<br>";
			echo"<input type='radio' id='radio22' name='iva' checked>Con precios</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:150px; border: 0px;'>";	
			echo"<input type='button' id='informe' value='Emitir Orden de compra'/>";
		echo"</fieldset>";
//		echo"<fieldset style='width:120px'>";
//			echo"<legend>OC Enviada:</legend>";	
//			echo"<input type='checkbox' id='checkbox11' name='moneda' checked>Enviada</option>";
//		echo"</fieldset>";
echo"</fieldset>";
echo"<br>";
