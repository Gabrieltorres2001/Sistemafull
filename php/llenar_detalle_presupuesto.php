<?php
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select Confecciono from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante); 
	
	if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."' order by Orden")) die("Problemas con la consulta2");
	
	$soyYo=0;
	if($reg['Confecciono']==$_REQUEST['sesses'])$soyYo=1;
	
echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetalleComprobante'>";  
echo "<tr>";  
echo "<th width='1' style='text-align:center'>Orden</th>";  
echo "<th width='1' style='text-align:center'>Id</th>"; 
echo "<th width='15' style='text-align:center'>Descripcion</th>";  
echo "<th width='4' style='text-align:center'>Cantidad</br>(Stock)</th>"; 
echo "<th width='1' style='text-align:center'>Unitario</th>"; 
echo "<th width='4' style='text-align:center'>%1</th>"; 
echo "<th width='4' style='text-align:center'>%2</th>";
echo "<th width='4' style='text-align:center'>%3</th>";
echo "<th width='1' style='text-align:center'>Moneda</th>";
echo "<th width='15' style='text-align:center'>Unitario</th>"; 
echo "<th width='15' style='text-align:center'>Subtotal</th>";
echo "<th width='1' style='text-align:center'>IVA</th>";  
echo "<th width='15' style='text-align:center'>Plazo entrega</th>";
echo "<th width='15' style='text-align:center'>Observaciones</th>";
echo "<th width='1' style='text-align:center'>Borrar</th>";
echo "</tr>"; 
  
