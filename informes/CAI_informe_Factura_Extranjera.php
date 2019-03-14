<?php
//============================================================+
	   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	//generamos la consulta para el encabezado
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, NumeroComprobante01, PlazoEntrega, Confecciono, MantiniemtoOferta, Transporte, Solicito, NumeroComprobante02 from comprobantes where TipoComprobante=3 and IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
		$reg = mysqli_fetch_array($resultComprobante);
		
		//Agosto 2018. Cambio los textos de forma de pago en tabla comprobantes a codigos numericos (id)
		//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
		//Padre 17 es la forma de pago. No lo puedo cambiar
		if(!$resultFormaPago = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$reg['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
		$regFormaPago = mysqli_fetch_array($resultFormaPago);
		$tmpFormaPago = explode(',', $regFormaPago['ContenidoValor']);	
	
		//Agrego un intermedio con el cambio de la tabla contactos a contactos2
		if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regContEmp = mysqli_fetch_array($resultContEmp);		
	
		if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion, CUIT, CondicionIVA from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
		$regEmp = mysqli_fetch_array($resultEmp);
														
		if(!$resultEmpDir = mysqli_query($conexion_sp, "select id, Direccion, Ciudad, Codigopostal, Provoestado, Pais from direcciones where CUIT='".$regContEmp['idOrganizacion']."' and Direccion not Like '%@%' and ((Direccion is not null) and (Ciudad is not null) and (Codigopostal is not null) and (Provoestado is not null) and (Pais is not null)) order by id asc limit 1")) die("Problemas con la consulta2");
		$regEmpDir = mysqli_fetch_array($resultEmpDir);		
		
		if(!$resultEmpTel = mysqli_query($conexion_sp, "select Telefono from telefonos where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regEmpTel = mysqli_fetch_array($resultEmpTel);	
	
	//generamos la consulta para el detalle	
		
		if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."' order by Orden")) die("Problemas con la consulta2");
		
	//generamos la consulta para los datos de CAEAFIP (Tiene que ser order id desc)
	//	if(!$resultAfip = mysqli_query($conexion_sp, "select NumeroFactura, VtoCAE from caeafip where CAE='".$_REQUEST['numCAE']."' limit 1")) die("Problemas con la consulta2");
	//	$regresultAfip = mysqli_fetch_array($resultAfip);	
	
	//generamos la consulta para la moneda ORIGINAL de toda la factura		
	if(!$monedaGeneral = mysqli_query($conexion_sp, "select Simbolo, Origen from monedaorigen where IdRegistroCambio='".$_REQUEST['monedaOriginal']."' limit 1")) die("Problemas con la consulta2");
	$rowmonedaGeneral = mysqli_fetch_array($monedaGeneral);	
	
//============================================================+

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public $miCuit;
	public $miIIBBCM;
	public $miFechaInicioAct;
	public $tipoComprobante;
	public $codTipoComprobante;
	public $miPuntoVenta;
	public $numeroComprobante;
	public $decrTipoComprobante;
	public $CAE;
	public $vtoCAE;
	public $totalFactura;
	public $subTotalFactura;
	public $totalIVAFactura;
	public $ivaFactura;
	public function Header() {
//============================================================+
//TEXTOS DEL HEADER
		
		$this->SetY(44);
		$this->SetX(159);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(1, 1, date('d').'/'.date('m').'/'.date('Y'), 0, false, 'L', 0, '', 0, false, 'M', 'M');

//============================================================+
		
//============================================================+
	}

	// Page footer
	public function Footer() {

		$this->SetY(-25);
		$this->SetX(19);
		$this->SetFont('helvetica', '', 11);
		$txt=$this->subTotalFactura;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-25);
		$this->SetX(139);
		$this->SetFont('helvetica', '', 11);
		$txt=$this->totalIVAFactura;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-32);
		$this->SetX(147);
		$this->SetFont('helvetica', '', 7);
		$txt=$this->ivaFactura;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-25);
		$this->SetX(172);
		$this->SetFont('helvetica', 'B', 12);
		$txt=$this->totalFactura;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
