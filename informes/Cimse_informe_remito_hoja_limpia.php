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
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select IdComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, NumeroComprobante01, PlazoEntrega, Confecciono, MantiniemtoOferta, Transporte, Solicito, UsuarioModificacion, NumeroComprobante02, ConddeIva from comprobantes where TipoComprobante=3 and NumeroComprobante='".$_REQUEST['idrto']."' limit 1")) die("Problemas con la consulta1");
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
		
		if(!$resultEmpDir = mysqli_query($conexion_sp, "select Direccion, Ciudad, Provoestado from direcciones where id='".$_REQUEST['diRemito']."' and Direccion Not Like '%@%' limit 1")) die("Problemas con la consulta diRemito");
		$regEmpDir = mysqli_fetch_array($resultEmpDir);		
		
		if(!$resultEmpTel = mysqli_query($conexion_sp, "select Telefono, Telefonomovil from telefonos where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regEmpTel = mysqli_fetch_array($resultEmpTel);		
	
	//generamos la consulta para el detalle	
		
		if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$reg['IdComprobante']."' order by Orden")) die("Problemas con la consulta2");
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
	public $ImpresionRemito;
	public $DelRemito;
	public $AlRemito;
	public function Header() {
//============================================================+
//TEXTOS DEL HEADER
$this->SetY(8);
$this->SetX(55);
$this->SetFont('helvetica', 'B', 26);
$txt='CIMSe';
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$this->MultiCell(49, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(18);
$this->SetX(55);
$this->SetFont('helvetica', 'B', 13);
$txt='PATAGONIA S.R.L.';
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$this->MultiCell(49, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(23);
$this->SetX(45);
$this->SetFont('helvetica', 'B', 6);
$txt='CENTRO DE INSTRUMENTACION, METROLOGÍA Y SERVICIOS';
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$this->MultiCell(69, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(26);
$this->SetX(59);
$this->SetFont('helvetica', 'B', 6);
$txt='CALIBRACIÓN Y VENTA DE INSTRUMENTOS DE MEDICIÓN';
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$this->MultiCell(39, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(34);
$this->SetX(38);
$this->SetFont('helvetica', 'B', 7);
$txt='Lote 8, Manzana “C”, Bº San Cristobal, Valentina Sur-Nqn';
$this->MultiCell(83, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(37);
$this->SetX(30);
$this->SetFont('helvetica', 'B', 7);
$txt='Cel.: Admin. (299) 156066112; Lab. (299) 155-179547';
$this->MultiCell(93, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(40);
$this->SetX(46);
$this->SetFont('helvetica', 'B', 7);
$txt='E-mail: administracion@cimsesrl.com.ar';
$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(43);
$this->SetX(46);
$this->SetFont('helvetica', '', 6);
$txt='IVA RESPONSABLE INSCRIPTO';
$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(14);
$this->SetX(170);
$this->SetFont('helvetica', 'B', 16);
$this->Cell(1, 1, $this->decrTipoComprobante, 0, false, 'C', 0, '', 0, false, 'M', 'M');

$this->SetY(23);
$this->SetX(170);
$this->SetFont('helvetica', 'B', 16);
$this->Cell(1, 1, 'Nº 0001 - '.$this->numeroComprobante, 0, false, 'C', 0, '', 0, false, 'M', 'M');

$this->SetY(32);
$this->SetX(170);
$this->SetFont('helvetica', 'B', 12);
$this->Cell(1, 1, 'FECHA  '.date('d').'/'.date('m').'/'.date('Y'), 0, false, 'C', 0, '', 0, false, 'M', 'M');

$this->SetY(16);
$this->SetX(122);
$this->SetFont('helvetica', 'b', 42);
$this->Cell(1, 1, $this->tipoComprobante, 0, false, 'L', 0, '', 0, false, 'M', 'M');

$this->SetY(37);
$this->SetX(140);
$this->SetFont('helvetica', '', 7);
$txt='CUIT:  '.$this->miCuit;
$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(40);
$this->SetX(140);
$this->SetFont('helvetica', '', 7);
$txt='Ingresos brutos CM:  '.$this->miIIBBCM;
$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(43);
$this->SetX(140);
$this->SetFont('helvetica', '', 7);
$txt='Inicio de actividades:  '.$this->miFechaInicioAct;
$this->MultiCell(63, 4, $txt, 0, 'C', 0, 0, '', '', true);

$this->SetY(22);
$this->SetX(103);
$this->SetFont('helvetica', 'B', 8);
$txt='Cod. '.$this->codTipoComprobante;
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$this->MultiCell(49, 4, $txt, 0, 'C', 0, 0, '', '', true);

//============================================================+
// LOGOS DEL HEADER
$image_file = K_PATH_IMAGES.'Presupuesto/Cimse.png';
// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$this->Image($image_file, 10, 10, 35, 35, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);	
//============================================================+

//============================================================+
// LINEAS DEL HEADER
$this->Line(8, 9, 8, 47, array('width' => 0.75));
$this->Line(8, 9, 205, 9, 6);
$this->Line(8, 47, 205, 47, 6);	
$this->Line(205, 9, 205, 47, 6);	
$this->Line(136, 9, 136, 27, 6);	
$this->Line(119, 9, 119, 27, 6);
$this->Line(128, 27, 128, 47, 6);	
$this->Line(119, 27, 136, 27, 6);		
//============================================================+

}

	// Page footer
	public $factu;
	public function Footer() {
		// Position at 15 mm from bottom
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->SetY(-45);
		$this->Cell(0, 10, 'Entregó:', 0, false, 'L', 0, '', 0, false, 'T', 'M');		
		$this->SetY(-35);
		$this->Cell(0, 10, 'Factura Nº: ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetFont('helvetica', 'I', 11);
		$this->SetY(-36);
		$this->Cell(0, 10, '               '.$this->factu, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetFont('helvetica', 'I', 9);
		$this->SetY(-35);
		$this->Cell(0, 10, 'Firma                  Aclaración                  Fecha', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->SetY(-14);
		$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

		// Position at 15 mm from bottom
		$this->SetY(-12);
		$this->SetX(9);
		$this->SetFont('helvetica', '', 7);
		$txt='ORIGINAL';
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-12);
		$this->SetX(29);
		$this->SetFont('helvetica', '', 7);
		$txt='DUPLICADO';
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-12);
		$this->SetX(54);
		$this->SetFont('helvetica', '', 7);
		$txt='TRIPLICADO';
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-25);
		$this->SetX(167);
		$this->SetFont('helvetica', 'B', 9);
		$txt='CAI '.$this->CAE;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-21);
		$this->SetX(168);
		$this->SetFont('helvetica', 'B', 9);
		$txt='Vto. CAI  '.substr($this->vtoCAE,6,2)."/".substr($this->vtoCAE,4,2)."/".substr($this->vtoCAE,0,4);
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		//Pompucci
		$this->SetY(-25);
		$this->SetX(11);
		$this->SetFont('helvetica', 'B', 5);
		$txt='IMPRENTA POMPUCCI S.R.L. - CUIT: 30-71046215-8';
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-23);
		$this->SetX(11);
		$this->SetFont('helvetica', 'B', 5);
		$txt='HABILITACION MUNICIPAL 562 - FECHA DE IMPRESION: '.$this->ImpresionRemito;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
		$this->SetY(-21);
		$this->SetX(11);
		$this->SetFont('helvetica', 'B', 5);
		$txt='DEL Nº '.$this->DelRemito." al ".$this->AlRemito;
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);

		$style = array(
			'align' => 'C',
		);		
		$this->SetY(-26);
		$this->SetX(78);
		$txt=str_replace("-","", $this->miCuit).$this->codTipoComprobante.$this->miPuntoVenta.$this->CAE.$this->vtoCAE.'5';
		$this->write1DBarcode($txt, 'I25+', '', '', 85, 7, 0.4, $style, 'N');
		$this->SetY(-19);
		$this->SetX(93);
		$this->SetFont('helvetica', '', 7);
		$this->MultiCell(63, 4, $txt, 0, 'L', 0, 0, '', '', true);
		
//============================================================+
// LINEAS DEL FOOTER
		$this->Line(8, $this->getPageHeight()-15, 205, $this->getPageHeight() -15, array('width' => 0.55));
		$this->Line(8, $this->getPageHeight()-27, 205, $this->getPageHeight()-27, 6);
		$this->Line(8, $this->getPageHeight()-15, 8, $this->getPageHeight()-27, 6);
		$this->Line(205, $this->getPageHeight()-15, 205, $this->getPageHeight()-27, 6);
	
		$this->Rect(21, $this->getPageHeight()-13, 5, 5, 'D');
		$this->Rect(44, $this->getPageHeight()-13, 5, 5, 'D');
		$this->Rect(69, $this->getPageHeight()-13, 5, 5, 'D');
//============================================================+
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('REMITO');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->factu = $reg['UsuarioModificacion'];

//variables para header y footer	
$codTipoComprobante=91;
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
$pdf->tipoComprobante='R';
$pdf->decrTipoComprobante='REMITO';
$descripTipoComprobante='REMITO';
$pdf->codTipoComprobante=str_pad($codTipoComprobante, 2,"0", STR_PAD_LEFT);
//BUSCO miPuntoVenta EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
$pdf->miPuntoVenta = str_pad($rowresultDatosAux['ContenidoValor'], 4,"0", STR_PAD_LEFT);
$auxPV=(string)str_pad($rowresultDatosAux['ContenidoValor'], 4,"0", STR_PAD_LEFT);
$pdf->numeroComprobante=str_pad($_REQUEST['numPreimpreso'], 8,"0", STR_PAD_LEFT);
$auxNF=(string)str_pad($_REQUEST['numPreimpreso'], 8,"0", STR_PAD_LEFT);
//BUSCO CAIRemito EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'CAIRemito' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->CAE=$rowresultDatosAux['ContenidoValor'];
//BUSCO VtoCAI EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'VtoCAI' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->vtoCAE=$rowresultDatosAux['ContenidoValor'];
//BUSCO ImpresionRemito EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'ImpresionRemito' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->ImpresionRemito=$rowresultDatosAux['ContenidoValor'];
//BUSCO DelRemito EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'DelRemito' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->DelRemito=$rowresultDatosAux['ContenidoValor'];
//BUSCO AlRemito EN CONTROLPANEL.
if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'AlRemito' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);
$pdf->AlRemito=$rowresultDatosAux['ContenidoValor'];

$pdf->SetTitle($descripTipoComprobante);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//margin top indica donde termina el header y empieza el formulario
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP+2, PDF_MARGIN_RIGHT);
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
$txt = "\nEmpresa: ".substr($regEmp['Organizacion'],0,90)."\nDomicilio: ".substr($regEmpDir['Direccion'],0,70)." - ".substr($regEmpDir['Ciudad'],0,37)."\nCUIT: ".$regEmp['CUIT']."                                           Condición de IVA:".$regEmp['CondicionIVA']."\n";
$pdf->MultiCell(193, 23, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// set some text for example
$txt = "Condiciones de venta: ".substr($tmpFormaPago[0],0,30);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(120, 6, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');

$txt = "Remito Nº: ".substr($reg['NumeroComprobante02'],0,17);
$pdf->MultiCell(73, 6, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

// set some text for example
$txt = "Orden de compra: ".substr($reg['NumeroComprobante01'],0,90);
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(193, 6, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 60, 'T');

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
		<th align="left" width="82%"><b>Descripción</b></th>
		<th align="right" width="5%"><b>Cant.</b></th>
		<th align="right" width="8%"><b>Unidad</b></th>';
	$html = $html .'			
	</tr>
	<hr width="105%">';

//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------

while ($rowDetalle = mysqli_fetch_array($resultDetalle)){   
	if(!$resultArticulo = mysqli_query($conexion_sp, "select descricpcion, MonedaOrigen, ValorVenta, IVA, UnidadMedida, ComposicionyDescirpcion from productos where IdProducto='".$rowDetalle['IdProducto']."' limit 1")) die("Problemas con la consulta2");
	$rowProd = mysqli_fetch_array($resultArticulo);
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Confecciono']."' limit 1")) die("Problemas con la consulta2");
	$rowConfecc = mysqli_fetch_array($confecc);
	if(!$solicit = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Solicito']."' limit 1")) die("Problemas con la consulta2");
	$rowSolicit = mysqli_fetch_array($solicit);
    $html = $html .'
	<tr>
		<td style="font-size:0.95em; font-weight:normal">'.$rowDetalle['Orden'].'</td>
		<td style="font-size:0.95em; font-weight:normal">'.$rowProd['descricpcion'].'</td>
		<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$rowDetalle['Cantidad'].'</td>
		<td style="font-size:0.95em; font-weight:normal; text-align: center">'.$rowProd['UnidadMedida'].'</td>
	</tr>';
	
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
}	
	$html = $html .'<hr width="105%">'; 
    $html = $html ."</table>";
	
$pdf->writeHTML($html, true, false, true, false, ''); 
// ---------------------------------------------------------
$html ='	
<table border="0" {border-collapse: collapse;}>	
	<tr>				
		<td width="75%" style="font-size:0.8em; text-align: left">CF: '.$rowConfecc['Nombre'].' '.$rowConfecc['Apellido'].'/'.$rowSolicit['Nombre'].' '.$rowSolicit['Apellido'].'</td>
	</tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

- - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------


//BUSCO EL CAMPO DONDE ESTA GUARDA LA RUTA DE LOS PRESUPUESTOS
	if(!$resultRutaPresup = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'rutaRemitos' and padre=1 limit 1")){
	die("Problemas con la consulta de ContenidoValor en controlpanel");}
	$rowresultRutaPresup = mysqli_fetch_array($resultRutaPresup);
	
//Close and output PDF document
if (file_exists($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\')== true) {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\('.$reg['NumeroComprobante02'].')'.$regEmp['Organizacion'].' Remito('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');}
	else {
		$pdf->Output($rowresultRutaPresup['ContenidoValor'].'('.$reg['NumeroComprobante02'].')'.$regEmp['Organizacion'].' Remito('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'FI');
	};

//============================================================+
// END OF FILE
//============================================================+
