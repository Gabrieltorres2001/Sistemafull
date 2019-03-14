<?php
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");

//generamos la consulta
//OCEnviada es para saber si el recibo ya fue generado, si es asi no lo puedo modificar (si lo puedo reimprimir), ya que sino se volverian a registrar los pagos a las facturas.
   if(!$resultComprobante = mysqli_query($conexion_sp, "select Confecciono, OCEnviada from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);
	
	if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."' and Destino='LIQUIDACION' order by Orden")) die("Problemas con la consulta2");
	//echo mysqli_num_rows($resultDetalle);
	$soyYo=0;
	if($reg['Confecciono']==$_REQUEST['sesses'])$soyYo=1;

	if($reg['OCEnviada']==1)$soyYo=0;

	$totalAPagar=0;

echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetalleComprobante'>";  
echo "<tr style='border: 2px solid;'>"; 
echo"<th colspan='9' style='text-align:center; color:red;'>LIQUIDACION - COMPROBANTES A CANCELAR</th>";
echo "</tr>"; 
echo "<tr>";  
echo "<th width='1' style='text-align:center'>Fecha</th>"; 
echo "<th width='45' style='text-align:center'>Comprobante</th>";  
echo "<th width='45' style='text-align:center'>Total Factura</th>"; 
echo "<th width='4' style='text-align:center'>Importe a cancelar</th>"; 
echo "<th width='4' style='text-align:center; color:red;'>Tipo de cambio <strong>(!)</strong></th>";
echo "<th width='4' style='text-align:center'>Subtotal</th>";
echo "<th width='1' style='text-align:center'>Borrar</th>";
echo "</tr>"; 
 
