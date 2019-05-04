<?php
	include 'php/globalFunctions.php';
	
		$userInfo = consultaMembers($_SESSION["user_id"]);
		$puedoModificar="";
		if($userInfo['PuedeModificarArticulos']=0){
			$puedoModificar=" disabled";
			};
		ob_start();
		?>
		<button class="btn btn-success btn-sm" id='botonActualizaArticulo' >Actualizar datos</button>
		<button class="btn btn-success btn-sm" id='botonCopiaArticulo' >Duplicar artículo</button>
		<button class="btn btn-success btn-sm" id='botonNuevoArticulo' >Nuevo artículo</button>
		<?php
		$ret = ob_get_contents();
		ob_end_clean();
		echo $ret;
