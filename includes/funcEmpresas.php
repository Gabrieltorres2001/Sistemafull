<?php

function llenar_listado_empresas() {
   //Creamos la conexión
	include_once 'includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	//generamos la consulta contactos2
	$sql ="SELECT id, Organizacion from organizaciones ORDER BY Organizacion asc limit 100";
	   if(!$result = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta organizaciones");
	
	return tablaEmpresas($result);
}

function tablaEmpresas($result){
	ob_start();
	?>
		<table class='table table-hover table-sm' id='tablaOrganizaciones'>
			<thead class=''>
				<tr>
					<th class="Organizacion"><a class="TableHeader" href="#">Organización</th>
				</tr>
			</thead>
			<?php
			while ($row = mysqli_fetch_row($result)){   
				?>
				<tr id=<?php echo $row[0]; ?>>
					<td><?php echo $row[1]; ?></td>
				</tr>
			<?php
			};  
			?>
		</table>
	<?php
	$html = ob_get_contents();
	ob_clean();
	return $html;
}

function imprimir_detalle_empresas($resultc, $conexion_sp, $idEmpresaTemp) {
	$reg = mysqli_fetch_array($resultc);  
	//Primero datos del contacto
	ob_start();
	?>
	<form>
	<div class="form-row">
		<div class="form-group col-md-4">
			<label for='idEmpresa' class="col-12 col-form-label">Id Empresa:</label>
			<input id='idEmpresa' class='col-12 form-control-plaintext' name='idEmpresa' type='text' alue='<?php echo $reg['id']; ?>'>
		</div>
		<div class="form-group col-md-4">
			<label for='CUIT' class="col-12 col-form-label">CUIT:</label>
			<input id='CUIT' class='col-12 form-control' name='CUIT' type='text' value='<?php echo $reg['CUIT']; ?>'>
		</div>
		<div class="form-group col-md-4">
			<label for='IdTipoContacto' class="col-12 col-form-label">Tipo:</label>
			<select id='IdTipoContacto' lass='select2' style="width: 100%;" name='IdTipoContacto'>
			<?php
			if(!$resultTC = mysqli_query($conexion_sp, "SELECT * from z_tipocontacto")) die("Problemas con la consulta z_tipocontacto");
			while ($row = mysqli_fetch_row($resultTC)){ 
				if ($reg['IdTipoContacto']==$row[0]){
					echo"<option selected value=".$row[0].">".$row[1]."</option>";
					}else{
						echo"<option value=".$row[0].">".$row[1]."</option>";
					}	
			}
			if ($reg['IdTipoContacto']=='' or $reg['IdTipoContacto']=='0'){
			echo"<option selected value=''></option>";
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-row">
		<label for='Organizacion' class="col-3 col-form-label">Razón social:</label>
		<div class="col-9">
			<input id='Organizacion' class='form-control' name='Organizacion' type='text' value='<?php echo $reg['Organizacion']; ?>'>
		</div>
	</div>
	<div class="form-row">
		<label for='ActividEmpresa' class="col-3 col-form-label">Actividad Empresa:</label>
		<div class="col-9">
			<input id='ActividEmpresa' class='form-control' name='ActividEmpresa' type='text' value='<?php echo $reg['ActividEmpresa']; ?>'>
		</div>
	</div>
	<div class="form-row">
		<label for='Observaciones' class="col-3 col-form-label">Observaciones:</label>
		<div class="col-9">
			<textarea id='Observaciones' class='form-control' name='Observaciones' rows='3' cols='90'><?php echo $reg['Observaciones']; ?></textarea> 
		</div>
	</div>
	<div class="form-row">
		<label for='Informacion' class="col-3 col-form-label">Rubro:</label>
		<div class="col-9">
			<input id='Informacion' class='form-control' name='Informacion' type='text' value='<?php echo $reg['Informacion']; ?>'>
		</div>
	</div>
	<div class="form-row">
		<label for='Horarios' class="col-3 col-form-label">Horarios de trabajo:</label>
		<div class="col-9">
			<input id='Horarios' class='form-control' name='Horarios' type='text' value='<?php echo $reg['Horarios']; ?>'>
		</div>
	</div>
	<div class="form-row">
		<label for='DiasDePago' class="col-3 col-form-label">Dias y horarios de pago:</label>
		<div class="col-9">
			<input id='DiasDePago' class='form-control' name='DiasDePago' type='text' value='<?php echo $reg['DiasDePago']; ?>'>
		</div>
	</div>
	<div class="form-row">
		<label for='EntregaFactura' class="col-3 col-form-label">Entrega de facturas:</label>
		<div class="col-9">
			<input id='EntregaFactura' class='form-control' name='EntregaFactura' type='text' value='<?php echo $reg['EntregaFactura']; ?>'>
		</div>
	</div>

	
	<label for='CondDePago'>Condición de pago:</label>
	<select id='CondDePago' class='input' name='CondDePago'>
	<option selected value=''></option>
	<?php
	//cambio la condicion de pago. ahora voy a guardar el id, ya no guardo el texto
	//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
	//Padre 17 es la forma de pago. No lo puedo cambiar
	if(!$resultCpago = mysqli_query($conexion_sp, "SELECT Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");
	while ($rowresultCpago = mysqli_fetch_array($resultCpago)){ 
		$tmpCpago = explode(',', $rowresultCpago['ContenidoValor']);
		if ($reg['CondDePago']==$rowresultCpago['Descripcion']){
			echo"<option selected value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}else{
				echo"<option value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}	
	}
	?>
	</select>
	
	<label for='CondicionIVA'>Condicion de IVA:</label>
	<select id='CondicionIVA' class='input' name='CondicionIVA'>
	<?php

	if(!$resultCIVA = mysqli_query($conexion_sp, "select ConddeIva from z_conddeiva")) die("Problemas con la consulta z_conddeiva");
	while ($row = mysqli_fetch_array($resultCIVA)){ 
		$selected = $reg['CondicionIVA']==$row['ConddeIva'] ? "selected" : "" ;
		echo"<option ". $selected." value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
	}
	if ($reg['CondicionIVA']=='' or $reg['CondicionIVA']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select>";		

	//Nueva 2018. Tipo de factura (A o B), para que el sistema lo seleccione solo a la hora de facturar
	if(!$tipocomprobantesafip = mysqli_query($conexion_sp, "select Codigo, Denominacion from tipocomprobantesafip where id = 1 or id = 6")) die("Problemas con la consulta tipocomprobantesafip");
	echo"<label for='tipocomprobantesafip'>Tipo de comprobantes:</label>";
	echo"<select id='tipocomprobantesafip' class='input' name='tipocomprobantesafip'>";
	while ($row = mysqli_fetch_array($tipocomprobantesafip)){ 
		if ($reg['tipoComprobante']==$row['Codigo']){
			echo"<option selected value='".$row['Codigo']."'>".$row['Denominacion']."</option>";
			}else{
				echo"<option value='".$row['Codigo']."'>".$row['Denominacion']."</option>";
			}	
	}
	if ($reg['tipoComprobante']=='' or $reg['tipoComprobante']=='0'){
	echo"<option selected value=''></option>";
	}
	echo"</select>";
	//Abril 2019. Precios y descuentos
	//Hago una tabla para separar visualmente
	echo"<label><u>Descuentos y recargos:</u></label>";
	if ($reg['IdTipoContacto']=='2'){$tipoContacto="red";} else {$tipoContacto="black";}
	//Grafico explicativo (costo del producto)
	?>
	<table style='padding: 1px; border-collapse: separate;' >
		<tr>
			<td style='border: 1px solid black;' rowspan='2' align='center'>Precio artículo<br>(lista o neto)</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid ".$tipoContacto.";' rowspan='2' align='center'>Descuento(s)<br>proveedor</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid ".$tipoContacto.";' rowspan='2' align='center'>Otros gastos<br>(flete, IIBB, etc)</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid black;' rowspan='2' align='center'>Margen de<br>ganancia</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid black;' rowspan='2' align='center'>PVP artículo<br>(precio de venta)</td>
		</tr>
		<tr>
			
			<td></td>

			<td></td>
			
			<td></td>

			<td></td>
		</tr>
	 </table>
	 </br>
	 <?php
	//Grafico explicativo (precio final del producto)
	if ($reg['IdTipoContacto']=='1'){$tipoContacto="red";} else {$tipoContacto="black";}
	?>
	<table style='padding: 1px; border-collapse: separate;' >
	<tr>
		<td style='border: 1px solid black;' rowspan='2' align='center'>PVP<br>(precio de venta)</td>
		<td style='border-bottom: 1px solid black;'></td>
		<td style='border: 1px solid <?php echo $tipoContacto; ?>;' rowspan='2' align='center'>Descuento habitual<br>cliente</td>
		<td style='border-bottom: 1px solid black;'></td>
		<td style='border: 1px solid black;' rowspan='2' align='center'>Descuento especial<br>por única vez</td>
		<td style='border-bottom: 1px solid black;'></td>
		<td style='border: 1px solid black;' rowspan='2' align='center'>Precio final<br>de venta</td>
	</tr>
	<tr>
		
		<td></td>

		<td></td>

		<td></td>
	</tr>
 </table>
 <label>Cliente:</label> Los descuentos/recargos se aplicarán al comprobante (presupuesto/venta) al momento de generarlo.
 <label>Proveedor:</label> Los descuentos/recargos se aplicarán a todos los artículos de este proveedor. También se aplicarán los de tipo Lista a las OC.
 <label>Varios o Cli/prov:</label> No se aplicarán descuentos o recargos automáticos.
 <?php
	//ver si es cliente o proveedor
	//1: Cliente. Los descuentos/recargos se aplicarán al comprobante
	//2: Proveedor. Los descuentos/recargos se aplicarán al artículo
	//3 y 4: Varios o Cli/prov. NO SE. Por ahora nada.

	if (($reg['IdTipoContacto']=='2')||($reg['IdTipoContacto']=='1')){
		if(!$tiposDescuentos = mysqli_query($conexion_sp, "select ID, Descripcion from tipos where ID = '26'")) die("Problemas con la consulta tipos");
		?>
		<label>Descuentos y recargos vigentes:</label><br />
		<table>
		<tr>
		<th>Porcentaje</th>
		<th>Fecha</th>
		<th>Tipo</th>
		<th>Responsable</th>
		<th>Eliminar descuento</th>
		</tr>
		<?php
		if(!$descuentos = mysqli_query($conexion_sp, "select Id, Porcentaje, Fecha, Tipo, Responsable from descuentos where Empresa = '".$reg['id']."' and (Tipo = '26'  or Tipo = '27') order by Id desc")) die("Problemas con la consulta descuentos");
		while ($rowDescuentos = mysqli_fetch_array($descuentos)){ 
			if(!$tipos = mysqli_query($conexion_sp, "select Descripcion from tipos where ID = '".$rowDescuentos['Tipo']."' limit 1")) die("Problemas con la consulta tipos");
			$rowTipos = mysqli_fetch_array($tipos);
			include_once '../includes/db_connect.php';
			$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or die("Problemas con la conexión");
			mysqli_query($conexion_db,"set names 'utf8'");
			if(!$miembros = mysqli_query($conexion_db, "select Nombre, Apellido from members where id = '".$rowDescuentos['Responsable']."' limit 1")) die("Problemas con la consulta tipos");
			$rowMiembros = mysqli_fetch_array($miembros);
			?>
			<tr name='DescuentoEmpresa' id='<?php echo $rowDescuentos['Id']; ?>'>
			<td><?php echo $rowDescuentos['Porcentaje']; ?> %</td>
			<td><?php echo $rowDescuentos['Fecha']; ?></td>
			<td><?php echo $rowTipos['Descripcion']; ?></td>
			<td><?php echo $rowMiembros['Nombre']." ".$rowMiembros['Apellido']; ?></td>
			<td><input value='X'/></td>
			</tr>";
			<?php
		}
		?>
		</table>
		<br />
		<input data-toggle='modal' data-target='#detallesdemovimientos' type='button' id='nuevoDescuento' value='Agregar nuevo descuento'/>
		<br />
		<label>Descuentos y recargos anteriores:</label>
		<?php
	}
	
	//Siguen las direcciones. Hacer una tabla.
	$sql= "SELECT id, Direccion, Ciudad, Codigopostal, Provoestado, Pais 
	from direcciones 
	where CUIT = '".$reg['id']."' and Direccion not Like '%@%' and ((Direccion is not null) and (Ciudad is not null) and (Codigopostal is not null) and (Provoestado is not null) and (Pais is not null)) order by id asc";

	if(!$resultDirec = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta Direcciones");
	echo $sql;
	?>
	<label><u>Direccion(es) de la empresa:</u></label>
	<table>
		<tr>
		<th>Direccion</th>
		<th>Ciudad</th>
		<th>CP</th>
		<th>Provincia</th>
		<th>pais</th>
		</tr>
		<?php
		$contadortd=0;
		while ($rowDir = mysqli_fetch_row($resultDirec)){ 
			?>
			<tr name='DireccionEmpresa' id='<?php echo $rowDir[0]; ?>'>
				<td><input id='Direccion<?php echo $contadortd; ?>' class='input' type='text' value='<?php echo $rowDir[1]; ?>'></td>
				<td><input id='Ciudad<?php echo $contadortd; ?>' class='input' type='text' value='<?php echo $rowDir[2]; ?>'></td>
				<td><input id='CP<?php echo $contadortd; ?>' class='input' type='text' alue='<?php echo $rowDir[3]; ?>'></td>
				<td><input id='Provincia<?php echo $contadortd; ?>' class='input' type='text' value='<?php echo $rowDir[4]; ?>'></td>
				<td><input id='pais<?php echo $contadortd; ?>' class='input' type='text' value='<?php echo $rowDir[5]; ?>'></td>
			</tr>
			<?php
			}
			?>
		<tr name='DireccionEmpresa' id='0'>
			<td><input id='Direccion<?php echo $contadortd; ?>' class='input' type='text' value=''></td>
			<td><input id='Ciudad<?php echo $contadortd; ?>' class='input' type='text' value=''></td>
			<td><input id='CP<?php echo $contadortd; ?>' class='input' type='text' alue=''></td>
			<td><input id='Provincia<?php echo $contadortd; ?>' class='input' type='text' value=''></td>
			<td><input id='pais<?php echo $contadortd; ?>' class='input' type='text' value=''></td>
			<td><input id='id<?php echo $contadortd; ?>' class='input' type='hidden' value='0'></td>
		</tr>
	</table>			
	<?php
	//Por ultimo los empleados de la empresa
	if(!$resultEmpleados = mysqli_query($conexion_sp, "SELECT NombreCompleto, FuncionEnLaEmpresa, PalabrasClave, PoderDecision from contactos2 where idOrganizacion = '".$reg['id']."' order by NombreCompleto")) die("Problemas con la consulta contactos2");
	?>
	<label><u>Empleados de la Empresa:</u></label>
	<table>
	<tr>
	<th>Nombre</th>
	<th>Funcion</th>
	<th>Palabras clave</th>
	<th>Decide</th>
	</tr>
	<?php
	while ($rowDir = mysqli_fetch_row($resultEmpleados)){ 
		?>
		<tr>
		<td><input class='input' type='text' value='<?php echo $rowDir[0]; ?>' disabled></td>
		<td><input class='input' type='text' value='<?php echo $rowDir[1]; ?>' disabled></td>
		<td><input class='input' type='text' value='<?php echo $rowDir[2]; ?>' disabled></td>
		<?php
		$value = $rowDir[3]=='1' ? "Si" : "No";
		?>
		<td><input class='input' type='text' value='<?php echo $value; ?>' disabled></td>
		</tr>
		<?php
	}
	?>
	</table></form>
	<?php

}

	
