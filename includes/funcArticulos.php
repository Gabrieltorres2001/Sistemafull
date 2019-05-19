<?php

function llenar_listado_articulos()
{
	//Creamos la conexión
	include_once 'includes/sp_connect.php';
	$conexion_sp = mysqli_connect(HOSTSP, USERSP, PASSWORDSP, DATABASESP) or
		die("Problemas con la conexión");
	mysqli_query($conexion_sp, "set names 'utf8'");
	//generamos la consulta
	$sql = "SELECT	IdProducto,descricpcion,idProveedor,MonedaOrigen,ValorVenta,EnStock, Simbolo
				FROM productos 
				LEFT JOIN monedaorigen on IdRegistroCambio =  MonedaOrigen
				ORDER BY IdProducto asc limit 100";

	if (!$result = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta productos");

	return tablaArticulos($result);
}

function tablaArticulos($result)
{

	ob_start();
	?>
	<table class='table table-hover table-sm' id='tablaArticulos'>
		<thead class=''>
			<tr>
				<th width='30' class="IdProducto"><a class="TableHeader" href="#">Cod</a></th>
				<th width='100' class="descricpcion"><a class="TableHeader" href="#">Descripción</a></th>
				<th width='140' class="idProveedor"><a class="TableHeader" href="#">Proveedor</a></th>
				<th width='80' class="Simbolo"><a class="TableHeader" href="#">ValorVenta</a></th>
				<th width='60' class="EnStock"><a class="TableHeader" href="#">EnStock</a></th>
			</tr>
		</thead>
		<tbody>
		<?php
		while ($row = mysqli_fetch_array($result)) {
			?>
			<tr id="<?php echo $row['IdProducto']; ?>">
				<td><?php echo $row['IdProducto']; ?></td>
				<td><?php echo $row['descricpcion']; ?></td>
				<td><?php echo $row['idProveedor']; ?></td>
				<td><?php echo $row['Simbolo']; ?><?php echo $row['ValorVenta']; ?></td>
				<td><?php echo $row['EnStock']; ?></td>
			</tr>
		<?php
	};
	?>
		</tbody>
	</table>

	<?php
	$html = ob_get_contents();
	ob_get_clean();
	return $html;
}


function imprimir_detalle_articulos($resultc, $conexion_sp, $readonly = false)
{
	$reg = mysqli_fetch_array($resultc);
	$readonly = $readonly ? "readonly" : "";
	ob_start();
	?>
	<form>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for='IdProducto' class="col-12 col-form-label">Id Artículo:</label>
				<input id='IdProducto' class='col-12 form-control-plaintext' name='IdProducto' type='text' value="<?php echo $reg['IdProducto']; ?>" readonly>
			</div>
			<div class="form-group col-md-4">
				<label for='actualiz' class="col-12 col-form-label ">Fecha de actualización:</label>
				<input id='actualiz' class='col-12 form-control-plaintext' name='actualiz' type='text' value='<?php echo $reg['actualiz']; ?>' readonly>
			</div>
			<?php

			if (!$resultTP = mysqli_query($conexion_sp, "select * from z_tipoproducto")) die("Problemas con la consulta z_tipoproducto");
			?>
			<div class="form-group col-md-4">
				<label for='TipoProducto' class="col-12 col-form-label">Tipo:</label>
				<select id='TipoProducto' class='form-control select2' style="width: 100%;" name='TipoProducto'>
					<?php
					while ($row = mysqli_fetch_array($resultTP)) {
						if ($reg['TipoProducto'] == $row['IdTipoProducto']) {
							?>
							<option selected value="<?php echo $row['IdTipoProducto'] ?>"><?php echo $row['TipoProducto'] ?></option>
						<?php
					} else {
						?>
							<option value="<?php echo $row['IdTipoProducto'] ?>"><?php echo $row['TipoProducto']; ?></option>
						<?php
					}
				}
				if ($reg['TipoProducto'] == '' or $reg['TipoProducto'] == '0') {
					?>
						<option selected value=''></option>
					<?php
				}
				?>
				</select>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-4">
				<label for='MonedaOrigen' class="col-12 col-form-label">Moneda:</label>
				<select id='MonedaOrigen' class='select2' style="width: 100%;" name='MonedaOrigen'>
					<?php
					if (!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen")) die("Problemas con la consulta monedaorigen");
					while ($row = mysqli_fetch_array($resultTM)) {
						if ($reg['MonedaOrigen'] == $row['IdRegistroCambio']) {
							echo "<option selected value=" . $row['IdRegistroCambio'] . ">" . $row['Origen'] . "</option>";
						} else {
							echo "<option value=" . $row['IdRegistroCambio'] . ">" . $row['Origen'] . "</option>";
						}
					}
					if ($reg['MonedaOrigen'] == '' or $reg['MonedaOrigen'] == '0') {
						?>
						<option selected value=''></option>
					<?php
				}
				?>
				</select>
			</div>
			<div class="form-group col-4">
				<label for='ValorVenta' class="col-12 col-form-label">Valor:</label>
				<input id='ValorVenta' class='col-12 form-control' name='ValorVenta' type='text' style='text-align: center;' value='<?php echo $reg['ValorVenta']; ?>' <?php echo $readonly; ?>>
			</div>
			<div class="form-group col-4">
				<label for='IVA' class="col-12 col-form-label">IVA:</label>
				<select id='IVA' class='select2' style="width: 100%;" name='IVA'>
					<?php
					if (!$resultTI = mysqli_query($conexion_sp, "select * from z_ivas")) die("Problemas con la consulta z_ivas");
					while ($rowTI = mysqli_fetch_array($resultTI)) {
						if ($reg['IVA'] == $rowTI['IdRegistro']) {
							echo "<option selected value=" . $rowTI['IdRegistro'] . ">" . $rowTI['IVA'] . "</option>";
						} else {
							echo "<option value=" . $rowTI['IdRegistro'] . ">" . $rowTI['IVA'] . "</option>";
						}
					}
					if ($reg['IVA'] == '' or $reg['IVA'] == '0') {
						?>
						<option selected value=''></option>
					<?php
				}
				?>
				</select>
			</div>
		</div>
		<div class="form-row">
			<label for="descricpcion" class="col-3 col-form-label">Descripción:</label>
			<div class="col-9">
				<textarea id="descricpcion" name="descricpcion" cols="40" rows="2" required="required" class="form-control" <?php echo $readonly; ?>><?php echo $reg['descricpcion']; ?></textarea>
			</div>
		</div>

		<div class="form-row">
			<label for="OfrecerAdemas" class="col-3 col-form-label">Ofrecer además:</label>
			<div class="col-9">
				<input id="OfrecerAdemas" name="OfrecerAdemas" class="form-control" type="text" value='<?php echo $reg['OfrecerAdemas'] ?>' <?php echo $readonly; ?>>
			</div>
		</div>

		<div class="form-row">
			<label for='NotasArt' class="col-3 col-form-label">Notas Internas:</label>
			<div class="col-9">
				<textarea id='NotasArt' class='form-control' name='NotasArt' cols="40" rows='3' style='background-color:#fadbd8;' <?php echo $readonly; ?>><?php echo $reg['Notas']; ?></textarea>
			</div>
		</div>

		<div class="form-row">
			<label for='ComposicionyDescirpcion' class="col-3 col-form-label">Composición y Descripción:</label>
			<div class="col-9">
				<textarea id='ComposicionyDescirpcion' class='form-control' name='ComposicionyDescirpcion' cols="40" rows='3' <?php echo $readonly; ?>><?php echo $reg['ComposicionyDescirpcion']; ?></textarea>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for='IdProveedor' class="col-12 col-form-label">Proveedor:</label>
				<select id='IdProveedor' class='select2' style="width: 100%;" name='IdProveedor'>
					<?php
					$sql = "SELECT min(contactos2.idContacto) as mindeidContacto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id group by organizaciones.Organizacion";

					if (!$resultCP = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta contactos2 Organizacion");
					while ($rowCP = mysqli_fetch_array($resultCP)) {
						$selected = "";
						if ($reg['IdProveedor'] == $rowCP['Organizacion']) {
							$selected = "selected";
						}
						echo "<option {$selected} value='{$rowCP['mindeidContacto']}'>" . substr($rowCP['Organizacion'], 0, 23) . "</option>";
					}
					if ($reg['IdProveedor'] == '' || $reg['IdProveedor'] == '0') {
						?>
						<option selected value='0'></option>
					<?php
				}
				?>
				</select>

			</div>

			<div class="form-group col-md-6">
				<label for='CodigoProveedor' class="col-12 col-form-label">Codigo del proveedor:</label>
				<input id='CodigoProveedor' class='col-12 form-control' name='CodigoProveedor' type='text' size='34' value='<?php echo $reg['CodigoProveedor']; ?>' <?php echo $readonly; ?>>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for='IdRubro' class="col-12 col-form-label">Rubro:</label>
				<select id='IdRubro' class='select2' style="width: 100%;" name='IdRubro'>
					<option selected value=''></option>
					<?php
					if (!$resultRub = mysqli_query($conexion_sp, "SELECT IdRubro,Rubro from z_rubros where Nivel=0 order by Rubro")) die("Problemas con la consulta z_rubros");
					while ($rowRub = mysqli_fetch_array($resultRub)) {
						if ($reg['IdRubro'] == $rowRub['IdRubro']) {
							?>
							<option selected value="<?php echo $rowRub['IdRubro'] ?>"><?php echo substr($rowRub['Rubro'], 0, 36); ?></option>
						<?php
					} else {
						?>
							<option value="<?php echo $rowRub['IdRubro']; ?>"><?php echo substr($rowRub['Rubro'], 0, 36); ?></option>
						<?php
					}
				}
				?>
				</select>
			</div>
			<div class="form-group col-md-6">
				<label for='IdSubRubro' class="col-12 col-form-label">SubRubro:</label>
				<select id='IdSubRubro' class='select2' style="width: 100%;" name='IdSubRubro'>
					<option selected value=''></option>
					<?php
					if (!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=1 order by Rubro")) die("Problemas con la consulta z_rubros sub rubros");
					while ($rowRub = mysqli_fetch_array($resultRub)) {
						if ($reg['IdSubRubro'] == $rowRub['IdRubro']) {
							?>
							<option selected value="<?php echo $rowRub['IdRubro']; ?>"><?php echo substr($rowRub['Rubro'], 0, 36); ?></option>
						<?php
					} else {
						?>
							<option value="<?php echo $rowRub['IdRubro']; ?>"><?php echo substr($rowRub['Rubro'], 0, 36); ?></option>
						<?php
					}
				}
				?>
				</select>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-4">
				<label for='StockMinimo' class="col-12">Stock Minimo:</label>
				<input id='StockMinimo' class='col-12 form-control' name='StockMinimo' type='text' size='4' style='text-align:center;' value='<?php echo $reg['StockMinimo']; ?>' <?php echo $readonly; ?>>
			</div>
			<?php
			//Una nueva. Colores por stock. PERO SOLO SI SON TANGIBLES!
			$colorFondo = '#abf1ab';
			if ($reg['EnStock'] <= $reg['StockMinimo']) {
				$colorFondo = 'yellow';
			}
			if ($reg['EnStock'] < 1) {
				$colorFondo = '#FA5858';
			}
			if ($reg['tangible'] < 1) {
				$colorFondo = 'white';
			}
			?>
			<div class="form-group col-md-4">
				<label for='EnStock' class="col-12">En Stock:</label>
				<input id='EnStock' class='col-12 form-control' name='EnStock' type='text' size='4' style='text-align:center; background-color:<?php echo $colorFondo; ?>;' value='<?php echo $reg['EnStock']; ?>' readonly>
			</div>
			<div class="form-group col-md-4">
				<label for='UnidadMedida' class="col-12">U nidad Medida:</label>
				<input id='UnidadMedida' class='col-12 form-control' name='UnidadMedida' type='text' size='6' style='text-align:center;' value='<?php echo $reg['UnidadMedida']; ?>' <?php echo $readonly; ?>>
			</div>
		</div>

		<div class="form-row">

			<div class="">
				<div class="custom-control custom-checkbox custom-control-inline">
					<?php
					if ($reg['tangible'] == 0) {
						?>
						<input name="tangible" id="tangible" class="form-check-input" value="0" type="checkbox" <?php echo $readonly; ?>>
						<!-- <input name='tangible' id='tangible' type='checkbox' value="0"> -->
					<?php
				} else {
					?>
						<input name="tangible" id="tangible" checked="checked" class="form-check-input" value="1" type="checkbox" <?php echo $readonly; ?>>
						<!-- <input name='tangible' id='tangible' type='checkbox' value="1" checked> -->
					<?php
				}
				?>

					<label for="tangible" class="col-form-label">Tangible</label>
				</div>
			</div>
		</div>


		<?php
		$sql = "SELECT Deposito,Estanteria,Estante from stock where Producto='" . $reg['IdProducto'] . "' limit 1;";
		if (!$resultUbicacion = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta Stock Ubicacion 167");
		$rowUbic = mysqli_fetch_array($resultUbicacion);
		?>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for='numDeposito' class="cols-12 col-form-label">Deposito:</label>
				<input id='numDeposito' class='form-control' name='numDeposito' type='text' size='17' value='<?php echo $rowUbic['Deposito']; ?>' <?php echo $readonly; ?>>
			</div>
			<div class="form-group col-md-4">
				<label for='Estanteria' class="cols-12 col-form-label">Módulo:</label>
				<input id='Estanteria' class='form-control' name='Estanteria' type='text' size='17' value='<?php echo $rowUbic['Estanteria']; ?>' <?php echo $readonly; ?>>
			</div>
			<div class="form-group col-md-4">
				<label for='Estante' class="cols-12 col-form-label">Estante:</label>
				<input id='Estante' class='form-control' name='Estante' type='text' size='17' value='<?php echo $rowUbic['Estante']; ?>' <?php echo $readonly; ?>>
			</div>
		</div>


		<label for='HojaFabricante' class="col-form-label col-12">HojaFabricante:</label>
		<div class="input-group mb-3">
			<input id='HojaFabricante' class='form-control' name='HojaFabricante' type='text' value='<?php echo $reg['HojaFabricante'] ?>' <?php echo $readonly; ?>>
			<div class="input-group-append">
				<?php
				if (strlen($reg['HojaFabricante']) > 0) {
					?>
					<button id='verHT' value='Ver...' class="btn btn-outline-secondary" type="button"><i class="fa fa-eye"></i>Ver</button>
				<?php
			}
			?>
				<button id='buscarHT' value='Buscar...' class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>


		<label for='Imagen' class="col-form-label col-12">Imagen:</label>
		<div class="input-group">
			<input id='Imagen' class='form-control' name='Imagen' type='text' value='<?php echo $reg['Imagen']; ?>' <?php echo $readonly; ?>>
			<div class="input-group-append">
				<?php
				if (strlen($reg['Imagen']) > 0) {
					?>
					<button id='verImagen' value='Ver...' class="btn btn-outline-secondary" type="button"><i class="fa fa-eye"></i>Ver</button>
				<?php
			}
			?>
				<button id='buscarHT' value='Buscar...' class="btn btn-outline-primary" type="button"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>

		<label for='CodigoInterno' hidden>CodigoInterno:</label>
		<input id='CodigoInterno' class='input' name='CodigoInterno' type='text' size='40' value='<?php echo $reg['CodigoInterno'] ?>' hidden>
		<label for='Numerodeserie' style='visibility:hidden'>Numerodeserie:</label>
		<input id='Numerodeserie' class='input' name='Numerodeserie' type='text' size='40' value='<?php echo $reg['Numerodeserie'] ?>' style='visibility:hidden'>
		<label style='visibility:hidden' for='IdCostoProveedor'>IdCostoProveedor:</label>
		<input style='visibility:hidden' id='IdCostoProveedor' class='input' name='IdCostoProveedor' type='text' size='26' value='<?php echo $reg['IdCostoProveedor'] ?>'>
		<label style='visibility:hidden' for='IdImagen'>IdImagen:</label>
		<input style='visibility:hidden' id='IdImagen' class='input' name='IdImagen' type='text' size='40' value='<?php echo $reg['IdImagen'] ?>'>
		<label style='visibility:hidden' for='HojaOtra'>HojaOtra:</label>
		<input style='visibility:hidden' id='HojaOtra' class='input' name='HojaOtra' type='text' size='40' value='<?php echo $reg['HojaOtra'] ?>'>
		<label style='visibility:hidden' for='UsuarioCreacion'>UsuarioCreacion:</label>
		<input style='visibility:hidden' id='UsuarioCreacion' class='input' name='UsuarioCreacion' type='text' size='17' value='<?php echo $reg['UsuarioCreacion']; ?>'>
		<label style='visibility:hidden' for='UsuarioModificacion'>UsuarioModificacion:</label>
		<input style='visibility:hidden' id='UsuarioModificacion' class='input' name='UsuarioModificacion' type='text' size='14' value='<?php echo $reg['UsuarioModificacion']; ?>'>
		<label style='visibility:hidden' for='UsuarioFC'>UsuarioFC:</label>
		<input style='visibility:hidden' id='UsuarioFC' class='input' name='UsuarioFC' type='text' size='28' value='<?php echo $reg['UsuarioFC'] ?>'>
		<label style='visibility:hidden' for='UsuarioFM'>UsuarioFM:</label>
		<input style='visibility:hidden' id='UsuarioFM' class='input' name='UsuarioFM' type='text' size='40' value='<?php echo $reg['UsuarioFM'] ?>'>
		<label style='visibility:hidden' for='FechaActualizacion'>FechaActualizacion:</label>
		<input style='visibility:hidden' id='FechaActualizacion' class='input' name='FechaActualizacion' type='text' size='40' value='<?php echo $reg['FechaActualizacion']; ?>'>
	</form>
	<?php
	if ($readonly === 'readonly') {
		?>
		<script>
			$(document).ready(function() {
				$('.select2').prop("disabled", true);
				$('#botonActualizaArticulo').prop("disabled", true);
			})
		</script>
	<?php
}
$html = ob_get_contents();
ob_clean();
return $html;
}


function imprimir_movimientos_articulos($resultc, $conexion_sp)
{
	ob_start();
	?>
	<table class='table table-hover table-sm' id='movimientos'>
	<caption>Resultados encontrados: <?php echo mysqli_num_rows($resultc); ?></caption>
		<thead>
			<tr>
				<th width='80'>Comprobante</th>
				<th width='50'>Número</th>
				<th width='60'>Fecha</th>
				<th width='180'>Empresa</th>
				<th width='50'>Cant</th>
				<th width='50'>Moneda</th>
				<th width='50'>Precio</th>
				<th width='50'>SubTotal</th>
				<th width='50'>Cumpl.</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while ($row = mysqli_fetch_array($resultc)) {
			//el id de los td tiene que ser el id de comprobante asi busco por ese numero en ambas tablas (comprobantes y detalle)
			$checked = $row['Cumplido'] == '0' ? "" : " checked";
			?>
			<tr id="<?php echo $row['IdComprobante']; ?>" >
				<td><?php echo $row['TipoComprobante']; ?></td>
				<td><?php echo $row['NumeroComprobante']; ?></td>
				<td><?php echo $row['FechaComprobante']; ?></td>
				<td><?php echo $row['Organizacion']; ?></td>
				<td><?php echo $row['Cantidad']; ?></td>
				<td><?php echo $row['Simbolo']; ?></td>
				<td><?php echo $row['CostoUnitario']; ?></td>
				<td><?php echo $row['SubTotal']; ?></td>
				<td><input type='checkbox'<?php echo $checked; ?> readonly></td>
			</tr>
			<?php
		};
		?>
		</tbody>
	</table>
	<?php
	$html = ob_get_contents();
	ob_clean();
	echo $html;
}


function imprimir_detalle_articulos_ajustado_stock($resultc, $conexion_sp)
{
	$reg = mysqli_fetch_array($resultc);
	ob_start();
	?>
	<label for='IdProducto'>Id del Producto:</label>
	<input id='IdProducto' class='input' name='IdProducto' type='text' size='6' value="<?php echo $reg['IdProducto']; ?>" readonly>
	<label for='actualiz'>Fecha de actualización:</label>
	<input id='actualiz' class='input' name='actualiz' type='text' size='33' value='<?php echo  $reg['actualiz']; ?>' readonly><br>
	<label for='MonedaOrigen'>Moneda:</label>
	<select id='MonedaOrigen' class='input' name='MonedaOrigen' style='font-size:1.7em' readonly>
	<?php
	if (!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen")) die("Problemas con la consulta monedaorigen");
	while ($row = mysqli_fetch_array($resultTM)) {
		if ($reg['MonedaOrigen'] == $row['IdRegistroCambio']) {
			echo "<option selected value=" . $row['IdRegistroCambio'] . ">" . $row['Origen'] . "</option>";
		} else {
			echo "<option value=" . $row['IdRegistroCambio'] . ">" . $row['Origen'] . "</option>";
		}
	}
	if ($reg['MonedaOrigen'] == '' or $reg['MonedaOrigen'] == '0') {
		echo "<option selected value=''></option>";
	}
	echo "</select>";

	echo "<label for='ValorVenta'>Valor:</label>";
	echo "<input id='ValorVenta' class='input' name='ValorVenta' type='text' size='18' style='text-align: center; font-size:1.7em' value='" . $reg['ValorVenta'] . "' readonly><br />";

	echo "<label for='descricpcion'>Descripción:</label>";
	echo "<textarea id='descricpcion' class='input' name='descricpcion' rows='2' cols='81' readonly>" . $reg['descricpcion'] . "</textarea> <br />";

	if (!$resultCP = mysqli_query($conexion_sp, "select min(contactos2.idContacto) as mindeidContacto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id group by organizaciones.Organizacion")) die("Problemas con la consulta contactos2 Organizacion");
	echo "<label for='IdProveedor'>Proveedor:</label>";
	echo "<select id='IdProveedor' class='input' name='IdProveedor' readonly>";
	while ($row = mysqli_fetch_row($resultCP)) {
		if ($reg['IdProveedor'] == $row[1]) {
			echo "<option selected value=" . $row[0] . ">" . substr($row[1], 0, 23) . "</option>";
		} else {
			echo "<option value=" . $row[0] . ">" . substr($row[1], 0, 23) . "</option>";
		}
	}
	if ($reg['IdProveedor'] == '' or $reg['IdProveedor'] == '0') {
		echo "<option selected value='0'></option>";
	}
	echo "</select>";

	echo "<label for='CodigoProveedor'>Codigo del proveedor:</label>";
	echo "<input id='CodigoProveedor' class='input' name='CodigoProveedor' type='text' size='34' value='" . $reg['CodigoProveedor'] . "' readonly><br />";

	if (!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=0 order by Rubro")) die("Problemas con la consulta z_rubros");
	echo "<label for='IdRubro'>Rubro:</label>";
	echo "<select id='IdRubro' class='input' name='IdRubro' readonly>";
	echo "<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)) {
		if ($reg['IdRubro'] == $row[0]) {
			echo "<option selected value=" . $row[0] . ">" . substr($row[1], 0, 36) . "</option>";
		} else {
			echo "<option value=" . $row[0] . ">" . substr($row[1], 0, 36) . "</option>";
		}
	}
	echo "</select>";

	if (!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=1 order by Rubro")) die("Problemas con la consulta z_rubros sub rubros");
	echo "<label for='IdSubRubro'>SubRubro:</label>";
	echo "<select id='IdSubRubro' class='input' name='IdSubRubro' readonly>";
	echo "<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)) {
		if ($reg['IdSubRubro'] == $row[0]) {
			echo "<option selected value=" . $row[0] . ">" . substr($row[1], 0, 36) . "</option>";
		} else {
			echo "<option value=" . $row[0] . ">" . substr($row[1], 0, 36) . "</option>";
		}
	}
	echo "</select><br />";

	echo "<label for='StockMinimo'>Stock Minimo:</label>";
	echo "<input id='StockMinimo' class='input' name='StockMinimo' type='text' size='4' style='text-align:center;' value='" . $reg['StockMinimo'] . "' readonly>";

	//Una nueva. Colores por stock. PERO SOLO SI SON TANGIBLES!
	$colorFondo = '#abf1ab';
	if ($reg['EnStock'] <= $reg['StockMinimo']) {
		$colorFondo = 'yellow';
	}
	if ($reg['EnStock'] < 1) {
		$colorFondo = '#FA5858';
	}
	if ($reg['tangible'] < 1) {
		$colorFondo = 'white';
	}

	echo "<label for='EnStock'>En Stock:</label>";
	echo "<input id='EnStock' class='input' name='EnStock' type='text' size='4' style='text-align:center; background-color:" . $colorFondo . ";' value='" . $reg['EnStock'] . "' readonly>";

	echo "<label for='UnidadMedida'>Unidad Medida:</label>";
	echo "<input id='UnidadMedida' class='input' name='UnidadMedida' type='text' size='6' style='text-align:center;' value='" . $reg['UnidadMedida'] . "' readonly>";

	echo "<label for='tangible'>Tangible: </label>";
	if ($reg['tangible'] == 0) {
		echo "<input name='tangible' id='tangible' type='checkbox' readonly></input>";
	} else {
		echo "<input name='tangible' id='tangible' type='checkbox' checked readonly></input>";
	}
	//Nueva Junio 2018. Ubicacion
	echo "<br />";
	if (!$resultUbicacion = mysqli_query($conexion_sp, "select Deposito,Estanteria,Estante from Stock where Producto='" . $reg['IdProducto'] . "' limit 1")) die("Problemas con la consulta Stock Ubicacion 571");
	$rowUbic = mysqli_fetch_array($resultUbicacion);
	echo "<label for='numDeposito'>Deposito:</label>";
	echo "<input id='numDeposito' class='input' name='numDeposito' type='text' size='17' value='" . $rowUbic['Deposito'] . "' readonly>";
	echo "<label for='Estanteria'>Módulo:</label>";
	echo "<input id='Estanteria' class='input' name='Estanteria' type='text' size='17' value='" . $rowUbic['Estanteria'] . "' readonly>";
	echo "<label for='Estante'>Estante:</label>";
	echo "<input id='Estante' class='input' name='Estante' type='text' size='17' value='" . $rowUbic['Estante'] . "' readonly>";
}
