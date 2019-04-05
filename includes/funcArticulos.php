<?php

function llenar_listado_articulos() {
   //Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select	IdProducto,descricpcion,idProveedor,MonedaOrigen,ValorVenta,EnStock from productos ORDER BY IdProducto asc limit 100")) die("Problemas con la consulta productos");
echo "<table class='display' id='tablaArticulos'>";  
echo "<th width='30'>Cod</th>";  
echo "<th width='100'>Descripción</th>";  
echo "<th  width='140'>Proveedor</th>";  
echo "<th  width='80'>ValorVenta</th>"; 
echo "<th  width='50'>EnStock</th>"; 
echo "</tr>";  
while ($row = mysqli_fetch_array($result)){   
    echo "<tr id=".$row['IdProducto'].">";  
    echo "<td id=".$row['IdProducto'].">".$row['IdProducto']."</td>";   
    echo "<td id=".$row['IdProducto'].">".$row['descricpcion']."</td>";
    echo "<td id=".$row['IdProducto'].">".$row['idProveedor']."</td>"; 
	if(!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen where IdRegistroCambio='".$row['MonedaOrigen']."'")) die("Problemas con la consulta monedaorigen"); 
		$regTM = mysqli_fetch_array($resultTM); 
    echo "<td id=".$row['IdProducto'].">".$regTM['Simbolo']." ".$row['ValorVenta']."</td>";
    echo "<td id=".$row['IdProducto'].">".$row['EnStock']."</td>"; 
    echo "</tr>";    
};  
echo "</table>";
}

function imprimir_detalle_articulos($resultc, $conexion_sp) {
	$reg = mysqli_fetch_array($resultc);  
	echo"<label for='IdProducto'>Id del Producto:</label>";
	echo"<input id='IdProducto' class='input' name='IdProducto' type='text' size='6' value=".$reg['IdProducto']." disabled>";

	echo"<label for='actualiz'>Fecha de actualización:</label>";
	echo"<input id='actualiz' class='input' name='actualiz' type='text' size='33' value='".$reg['actualiz']."' disabled>";	
	
	if(!$resultTP = mysqli_query($conexion_sp, "select * from z_tipoproducto")) die("Problemas con la consulta z_tipoproducto");
	echo"<label for='TipoProducto'>Tipo:</label>";
	echo"<select id='TipoProducto' class='input' name='TipoProducto'>";
	while ($row = mysqli_fetch_array($resultTP)){ 
		if ($reg['TipoProducto']==$row['IdTipoProducto']){
			echo"<option selected value=".$row['IdTipoProducto'].">".$row['TipoProducto']."</option>";
			}else{
				echo"<option value=".$row['IdTipoProducto'].">".$row['TipoProducto']."</option>";
			}	
	}
	if ($reg['TipoProducto']=='' or $reg['TipoProducto']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	
	if(!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen")) die("Problemas con la consulta monedaorigen");
	echo"<label for='MonedaOrigen'>Moneda:</label>";
	echo"<select id='MonedaOrigen' class='input' name='MonedaOrigen' style='font-size:1.7em'>";
	while ($row = mysqli_fetch_array($resultTM)){ 
		if ($reg['MonedaOrigen']==$row['IdRegistroCambio']){
			echo"<option selected value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}else{
				echo"<option value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}	
	}
	if ($reg['MonedaOrigen']=='' or $reg['MonedaOrigen']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select>";
	
	echo"<label for='ValorVenta'>Valor:</label>";
	echo"<input id='ValorVenta' class='input' name='ValorVenta' type='text' size='18' style='text-align: center; font-size:1.7em' value='".$reg['ValorVenta']."'>";
	
	if(!$resultTI = mysqli_query($conexion_sp, "select * from z_ivas")) die("Problemas con la consulta z_ivas");
	echo"<label for='IVA'>IVA:</label>";
	echo"<select id='IVA' class='input' name='IVA' style='font-size:1.7em'>";
	while ($rowTI = mysqli_fetch_array($resultTI)){ 
		if ($reg['IVA']==$rowTI['IdRegistro']){
			echo"<option selected value=".$rowTI['IdRegistro'].">".$rowTI['IVA']."</option>";
			}else{
				echo"<option value=".$rowTI['IdRegistro'].">".$rowTI['IVA']."</option>";
			}	
	}
	if ($reg['IVA']=='' or $reg['IVA']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	
	echo"<label for='descricpcion'>Descripción:</label>";
	echo"<textarea id='descricpcion' class='input' name='descricpcion' rows='2' cols='94'>".$reg['descricpcion']."</textarea> <br />";
	
	echo"<label for='OfrecerAdemas'>Ofrecer además:</label>";
	echo"<input id='OfrecerAdemas' class='input' name='OfrecerAdemas' type='text' size='92' value='".$reg['OfrecerAdemas']."'><br />";
	
	echo"<label for='NotasArt'>Notas Internas:</label>";
	echo"<textarea id='NotasArt' class='input' name='NotasArt' rows='6' cols='94' style='background-color:#fadbd8;' >".$reg['Notas']."</textarea> <br />";
	
	echo"<label for='ComposicionyDescirpcion'>Composición y Descripción:</label>";
	echo"<textarea id='ComposicionyDescirpcion' class='input' name='ComposicionyDescirpcion' rows='6' cols='80'>".$reg['ComposicionyDescirpcion']."</textarea> <br />";
	
	if(!$resultCP = mysqli_query($conexion_sp, "select min(contactos2.idContacto) as mindeidContacto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id group by organizaciones.Organizacion")) die("Problemas con la consulta contactos2 Organizacion"); 
	echo"<label for='IdProveedor'>Proveedor:</label>";
	echo"<select id='IdProveedor' class='input' name='IdProveedor'>";
	while ($rowCP = mysqli_fetch_array($resultCP)){
		if ($reg['IdProveedor']==$rowCP['Organizacion']){
			echo"<option selected value=".$rowCP['mindeidContacto'].">".substr($rowCP['Organizacion'],0,23)."</option>";
			}else{
				echo"<option value=".$rowCP['mindeidContacto'].">".substr($rowCP['Organizacion'],0,23)."</option>";
			}	
	}
	if ($reg['IdProveedor']=='' or $reg['IdProveedor']=='0'){
		echo"<option selected value='0'></option>";
	}
    echo"</select>";
	
	echo"<label for='CodigoProveedor'>Codigo del proveedor:</label>";
	echo"<input id='CodigoProveedor' class='input' name='CodigoProveedor' type='text' size='34' value='".$reg['CodigoProveedor']."'><br />";
	
	if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=0 order by Rubro")) die("Problemas con la consulta z_rubros");
	echo"<label for='IdRubro'>Rubro:</label>";
	echo"<select id='IdRubro' class='input' name='IdRubro'>";
		echo"<option selected value=''></option>";
	while ($rowRub = mysqli_fetch_array($resultRub)){ 
		if ($reg['IdRubro']==$rowRub['IdRubro']){
			echo"<option selected value=".$rowRub['IdRubro'].">".substr($rowRub['Rubro'],0,36)."</option>";
			}else{
				echo"<option value=".$rowRub['IdRubro'].">".substr($rowRub['Rubro'],0,36)."</option>";
			}	
	}
    echo"</select>";
	
		if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=1 order by Rubro")) die("Problemas con la consulta z_rubros sub rubros");
	echo"<label for='IdSubRubro'>SubRubro:</label>";
	echo"<select id='IdSubRubro' class='input' name='IdSubRubro'>";
	echo"<option selected value=''></option>";
	while ($rowRub = mysqli_fetch_array($resultRub)){ 
		if ($reg['IdSubRubro']==$rowRub['IdRubro']){
			echo"<option selected value=".$rowRub['IdRubro'].">".substr($rowRub['Rubro'],0,36)."</option>";
			}else{
				echo"<option value=".$rowRub['IdRubro'].">".substr($rowRub['Rubro'],0,36)."</option>";
			}	
	}
    echo"</select><br />";
	
	echo"<label for='StockMinimo'>Stock Minimo:</label>";
	echo"<input id='StockMinimo' class='input' name='StockMinimo' type='text' size='4' style='text-align:center;' value='".$reg['StockMinimo']."'>";
	
	//Una nueva. Colores por stock. PERO SOLO SI SON TANGIBLES!
		$colorFondo='#abf1ab';
		if ($reg['EnStock']<=$reg['StockMinimo']) {$colorFondo='yellow';}	
		if ($reg['EnStock']<1) {$colorFondo='#FA5858';}
		if ($reg['tangible']<1) {$colorFondo='white';}	
		
	echo"<label for='EnStock'>En Stock:</label>";
	echo"<input id='EnStock' class='input' name='EnStock' type='text' size='4' style='text-align:center; background-color:".$colorFondo.";' value='".$reg['EnStock']."' readonly>";
		
	echo"<label for='UnidadMedida'>Unidad Medida:</label>";
	echo"<input id='UnidadMedida' class='input' name='UnidadMedida' type='text' size='6' style='text-align:center;' value='".$reg['UnidadMedida']."'>";
		
	echo"<label for='tangible'>Tangible: </label>";
	if ($reg['tangible']==0){
	echo "<input name='tangible' id='tangible' type='checkbox'></input>";
	} else {
		echo "<input name='tangible' id='tangible' type='checkbox' checked></input>";
	}
	//Nueva Junio 2018. Ubicacion
	echo"<br />";
	if(!$resultUbicacion = mysqli_query($conexion_sp, "select Deposito,Estanteria,Estante from Stock where Producto='".$reg['IdProducto']."' limit 1")) die("Problemas con la consulta Stock Ubicacion 167");
	$rowUbic = mysqli_fetch_array($resultUbicacion);
	echo"<label for='numDeposito'>Deposito:</label>";
	echo"<input id='numDeposito' class='input' name='numDeposito' type='text' size='17' value='".$rowUbic['Deposito']."'>";
	echo"<label for='Estanteria'>Módulo:</label>";
	echo"<input id='Estanteria' class='input' name='Estanteria' type='text' size='17' value='".$rowUbic['Estanteria']."'>";
	echo"<label for='Estante'>Estante:</label>";
	echo"<input id='Estante' class='input' name='Estante' type='text' size='17' value='".$rowUbic['Estante']."'>";
	echo"<br />";
	echo"<label for='HojaFabricante'>HojaFabricante:</label>";
	echo"<input id='HojaFabricante' class='input' name='HojaFabricante' type='text' size='50' value='".$reg['HojaFabricante']."'>";
	if (strlen($reg['HojaFabricante'])>0) {echo"<input type='button' id='verHT' value='Ver...'/>";} else {echo"<input type='button' id='verHT' value='Ver...' disabled/>";}
	echo"<input type='button' id='buscarHT' value='Buscar...'/>";
	echo"<br />";	
	echo"<label for='Imagen'>Imagen:</label>";
	echo"<input id='Imagen' class='input' name='Imagen' type='text' size='50' value='".$reg['Imagen']."'>";
	if (strlen($reg['Imagen'])>0) {echo"<input type='button' id='verImagen' value='Ver...'/>";} else {echo"<input type='button' id='verImagen' value='Ver...' disabled/>";}
	echo"<input type='button' id='buscarHT' value='Buscar...'/>";

	/*echo"<br />";
	echo"<br />";
	echo"<br />";*/
	
	echo"<label for='CodigoInterno' style='visibility:hidden'>CodigoInterno:</label>";
	echo"<input id='CodigoInterno' class='input' name='CodigoInterno' type='text' size='40' value='".$reg['CodigoInterno']."'  style='visibility:hidden'>";	
	
	echo"<label for='Numerodeserie'  style='visibility:hidden'>Numerodeserie:</label>";
	echo"<input id='Numerodeserie' class='input' name='Numerodeserie' type='text' size='40' value='".$reg['Numerodeserie']."'  style='visibility:hidden'>";	
	
	echo"<label  style='visibility:hidden' for='IdCostoProveedor'>IdCostoProveedor:</label>";
	echo"<input  style='visibility:hidden' id='IdCostoProveedor' class='input' name='IdCostoProveedor' type='text' size='26' value='".$reg['IdCostoProveedor']."'>";	
	
	echo"<label  style='visibility:hidden' for='IdImagen'>IdImagen:</label>";
	echo"<input  style='visibility:hidden' id='IdImagen' class='input' name='IdImagen' type='text' size='40' value='".$reg['IdImagen']."'>";
	
	echo"<label  style='visibility:hidden' for='HojaOtra'>HojaOtra:</label>";
	echo"<input  style='visibility:hidden' id='HojaOtra' class='input' name='HojaOtra' type='text' size='40' value='".$reg['HojaOtra']."'>";
	
	echo"<label  style='visibility:hidden' for='UsuarioCreacion'>UsuarioCreacion:</label>";
	echo"<input  style='visibility:hidden' id='UsuarioCreacion' class='input' name='UsuarioCreacion' type='text' size='17' value='".$reg['UsuarioCreacion']."'>";
	
	echo"<label  style='visibility:hidden' for='UsuarioModificacion'>UsuarioModificacion:</label>";
	echo"<input  style='visibility:hidden' id='UsuarioModificacion' class='input' name='UsuarioModificacion' type='text' size='14' value='".$reg['UsuarioModificacion']."'>";
		
	echo"<label  style='visibility:hidden' for='UsuarioFC'>UsuarioFC:</label>";
	echo"<input  style='visibility:hidden' id='UsuarioFC' class='input' name='UsuarioFC' type='text' size='28' value='".$reg['UsuarioFC']."'>";		
	
	echo"<label  style='visibility:hidden' for='UsuarioFM'>UsuarioFM:</label>";
	echo"<input  style='visibility:hidden' id='UsuarioFM' class='input' name='UsuarioFM' type='text' size='40' value='".$reg['UsuarioFM']."'>";


	echo"<label  style='visibility:hidden' for='FechaActualizacion'>FechaActualizacion:</label>";
	echo"<input style='visibility:hidden' id='FechaActualizacion' class='input' name='FechaActualizacion' type='text' size='40' value='".$reg['FechaActualizacion']."'>";	
	//echo"<br />";	


}


function imprimir_movimientos_articulos($resultc, $conexion_sp) {
	//$reg = mysqli_fetch_array($resultc); 
	echo "<table class='display' width='650' style='table-layout:fixed'>"; 
	echo "<caption>Resultados encontrados: ".mysqli_num_rows($resultc)."</caption>";

	echo "<tr>";  
	echo "<th width='80'>Comprobante</th>";  
	echo "<th width='50'>Número</th>";  
	echo "<th  width='60'>Fecha</th>";  
	echo "<th  width='180'>Empresa</th>"; 
	echo "<th  width='50'>Cant</th>"; 
	echo "<th  width='50'>Moneda</th>"; 
	echo "<th  width='50'>Precio</th>"; 
	echo "<th  width='50'>SubTotal</th>"; 
	echo "<th  width='50'>Cumpl.</th>"; 
	echo "</tr>";  
	while ($row = mysqli_fetch_array($resultc)){   
		echo "<tr>";  
		if(!$resultCompro = mysqli_query($conexion_sp, "select TipoComprobante,FechaComprobante,NonmbreEmpresa,NumeroComprobante from comprobantes where IdComprobante='".$row['IdComprobante']."'")) die("Problemas con la consulta comprobantes"); 
		$regCompro = mysqli_fetch_array($resultCompro);
		if(!$resultTP = mysqli_query($conexion_sp, "select TipoComprobante from z_tipocomprobante where IdTipoComprobante='".$regCompro['TipoComprobante']."'")) die("Problemas con la consulta z_tipocomprobante"); 
		$regTP = mysqli_fetch_array($resultTP);
		if(!$resultEmp = mysqli_query($conexion_sp, "select organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id where contactos2.IdContacto='".$regCompro['NonmbreEmpresa']."'")) die("Problemas con la consulta contactos2"); 
		$regEmp = mysqli_fetch_array($resultEmp);
		if(!$resultMon = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$row['Moneda']."'")) die("Problemas con la consulta monedaorigen"); 
		$regMon = mysqli_fetch_array($resultMon);
		//el id de los td tiene que ser el id de comprobante asi busco por ese numero en ambas tablas (comprobantes y detalle)
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$regTP['TipoComprobante']."</td>";   
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$regCompro['NumeroComprobante']."</td>";
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$regCompro['FechaComprobante']."</td>"; 
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$regEmp['Organizacion']."</td>";  
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$row['Cantidad']."</td>"; 
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$regMon['Simbolo']."</td>";		 
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$row['CostoUnitario']."</td>"; 
		echo "<td name='xxxx' id=".$row['IdComprobante'].">".$row['SubTotal']."</td>"; 
		if ($row['Cumplido']=='0')
			{
				echo "<td name='xxxx' id=".$row['IdComprobante']."><input type='checkbox' / disabled></td>"; 
			}
			else
			{
				echo "<td name='xxxx' id=".$row['IdComprobante']."><input type='checkbox' checked disabled></td>"; 
			}
		echo "</tr>";  
	};
	
	echo "</table>";

}
	


function imprimir_detalle_articulos_deshabilitado($resultc, $conexion_sp) {
	$reg = mysqli_fetch_array($resultc);  
	echo"<label for='IdProducto'>Id del Producto:</label>";
	echo"<input id='IdProducto' class='input' name='IdProducto' type='text' size='6' value=".$reg['IdProducto']." disabled>";

	echo"<label for='actualiz'>Fecha de actualización:</label>";
	echo"<input id='actualiz' class='input' name='actualiz' type='text' size='33' value='".$reg['actualiz']."' disabled>";	
	
	if(!$resultTP = mysqli_query($conexion_sp, "select * from z_tipoproducto")) die("Problemas con la consulta z_tipoproducto");
	echo"<label for='TipoProducto'>Tipo:</label>";
	echo"<select id='TipoProducto' class='input' name='TipoProducto' disabled>";
	while ($row = mysqli_fetch_row($resultTP)){ 
		if ($reg['TipoProducto']==$row[0]){
			echo"<option selected value=".$row[0].">".$row[1]."</option>";
			}else{
				echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
	}
	if ($reg['TipoProducto']=='' or $reg['TipoProducto']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	
	if(!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen")) die("Problemas con la consulta monedaorigen");
	echo"<label for='MonedaOrigen'>Moneda:</label>";
	echo"<select id='MonedaOrigen' class='input' name='MonedaOrigen' style='font-size:1.7em' disabled>";
	while ($row = mysqli_fetch_array($resultTM)){ 
		if ($reg['MonedaOrigen']==$row['IdRegistroCambio']){
			echo"<option selected value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}else{
				echo"<option value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}	
	}
	if ($reg['MonedaOrigen']=='' or $reg['MonedaOrigen']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select>";
	
	echo"<label for='ValorVenta'>Valor:</label>";
	echo"<input id='ValorVenta' class='input' name='ValorVenta' type='text' size='18' style='text-align: center; font-size:1.7em' value='".$reg['ValorVenta']."' disabled>";
	
	if(!$resultTI = mysqli_query($conexion_sp, "select * from z_ivas")) die("Problemas con la consulta z_ivas");
	echo"<label for='IVA'>IVA:</label>";
	echo"<select id='IVA' class='input' name='IVA' style='font-size:1.7em' disabled>";
	while ($row = mysqli_fetch_row($resultTI)){ 
		if ($reg['IVA']==$row[0]){
			echo"<option selected value=".$row[0].">".$row[1]."</option>";
			}else{
				echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
	}
	if ($reg['IVA']=='' or $reg['IVA']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	
	echo"<label for='descricpcion'>Descripción:</label>";
	echo"<textarea id='descricpcion' class='input' name='descricpcion' rows='2' cols='94' disabled>".$reg['descricpcion']."</textarea> <br />";
	
	echo"<label for='OfrecerAdemas'>Ofrecer además:</label>";
	echo"<input id='OfrecerAdemas' class='input' name='OfrecerAdemas' type='text' size='92' value='".$reg['OfrecerAdemas']."' disabled><br />";
	
	echo"<label for='NotasArt'>Notas Internas:</label>";
	echo"<textarea id='NotasArt' class='input' name='NotasArt' rows='6' cols='94' disabled>".$reg['Notas']."</textarea> <br />";
	
	echo"<label for='ComposicionyDescirpcion'>Composición y Descripción:</label>";
	echo"<textarea id='ComposicionyDescirpcion' class='input' name='ComposicionyDescirpcion' rows='6' cols='80' disabled>".$reg['ComposicionyDescirpcion']."</textarea> <br />";
	
	if(!$resultCP = mysqli_query($conexion_sp, "select min(contactos2.idContacto) as mindeidContacto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id group by organizaciones.Organizacion")) die("Problemas con la consulta contactos2 Organizacion"); 
	echo"<label for='IdProveedor'>Proveedor:</label>";
	echo"<select id='IdProveedor' class='input' name='IdProveedor' disabled>";
	while ($row = mysqli_fetch_row($resultCP)){
		if ($reg['IdProveedor']==$row[1]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,23)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,23)."</option>";
			}	
	}
	if ($reg['IdProveedor']=='' or $reg['IdProveedor']=='0'){
		echo"<option selected value='0'></option>";
	}
    echo"</select>";
	
	echo"<label for='CodigoProveedor'>Codigo del proveedor:</label>";
	echo"<input id='CodigoProveedor' class='input' name='CodigoProveedor' type='text' size='34' value='".$reg['CodigoProveedor']."' disabled><br />";
	
	if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=0 order by Rubro")) die("Problemas con la consulta z_rubros");
	echo"<label for='IdRubro'>Rubro:</label>";
	echo"<select id='IdRubro' class='input' name='IdRubro' disabled>";
		echo"<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)){ 
		if ($reg['IdRubro']==$row[0]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,36)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,36)."</option>";
			}	
	}
    echo"</select>";
	
		if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=1 order by Rubro")) die("Problemas con la consulta z_rubros sub rubros");
	echo"<label for='IdSubRubro'>SubRubro:</label>";
	echo"<select id='IdSubRubro' class='input' name='IdSubRubro' disabled>";
	echo"<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)){ 
		if ($reg['IdSubRubro']==$row[0]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,36)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,36)."</option>";
			}	
	}
    echo"</select><br />";
	
	echo"<label for='StockMinimo'>Stock Minimo:</label>";
	echo"<input id='StockMinimo' class='input' name='StockMinimo' type='text' size='4' value='".$reg['StockMinimo']."' disabled>";
	
	echo"<label for='EnStock'>En Stock:</label>";
	echo"<input id='EnStock' class='input' name='EnStock' type='text' size='4' value='".$reg['EnStock']."' disabled='disabled'>";
		
	echo"<label for='UnidadMedida'>Unidad Medida:</label>";
	echo"<input id='UnidadMedida' class='input' name='UnidadMedida' type='text' size='6' value='".$reg['UnidadMedida']."' disabled>";
	
	echo"<label for='tangible'>Tangible: </label>";
	if ($reg['tangible']==0){
	echo "<input name='tangible' id='tangible' type='checkbox'></input>";
	} else {
		echo "<input name='tangible' id='tangible' type='checkbox' checked></input>";
	}
	
	echo"<br />";
	echo"<br />";
	echo"<br />";
	echo"<br />";
	
	echo"<label for='CodigoInterno'>CodigoInterno:</label>";
	echo"<input id='CodigoInterno' class='input' name='CodigoInterno' type='text' size='40' value='".$reg['CodigoInterno']."' disabled><br />";	
	
	echo"<label for='Numerodeserie'>Numerodeserie:</label>";
	echo"<input id='Numerodeserie' class='input' name='Numerodeserie' type='text' size='40' value='".$reg['Numerodeserie']."' disabled><br />";	
	
	echo"<label for='IdCostoProveedor'>IdCostoProveedor:</label>";
	echo"<input id='IdCostoProveedor' class='input' name='IdCostoProveedor' type='text' size='26' value='".$reg['IdCostoProveedor']."' disabled><br />";	
	
	echo"<label for='IdImagen'>IdImagen:</label>";
	echo"<input id='IdImagen' class='input' name='IdImagen' type='text' size='40' value='".$reg['IdImagen']."' disabled><br />";
	
	echo"<label for='HojaFabricante'>HojaFabricante:</label>";
	echo"<input id='HojaFabricante' class='input' name='HojaFabricante' type='text' size='40' value='".$reg['HojaFabricante']."' disabled><br />";
	
	echo"<label for='HojaOtra'>HojaOtra:</label>";
	echo"<input id='HojaOtra' class='input' name='HojaOtra' type='text' size='40' value='".$reg['HojaOtra']."' disabled><br />";
	
	echo"<label for='UsuarioCreacion'>UsuarioCreacion:</label>";
	echo"<input id='UsuarioCreacion' class='input' name='UsuarioCreacion' type='text' size='17' value='".$reg['UsuarioCreacion']."' disabled><br />";
	
	echo"<label for='UsuarioModificacion'>UsuarioModificacion:</label>";
	echo"<input id='UsuarioModificacion' class='input' name='UsuarioModificacion' type='text' size='14' value='".$reg['UsuarioModificacion']."' disabled><br />";
		
	echo"<label for='UsuarioFC'>UsuarioFC:</label>";
	echo"<input id='UsuarioFC' class='input' name='UsuarioFC' type='text' size='28' value='".$reg['UsuarioFC']."' disabled><br />";		
	
	echo"<label for='UsuarioFM'>UsuarioFM:</label>";
	echo"<input id='UsuarioFM' class='input' name='UsuarioFM' type='text' size='40' value='".$reg['UsuarioFM']."' disabled><br />";
	
	echo"<label for='Imagen'>Imagen:</label>";
	echo"<input id='Imagen' class='input' name='Imagen' type='text' size='97' value='".$reg['Imagen']."' disabled><br />";

	echo"<label for='FechaActualizacion'>FechaActualizacion:</label>";
	echo"<input id='FechaActualizacion' class='input' name='FechaActualizacion' type='text' size='40' value='".$reg['FechaActualizacion']."' disabled>";	
	echo"<br />";	
}


function imprimir_detalle_articulos_ajustado_stock($resultc, $conexion_sp) {
	$reg = mysqli_fetch_array($resultc);  
	echo"<label for='IdProducto'>Id del Producto:</label>";
	echo"<input id='IdProducto' class='input' name='IdProducto' type='text' size='6' value=".$reg['IdProducto']." disabled>";

	echo"<label for='actualiz'>Fecha de actualización:</label>";
	echo"<input id='actualiz' class='input' name='actualiz' type='text' size='33' value='".$reg['actualiz']."' disabled><br />";	
	
	if(!$resultTM = mysqli_query($conexion_sp, "select * from monedaorigen")) die("Problemas con la consulta monedaorigen");
	echo"<label for='MonedaOrigen'>Moneda:</label>";
	echo"<select id='MonedaOrigen' class='input' name='MonedaOrigen' style='font-size:1.7em' disabled>";
	while ($row = mysqli_fetch_array($resultTM)){ 
		if ($reg['MonedaOrigen']==$row['IdRegistroCambio']){
			echo"<option selected value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}else{
				echo"<option value=".$row['IdRegistroCambio'].">".$row['Origen']."</option>";
			}	
	}
	if ($reg['MonedaOrigen']=='' or $reg['MonedaOrigen']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select>";
	
	echo"<label for='ValorVenta'>Valor:</label>";
	echo"<input id='ValorVenta' class='input' name='ValorVenta' type='text' size='18' style='text-align: center; font-size:1.7em' value='".$reg['ValorVenta']."' disabled><br />";
	
	echo"<label for='descricpcion'>Descripción:</label>";
	echo"<textarea id='descricpcion' class='input' name='descricpcion' rows='2' cols='81' disabled>".$reg['descricpcion']."</textarea> <br />";
	
	if(!$resultCP = mysqli_query($conexion_sp, "select min(contactos2.idContacto) as mindeidContacto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id group by organizaciones.Organizacion")) die("Problemas con la consulta contactos2 Organizacion"); 
	echo"<label for='IdProveedor'>Proveedor:</label>";
	echo"<select id='IdProveedor' class='input' name='IdProveedor' disabled>";
	while ($row = mysqli_fetch_row($resultCP)){
		if ($reg['IdProveedor']==$row[1]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,23)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,23)."</option>";
			}	
	}
	if ($reg['IdProveedor']=='' or $reg['IdProveedor']=='0'){
		echo"<option selected value='0'></option>";
	}
    echo"</select>";
	
	echo"<label for='CodigoProveedor'>Codigo del proveedor:</label>";
	echo"<input id='CodigoProveedor' class='input' name='CodigoProveedor' type='text' size='34' value='".$reg['CodigoProveedor']."' disabled><br />";
	
	if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=0 order by Rubro")) die("Problemas con la consulta z_rubros");
	echo"<label for='IdRubro'>Rubro:</label>";
	echo"<select id='IdRubro' class='input' name='IdRubro' disabled>";
		echo"<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)){ 
		if ($reg['IdRubro']==$row[0]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,36)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,36)."</option>";
			}	
	}
    echo"</select>";
	
		if(!$resultRub = mysqli_query($conexion_sp, "select IdRubro,Rubro from z_rubros where Nivel=1 order by Rubro")) die("Problemas con la consulta z_rubros sub rubros");
	echo"<label for='IdSubRubro'>SubRubro:</label>";
	echo"<select id='IdSubRubro' class='input' name='IdSubRubro' disabled>";
	echo"<option selected value=''></option>";
	while ($row = mysqli_fetch_row($resultRub)){ 
		if ($reg['IdSubRubro']==$row[0]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,36)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,36)."</option>";
			}	
	}
    echo"</select><br />";
	
	echo"<label for='StockMinimo'>Stock Minimo:</label>";
	echo"<input id='StockMinimo' class='input' name='StockMinimo' type='text' size='4' style='text-align:center;' value='".$reg['StockMinimo']."' disabled>";
	
	//Una nueva. Colores por stock. PERO SOLO SI SON TANGIBLES!
		$colorFondo='#abf1ab';
		if ($reg['EnStock']<=$reg['StockMinimo']) {$colorFondo='yellow';}	
		if ($reg['EnStock']<1) {$colorFondo='#FA5858';}
		if ($reg['tangible']<1) {$colorFondo='white';}	
		
	echo"<label for='EnStock'>En Stock:</label>";
	echo"<input id='EnStock' class='input' name='EnStock' type='text' size='4' style='text-align:center; background-color:".$colorFondo.";' value='".$reg['EnStock']."' readonly>";
		
	echo"<label for='UnidadMedida'>Unidad Medida:</label>";
	echo"<input id='UnidadMedida' class='input' name='UnidadMedida' type='text' size='6' style='text-align:center;' value='".$reg['UnidadMedida']."' disabled>";
		
	echo"<label for='tangible'>Tangible: </label>";
	if ($reg['tangible']==0){
	echo "<input name='tangible' id='tangible' type='checkbox' disabled></input>";
	} else {
		echo "<input name='tangible' id='tangible' type='checkbox' checked disabled></input>";
	}
	//Nueva Junio 2018. Ubicacion
	echo"<br />";
	if(!$resultUbicacion = mysqli_query($conexion_sp, "select Deposito,Estanteria,Estante from Stock where Producto='".$reg['IdProducto']."' limit 1")) die("Problemas con la consulta Stock Ubicacion 571");
	$rowUbic = mysqli_fetch_array($resultUbicacion);
	echo"<label for='numDeposito'>Deposito:</label>";
	echo"<input id='numDeposito' class='input' name='numDeposito' type='text' size='17' value='".$rowUbic['Deposito']."' disabled>";
	echo"<label for='Estanteria'>Módulo:</label>";
	echo"<input id='Estanteria' class='input' name='Estanteria' type='text' size='17' value='".$rowUbic['Estanteria']."' disabled>";
	echo"<label for='Estante'>Estante:</label>";
	echo"<input id='Estante' class='input' name='Estante' type='text' size='17' value='".$rowUbic['Estante']."' disabled>";

}