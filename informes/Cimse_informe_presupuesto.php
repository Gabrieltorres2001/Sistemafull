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
	//echo"<ul class='nav navbar-nav'>";
	//echo"<li>  Detalle:  </li>";
	//echo"</ul>";
	//echo"<br>";
	//generamos la consulta para el encabezado
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select IdComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, NumeroComprobante01, PlazoEntrega, Confecciono, MantiniemtoOferta, Transporte, Solicito from comprobantes where TipoComprobante=5 and NumeroComprobante='".$_REQUEST['idppto']."' limit 1")) die("Problemas con la consulta1");
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
		
		if(!$resultEmpDir = mysqli_query($conexion_sp, "select Direccion, Ciudad, Provoestado from direcciones where CUIT='".$regContEmp['idOrganizacion']."' and Direccion Not Like '%@%' order by id asc limit 1")) die("Problemas con la consulta2");
		$regEmpDir = mysqli_fetch_array($resultEmpDir);		
		
		if(!$resultEmpTel = mysqli_query($conexion_sp, "select Telefono, Telefonomovil from telefonos where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regEmpTel = mysqli_fetch_array($resultEmpTel);		

		if(!$resultEmpMail = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT='".$reg['NonmbreEmpresa']."' and Direccion Like '%@%' limit 1")) die("Problemas con la consulta2");
		$regEmpMail = mysqli_fetch_array($resultEmpMail);
	
	//generamos la consulta para el detalle	
		
		if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$reg['IdComprobante']."' order by Orden")) die("Problemas con la consulta2");
//============================================================+

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
//============================================================+
//TEXTOS DEL HEADER	
		$this->SetY(12);
		$this->SetX(15);
		$this->SetFont('helvetica', 'B', 9);
		$txt='Centro de Instrumentación, Metrología y Servicios Patagonia S.R.L.';
		//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$this->MultiCell(129, 14, $txt, 0, 'C', 0, 0, '', '', true);

		$this->SetY(16);
		$this->SetX(15);
		$this->SetFont('helvetica', 'B', 9);
		$txt='Lote 8, Manzana “C”, Bº San Cristobal, Valentina Sur-Neuquén';
		$this->MultiCell(129, 14, $txt, 0, 'C', 0, 0, '', '', true);
		
		$this->SetY(20);
		$this->SetX(15);
		$this->SetFont('helvetica', 'B', 9);
		$txt='Cel.: Admin. (299) 156066112; Ger. (299) 155-711354; Lab. (299) 155-179547';
		$this->MultiCell(129, 14, $txt, 0, 'C', 0, 0, '', '', true);
//============================================================+
// LOGOS DEL HEADER		
		$image_file = K_PATH_IMAGES.'Presupuesto/Cimse.png';
		$this->Image($image_file, 167, 5, 28, 28, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//============================================================+
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->SetY(-19);
		$this->Cell(0, 10, 'Lote 8, Manzana “C”, Bº San Cristobal, Valentina Sur-Neuquén- Cel.: Admin. (299) 156066112; Ger. (299) 155-711354; Lab. (299) 155-179547', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->SetY(-15);
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		$this->Cell(0, 10, $dias[date('w')].', '.date("d").' de '.$meses[date('n')-1].' de '.date("Y").' - administracion@cimsesrl.com.ar - Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('COTIZACION');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP-14, PDF_MARGIN_RIGHT);
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

//PRIMERA TABLA, SOLO PARA CIMSE
// set some text for example
$txt = "Cotización Número: ".$reg['NumeroComprobante'];
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(60, 5, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');
$txt = "Fecha: ".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4);
$pdf->MultiCell(40, 5, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
$txt = "Validez: 10 (Diez) Días";
$pdf->MultiCell(53, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$pdf->Ln(5);

//SEGUNDA TABLA, SOLO PARA CIMSE
// set some text for example
$txt = "Empresa: ".substr($regEmp['Organizacion'],0,60);
$pdf->MultiCell(98, 5, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
$txt = "Petición de oferta/Subcliente: ".substr($reg['NumeroComprobante01'],0,25);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(95, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 60, 'T');

$txt = "Domicilio: ".substr($regEmpDir['Direccion'],0,70)." - ".substr($regEmpDir['Ciudad'],0,37);
$pdf->MultiCell(193, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$txt = "Solicitante: ".$reg['ApellidoContacto'];
$pdf->MultiCell(113, 5, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
$txt = "Cel: ".substr($regEmpTel['Telefonomovil'],0,23);
$pdf->MultiCell(80, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 60, 'T');

$txt = "Tel: ".substr($regEmpTel['Telefono'],0,23);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(70, 5, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');

$txt = "Mail: ".substr($regEmpMail['Direccion'],0,37);
$pdf->MultiCell(123, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$pdf->Ln(3);

$pdf->MultiCell(15, 5, 'Notas:', 0, 'J', 0, 0, '', '', true, 0, false, true, 40, 'T');
$txt = $reg['Notas'];
$pdf->MultiCell(178, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');


$pdf->Ln(4);

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

	$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td rowspan="2" colspan="5" style="font-size:1.1em; color: red; text-align: Center">LEER LA COTIZACION HASTA EL FINAL, TODOS LOS ITEMS SON IMPORTANTES.</td>
	</tr>
	</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.9em; text-align: Left">De acuerdo a lo solicitado, le enviamos la cotización por la calibración y certificación con trazabilidad a patrones Nacionales de los siguientes instrumentos: </td>
	</tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

	$html = '
<table border="0" width="105%"{border-collapse: collapse;}>
	<tr>
		<th align="Center" width="5%" border="1"><b>Item</b></th>
		<th align="Center" width="54%" border="1"><b>Descripción</b></th>
		<th align="Center" width="8%" border="1"><b>Cant.</b></th>';
		IF ($_REQUEST['iva']=='1'){
			$html = $html .'
			<th align="Center" width="13%" border="1"><b>Unitario</b></th>
			<th align="Center" width="15%" border="1"><b>SubTotal s/IVA</b></th>
			<th align="Center" width="5%" border="1"><b>IVA</b></th>';}
			else {
				$html = $html .'
				<th align="Center" width="15%" border="1"><b>Unitario</b></th>
				<th align="Center" width="18%" border="1"><b>SubTotal c/IVA</b></th>';}
	$html = $html .'			
	</tr>
	<hr width="105%">';

//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------

$totalPresup=0;
while ($rowDetalle = mysqli_fetch_array($resultDetalle)){   
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, MonedaOrigen, ValorVenta, IVA, UnidadMedida,  	ComposicionyDescirpcion from productos where IdProducto='".$rowDetalle['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$rowProd = mysqli_fetch_array($resultArticulo);
	if(!$monedaArticulo = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowProd['MonedaOrigen']."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaArt = mysqli_fetch_array($monedaArticulo);
	if(!$monedaDetalle = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowDetalle['Moneda']."' limit 1")) die("Problemas con la consulta2");
	$rowMonedaDet = mysqli_fetch_array($monedaDetalle);
	if(!$iva = mysqli_query($conexion_sp, "select Texto, Valor from z_ivas where IdRegistro='".$rowProd['IVA']."' limit 1")) die("Problemas con la consulta2");
	$rowIVA = mysqli_fetch_array($iva);
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Confecciono']."' limit 1")) die("Problemas con la consulta2");
	$rowConfecc = mysqli_fetch_array($confecc);
	if(!$solicit = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Solicito']."' limit 1")) die("Problemas con la consulta2");
	$rowSolicit = mysqli_fetch_array($solicit);
    $html = $html .'
	<tr>
		<td style="font-size:0.95em; font-weight:normal">'.$rowDetalle['Orden'].'</td>
		<td style="font-size:0.95em; font-weight:normal">'.$rowProd['descricpcion'].'</td>
		<td style="font-size:0.95em; font-weight:normal; text-align: center">'.$rowDetalle['Cantidad'].'</td>';
		//MONEDA
		if ($_REQUEST['moneda']=='1'){
			//moneda de origen
			$simboloMoneda=$rowMonedaDet['Simbolo'];
		} else {
			//moneda en Pesos
			$simboloMoneda="$";
		}
		//IVA
		IF ($_REQUEST['iva']=='1'){
			// IVA discriminado
			$html = $html .'
				<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['CostoUnitario']*$_REQUEST['cambioPesosAMoneda'],2,',','.').'</td>
				<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['SubTotal']*$_REQUEST['cambioPesosAMoneda'],2,',','.').'</td>
				<td style="font-size:0.9em; font-weight:normal; text-align: right"><small>+'.$rowIVA['Texto'].'</small></td>
			</tr>';}
			else {
				//IVA incluido
				$html = $html .'
						<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['CostoUnitario']*(1+$rowIVA['Valor'])*$_REQUEST['cambioPesosAMoneda'],2,',','.').'</td>
						<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$simboloMoneda.' '.number_format($rowDetalle['SubTotal']*(1+$rowIVA['Valor'])*$_REQUEST['cambioPesosAMoneda'],2,',','.').'</td>
					</tr>';}
	
	//DETALLE DEL ARTICULO
	IF ($_REQUEST['descr']=='1'){
	$html = $html .'<tr>
		<td style="font-size:0.95em; font-weight:normal">  </td>
		<td colspan="3" style="font-size:0.66em; font-weight:normal">'.$rowProd['ComposicionyDescirpcion'].'</td>
		<td style="font-size:0.95em; font-weight:normal">  </td>
	</tr>';}
	
	//PLAZO ENTREGA DEL ARTICULO
	IF (($_REQUEST['plazo']=='0') and ($rowDetalle['Observaciones']!=NULL)){
	$html = $html .'<tr>
		<td style="font-size:0.95em; font-weight:normal">  </td>
		<td colspan="3" style="font-size:0.66em; font-weight:normal">'.$rowDetalle['Observaciones'].'</td>
		<td style="font-size:0.95em; font-weight:normal">  </td>
	</tr>';}
	
	$html = $html .'	<hr width="105%">'; 
	IF ($_REQUEST['iva']=='1'){
		$totalPresup= $totalPresup + $rowDetalle['SubTotal']*$_REQUEST['cambioPesosAMoneda'];}
		else {
			$totalPresup= $totalPresup + ($rowDetalle['SubTotal']*(1+$rowIVA['Valor'])*$_REQUEST['cambioPesosAMoneda']);}
	

}  
    $html = $html ."</table>";
$pdf->writeHTML($html, true, false, true, false, ''); 
// ---------------------------------------------------------

	
 
	$html ='
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td> </td>';
		IF ($_REQUEST['iva']=='1'){
			$html =$html .'<td style="font-size:1.3em; font-weight:bold; text-align: right" colspan="5">SUBTOTAL s/IVA:</td>';}
				else {
				$html = $html .'
					<td style="font-size:1.3em; font-weight:bold; text-align: right" colspan="5">SUBTOTAL c/IVA:</td>';}
		$html = $html .'
		<td style="font-size:1.3em; font-weight:bold; text-align: center" colspan="2">'.$simboloMoneda.' '.number_format($totalPresup,2,',','.').'</td>
	</tr>
	<hr width="105%">
</table>';

$pdf->writeHTML($html, true, false, true, false, ''); 

//Las condiciones de CIMSe
	$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td rowspan="2" colspan="5" style="font-size:1.1em; text-decoration: underline; text-align: Center; font-weight:bold">CONDICIONES GENERALES</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">A) El rango o puntos a calibrar de cada instrumento debera ser comunicado por el cliente al laboratorio, por medio de una nota escrita o e-mail, de lo contrario las calibraciones seran realizadas según el criterio del laboratorio.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">B) Los equipos e instrumentos deberan estar provistos con sus respectivos manuales de operación para poder realizar los ajustes convenientes en el caso de ser necesario. De no ser asi se emitira un certificado de calibración/verificación informando las desviaciones observadas.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td style="font-size:0.87em; text-align: Left">C) Los equipos e instrumentos deberan estar provistos de sus respectivas pilas o baterias y fusibles, de lo contrario las mismas seran provistas por el laboratorio trasladando el costo correspondiente o serán devueltos en las condiciones recibidos.<h3 style="color: red; font-size:0.87em; text-align: Left"> Se debera tener presente que esto implica una nueva cotización que debera ser aprobada con las consiguientes demoras en el proceso de calibración. </h3></td>
	</tr>	
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">D)La presente cotización sólo es válida si los instrumentos son recibidos  en perfecto estado de funcionamiento y conservación, en caso contrario los mismos podrán ser devueltos sin intervenir o se realizará un diagnóstico de daños que deberá ser abonado indefectiblemente  (lo que prefiera el cliente) y posteriormente éste costo se deducirá del precio de la reparación en caso de ser realizada. Este proceso suspende el plazo de entrega indicado en el prente, el nuevo plazo de entrega se determinará de acuerdo al grado de reparaciones que deban ser realizadas.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">E) El cliente podrá informar al laboratorio la fecha de la proxima calibración/verificación del instrumento/equipo para que la misma sea informada en el respectivo certificado de calibración/verificación.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">F) En lo posible, los instrumentos/equipos deberan ingresar al laboratorio limpios al igual que sus respectivos estuches.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>	
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">G) Cuándo se deban realizar calibraciones en el domicilio del cliente y existan dudas respecto de la localización, disponibilidad, funcionamiento del equipo/instrumento se realizará una visita a planta para evaluar por nuestro personal las condiciones de calibración, ésta visita tendrá un costo que será proporcional a la distancia al domicilio del cliente y una cantidad de horas ponderadas y deberá ser abonada por anticipado o generarse una orden de compra por la misma, independientemente que a posteriori se determine que la calibración no puede ser realizada.</td>
	</tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

if(!$plazoEnt = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion='".$reg['PlazoEntrega']."' and padre='51' limit 1")) die("Problemas con la consulta plazoentrega en controlpanel");

if ($rowPlazoEnt = mysqli_fetch_array($plazoEnt)){$elPlazoEnt=$rowPlazoEnt['ContenidoValor'];}
else {$elPlazoEnt='';}

	$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td rowspan="2" colspan="5" style="font-size:1.1em; text-decoration: underline; text-align: Center; font-weight:bold">CONDICIONES COMERCIALES</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left">PLAZO DE ENTREGA: Los instrumentos serán calibrados y sus certificados estarán disponibles para la entrega en un plazo máximo de '.$elPlazoEnt.'. Los plazos indicados se establecen desde la fecha efectiva de ingreso al laboratorio, entendiéndose como tal al momento en que los instrumentos fueron controlados y se haya verificado que la orden de compra emitida por el cliente se ajusta a la cantidad y requerimientos de reparación, ajuste y/o calibración de los mismos. </td>
	</tr>
</table>
</br></br></br>
<table border="0" {border-collapse: collapse;}>	
	<tr>
	<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">
		   
	</td>
	</tr>
</table>	
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">CONDICION DE PAGO: '.$tmpFormaPago[0].', mediante transferencia bancaria (Cta. Cte. Santander Río Nº:124-20650/7 CBU: 0720124620000002065072), o cheque a la orden de CENTRO DE INSTR. MET. Y S P SRL. Contra la entrega de el/los instrumentos y sus certificados de calibración. </td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
	<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">
		   
	</td>
	</tr>
</table>	
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left;">Los aranceles están expresados en $ (Pesos) y no incluyen el IVA, salvo expresa aclaración. </td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
	<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">
		   
	</td>
	</tr>
</table>	
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left;">La presente cotización contempla gastos de seguros y fletes en un radio de hasta 10 Km de la ciudad de Neuquen, siempre y cuando sea realizada la totalidad de las calibraciones de los instrumentos cotizados en un mismo
despacho.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
	<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">
		   
	</td>
	</tr>
</table>	
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left;">Las calibraciones no contemplan reparaciones. En caso de ser necesario, las mismas serán cotizadas en cotización por separado.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
	<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: Left; font-weight:bold;">
		   
	</td>
	</tr>
</table>	
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: center; font-weight:bold;">Nuestro laboratorio cuenta con un Sistema de la Calidad conforme a los requisitos establecidos en la Norma IRAM 301 equivalente a la Norma ISO/IEC 17025. Las calibraciones son realizadas por profesionales calificados empleando patrones de medida trazables a los patrones nacionales o internacionales de medida y las incertidumbres de medición se determinan de acuerdo a lo establecido en la “Guía para la expresión de incertidumbres de medición” traducción INTI – CeFis del documento “Guide of uncertainty in meassurements” (BIPM, IEC, IFCC, ISO,IUPAC, IUPAP, OIML) 1993. Por lo tanto los certificados de calibración por nosotros emitidos son TRAZABLES a patrones de medida Nacionales y /o Internacionales, reconocidos y con calibración vigente.</td>
	</tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

	$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td rowspan="2" colspan="5" style="font-size:1.1em; text-decoration: underline; text-align: Center; font-weight:bold">IMPORTANTE</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: center; font-weight:bold;">Los instrumentos deberán ser retirados dentro de los treinta días corridos a partir de la comunicación fehaciente que la calibración fue realizada y que los mismos se encuentran disponibles para su retiro, en caso contrario el laboratorio CIMSe PATAGONIA SRL no se responsabiliza por pérdidas y daños que los mismos pudieran sufrir.</td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>	
	<tr>
		<td rowspan="2" colspan="5" style="font-size:0.87em; text-align: LEFT;">Cordialmente:</td>
	</tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');

	$html ='
 <table border="0px" style="font-size:0.8em; text-align: center;"> 
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
				<td><img src="../images/Presupuesto/Eduardo.png" width="100" height="60"></td>
            </tr>
            <tr>
				<td rowspan="2" width="18%">ELABORADA POR:</td>
                <td>'.$rowConfecc['Nombre'].' '.$rowConfecc['Apellido'].'</td>
				<td rowspan="2" width="33%" style="text-align: right;">APROBADA POR:</td>
				<td>Arrausi Eduardo</td>
            </tr>

            <tr>
                <td> </td>

				<td>Responsable técnico</td>
            </tr>

        </table>';

$pdf->writeHTML($html, true, false, true, false, '');

- - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------


//BUSCO EL CAMPO DONDE ESTA GUARDA LA RUTA DE LOS PRESUPUESTOS
	if(!$resultRutaPresup = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'rutaPresupuestos' and padre=1 limit 1")){
		 die("Problemas con la consulta de ContenidoValor en controlpanel");
	}
	$rowresultRutaPresup = mysqli_fetch_array($resultRutaPresup);
	
//Close and output PDF document
if (file_exists($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\')== true) {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\'.$regEmp['Organizacion'].' Cotiz('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');}
	else {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].' Cotiz('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');
	};

//============================================================+
// END OF FILE
//============================================================+