while ($row = mysqli_fetch_array($resultDetalle)){  

	//Busco el comprobante en la tabla CAEAFIP donde IdProducto=Id(caeafip)
	//IdEnviado es la moneda de la factura
	if(!$resultComprobante = mysqli_query($conexion_sp, "select FechaFactura, TipoFactura, NumeroFactura, ImporteTotal, IdEnviado, CAE from caeafip where Id='".$row['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$rowComprobante = mysqli_fetch_array($resultComprobante);
	//Luego busco el tipo de cambio usado, en la tabla 
	if(!$tipoCambioUsado = mysqli_query($conexion_sp, "select tipoCambio from datosauxfacturasemitidas where CAE = '".$rowComprobante['CAE']."' limit 1")) die("Problemas con la consulta forma de pago en datosauxfacturasemitidas");	
	$rowtipoCambioUsado = mysqli_fetch_array($tipoCambioUsado);

	//Luego busco el símbolo para la moneda facturada
	$codigoMoneda=$rowComprobante['IdEnviado']+1;
	if(!$monedaComprobante = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$codigoMoneda."' limit 1")) die("Problemas con la consulta monedaorigen");
	$rowMonedaComprobante = mysqli_fetch_array($monedaComprobante);
	
	//Ahora cargo la tabla
    echo "<tr id='".$row['IdDetalleComprobante']."'>";  
	//Tengo que dejar el formato: $row['IdDetalleComprobante']&$row['IdProducto']&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
	//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
	//Fecha
	$fechaEnArgentino=substr($rowComprobante['FechaFactura'],8,2)."/".substr($rowComprobante['FechaFactura'],5,2)."/".substr($rowComprobante['FechaFactura'],0,4);
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&fechaitem'>".$fechaEnArgentino."</td>"; 
	//Comprobante
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&comprobanteitem'>".$rowComprobante['TipoFactura']." ".$rowComprobante['NumeroFactura']."</td>";
	//Total Factura
	$totalRedondeado=number_format($rowComprobante['ImporteTotal'],2,'.',' ');
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&totalFacturaitem'>".$rowMonedaComprobante['Simbolo']." ".$totalRedondeado."</td>";
	
	//Importe a cancelar (en moneda original). NO es el total de la factura, es lo restante de pagar.
	//Aca tengo que ver si el recibo es mio, sino no lo puedo modificar
	if ($soyYo==0) {
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')." disabled></td>";	
	} else {
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')."></td>";	
	}

	//Cambio a utilizar para este comprobante en el recibo.
	//Busco el tipo de cambio que se usó en la FC o ND
	//Antes que nada, me fijo si es en pesos, en ese caso el TC es siempre 1
	if ($rowComprobante['IdEnviado']==0){
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem'><input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value='1' Disabled></td>";
	} else {
	if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem'><input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem'><input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')."></td>";}}

		//Por ultimo el subtotal, que es igual al pendiente * tipocambio
	if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')."></td>";}	
	//El total de las facturas (a pagar)
	$totalAPagar=$totalAPagar+$row['SubTotal'];
	
	//Borrar
	if ($soyYo==0) {} else {echo "<td style='text-align:center' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&action'><img name='xxxxx' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}
    echo "</tr>";	
}
  	
//Marzo 2019. Busco ademas si hay campos ACUENTA y REDONDEO
//ACUENTA
if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."' and Destino='ACUENTA' limit 1")) die("Problemas con la consulta2");
while ($row = mysqli_fetch_array($resultDetalle)){  

	//Busco el comprobante en la tabla CAEAFIP donde IdProducto=Id(caeafip)
	//IdEnviado es la moneda de la factura
	if(!$resultComprobante = mysqli_query($conexion_sp, "select FechaFactura, TipoFactura, NumeroFactura, ImporteTotal, IdEnviado, CAE from caeafip where Id='".$row['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$rowComprobante = mysqli_fetch_array($resultComprobante);
	//Luego busco el tipo de cambio usado, en la tabla 
	if(!$tipoCambioUsado = mysqli_query($conexion_sp, "select tipoCambio from datosauxfacturasemitidas where CAE = '".$rowComprobante['CAE']."' limit 1")) die("Problemas con la consulta forma de pago en datosauxfacturasemitidas");	
	$rowtipoCambioUsado = mysqli_fetch_array($tipoCambioUsado);

	//Luego busco el símbolo para la moneda facturada
	$codigoMoneda=$rowComprobante['IdEnviado']+1;
	if(!$monedaComprobante = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$codigoMoneda."' limit 1")) die("Problemas con la consulta monedaorigen");
	$rowMonedaComprobante = mysqli_fetch_array($monedaComprobante);
	
	//Ahora cargo la tabla
    echo "<tr id='".$row['IdDetalleComprobante']."'>";  
	//Tengo que dejar el formato: $row['IdDetalleComprobante']&$row['IdProducto']&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
	//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
	//Fecha
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&fechaitem'></td>"; 
	//Comprobante
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&comprobanteitem'>A CUENTA</td>";
	//Total Factura
	$totalRedondeado=number_format($rowComprobante['ImporteTotal'],2,'.',' ');
	echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&totalFacturaitem'></td>";
	
	//Importe a cancelar (en moneda original). NO es el total de la factura, es lo restante de pagar.
	//Aca tengo que ver si el recibo es mio, sino no lo puedo modificar
	if ($soyYo==0) {
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&25&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')." disabled></td>";	
	} else {
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&25&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')."></td>";	
	}

	//Cambio a utilizar para este comprobante en el recibo.
	//Busco el tipo de cambio que se usó en la FC o ND
	//Antes que nada, me fijo si es en pesos, en ese caso el TC es siempre 1
	if ($rowComprobante['IdEnviado']==0){
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&cambioitem'><input id='".$row['IdDetalleComprobante']."&25&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value='1' Disabled></td>";
	} else {
	if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&cambioitem'><input id='".$row['IdDetalleComprobante']."&25&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&cambioitem'><input id='".$row['IdDetalleComprobante']."&25&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')."></td>";}}

		//Por ultimo el subtotal, que es igual al pendiente * tipocambio
	if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&25&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&25&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&25&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')."></td>";}	
	//El total de las facturas (a pagar)
	$totalAPagar=$totalAPagar+$row['SubTotal'];

	//Borrar
	if ($soyYo==0) {} else {echo "<td style='text-align:center' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&action'><img name='xxxxx' id='".$row['IdDetalleComprobante']."&25&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}
	echo "</tr>";	
}

	//REDONDEO
	if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."' and Destino='REDONDEO' order by Orden")) die("Problemas con la consulta2");
	while ($row = mysqli_fetch_array($resultDetalle)){  
	
		//Busco el comprobante en la tabla CAEAFIP donde IdProducto=Id(caeafip)
		//IdEnviado es la moneda de la factura
		if(!$resultComprobante = mysqli_query($conexion_sp, "select FechaFactura, TipoFactura, NumeroFactura, ImporteTotal, IdEnviado, CAE from caeafip where Id='".$row['IdProducto']."' limit 1")) die("Problemas con la consulta2");
		$rowComprobante = mysqli_fetch_array($resultComprobante);
		//Luego busco el tipo de cambio usado, en la tabla 
		if(!$tipoCambioUsado = mysqli_query($conexion_sp, "select tipoCambio from datosauxfacturasemitidas where CAE = '".$rowComprobante['CAE']."' limit 1")) die("Problemas con la consulta forma de pago en datosauxfacturasemitidas");	
		$rowtipoCambioUsado = mysqli_fetch_array($tipoCambioUsado);
	
		//Luego busco el símbolo para la moneda facturada
		$codigoMoneda=$rowComprobante['IdEnviado']+1;
		if(!$monedaComprobante = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$codigoMoneda."' limit 1")) die("Problemas con la consulta monedaorigen");
		$rowMonedaComprobante = mysqli_fetch_array($monedaComprobante);
		
		//Ahora cargo la tabla
		echo "<tr id='".$row['IdDetalleComprobante']."'>";  
		//Tengo que dejar el formato: $row['IdDetalleComprobante']&$row['IdProducto']&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
		//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
		//Fecha
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&fechaitem'></td>"; 
		//Comprobante
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&comprobanteitem'>REDONDEO</td>";
		//Total Factura
		$totalRedondeado=number_format($rowComprobante['ImporteTotal'],2,'.',' ');
		echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&totalFacturaitem'></td>";
		
		//Importe a cancelar (en moneda original). NO es el total de la factura, es lo restante de pagar.
		//Aca tengo que ver si el recibo es mio, sino no lo puedo modificar
		if ($soyYo==0) {
			echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&17&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')." disabled></td>";	
		} else {
			echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&pendienteFacturaitem'>".$rowMonedaComprobante['Simbolo']." <input id='".$row['IdDetalleComprobante']."&17&pendienteFacturaitem&E' class='input' name='xxxxt' type='text' size='8' style='text-align:center' value=".number_format($row['CostoUnitario'],2,'.','')."></td>";	
		}
	
		//Cambio a utilizar para este comprobante en el recibo.
		//Busco el tipo de cambio que se usó en la FC o ND
		//Antes que nada, me fijo si es en pesos, en ese caso el TC es siempre 1
		if ($rowComprobante['IdEnviado']==0){
			echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&cambioitem'><input id='".$row['IdDetalleComprobante']."&17&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value='1' Disabled></td>";
		} else {
		if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&cambioitem'><input id='".$row['IdDetalleComprobante']."&17&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&cambioitem'><input id='".$row['IdDetalleComprobante']."&17&cambioitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row['Descuento'],2,'.','')."></td>";}}
	
			//Por ultimo el subtotal, que es igual al pendiente * tipocambio
		if ($soyYo==0) {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&17&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')." Disabled></td>";} else {echo "<td style='text-align:center' name='xxxx' id='".$row['IdDetalleComprobante']."&17&subtotitem'>$ <input id='".$row['IdDetalleComprobante']."&17&subtotitem&E' class='input' name='xxxxt' type='text' size='10' style='text-align:center' value=".number_format($row['SubTotal'],2,'.','')."></td>";}	
		//El total de las facturas (a pagar)
		$totalAPagar=$totalAPagar+$row['SubTotal'];	
	
		//Borrar
		if ($soyYo==0) {} else {echo "<td style='text-align:center' id='".$row['IdDetalleComprobante']."&17&action'><img name='xxxxx' id='".$row['IdDetalleComprobante']."&17&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}
		echo "</tr>";	
}


//Ahora el total a pagar
echo "<tr style='border: 1px solid;'>"; 
echo"<td colspan='4' style='text-align:center; color:red;'></td>";
echo"<td style='text-align:center; color:red;'>TOTAL A CANCELAR:</td>";
echo"<td style='text-align:center; color:red;'>$   <input id='totalFacturas' class='input' name='xxxxt' type='text' size='10' style='text-align:center; color:red;' value=".number_format($totalAPagar,2,'.','')." Disabled></td>";
echo"<td style='text-align:center; color:red;'></td>";
echo "</tr>"; 

echo "</table>";

//ahora la ultima fila en blanco para agregar item
if ($soyYo==0) {} else {
	echo "<img name='xxxxz' src='./images/lupa.jpg' width='35' height='35'>";
	echo "<img name='xxxxy' id='".$row['IdDetalleComprobante']."&".$row['IdProducto']."&imagenOk' src='./images/recarga.jpg' width='35' height='35'>";
}

