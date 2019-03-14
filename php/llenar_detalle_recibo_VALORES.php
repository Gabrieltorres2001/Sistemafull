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
	//Busco los pagos en la tabla fondos. Los tipo 2 son para Recibos (los tipo 1 son para cuentas corrientes, factura por factura)
	//Los pagos de la tabla fondo tipo 2 (Generales de un recibo) se transformarán luego en tipo 1 (individuales de cada factura)
	if(!$resultDetalle = mysqli_query($conexion_sp, "select ID, Fecha, Descripcion, Importe, TipoValor from fondos where IDComprobante='".$_REQUEST['idcomprobante']."' and Tipo = '2' order by Fecha")) die("Problemas con la consulta fondos");
	//echo mysqli_num_rows($resultDetalle);

	//OCEnviada es para saber si el recibo ya fue generado, si es asi no lo puedo modificar (si lo puedo reimprimir), ya que sino se volverian a registrar los pagos a las facturas.
	if(!$resultComprobante = mysqli_query($conexion_sp, "select Confecciono, OCEnviada from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta comprobantes");
	$reg = mysqli_fetch_array($resultComprobante);
	$soyYo=0;
	if($reg['Confecciono']==$_REQUEST['sesses'])$soyYo=1;
	if($reg['OCEnviada']==1)$soyYo=0;

	//El total de los pagos
	$totalACobrar=0;

echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetalleComprobante'>";  
echo "<tr style='border: 2px solid;'>"; 
echo"<th colspan='7' style='text-align:center; color:blue;'>VALORES - DETALLE DE PAGOS</th>";
echo "</tr>"; 
echo "<tr>";  
echo "<th width='1' style='text-align:center'>Fecha</th>"; 
echo "<th width='45' style='text-align:center'>Forma de pago</th>";  
echo "<th width='145' style='text-align:center'>Descripcion</th>"; 
echo "<th width='4' style='text-align:center'>Importe</th>"; 
echo "<th width='1' style='text-align:center'>Borrar</th>";
echo "</tr>"; 
 
while ($row = mysqli_fetch_array($resultDetalle)){  
	
	//Ahora cargo la tabla
    echo "<tr id='".$row['ID']."'>";  
	//Tengo que dejar el formato: $row['ID']&$_REQUEST['idcomprobante']&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
	//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
	//Fecha
	$fechaEnArgentino=substr($row['Fecha'],8,2)."/".substr($row['Fecha'],5,2)."/".substr($row['Fecha'],0,4);
	echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&fechaPago'>".$fechaEnArgentino."</td>"; 
	//Forma de pago
	//Primero busco la relación entre el número y la tabla tipos
	if(!$resultTipos = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$row['TipoValor']."' limit 1")) die("Problemas con la consulta tipos");
	$regTipos = mysqli_fetch_array($resultTipos);
	echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&tipoFormaPago'>".$regTipos['Descripcion']."</td>";
	//Descripcion
	//Aca tengo que ver si el recibo es mio, sino no lo puedo modificar
	if ($soyYo==0) {
		echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&descripcionPago'><textarea id='".$row['ID']."&".$_REQUEST['idcomprobante']."&descripcionPago&E' class='input' name='xxxxtp' type='text' cols='28' rows='2' disabled>".$row['Descripcion']." </textarea></td>";	
	} else {
		echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&descripcionPago'><textarea id='".$row['ID']."&".$_REQUEST['idcomprobante']."&descripcionPago&E' class='input' name='xxxxtp' type='text' cols='28' rows='2'>".$row['Descripcion']." </textarea></td>";	
	}
	//Total Pago
	//Aca tengo que ver si el recibo es mio, sino no lo puedo modificar
	if ($soyYo==0) {
		echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&totalPago'>$ <input id='".$row['ID']."&".$_REQUEST['idcomprobante']."&totalPago&E' class='input' name='xxxxtp' type='text' size='8' style='text-align:center' value=".number_format($row['Importe'],2,'.','')." disabled></td>";	
	} else {
		echo "<td style='text-align:center' name='xxxx' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&totalPago'>$ <input id='".$row['ID']."&".$_REQUEST['idcomprobante']."&totalPago&E' class='input' name='xxxxtp' type='text' size='8' style='text-align:center' value=".number_format($row['Importe'],2,'.','')."></td>";	
	}
	$totalACobrar=$totalACobrar+$row['Importe'];
	
	//Borrar
	if ($soyYo==0) {} else {echo "<td style='text-align:center' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&action'><img name='xxxxxp' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}
    echo "</tr>";	
}

//Ahora el total de pagos
echo "<tr style='border: 1px solid;'>"; 
echo"<td colspan='2' style='text-align:center; color:blue;'></td>";
echo"<td style='text-align:right; color:blue;'>TOTAL PAGOS:</td>";
echo"<td style='text-align:center; color:blue;'>$   <input id='totalValores' class='input' name='xxxxt' type='text' size='10' style='text-align:center; color:blue;' value=".number_format($totalACobrar,2,'.','')." Disabled></td>";
echo"<td style='text-align:center; color:blue;'></td>";
echo "</tr>"; 

echo "</table>";

//ahora la ultima fila en blanco para agregar item
if ($soyYo==0) {} else {
	echo "<img name='xxxxzp' src='./images/lupa.jpg' width='35' height='35'>";
	echo "<img name='xxxxyp' id='".$row['ID']."&".$_REQUEST['idcomprobante']."&imagenOk' src='./images/recarga.jpg' width='35' height='35'>";
}