while ($row = mysqli_fetch_row($resultDetalle)){  
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, MonedaOrigen, ValorVenta, IVA from productos where IdProducto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
	$rowProd = mysqli_fetch_array($resultArticulo);
	if(!$monedaArticulo = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowProd['MonedaOrigen']."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaArt = mysqli_fetch_array($monedaArticulo);
	if(!$monedaDetalle = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$row[13]."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaDet = mysqli_fetch_array($monedaDetalle);
	if(!$iva = mysqli_query($conexion_sp, "select Texto from z_ivas where IdRegistro='".$rowProd['IVA']."' limit 1")) die("Problemas con la consulta2");
	$rowIVA = mysqli_fetch_array($iva);
    echo "<tr id='$row[0]'>";  
	//Tengo que dejar el formato: $row[0]&$row[2]&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
	//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&ordenitem' height='50'><input id='$row[0]&$row[2]&ordenitem&E' class='input' name='xxxxt' type='text' size='1' style='text-align:center' value=".$row[7]." Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&ordenitem' height='50'><input id='$row[0]&$row[2]&ordenitem&E' class='input' name='xxxxt' type='text' size='1' style='text-align:center' value=".$row[7]."></td>";}
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&iditem'><input id='$row[0]&$row[2]&iditem&E' class='input' name='xxxxt' type='text' size='2' style='text-align:center' value=".$row[2]." Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&iditem'><input id='$row[0]&$row[2]&iditem&E' class='input' name='xxxxt' type='text' size='2' style='text-align:center' value=".$row[2]."></td>";}
    echo "<td name='xxxx' id='$row[0]&$row[2]&descriptitem'>".$rowProd['descricpcion']."</td>";  
	//Cantidad. Ver de que color de fondo lo pinto.
	//Una nueva. Reviso el stock y pinto los campos de colores
	if(!$resultArt = mysqli_query($conexion_sp, "select EnStock, StockMinimo, tangible from productos where IdProducto = '".$row[2]."' limit 1")){
			die("Problemas con la consulta de lectura detallecomprobante");};		
	$art = mysqli_fetch_array($resultArt);
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&cantitem' style='text-align:center;'><input id='$row[0]&$row[2]&cantitem&E' class='input' name='xxxxt' type='text' size='2' style='text-align:center' value=".$row[3]." Disabled></br>(".$art['EnStock'].")</td>";} else {
		//Mio. Habilitado
		$colorFondo='#abf1ab';
		if ($art['StockMinimo']<=$row[3]) {$colorFondo='yellow';}	
		if ($art['EnStock']<$row[3]) {$colorFondo='#FA5858';}
		if ($art['tangible']<1) {$colorFondo='white';}		
		echo "<td name='xxxx' id='$row[0]&$row[2]&cantitem' style='text-align:center;'><input id='$row[0]&$row[2]&cantitem&E' class='input' name='xxxxt' type='text' size='2' style='text-align:center; background-color:".$colorFondo.";' value=".$row[3]."></br>(".$art['EnStock'].")</td>";
		}	
    echo "<td name='xxxx' id='$row[0]&$row[2]&unititem' style='text-align:center'>".$rowMonedaArt['Simbolo']." ".number_format($rowProd['ValorVenta'],2,'.','')."</td>";
	$porc=(float)$row[11]*100;
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&desc1item'><input id='E$row[0]&$row[2]&desc1item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."% Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&desc1item'><input id='$row[0]&$row[2]&desc1item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."%></td>";}
	$porc=(float)$row[14]*100;	
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&desc2item'><input id='$row[0]&$row[2]&desc2item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."% Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&desc2item'><input id='$row[0]&$row[2]&desc2item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."%></td>";}
	$porc=(float)$row[15]*100;	
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&desc3item'><input id='$row[0]&$row[2]&desc3item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."% Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&desc3item'><input id='$row[0]&$row[2]&desc3item&E' class='input' name='xxxxt' type='text' size='3' style='text-align:center' value=".number_format($porc,2,'.','')."%></td>";}
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&monedaitem'><input id='E&$row[0]&$row[2]&monedaitem' class='input' name='xxxxtn' type='text' size='1' style='text-align:center' value=".$rowMonedaDet['Simbolo']." Disabled></td>";} else {	
	echo "<td width='11' name='xxxx' id='$row[0]&$row[2]&monedaitem'>";
	echo"<select id='$row[0]&$row[2]&monedaitem&E' name='xxxxt'>";
		  if ('$'==$rowMonedaDet['Simbolo']){echo"<option value='$' selected='selected'>$</option>";} else {echo"<option value='$'>$</option>";};   
		  if ('USD'==$rowMonedaDet['Simbolo']){echo"<option value='U' selected='selected'>USD</option>";} else {echo"<option value='U'>USD</option>";};   
		  if ('€'==$rowMonedaDet['Simbolo']){echo"<option value='€' selected='selected'>€</option>";} else {echo"<option value='€'>€</option>";};   
	echo"</select>";
	echo"</td>";
	}	
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&descontadoitem'><input id='$row[0]&$row[2]&descontadoitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row[4],2,'.','')." Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&descontadoitem'><input id='$row[0]&$row[2]&descontadoitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row[4],2,'.','')."></td>";}	
    if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&subtotitem'><input id='$row[0]&$row[2]&subtotitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row[6],2,'.','')." Disabled></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&subtotitem'><input id='$row[0]&$row[2]&subtotitem&E' class='input' name='xxxxt' type='text' size='5' style='text-align:center' value=".number_format($row[6],2,'.','')."></td>";}	
    echo "<td name='xxxx' id='$row[0]&$row[2]&ivaitem' style='text-align:center'>".$rowIVA['Texto']."</td>";	
	if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&plazoitem'><textarea id='$row[0]&$row[2]&plazoitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4' disabled>".$row[17]."</textarea></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&plazoitem'><textarea id='$row[0]&$row[2]&plazoitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4'>".$row[17]."</textarea></td>";}
	if ($soyYo==0) {echo "<td name='xxxx' id='$row[0]&$row[2]&obsitem'><textarea id='$row[0]&$row[2]&obsitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4' disabled>".$row[8]."</textarea></td>";} else {echo "<td name='xxxx' id='$row[0]&$row[2]&obsitem'><textarea id='$row[0]&$row[2]&obsitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='8' rows='4'>".$row[8]."</textarea></td>";}
	if ($soyYo==0) {} else {echo "<td id='$row[0]&$row[2]&action'><img name='xxxxx' id='$row[0]&$row[2]&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}
    echo "</tr>";	
}  	
echo "</table>";

//ahora la ultima fila en blanco para agregar item
if ($soyYo==0) {} else {
	echo "<img name='xxxxuz' src='./images/Agregar.jpg' width='35' height='35'>";
	echo "<img name='xxxxz' src='./images/lupa.jpg' width='35' height='35'>";
	echo "<img name='xxxxy' id='$row[0]&$row[2]&imagenOk' src='./images/recarga.jpg' width='35' height='35'>";
}
