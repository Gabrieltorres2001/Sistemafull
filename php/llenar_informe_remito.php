<?php 

echo"<fieldset style='width:99%'>";
	echo"<legend>Opciones de impresion de REMITO:</legend>";
		echo"<fieldset style='width:150px'>";
			echo"<legend>Descripción extendida:</legend>";	
			echo"<input type='radio' id='radio111' name='descrip'>Automática</option>";
			echo"<br>";
			echo"<input type='radio' id='radio112' name='descrip' checked>Ninguna</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:130px'>";
			echo"<legend>Número de serie:</legend>";	
			echo"<input type='radio' id='radio121' name='serieremito' checked>Automático</option>";
			echo"<br>";
			echo"<input type='radio' id='radio122' name='serieremito'>Ninguno</option>";
		echo"</fieldset>";
		//Nueva 2018. Remito desde hoja en blanco.
		//Ojo con el CAI. Mejor tomarlo de la BD.
		echo"<fieldset style='width:130px'>";
			echo"<legend>Preimpreso:</legend>";	
			echo"<input type='radio' id='radio131' name='preimpresoremito' checked>Hoja preimpresa</option>";
			echo"<br>";
			echo"<input type='radio' id='radio132' name='preimpresoremito'>Hoja en blanco</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:150px; border: 0px;'>";		
			echo"<input type='button' id='informe' value='Emitir Remito'/>";
		echo"</fieldset>";
echo"</fieldset>";
echo"<br>";