//============================================================+

//============================================================+
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');

$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//variables para header y footer
if ($_REQUEST['tipoFactura']=="A"){
	if ($_REQUEST['tipoComprobante']=="FC"){$codTipoComprobante=1;}
		else {if($_REQUEST['tipoComprobante']=="NC"){$codTipoComprobante=3;}
else {$codTipoComprobante=2;}}}
if ($_REQUEST['tipoFactura']=="B"){
	if ($_REQUEST['tipoComprobante']=="FC"){$codTipoComprobante=6;}
		else {if($_REQUEST['tipoComprobante']=="NC"){$codTipoComprobante=8;}
else {$codTipoComprobante=7;}}}

//BUSCO miCuit EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miCuit' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->miCuit = $rowresultDatosAux['ContenidoValor'];
//BUSCO miIIBBCM EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miIIBBCM' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
$pdf->miIIBBCM = $rowresultDatosAux['ContenidoValor'];
//BUSCO miInicioActividad EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miInicioActividad' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
$pdf->miFechaInicioAct = $rowresultDatosAux['ContenidoValor'];
$pdf->tipoComprobante=$_REQUEST['tipoFactura'];
$txtComprob = array("FACTURA","N. DEBITO","N. CREDITO","RECIBO A","NOTA DE VENTA AL CONTADO A","FACTURA","N. DEBITO","N. CREDITO");
$pdf->decrTipoComprobante=$txtComprob[$codTipoComprobante-1];
$descripTipoComprobante=$txtComprob[$codTipoComprobante-1];
$pdf->codTipoComprobante=str_pad($codTipoComprobante, 2,"0", STR_PAD_LEFT);
//BUSCO miPuntoVenta EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
$pdf->miPuntoVenta = str_pad($rowresultDatosAux['ContenidoValor'], 4,"0", STR_PAD_LEFT);
$auxPV=(string)str_pad($rowresultDatosAux['ContenidoValor'], 4,"0", STR_PAD_LEFT);
//$pdf->numeroComprobante=str_pad($regresultAfip['NumeroFactura'], 8,"0", STR_PAD_LEFT);
//$auxNF=(string)str_pad($regresultAfip['NumeroFactura'], 8,"0", STR_PAD_LEFT);
//$pdf->CAE=$_REQUEST['numCAE'];
//$pdf->vtoCAE=str_replace("-","", $regresultAfip['VtoCAE']);

$pdf->SetTitle($descripTipoComprobante);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP-2, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 11);

