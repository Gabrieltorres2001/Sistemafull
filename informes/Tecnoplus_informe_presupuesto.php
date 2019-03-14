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
		$this->SetY(28);
		$this->SetX(9);
		// Set font
		$this->SetFont('helvetica', '', 9);
		// Title
		//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(1, 1, 'De Ing. Aldo A. Bruschi', 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$this->SetY(10);
		$this->SetX(45);
		$this->SetFont('helvetica', 'B', 8);
		$txt='Productos y Servicios para Automatización, Control, Instrumentación y Mediciones. Materiales eléctricos industriales.';
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$this->MultiCell(49, 4, $txt, 0, 'C', 0, 0, '', '', true);
		
		$this->SetY(10);
		$this->SetX(95);
		$this->SetFont('helvetica', '', 8);
		$txt='OMRON-WEIDMÜLLER-AMPROBE-MSYSTEM VICOR-TES-Delta-CAREL-Jefferson-Autonics Kyoritsu-BAUR-ISA-Prova-HCK-Telco-Proskit AECO-Takex-Varitrans-Hart Scientific-Gefran Novus-Marlew-Argenplas-Altron-Strikesorb';
		$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);
		
		$this->SetY(13);
		$this->SetX(170);
		$this->SetFont('helvetica', 'B', 9);
		$this->Cell(1, 1, 'DISTRIBUIDOR', 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$this->SetY(26);
		$this->SetX(166);
		$this->SetFont('helvetica', '', 9);
		$this->Cell(1, 1, 'PARA EL COMAHUE', 0, false, 'L', 0, '', 0, false, 'M', 'M');
		
		$this->SetY(45);
		$this->SetX(80);
		$this->SetFont('helvetica', 'bi', 21);
		$this->Cell(1, 1, 'COTIZACION', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//============================================================+
// LOGOS DEL HEADER
		$image_file = K_PATH_IMAGES.'Presupuesto/Tecnopluslogo.jpg';
		// Image method signature:
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		$this->Image($image_file, 8, 10, 35, 14, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Testo.jpg';
		$this->Image($image_file, 39, 31, 14.5, 14.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Moeller.jpg';
		$this->Image($image_file, 10, 33, 29, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Danfoss.jpg';
		$this->Image($image_file, 54, 33, 26, 9.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Norriseal.jpg';
		$this->Image($image_file, 84, 29, 45, 13, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Fluke.jpg';
		$this->Image($image_file, 130, 33, 31, 6.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Nollmann.jpg';
		$this->Image($image_file, 162, 33, 39.5, 6.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$image_file = K_PATH_IMAGES.'Presupuesto/Festo.jpg';
		$this->Image($image_file, 167, 17, 29.5, 6, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//============================================================+
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->SetY(-19);
		$this->Cell(0, 10, 'Administración y Ventas - Alderete 2393 - Neuquén Capital- Tele/FAX: 0299-4478540 - Cel : 0299 155836918', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->SetY(-15);
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		$this->Cell(0, 10, $dias[date('w')].', '.date("d").' de '.$meses[date('n')-1].' de '.date("Y").' - aldobruschi@tecnoplusonline.com.ar - Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

// set some text for example
$txt = "Num.: ".$reg['NumeroComprobante']."\nFecha: ".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4)."\nPetición de oferta:\n".substr($reg['NumeroComprobante01'],0,25);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(50, 25, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');

$txt = "Empresa: ".substr($regEmp['Organizacion'],0,60)."\nAt.: ".$reg['ApellidoContacto']."\nDirección: ".substr($regEmpDir['Direccion'],0,40)." - ".substr($regEmpDir['Ciudad'],0,17);
$pdf->MultiCell(90, 25, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');

if (strlen($regEmp['CUIT']) < 6) {
	$txt = "CUIT/DNI:  \nTel: ".substr($regEmpTel['Telefono'],0,23)."\nCel: ".substr($regEmpTel['Telefonomovil'],0,23)."\nMail: ".substr($regEmpMail['Direccion'],0,27);
} else {
	$txt = "CUIT/DNI: ".$regEmp['CUIT']."\nTel: ".substr($regEmpTel['Telefono'],0,23)."\nCel: ".substr($regEmpTel['Telefonomovil'],0,23)."\nMail: ".substr($regEmpMail['Direccion'],0,27);
	}
	 
$pdf->MultiCell(53, 25, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$pdf->Ln(1);

$pdf->MultiCell(15, 5, 'Notas:', 0, 'J', 0, 0, '', '', true, 0, false, true, 40, 'T');
$txt = $reg['Notas'];
$pdf->MultiCell(178, 5, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');


$pdf->Ln(4);

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
	$html = '
<table border="0" width="105%"{border-collapse: collapse;}>
	<tr>
		<th width="5%"><b>Item</b></th>
		<th align="left" width="49%"><b>Descripción</b></th>
		<th align="right" width="5%"><b>Cant.</b></th>
		<th align="right" width="8%"><b>Unidad</b></th>';
		IF ($_REQUEST['iva']=='1'){
			$html = $html .'
			<th align="right" width="13%"><b>Unitario</b></th>
			<th align="right" width="15%"><b>SubTotal s/IVA</b></th>
			<th align="right" width="5%"><b>IVA</b></th>';}
			else {
				$html = $html .'
				<th align="right" width="15%"><b>Unitario</b></th>
				<th align="right" width="18%"><b>SubTotal c/IVA</b></th>';}
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
		<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$rowDetalle['Cantidad'].'</td>
		<td style="font-size:0.95em; font-weight:normal; text-align: center">'.$rowProd['UnidadMedida'].'</td>';
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
		<td colspan="3" style="font-size:0.66em; font-weight:normal"><b>Plazo de entrega: </B>'.$rowDetalle['Observaciones'].'</td>
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

if(!$plazoEnt = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion='".$reg['PlazoEntrega']."' and padre='51' limit 1")) die("Problemas con la consulta plazoentrega en controlpanel");

if ($rowPlazoEnt = mysqli_fetch_array($plazoEnt)){$elPlazoEnt=$rowPlazoEnt['ContenidoValor'];}
else {$elPlazoEnt='';}

	$html ='
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="25%" style="font-size:0.9em; font-weight:bold; text-align: right"><b>Mantenimiento de Oferta: </b></td>
		<td width="1%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
		<td width="65%" style="font-size:0.9em; font-weight:normal; text-align: left">'.$reg['MantiniemtoOferta'].' Días</td>
		<td width="11%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
	</tr>
	<tr>
		<td width="25%" style="font-size:0.9em; font-weight:bold; text-align: right"><b>Transporte: </b></td>
		<td width="1%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
		<td width="65%" style="font-size:0.9em; font-weight:normal; text-align: left">'.$reg['Transporte'].'</td>
		<td width="11%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
	</tr>
	<tr>
		<td width="25%" style="font-size:0.9em; font-weight:bold; text-align: right"><b>Plazo de Entrega: </b></td>
		<td width="1%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
		<td width="65%" style="font-size:0.9em; font-weight:normal; text-align: left">'.$elPlazoEnt.'</td>
		<td width="11%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
	</tr>
	<tr>
		<td width="25%" style="font-size:0.9em; font-weight:bold; text-align: right"><b>Condiciones de pago: </b></td>
		<td width="1%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
		<td width="65%" style="font-size:0.9em; font-weight:normal; text-align: left">'.$tmpFormaPago[0].'</td>
		<td width="11%" style="font-size:0.9em; font-weight:bold; text-align: right"> </td>
	</tr>
	<tr>
		<td rowspan="2" colspan="5" style="font-size:1em; text-align: left">De requerir mayor información o aclaraciones sobre esta cotización u otros productos no dude en comunicarse con el Ing. Aldo Bruschi. CUIT 20-10593800-5. Tel./FAX: (0299) 4478540. </td>
	</tr>
</table>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="75%" style="font-size:1em; text-align: left">Cel. (0299) 155836918. E-mail: aldobruschi@infovia.com.ar</td>

		<td width="25%" style="font-size:1em; text-align: center" rowspan="3"><img src="../images/Presupuesto/Firma.jpg" width="100" height="60"></td>
	</tr>
	<tr>
		<td width="75%" style="font-size:1em; text-align: left">Sin otro particular, quedando a sus ordenes, saludamos a Ud. muy atentamente.</td>

	</tr>
	<tr>				
		<td width="75%" style="font-size:0.8em; text-align: left">CF: '.$rowConfecc['Nombre'].' '.$rowConfecc['Apellido'].'/'.$rowSolicit['Nombre'].' '.$rowSolicit['Apellido'].'</td>
	</tr>
</table>
</br>
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td width="75%" style="font-size:1em; text-align: left">El monto de la presente cotización deberá ser abonado en Dólares/Euros billetes o su equivalente en pesos, al tipo de cambio vigente al día anterior a la fecha de pago efectivo, según B. N. A. Dólar/Euro billete vendedor o el que en el futuro lo reemplace.</td>
		<td rowspan="2" width="25%" style="font-size:1em; text-align: center; vertical-align: bottom">Aldo Bruschi</td>
	</tr>
	<tr>
		<td width="99%" style="font-size:1em; text-align: left">El envío de cualquier órden de compra implicará conocer y aceptar la totalidad de las condiciones de la presente cotización. Sólo se aceptarán órdenes de compras en la misma moneda que la cotización.</td>
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
