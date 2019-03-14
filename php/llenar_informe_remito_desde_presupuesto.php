<?php 
	//Creamos la conexión
	include_once '../includes/db_connect.php';
	
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");

echo"<fieldset style='width:99%; height:90%'>";
	echo"<legend>Opciones de impresion de REMITO:</legend>";
		echo"<fieldset style='width:150px'>";
			echo"<legend>Descripción extendida:</legend>";	
			echo"<input type='radio' id='radio111' name='descripRem' disabled>Automática</option>";
			echo"<br>";
			echo"<input type='radio' id='radio112' name='descripRem' checked disabled>Ninguna</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:130px'>";
			echo"<legend>Número de serie:</legend>";	
			echo"<input type='radio' id='radio121' name='serieremito' checked disabled>Automático</option>";
			echo"<br>";
			echo"<input type='radio' id='radio122' name='serieremito' disabled>Ninguno</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:150px'>";
			echo"<legend>Nº O.C.:</legend>";	
			echo"<input type='text' id='ocRemito' name='ocRemito'>";
		echo"</fieldset>";
		echo"<fieldset style='width:130px'>";
			echo"<legend>Nº preimpreso:</legend>";	
			echo"<input type='text' id='preimpreso1' name='preimpreso1'>";
			echo"<br>";
		echo"</fieldset>";
		echo"<fieldset style='width:230px; border: 0px;'>";	
			echo"<legend style='color: #FF0000;'>Al presionar el botón <B> generá un nuevo formulario tipo remito. </b>Luego se le enviará a la ventana de remitos.</legend>";
			echo"<br>";	
		//tengo que tener asociado un usuario de sistemaplus PERO ADEMAS tengo que tener permiso para cotizar
		if(!$sesionSistPlus = mysqli_query($conexion_db, "select PuedeCotizar from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la consulta3");
		$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
		$puedoCotizar=0;
		if($rowSesionSistPlus['PuedeCotizar']!=0) $puedoCotizar=1;
		
		if ($puedoCotizar==0) {echo"<input type='button' id='informeRemitoEnPresupuesto' value='Generar Remito' disabled>";} else {echo"<input type='button' id='informeRemitoEnPresupuesto' value='Generar Remito'/>";}
		//echo"<input type='button' id='informeRemitoEnPresupuesto' value='Generar Remito'/>";
		echo"</fieldset>";
echo"</fieldset>";
echo"<br>";