// add a page
$pdf->AddPage('P', 'A4');
//Primero un espacio hacia abajo. $ln=1 para no hacer salto de linea 
$pdf->MultiCell(20, 20, '', 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

//Primero un espacio a la izquierda (para la palabra Senor(es): del preimpreso). $ln=0 para no hacer salto de linea 
$pdf->MultiCell(24, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego el nombre de la empresa. $ln=1 para si hacer salto de linea.
$txt = substr($regEmp['Organizacion'],0,260);
$pdf->MultiCell(190, 10, $txt, 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

//Primero un espacio a la izquierda . $ln=0 para no hacer salto de linea 
$pdf->MultiCell(24, 10, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego la direccion de la empresa. $ln=1 para si hacer salto de linea.
$txt = substr($regEmpDir['Direccion'],0,181)." - ".substr($regEmpDir['Ciudad'],0,50)." - ".substr($regEmpDir['Provoestado'],0,23);
$pdf->MultiCell(190, 10, $txt, 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

//Primero un espacio a la izquierda . $ln=0 para no hacer salto de linea 
$pdf->MultiCell(15, 8, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego el CUIT de la empresa. $$ln=0 para no hacer salto de linea
$txt = $regEmp['CUIT'];
$pdf->MultiCell(90, 8, $txt, 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego la condicion de iva de la empresa. $ln=1 para si hacer salto de linea.
$txt = $regEmp['CondicionIVA'];
$pdf->MultiCell(90, 8, $txt, 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

//Primero un espacio a la izquierda . $ln=0 para no hacer salto de linea 
$pdf->MultiCell(35, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego la condicion de pago. $$ln=0 para no hacer salto de linea
$txt = substr($tmpFormaPago[0],0,30);
$pdf->MultiCell(100, 7, $txt, 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego el numero de remito (alcanza hasta 3). $ln=1 para si hacer salto de linea.
$txt = substr($reg['NumeroComprobante02'],0,27);
$pdf->MultiCell(90, 7, $txt, 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
	$html = '
<table border="0" width="105%"{border-collapse: collapse;}>
	<tr>
		<th align="center" width="14%"></th>
		<th align="left" width="56%"></th>';
		IF ($_REQUEST['tipoFactura']=='A'){
			$html = $html .'
			<th align="right" width="13%"></th>
			<th align="right" width="15%"></th>';}
			else {//$_REQUEST['tipoFactura']=='B'
				$html = $html .'
				<th align="right" width="15%"></th>
				<th align="right" width="18%"></th>';}
	$html = $html .'			
	</tr>
	<hr width="105%">';

//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------

$totalPresup=0;
$IVAdel21=0;
$IVAdel10=0;
$subtotaliva21=0;
$subtotaliva10=0;
while ($rowDetalle = mysqli_fetch_array($resultDetalle)){   
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, MonedaOrigen, ValorVenta, IVA, UnidadMedida, ComposicionyDescirpcion from productos where IdProducto='".$rowDetalle['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$rowProd = mysqli_fetch_array($resultArticulo);
	if(!$monedaArticulo = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowProd['MonedaOrigen']."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaArt = mysqli_fetch_array($monedaArticulo);
	if(!$monedaDetalle = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowDetalle['Moneda']."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaDet = mysqli_fetch_array($monedaDetalle);
	if(!$iva = mysqli_query($conexion_sp, "select Texto, Valor from z_ivas where IdRegistro='".$rowProd['IVA']."' limit 1")) die("Problemas con la consulta2");
	$rowIVA = mysqli_fetch_array($iva);
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Confecciono']."' limit 1")) die("Problemas con la consulta members");
	$rowConfecc = mysqli_fetch_array($confecc);
	if(!$solicit = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Solicito']."' limit 1")) die("Problemas con la consulta members");
	$rowSolicit = mysqli_fetch_array($solicit);
    $html = $html .'
	<tr>
		<td style="font-size:0.95em; font-weight:normal; text-align: center">'.$rowDetalle['Cantidad'].'</td>
		<td style="font-size:0.95em; font-weight:normal">'.$rowProd['descricpcion'].'</td>';
		//MONEDA
		if ((double)$_REQUEST['tipoCambio'] > 1){
			//moneda de origen
			$simboloMoneda=$rowMonedaDet['Simbolo'];
		} else {
			//moneda en Pesos
			$simboloMoneda="$";
		}
		//POR AHORA SOLO PESOS!!
		//Asi que no importa que hice en el IF anterior, a $simboloMoneda le asigno "$"
		//$simboloMoneda="$";
		//IVA
		IF ($_REQUEST['tipoFactura']=='A'){
			// IVA discriminado
			$html = $html .'
				<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['CostoUnitario'],2,',','.').'</td>
				<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['SubTotal'],2,',','.').'</td>
			</tr>';}
			else {//$_REQUEST['tipoFactura']=='B'
				//IVA incluido
				$html = $html .'
						<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['CostoUnitario']*(1+$rowIVA['Valor']),2,',','.').'</td>
						<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['SubTotal']*(1+$rowIVA['Valor']),2,',','.').'</td>
					</tr>';}
	//separo los ivas
	if ($rowProd['IVA']=='1'){
		$subtotaliva21=$subtotaliva21+($rowDetalle['SubTotal']);
		$IVAdel21=$IVAdel21+($rowDetalle['SubTotal']*($rowIVA['Valor']));}
	if ($rowProd['IVA']=='2'){
		$subtotaliva10=$subtotaliva10+($rowDetalle['SubTotal']);
		$IVAdel10=$IVAdel10+($rowDetalle['SubTotal']*($rowIVA['Valor']));}
	
	//DETALLE DEL ARTICULO
	IF ($_REQUEST['descr']=='1'){
	$html = $html .'<tr>
		<td style="font-size:0.95em; font-weight:normal">  </td>
		<td colspan="3" style="font-size:0.66em; font-weight:normal">'.$rowProd['ComposicionyDescirpcion'].'</td>
		<td style="font-size:0.95em; font-weight:normal">  </td>
	</tr>';}
	
	//NUMERO DE SERIE DEL ARTICULO
	//Diciembre 2018. También los números de serie de la tabla
	IF ($_REQUEST['serie']=='1') {
		//Si el cliente no los quiere mostrar ($_REQUEST['serie']=='0') ni me gasto
		//Tengo que buscar todos los numeros de serie de este idDetalleComprobante en la tabla NumerosSerie
		if(!$resultNumerosSerie = mysqli_query($conexion_sp, "select idNumeroSerie,numeroSerie from numerosserie where IdDetalleComprobante='".$rowDetalle['IdDetalleComprobante']."' order by numeroSerie")) die("Problemas con la consulta numerosserie");
		//Si hay números de serie para mostrar sigo, sino no
		if ((mysqli_num_rows($resultNumerosSerie)>0) or ($rowDetalle['NumeroSerie']!=NULL)){
			$html = $html .'<tr>
			<td style="font-size:0.95em; font-weight:normal">  </td>
			<td colspan="3" style="font-size:0.66em; font-weight:normal">Nº de serie: ';
			//Si hay números del método nuevo
			if (mysqli_num_rows($resultNumerosSerie)>0){
				while ($regNumerosSerie = mysqli_fetch_array($resultNumerosSerie)){
					$html = $html.$regNumerosSerie['numeroSerie']. " - ";	
				}
			}
			//Si hay numeros del metodo viejo
			if ($rowDetalle['NumeroSerie']!=NULL){$html = $html.$rowDetalle['NumeroSerie'];}
			$html = $html .'</td>
			<td style="font-size:0.95em; font-weight:normal">  </td>
		</tr>';
		}
	}
	
	$html = $html .'	<hr width="105%">'; 
	//IF ($_REQUEST['tipoFactura']=='A'){
	//	$totalPresup= $totalPresup + $rowDetalle['SubTotal']*$_REQUEST['tipoCambio'];}
	//	else {//$_REQUEST['tipoFactura']=='B'
			$totalPresup= $totalPresup + ($rowDetalle['SubTotal']*(1+$rowIVA['Valor']));
	//}
	

}  
    $html = $html ."</table>";
$pdf->writeHTML($html, true, false, true, false, ''); 
// ---------------------------------------------------------


IF ($_REQUEST['tipoFactura']=='A'){	
	if (($subtotaliva10>0)&&($subtotaliva21<0.01)){
			$pdf->subTotalFactura = $simboloMoneda.' '.number_format($subtotaliva10,2,',','.');
			$pdf->ivaFactura = '10,5';
			$pdf->totalIVAFactura = $simboloMoneda.' '.number_format($IVAdel10,2,',','.');}
	if (($subtotaliva21>0)&&($subtotaliva10<0.01))		{
			$pdf->subTotalFactura = $simboloMoneda.' '.number_format($subtotaliva21,2,',','.');
			$pdf->ivaFactura = '21';
			$pdf->totalIVAFactura = $simboloMoneda.' '.number_format($IVAdel21,2,',','.');}		
	if (($subtotaliva21>0)&&($subtotaliva10>0)){
			$pdf->subTotalFactura = $simboloMoneda.' '.number_format($subtotaliva10+$subtotaliva21,2,',','.');
			$pdf->ivaFactura = '21+10,5';
			$pdf->totalIVAFactura = $simboloMoneda.' '.number_format($IVAdel10+$IVAdel21,2,',','.');}			    
}

	$pdf->totalFactura = $simboloMoneda.' '.number_format($totalPresup,2,',','.');



$datee= date("d-m-Y");
$CbteFch =strtotime($datee."+ ".$tmpFormaPago[1]." days");


$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);

$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="100%" style="font-size:0.85em; text-align: left">Esta factura vence el '.date("d/m/Y",$CbteFch).'. Pasado este lapso se devengará un interés mensual del 5% proporcional al tiempo transcurrido hasta la efectiva acreditación del pago.</td>
	</tr>
	<tr>
		<td width="100%" style="font-size:1.05em; text-align: left">Cheque a la orden de: Bruschi Aldo Ambrosio. Transferencias a Cta. Cte. Banco Galicia Nº 6878-9 129-7. CBU: 00701293-20000006878975.</td>
	</tr>
</table>';
if ((double)$_REQUEST['tipoCambio'] > 1){
$html = $html.'
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="100%" style="font-size:0.85em; text-align: left">NOTA: A efectos contables el tipo de cambio es '.number_format($_REQUEST['tipoCambio'],2,',','.').'.</td>
	</tr>
</table>';}
$html = $html.'
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="100%" style="font-size:0.85em; text-align: left">No se aceptarán reclamos s/esta factura pasados 7 días después de la entrega. Toda mercadería enviada por transporte viaja por cuenta y riesgo del comprador.</td>		
	</tr>
	<tr>
		<td width="100%" style="font-size:0.85em; text-align: left">Esta factura corresponde a una obligación pactada en moneda extranjera, regida por el art. 766 del Código Civil y Comercial de la Nación y cuyo pago resulta exigible en esa moneda. Puede cancelarse en pesos, al tipo de cambio billete vendedor informado en la página Web del Banco de la Nación Argentina al cierre de las operaciones del día hábil anterior a la efectiva acreditación del pago (Cotización de referencia). Si el monto acreditado en la cuenta de Bruschi Aldo Ambrosio no fuese suficiente para cancelar el importe adeudado en moneda extranjera según la cotización de referencia, lo acreditado será considerado como pago a cuenta a todos sus efectos.</td>
	</tr>
	<tr>
		<td width="100%" style="font-size:0.85em; text-align: left">Cláusula de reajuste: De existir saldos pendientes por diferencias de cotización, emitiremos nota de débito o crédito según corresponda.</td>	
	</tr>
	<tr>		
		<td width="100%" style="font-size:0.8em; text-align: left">CF: '.$rowConfecc['Nombre'].' '.$rowConfecc['Apellido'].'/'.$rowSolicit['Nombre'].' '.$rowSolicit['Apellido'].'</td>
	</tr>
</table>';
	
$pdf->writeHTML($html, true, false, true, false, '');

//-------------------
//imagen firma
// Image example with resizing
//$image_file = K_PATH_IMAGES.'Presupuesto/Firma.jpg';
// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
//$pdf->Image($image_file, 15, 140, 30, 18, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);


- - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

// ---------------------------------------------------------
//Change To Avoid the PDF Error
  ob_end_clean();

//BUSCO EL CAMPO DONDE ESTA GUARDA LA RUTA DE LAS FACTURAS
	if(!$resultRutaPresup = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'rutaFacturas' and padre=1 limit 1")){
	die("Problemas con la consulta de ContenidoValor en controlpanel");}
	$rowresultRutaPresup = mysqli_fetch_array($resultRutaPresup);
	
//Close and output PDF document
if (file_exists($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\')== true) {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\('.$_REQUEST['tiponumfac'].')'.$regEmp['Organizacion'].' '.$descripTipoComprobante.' ('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');}
	else {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].'('.$_REQUEST['tiponumfac'].')'.$regEmp['Organizacion'].' '.$descripTipoComprobante.' ('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');
	};


//============================================================+
// END OF FILE
//============================================================+
