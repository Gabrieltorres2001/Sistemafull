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
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select Confecciono, fechaLegajo from legajos where id='".$_REQUEST['idlegajo']."' limit 1")) die("Problemas con la consulta1");
		$reg = mysqli_fetch_array($resultComprobante); 		

	if(!$resultresponsable = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Confecciono']."' limit 1")) die("Problemas con la consulta 1.5");
	$rowresponsable = mysqli_fetch_array($resultresponsable);		

//============================================================+

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
//require_once('tcpdf.php');
//require_once('tcpdi.php');

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
		
		$this->SetY(18);
		$this->SetX(90);
		$this->SetFont('helvetica', 'bi', 21);
		$this->Cell(1, 1, 'LEGAJO', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//============================================================+
// LOGOS DEL HEADER
		$image_file = K_PATH_IMAGES.'Presupuesto/Tecnopluslogo.jpg';
		// Image method signature:
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		$this->Image($image_file, 8, 10, 35, 14, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
//============================================================+
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		$this->SetY(-18);
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 		//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		$this->Cell(0, 24, $dias[date('w')].', '.date("d").' de '.$meses[date('n')-1].' de '.date("Y").' - Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Create new PDF document.
//$pdf = new TCPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('LEGAJO');
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
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP-18, PDF_MARGIN_RIGHT);
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
$txt = "Número: ".$_REQUEST['idlegajo'];
$pdf->MultiCell(50, 25, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');

$txt = "Responsable: ".$rowresponsable['Nombre'].' '.$rowresponsable['Apellido'];
$pdf->MultiCell(90, 25, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');

$txt = "Fecha: ".substr($reg['fechaLegajo'],8,2)."/".substr($reg['fechaLegajo'],5,2)."/".substr($reg['fechaLegajo'],0,4);	 
$pdf->MultiCell(53, 25, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$pdf->Ln(1);

// create some HTML content
	$html ='
<table border="0" {border-collapse: collapse;}>
	<tr>
		<td style="font-size:1.3em; font-weight:bold; text-align: center" colspan="5">Check List:</td>
	</tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, ''); 

// ---------------------------------------------------------


	$html = '
<table border="0" width="105%"{border-collapse: collapse;}>
	<tr>
		<th width="10%"><b>Orden</b></th>
		<th align="left" width="34%"><b>Tipo</b></th>
		<th align="left" width="40%"><b>Descripción</b></th>
		<th align="right" width="15%"><b>Nº</b></th>';
	$html = $html .'			
	</tr>
	<hr width="105%">';

//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------


//generamos la consulta para el detalle
//Primero voy a recorrer la tabla z_tipocomprobante
	if(!$resulttipocomprobante = mysqli_query($conexion_sp, "select IdTipoComprobante, TipoComprobante, Abrev from z_tipocomprobante where Abrev>0 order by Abrev")) die("Problemas con la consulta 1.5");
	while ($rowtipocomprobante = mysqli_fetch_array($resulttipocomprobante)){ 
		
	   if(!$resultDetalle = mysqli_query($conexion_sp, "select idComprobante, numComprobante, tipoComprobante, textoComprobante, orden from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and tipoComprobante='".$rowtipocomprobante['IdTipoComprobante']."' order by tipoComprobante")) die("Problemas con la consulta 2");
	   $existeCampo=0;
		while ($row = mysqli_fetch_array($resultDetalle)){ 
			$existeCampo=1;
			$html = $html .'
			<tr>
				<td style="font-size:0.95em; font-weight:normal">'.$rowtipocomprobante['Abrev'].'</td>
				<td style="font-size:0.95em; font-weight:normal">'.$rowtipocomprobante['TipoComprobante'].'</td>
				<td style="font-size:0.95em; font-weight:normal;">'.$row['textoComprobante'].'</td>
				<td style="font-size:0.95em; font-weight:normal; text-align: right">'.$row['numComprobante'].'</td>
			</tr>
			<hr width="105%">';
		}  
		if ($existeCampo==0) {
			$html = $html .'
			<tr>
				<td style="font-size:0.95em; font-weight:normal">'.$rowtipocomprobante['Abrev'].'</td>
				<td style="font-size:0.95em; font-weight:normal">'.$rowtipocomprobante['TipoComprobante'].'</td>
				<td style="font-size:0.95em; font-weight:normal;"> </td>
				<td style="font-size:0.95em; font-weight:normal; text-align: right"> (X) </td>
			</tr>
			<hr width="105%">';
		} 		
	}
    $html = $html ."</table>";
$pdf->writeHTML($html, true, false, true, false, ''); 
// ---------------------------------------------------------
	   if(!$resultDetalle2 = mysqli_query($conexion_sp, "select PDF from detallelegajos where idLegajo='".$_REQUEST['idlegajo']."' and PDF>0 order by orden")) die("Problemas con la consulta 3");
		while ($rowDet2 = mysqli_fetch_array($resultDetalle2)){ 
			// add a page
			$pdf->AddPage('P', 'A4');
			if(!$resultPDF = mysqli_query($conexion_sp, "select PDF, tipo from pdflegajos where id='".$rowDet2[0]."' limit 1")) die("Problemas con la consulta2");
			if ($regPDF = mysqli_fetch_array($resultPDF)){
				$contenido = $regPDF['PDF'];
				// create new PDF document
				//$pdf = new TCPDF_IMPORT('Agromadera SRLCotiz(31359)150317.pdf');
				//importPDF('Agromadera SRLCotiz(31359)150317.pdf');
				//$html ='<object data="data:application/pdf;base64,'.base64_encode($contenido).'" type="application/pdf" ></object>';
				$html ='<embed src="Agromadera SRLCotiz(31359)150317.pdf" type="application/pdf" width="800" height="600"></embed>';
				$pdf->writeHTML($html, true, false, true, false, '');
				//$pdf->Write(0, '<object data="data:application/pdf;base64,'.base64_encode($contenido).'" type="application/pdf" ></object>', '', 0, 'C', 1, 0, false, false, 0);
			}; 
		}

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//BUSCO EL CAMPO DONDE ESTA GUARDA LA RUTA DE LOS PRESUPUESTOS
	if(!$resultRutaPresup = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'rutaPresupuestos' and padre=1 limit 1")){
		 die("Problemas con la consulta de ContenidoValor en controlpanel");
	}
	$rowresultRutaPresup = mysqli_fetch_array($resultRutaPresup);
	
//Close and output PDF document
	$pdf->Output('Legajo ('.$_REQUEST['idlegajo'].') '.date("dmy").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
