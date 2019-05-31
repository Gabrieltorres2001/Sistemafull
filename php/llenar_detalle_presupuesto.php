<?php
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//Creamos la conexión
$conexion_sp = mysqli_connect(HOSTSP, USERSP, PASSWORDSP, DATABASESP) or
	die("Problemas con la conexión");
mysqli_query($conexion_sp, "set names 'utf8'");
$conexion_db = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or
	die("Problemas con la conexión");
mysqli_query($conexion_db, "set names 'utf8'");

//generamos la consulta
if (!$resultComprobante = mysqli_query($conexion_sp, "select Confecciono from comprobantes where IdComprobante='" . $_REQUEST['idcomprobante'] . "' limit 1")) die("Problemas con la consulta1");
$reg = mysqli_fetch_array($resultComprobante);

if (!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='" . $_REQUEST['idcomprobante'] . "' order by Orden")) die("Problemas con la consulta2");

$soyYo = 0;
//if($reg['Confecciono']==$_REQUEST['sesses'])$soyYo=1;
$disabled = $soyYo == '0' ? " disabled" : "";
ob_start();
?>
<table class='table table-hover table-sm' id='tablaDetalleComprobante'>
	<thead class=''>
		<tr>
			<th></th>
			<th width='1'>Orden</th>
			<th width='1'>Id</th>
			<th width='4'>Cantidad</br>(Stock)</th>
			<th width='1'>Unitario</th>
			<th width='4'>%1</th>
			<th width='4'>%2</th>
			<th width='4'>%3</th>
			<th width='1'>Moneda</th>
			<th width='15'>Unitario</th>
			<th width='15'>Subtotal</th>
			<th width='1'>IVA</th>
			<th width='15'>Plazo entrega</th>
			<th width='15'>Observaciones</th>
			<?php
			if ($soyYo != '0') {
				?><th width='1'>Borrar</th><?php
									}
									?>
		</tr>
	</thead>
	<tbody>
	<?php
	while ($row = mysqli_fetch_row($resultDetalle)) {
		if (!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, MonedaOrigen, ValorVenta, IVA from productos where IdProducto='" . $row[2] . "' limit 1")) die("Problemas con la consulta2");
		$rowProd = mysqli_fetch_array($resultArticulo);
		if (!$monedaArticulo = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='" . $rowProd['MonedaOrigen'] . "' limit 1")) die("Problemas con la consulta2");
		$rowMonedaArt = mysqli_fetch_array($monedaArticulo);
		if (!$monedaDetalle = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='" . $row[13] . "' limit 1")) die("Problemas con la consulta2");
		$rowMonedaDet = mysqli_fetch_array($monedaDetalle);
		if (!$iva = mysqli_query($conexion_sp, "select Texto from z_ivas where IdRegistro='" . $rowProd['IVA'] . "' limit 1")) die("Problemas con la consulta2");
		$rowIVA = mysqli_fetch_array($iva);
		//Cantidad. Ver de que color de fondo lo pinto.
		//Una nueva. Reviso el stock y pinto los campos de colores
		if (!$resultArt = mysqli_query($conexion_sp, "select EnStock, StockMinimo, tangible from productos where IdProducto = '" . $row[2] . "' limit 1")) {
			die("Problemas con la consulta de lectura detallecomprobante");
		};
		$art = mysqli_fetch_array($resultArt);
		$colorFondo = '#abf1ab';
		if ($art['StockMinimo'] <= $row[3]) {
			$colorFondo = 'yellow';
		}
		if ($art['EnStock'] < $row[3]) {
			$colorFondo = '#FA5858';
		}
		if ($art['tangible'] < 1) {
			$colorFondo = 'white';
		}
		$porc = (float)$row[11] * 100;
		$porc = (float)$row[14] * 100;
		$porc = (float)$row[15] * 100;
		//Tengo que dejar el formato: $row[0]&$row[2]&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
		//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
		?>
		<tr id='$row[0]'>
			<th></th>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&ordenitem"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&ordenitem&E"; ?>' class="col-12" name='xxxxt' type='text' value="<?php echo $row[7]; ?>" <?php echo $disabled; ?>>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&iditem"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&iditem&E"; ?>' class='col-12' name='xxxxt' type='text' value="<?php echo $row[2]; ?>" <?php echo $disabled; ?>>
			</td>
			
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&cantitem"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&cantitem&E"; ?>' class='col-12' name='xxxxt' type='text' style='background-color:<?php echo $colorFondo; ?>' value="<?php echo $row[3]; ?>" <?php echo $disabled; ?>>
				(<?php echo $art['EnStock']; ?>)
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&unititem"; ?>'><?php echo $rowMonedaArt['Simbolo'] . " " . number_format($rowProd['ValorVenta'], 2, '.', ''); ?>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&desc1item"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&desc1item&E"; ?>' class='col-12' name='xxxxt' type='text' value=<?php echo number_format($porc, 2, '.', '') . "% " . $disabled; ?>>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&desc2item"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&desc2item&E"; ?>' class='col-12' name='xxxxt' type='text' value=<?php echo number_format($porc, 2, '.', '') . "% " . $disabled; ?>>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&desc3item"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&desc3item&E"; ?>' class='col-12' name='xxxxt' type='text' value=<?php echo number_format($porc, 2, '.', '') . "% " . $disabled; ?>>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&monedaitem"; ?>'>
				<select id='<?php echo "$row[0]&$row[2]&monedaitem&E"; ?>' name='xxxxt' <?php echo $disabled; ?>>
					<?php
					if ('$' == $rowMonedaDet['Simbolo']) {
						echo "<option value='$' selected='selected'>$</option>";
					} else {
						echo "<option value='$'>$</option>";
					};
					if ('USD' == $rowMonedaDet['Simbolo']) {
						echo "<option value='U' selected='selected'>USD</option>";
					} else {
						echo "<option value='U'>USD</option>";
					};
					if ('€' == $rowMonedaDet['Simbolo']) {
						echo "<option value='€' selected='selected'>€</option>";
					} else {
						echo "<option value='€'>€</option>";
					};
					?>
				</select>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&descontadoitem"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&descontadoitem&E"; ?>' class='col-12' name='xxxxt' type='text' value='<?php echo number_format($row[4], 2, '.', ''); ?>' <?php echo $disabled; ?>>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&subtotitem"; ?>'>
				<input id='<?php echo "$row[0]&$row[2]&subtotitem&E"; ?>' class='col-12' name='xxxxt' type='text' value='<?php echo number_format($row[6], 2, '.', ''); ?>' <?php echo $disabled; ?>">
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&ivaitem"; ?>'>
				<?php echo $rowIVA['Texto']; ?>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&plazoitem"; ?>'>
				<textarea id='<?php echo "$row[0]&$row[2]&plazoitem&E"; ?>' class='col-12' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4' <?php echo $disabled; ?>><?php echo $row[17]; ?></textarea>
			</td>
			<td name='xxxx' id='<?php echo "$row[0]&$row[2]&obsitem"; ?>'>
				<textarea id='<?php echo "$row[0]&$row[2]&obsitem&E"; ?>' class='col-12' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4' <?php echo $disabled; ?>><?php echo $row[8]; ?></textarea>
			</td>
			<?php
			if ($soyYo != 0) {
				echo "<td id='$row[0]&$row[2]&action'><img name='xxxxx' id='$row[0]&$row[2]&imagenCanc' src='./images/canc.jpg' width='32'></td>";
			}
			?>
		</tr>
		<tr>
		<th width="2">Descripcion</th>
			<td colspan="13" name='xxxx' id='<?php echo "$row[0]&$row[2]&descriptitem"; ?>'><?php echo $rowProd['descricpcion']; ?>
			</td>
		</tr>
	<?php
}
?>
	</tbody>
</table>
<?php
//ahora la ultima fila en blanco para agregar item
if ($soyYo != 0) {
	echo "<img name='xxxxuz' src='./images/Agregar.jpg' width='35'>";
	echo "<img name='xxxxz' src='./images/lupa.jpg' width='35'>";
	echo "<img name='xxxxy' id='$row[0]&$row[2]&imagenOk' src='./images/recarga.jpg' width='35'>";
}
$html = ob_get_contents();
ob_clean();
echo $html;
