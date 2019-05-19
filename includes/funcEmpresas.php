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
	<label for='idEmpresa'>Id Empresa:</label>
	<input id='idEmpresa' class='hidden' name='idEmpresa' type='text' size='5' value='<?php echo $reg['id']; ?>'>
	<label for='CUIT'>CUIT:</label>
	<input id='CUIT' class='input' name='CUIT' type='text' size='12' value='<?php echo $reg['CUIT']; ?>'>
	<label for='Organizacion'>Razón social:</label>
	<input id='Organizacion' class='input' name='Organizacion' type='text' size='72' value='<?php echo $reg['Organizacion']; ?>'>

	<label for='IdTipoContacto'>Tipo:</label>
	<select id='IdTipoContacto' class='input' name='IdTipoContacto'>
	<?php
	if(!$resultTC = mysqli_query($conexion_sp, "select * from z_tipocontacto")) die("Problemas con la consulta z_tipocontacto");
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
	<label for='ActividEmpresa'>Actividad de la empresa:</label>
	<input id='ActividEmpresa' class='input' name='ActividEmpresa' type='text' size='55' value='<?php echo $reg['ActividEmpresa']; ?>'><br />
	<label for='Observaciones'>Observaciones:</label>
	<textarea id='Observaciones' class='input' name='Observaciones' rows='6' cols='90'><?php echo $reg['Observaciones']; ?></textarea> <br />
	<label for='Informacion'>Rubro:</label>
	<input id='Informacion' class='input' name='Informacion' type='text' size='34' value='<?php echo $reg['Informacion']; ?>'><br />
	<label for='Horarios'>Horarios de trabajo:</label>
	<input id='Horarios' class='input' name='Horarios' type='text' size='89' value='<?php echo $reg['Horarios']; ?>'><br />
	<label for='DiasDePago'>Dias y horarios de pago:</label>
	<input id='DiasDePago' class='input' name='DiasDePago' type='text' size='85' value='<?php echo $reg['DiasDePago']; ?>'><br />
	<label for='EntregaFactura'>Entrega de facturas:</label>
	<input id='EntregaFactura' class='input' name='EntregaFactura' type='text' size='88' value='<?php echo $reg['EntregaFactura']; ?>'><br />
	
	<label for='CondDePago'>Condición de pago:</label>
	<select id='CondDePago' class='input' name='CondDePago'>
	<option selected value=''></option>
	<?php
	//cambio la condicion de pago. ahora voy a guardar el id, ya no guardo el texto
	//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
	//Padre 17 es la forma de pago. No lo puedo cambiar
	if(!$resultCpago = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");
	while ($rowresultCpago = mysqli_fetch_array($resultCpago)){ 
		$tmpCpago = explode(',', $rowresultCpago['ContenidoValor']);
		if ($reg['CondDePago']==$rowresultCpago['Descripcion']){
			echo"<option selected value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}else{
				echo"<option value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}	
	}
	?>
    </select><br />
	<label for='CondicionIVA'>Condicion de IVA:</label>
	<select id='CondicionIVA' class='input' name='CondicionIVA'>
	<?php
	if(!$resultCIVA = mysqli_query($conexion_sp, "select ConddeIva from z_conddeiva")) die("Problemas con la consulta z_conddeiva");
	while ($row = mysqli_fetch_array($resultCIVA)){ 
		if ($reg['CondicionIVA']==$row['ConddeIva']){
			echo"<option selected value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
			}else{
				echo"<option value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
			}	
	}
	if ($reg['CondicionIVA']=='' or $reg['CondicionIVA']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";		

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
	echo"</select><br />";
	//Abril 2019. Precios y descuentos
	//Hago una tabla para separar visualmente
	echo"<label><u>Descuentos y recargos:</u></label><br />";
	if ($reg['IdTipoContacto']=='2'){$tipoContacto="red";} else {$tipoContacto="black";}
	//Grafico explicativo (costo del producto)

	echo "<table style='padding: 1px; border-collapse: separate;' >
		<tr>
			<td style='border: 1px solid black;' rowspan='2' align='center'>Precio artículo<br>(lista o neto)</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid ".$tipoContacto.";' rowspan='2' align='center'>Descuento<br>proveedor</td>
			<td style='border-bottom: 1px solid black;' align='center'>Nuestro costo</td>
			<td style='border: 1px solid black;' rowspan='2' align='center'>Margen de<br>ganancia</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid black;' rowspan='2' align='center'>Otros gastos<br>(flete, IIBB, etc)</td>
			<td style='border-bottom: 1px solid black;'></td>
			<td style='border: 1px solid black;' rowspan='2' align='center'>PVP artículo<br>(precio de venta)</td>
		</tr>
		<tr>
			
			<td></td>

			<td align='center'>del producto</td>
			
			<td></td>

			<td></td>
		</tr>
	 </table>
	 </br>";
	//Grafico explicativo (precio final del producto)
	if ($reg['IdTipoContacto']=='1'){$tipoContacto="red";} else {$tipoContacto="black";}
	echo "<table style='padding: 1px; border-collapse: separate;' >
	<tr>
		<td style='border: 1px solid black;' rowspan='2' align='center'>PVP<br>(precio de venta)</td>
		<td style='border-bottom: 1px solid black;'></td>
		<td style='border: 1px solid ".$tipoContacto.";' rowspan='2' align='center'>Descuento habitual<br>cliente</td>
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
 </table>";
	//ver si es cliente o proveedor
	//1: Cliente. Los descuentos/recargos se aplicarán al comprobante
	//2: Proveedor. Los descuentos/recargos se aplicarán al artículo
	//3 y 4: Varios o Cli/prov. NO SE. Por ahora nada.

	echo "<label>Cliente:</label> Los descuentos/recargos se aplicarán al comprobante (presupuesto/venta) al momento de generarlo.<br />";
	echo "<label>Proveedor:</label> Los descuentos/recargos se aplicarán a todos los artículos de este proveedor. También se aplicarán los de tipo Lista a las OC.<br />";
	echo "<label>Varios o Cli/prov:</label> No se aplicarán descuentos o recargos automáticos.<br />";

	if (($reg['IdTipoContacto']=='2')||($reg['IdTipoContacto']=='1')){
		echo"<label>Descuentos y recargos vigentes:</label><br />";
		if(!$tiposDescuentos = mysqli_query($conexion_sp, "select ID, Descripcion from tipos where Destino = 'Descuentos'")) die("Problemas con la consulta tipos");
		while ($rowTiposDescuentos = mysqli_fetch_array($tiposDescuentos)){ 
			if(!$descuentos = mysqli_query($conexion_sp, "select Id, Porcentaje, Fecha, Tipo from descuentos where Empresa = '".$reg['id']."' and Tipo = '".$rowTiposDescuentos['ID']."' order by Id desc limit 1")) die("Problemas con la consulta descuentos");

		}
		echo"<br />";

		echo"<label>Descuentos y recargos anteriores:</label><br />";
		echo"<br />";
	}
	
	//Siguen las direcciones. Hacer una tabla.
	if(!$resultDirec = mysqli_query($conexion_sp, "select id, Direccion, Ciudad, Codigopostal, Provoestado, Pais from direcciones where CUIT = '".$reg['id']."' and Direccion not Like '%@%' and ((Direccion is not null) and (Ciudad is not null) and (Codigopostal is not null) and (Provoestado is not null) and (Pais is not null)) order by id asc")) die("Problemas con la consulta Direcciones");
	echo"<label><u>Direccion(es) de la empresa:</u></label>";
	echo"<br />";
	echo"<table>";
	echo"<tr>";
	echo"<th>Direccion</th>";
	echo"<th>Ciudad</th>";
	echo"<th>CP</th>";
	echo"<th>Provincia</th>";
	echo"<th>pais</th>";	
	echo"</tr>";
	$contadortd=0;
	while ($rowDir = mysqli_fetch_row($resultDirec)){ 
		echo"<tr name='DireccionEmpresa' id='".$rowDir[0]."'>";
		echo"<td><input id='Direccion".$contadortd."' class='input' type='text' size='34' value='".$rowDir[1]."'></td>";
		echo"<td><input id='Ciudad".$contadortd."' class='input' type='text' size='10' value='".$rowDir[2]."'></td>";
		echo"<td><input id='CP".$contadortd."' class='input' type='text' size='4' value='".$rowDir[3]."'></td>";
		echo"<td><input id='Provincia".$contadortd."' class='input' type='text' size='14' value='".$rowDir[4]."'></td>";
		echo"<td><input id='pais".$contadortd."' class='input' type='text' size='10' value='".$rowDir[5]."'></td>";		
		if ($contadortd==0) {echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='".$rowDir[0]."'>Facturación</td>";} else {echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='".$rowDir[0]."'></td>";}
		echo"</tr>";
		$contadortd++;
	}
		echo"<tr name='DireccionEmpresa' id='0'>";
		echo"<td><input id='Direccion".$contadortd."' class='input' type='text' size='34' value=''></td>";
		echo"<td><input id='Ciudad".$contadortd."' class='input' type='text' size='10' value=''></td>";
		echo"<td><input id='CP".$contadortd."' class='input' type='text' size='4' value=''></td>";
		echo"<td><input id='Provincia".$contadortd."' class='input' type='text' size='14' value=''></td>";
		echo"<td><input id='pais".$contadortd."' class='input' type='text' size='10' value=''></td>";
		echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='0'></td>";		
		echo"</tr>";
	echo"</table>";			
	//Por ultimo los empleados de la empresa
	if(!$resultEmpleados = mysqli_query($conexion_sp, "select NombreCompleto, FuncionEnLaEmpresa, PalabrasClave, PoderDecision from contactos2 where idOrganizacion = '".$reg['id']."' order by NombreCompleto")) die("Problemas con la consulta contactos2");
	echo"<label><u>Empleados de la Empresa:</u></label>";
	echo"<br />";
	echo"<table>";
	echo"<tr>";
	echo"<th>Nombre</th>";
	echo"<th>Funcion</th>";
	echo"<th>Palabras clave</th>";
	echo"<th>Decide</th>";	
	echo"</tr>";
	while ($rowDir = mysqli_fetch_row($resultEmpleados)){ 
		echo"<tr>";
		echo"<td><input class='input' type='text' size='34' value='".$rowDir[0]."' disabled></td>";
		echo"<td><input class='input' type='text' size='30' value='".$rowDir[1]."' disabled></td>";
		echo"<td><input class='input' type='text' size='30' value='".$rowDir[2]."' disabled></td>";
		if ($rowDir[3]=='1') {echo"<td><input class='input' type='text' size='2' value='Si' disabled></td>";} else {echo"<td><input class='input' type='text' size='2' value='No' disabled></td>";}
		echo"</tr>";
	}
	echo"</table>";	
}

	
