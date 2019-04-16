<?php
	include 'php/globalFunctions.php';
	
		$rowPermisoModificar = consultaMembers($_REQUEST['sesses']);
		$puedoModificar="";
		if($rowPermisoModificar['PuedeModificarArticulos']=0){
			$puedoModificar=" disabled";
			};
		ob_start();
		?>
		<p>
		<input type='button' id='botonActualizaArticulo' value='Actualizar datos'<?php echo $puedoModificar ?>>
		<input type='button' id='botonCopiaArticulo' value='Duplicar artículo'<?php echo $puedoModificar ?>>
		<input type='button' id='botonNuevoArticulo' value='Nuevo artículo'<?php echo $puedoModificar ?>>
		<br>
		<br>
		<input type='checkbox' id='checkMostrarMovimientos' value='MostrarMovimientos'>Mostrar movimientos del producto"
		</p>
		<?php
		$ret = ob_get_contents();
		ob_end_clean();
		echo $ret;