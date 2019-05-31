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
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, Confecciono, Transporte, PlazoEntrega, NumeroComprobante01, Solicito, TipoComprobante, NumeroComprobante02, UsuarioModificacion, OCEnviada from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$regComprobante = mysqli_fetch_array($resultComprobante);  
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$regComprobante['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion, Observaciones, CondDePago, CUIT, ActividEmpresa from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regEmp = mysqli_fetch_array($resultEmp);
	
	if(!$resultEmpMail = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT='".$regComprobante['NonmbreEmpresa']."' and Direccion Like '%@%'")) die("Problemas con la consulta2");
	$regEmpMail = mysqli_fetch_array($resultEmpMail);
	
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$regComprobante['Confecciono']."' limit 1")) die("Problemas con la consulta members1");
	$rowConfecc = mysqli_fetch_array($confecc);	
	
	ob_start();
?>
	<div class="form-row">
		<div class="form-group col-md-3">
			<label for='NumeroComprobante' class="col-12 col-form-label">Nº:</label>
			<input id='NumeroComprobante' class='col-12 form-control' name='NumeroComprobante' type='text' size='5' value="<?php echo $regComprobante['NumeroComprobante']; ?>"  Disabled>
		</div>
		<div class="form-group col-md-3">	
			<label for='FechaComprobante' class="col-12 col-form-label">Fecha del comprobante:</label>
			<input id='FechaComprobante' class='col-12 form-control' name='FechaComprobante' type='text' size='10' value="<?php echo substr($regComprobante['FechaComprobante'],8,2)."/".substr($regComprobante['FechaComprobante'],5,2)."/".substr($regComprobante['FechaComprobante'],0,4); ?>" disabled>
		</div>
		<div class="form-group col-md-3">	
			<label for='Confeccion' class="col-12 col-form-label">Confeccionó:</label>
			<input id='Confeccion' class='col-12 form-control' name='Confeccion' type='text' size='18' value='<?php echo $rowConfecc['Nombre']." ".$rowConfecc['Apellido']; ?>' disabled>
		</div>
		<div class="form-group col-md-3">	
			<label for='Solicita' class="col-12 col-form-label">Solicita:</label>
			<select id='Solicita' name='Solicita' class='form-control select2' disabled>
			<option value='0'> </option>
		<?php

				//Agrego el Where usuarioTrabajando=1, asi no listo a todos!
				if(!$solicitTodos = mysqli_query($conexion_db, "select id, Nombre, Apellido from members where usuarioTrabajando = 1")) die("Problemas con la consulta members5");
				while ($rowSolicitTodos = mysqli_fetch_array($solicitTodos)){
					$selected = $rowSolicitTodos['id']==$regComprobante['Solicito'] ? "selected='selected'" : "";
					?>
						<option value='<?php echo $rowSolicitTodos['id']; ?>' <?php echo $selected ?> ><?php echo $rowSolicitTodos['Nombre']." ".$rowSolicitTodos['Apellido']; ?></option>;
					<?php
				}  
				?>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for='Organizacion' class="col-12 col-form-label">Organizacion:</label>
			<input id='Organizacion' class='col-12 form-control' name='Organizacion' type='text' size='50' value='<?php echo $regEmp['Organizacion']; ?>'  disabled>
		</div>
		<div class="form-group col-md-6">
			<label for='Organizacion' class="col-12 col-form-label">Contacto:</label>
			<div class="input-group mb-3">
				<input id='Contacto' type="text" class="form-control" value='<?php echo $regComprobante['ApellidoContacto']; ?>' disabled>
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" id="sendmail">
							<i id='botonMailP' class="fa fa-envelope-o"></i>
							<input id='DirecciondecorreoelectronicoP' class='col-12 form-control' name='Direcciondecorreoelectronico' type='hidden' size='43' value='<?php echo $regEmpMail['Direccion']; ?>'>
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-12" >
			<textarea id='NotasInternas' overflow='scroll' name='NotasInternas' rows='2' class="form-control"  disabled><?php echo $regEmp['ActividEmpresa']; ?> <?php echo $regEmp['Observaciones'];?></textarea>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-4">
			<label for='CondicionesPago'>Condiciones de Pago:</label>
			<select id='CondicionesPago' name='CondicionesPago' class='form-control select2' disabled>
				<?php
				if(!$condicPago = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");	
				while ($rowCondicPago = mysqli_fetch_array($condicPago)){
					$selected = $rowCondicPago['Descripcion']==$regComprobante['CondicionesPago'] ? "selected='selected'" : "";
					$tmpFP = explode(',', $rowCondicPago['ContenidoValor']);
					?>
					<option value='<?php echo $rowCondicPago['Descripcion']; ?>' <?php $selected ?> ><?php echo $tmpFP[0]; ?></option>
					<?php
				}  
				?>
				</select>
			
		</div>
		<div class="form-group col-md-4">
			<label for='PlazoEntrega'>Plazo de Entrega:</label>
			<select id='PlazoEntrega' name='PlazoEntrega' class='form-control select2' disabled>
			<option value='0'> </option>
			<?php
			if(!$plazoEnt = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='51' order by ContenidoValor")) die("Problemas con la consulta plazoentrega en controlpanel");
			while ($rowPlazoEnt = mysqli_fetch_array($plazoEnt)){
				$selected = $rowPlazoEnt['Descripcion']==$regComprobante['PlazoEntrega'] ? "selected='selected'" : "";
					?>
					<option value='<?php echo $rowPlazoEnt['Descripcion']; ?>' <?php echo $selected; ?> ><?php echo $rowPlazoEnt['ContenidoValor']; ?></option>";
					<?php
			}  
			?>
			</select>
			
		</div>
		<div class="form-group col-md-4">
			<label for='Transporte'>Transporte:</label>
			<select id='Transporte' name='Transporte' class='form-control select2' disabled>
			<option value='0'> </option>
			<?php
			if(!$transport = mysqli_query($conexion_sp, "select idTransporte, Transporte from z_transportes order by Transporte")) die("Problemas con la consulta_z_transportes");
			while ($rowTransport = mysqli_fetch_array($transport)){
				$selected = $rowTransport['Transporte']==$regComprobante['Transporte'] ? "selected='selected'" : "";
				?>
					<option value='<?php echo $rowTransport['idTransporte']; ?>' <?php echo $selected; ?> ><?php echo $rowTransport['Transporte']; ?></option>
				<?php
			}  
			?>
		</select>
			
		</div>
	</div>
	<?php
	//Hasta aca es igual para todos. TODO: Ahora tengo que ver si es
	//Presupuesto, Remito o OC para completar el resto.
	//Presupuesto
	if($regComprobante['TipoComprobante']=="5") { 	
		?>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for='PeticionOferta'>Peticion de Oferta:</label>
				<input id='PeticionOferta' class="form-control" name='PeticionOferta' type='text' size='50' value='<?php echo $regComprobante['NumeroComprobante01']; ?>' disabled>

			</div>
			<div class="form-group col-md-6">
				<label for='Notas'>Notas:</label>
				<textarea id='Notas' class="form-control" rows='2' disabled><?php echo $regComprobante['Notas']; ?></textarea>

			</div>
		</div>
	<?php
	}
	//Remito
	if($regComprobante['TipoComprobante']=="3") { 
		?>
		<div class="form-row">
			<div class="form-group col-md-6">
					<label for='PeticionOferta'>Nº OC cliente:</label>
					<input id='PeticionOferta' class="form-control" name='PeticionOferta' type='text' value='<?php echo $regComprobante['NumeroComprobante01']; ?>' disabled>
			</div>
			<div class="form-group col-md-6">
				<label for='preimpreso'>Nº remito preimpreso:</label>
				<input id='preimpreso' class="form-control" name='preimpreso' type='text' value='<?php echo $regComprobante['NumeroComprobante02']; ?>' disabled>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for='numfactura'>Nº factura:</label>
				<input id='numfactura' class="form-control" name='numfactura' type='text' value='<?php echo $regComprobante['UsuarioModificacion']; ?>' disabled>
			</div>
			<div class="form-group col-md-6">
				<label for='Notas'>Notas:</label>
				<textarea id='Notas' class="form-control" overflow='scroll' name='Notas' rows='2' disabled><?php echo $regComprobante['Notas']; ?></textarea>
			</div>
		</div>
	<?php
	}
	//OC
	if($regComprobante['TipoComprobante']=="9") { 		
		?>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for='PeticionOferta'>Cotización:</label>
					<input id='PeticionOferta' class='form-control' name='PeticionOferta' type='text' value='<?php echo $regComprobante['NumeroComprobante01']; ?>' disabled>
				</div>
				<div class="form-group col-md-6">
					<label for='Notas'>Notas:</label>
					<textarea id='Notas' class='form-control'  name='Notas' rows='2' disabled><?php echo $regComprobante['Notas']; ?></textarea>
				</div>
			</div>
		<?php
		if ($regComprobante['OCEnviada']==0){
			$class = 'class="badge badge-warning text-wrap"';
			$value ='OC NO GENERADA';
		} else {
			$value ='OC GENERADA';
			$class = 'class="badge badge-success text-wrap"';
		}
			?>
			<div id='ocEnviada' name='ocEnviada' type='text' <?php echo $class; ?>> <?php echo $value; ?></div>
			<?php
	}
	//Buscar si existe en algun legajo	
	if(!$legajo = mysqli_query($conexion_sp, "select idLegajo from detallelegajos where idComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta detallelegajos");
	if ($rowLegajo = mysqli_fetch_array($legajo)) {
		?>
			<div class="badge badge-success text-wrap"> Este presupuesto forma parte del legajo nº <?php echo $rowLegajo['idLegajo']; ?></div>
		<?php
	}else{
		?>
			<div class="badge badge-warning text-wrap"> Este comprobante no forma parte de ningún legajo electrónico</div>
		<?php
	}
	?>
	<br>
	<br>
	<?php
	$html = ob_get_contents();
	ob_clean();

	echo $html;

