<?php
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);
//============================================================+
	//Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	//generamos la consulta para el encabezado
	if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$_REQUEST['CUIT']."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
	$reg = mysqli_fetch_array($result);

	//generamos la consulta
    if(!$result = mysqli_query($conexion_sp, "select Euro, Dolar from cotizacionesnew ORDER BY Id desc limit 1")) die("Problemas con la consulta");
	$regMon = mysqli_fetch_array($result);  
	$euro=$regMon['Euro'];	
	$Dolar=$regMon['Dolar'];
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
		$this->SetX(60);
		$this->SetFont('helvetica', 'bi', 15);
		$this->Cell(1, 1, 'INFORME CUENTA CORRIENTE', 0, false, 'L', 0, '', 0, false, 'M', 'M');
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
$pdf->SetTitle('INFORME CUENTA CORRIENTE');
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
$txt = "Desde.: ".substr($_REQUEST['desde'],8,2)."/".substr($_REQUEST['desde'],5,2)."/".substr($_REQUEST['desde'],0,4)."\nHasta: ".substr($_REQUEST['hasta'],8,2)."/".substr($_REQUEST['hasta'],5,2)."/".substr($_REQUEST['hasta'],0,4);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(35, 10, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 60, 'T');

$txt = "Empresa: ".substr($reg['Organizacion'],0,60);
$pdf->MultiCell(105, 10, $txt, 1, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');

if (strlen($reg['CUIT']) < 6) {
	$txt = "CUIT/DNI:  ";
} else {
	$txt = "CUIT/DNI: ".$reg['CUIT'];
	}
	 
$pdf->MultiCell(53, 10, $txt, 1, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

$pdf->Ln(1);

$pdf->Ln(4);

// ---------------------------------------------------------
	if ($_REQUEST['Canceladas']=='true'){
		//echo "todas";
		//mostrar todas
			$Suma=0;
			if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$_REQUEST['CUIT']."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
			$reg = mysqli_fetch_array($result);
			//echo "Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")";
			//$html = "Comprobantes de este cliente desde: ".substr($_REQUEST['desde'],8,2)."/".substr($_REQUEST['desde'],5,2)."/".substr($_REQUEST['desde'],0,4)." hasta: ".substr($_REQUEST['hasta'],8,2)."/".substr($_REQUEST['hasta'],5,2)."/".substr($_REQUEST['hasta'],0,4);
			$html = <<<EOD
			<table border="0.1" width="105%"{border-collapse: collapse;}> 
			<tr>   
			<th width='2'> Tipo</th>
			<th width='4'> Numero</th>  
			<th width='6'> Fecha</th>
			<th width='6'> Importe Total</th>
			<th width='6'> Pagado</th>
			<th width='6'> Acumulado</th>
			<th width='6'> Vencimiento</th> 
			</tr>
EOD;
			
			if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "SELECT fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal FROM fondosyfacturas INNER JOIN caeafip ON fondosyfacturas.idCaeAfip = caeafip.Id GROUP BY fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal HAVING (fondosyfacturas.CUIT='".$_REQUEST['CUIT']."') ORDER BY fondosyfacturas.CUIT")) die("Problemas con la consulta FondosyFacturas");
			while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){
				//Tengo que conseguir la fecha y el vencimiento de la factura
				if(!$resultDetalle = mysqli_query($conexion_sp, "select FechaFactura, IdComprobante, IdEnviado from caeafip where Id='".$rowFyF[1]."' order by Id limit 1")) die("Problemas con la consulta2");
				$rowFechaId = mysqli_fetch_row($resultDetalle);
				//Verifico si la fecha esta dentro de lo pedido
				$entraPorFecha=0;
				$CbteFch1 =intval(substr($rowFechaId[0],0,4)."".substr($rowFechaId[0],5,2)."".substr($rowFechaId[0],8,2));
				$CbteFch2=intval(substr($_REQUEST['desde'],0,4)."".substr($_REQUEST['desde'],5,2)."".substr($_REQUEST['desde'],8,2));
				if ($CbteFch2<=$CbteFch1) {
					$CbteFch2=intval(substr($_REQUEST['hasta'],0,4)."".substr($_REQUEST['hasta'],5,2)."".substr($_REQUEST['hasta'],8,2));
					if ($CbteFch2>=$CbteFch1) {
						$entraPorFecha=1;
						//echo "<td>Entra por fecha</td>"; 
						;}
					;}
				if ($entraPorFecha==1) {
					//Busco el vencimiento de la factura desde la tabla comprobantes
					if(!$resultComprobante = mysqli_query($conexion_sp, "select CondicionesPago from comprobantes where TipoComprobante=3 and IdComprobante='".$rowFechaId[1]."' limit 1")) die("Problemas con la consulta comprobantes");
					$regComprobante = mysqli_fetch_array($resultComprobante);	
					//Ahora tengo que buscar los pagos
					$Pagos=0;
					$errorTcPagoFactura=0;
					//echo "idCaeAfip='".$rowFyF[1]."'";
					if(!$resultRegFyF = mysqli_query($conexion_sp, "select ID, importe, MonedaPago from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondosyfacturas2");
					while ($regRegFyF = mysqli_fetch_row($resultRegFyF)){
						if ($regRegFyF[2]==($rowFechaId[2]+1)) {
							$Pagos=$Pagos + $regRegFyF[1];
						} else {
							//No coincide la moneda del pago con la moneda de la factura
							//$pagos="Error en TC";
							$pagos=0;
							$errorTcPagoFactura=1;
						}
					}
					$html = $html ."<tr>";   
					$html = $html ."<td> $rowFyF[2]</td>";   
					$html = $html ."<td> $rowFyF[3]</td>"; 
					$html = $html ."<td> ".substr($rowFechaId[0],8,2)."/".substr($rowFechaId[0],5,2)."/".substr($rowFechaId[0],0,4)."</td>"; 

					if ($rowFechaId[2]==60) {//Euros
						$html = $html ."<td> € ".number_format($rowFyF[4],2,'.',',')."</td>";
						if ($errorTcPagoFactura==0){
							$html = $html ."<td> € ".number_format($Pagos,2,'.',',')."</td>";	
							} else {
								$html = $html ."<td>Dif. en TC</td>";
						}		
					if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$euro);}
					}
					
					if ($rowFechaId[2]==1) {//Dolares
						$html = $html ."<td> USD ".number_format($rowFyF[4],2,'.',',')."</td>";
						if ($errorTcPagoFactura==0){
							$html = $html ."<td> USD ".number_format($Pagos,2,'.',',')."</td>";	
							} else {
								$html = $html ."<td>Dif. en TC</td>";
						}		
					if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$Dolar);}
					}
					
					if ($rowFechaId[2]==0) {//Pesos
						$html = $html ."<td> $ ".number_format($rowFyF[4],2,'.',',')."</td>";
						if ($errorTcPagoFactura==0){
							$html = $html ."<td> $ ".number_format($Pagos,2,'.',',')."</td>";	
							} else {
								$html = $html ."<td>Dif. en TC</td>";
						}		
					if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ round($rowFyF[4],2)-round($Pagos,2);}
					}	
					//Comun a todas las monedas
					$html = $html ."<td> $ ".number_format($Suma,2,'.',',')."</td>";
					
					//generamos la consulta para el vencimiento de la factura.	
					//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
					//Padre 17 es la forma de pago. No lo puedo cambiar
					if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17'")) die("Problemas con la consulta forma de pago en controlpanel");
					$rowplazoFactura = mysqli_fetch_array($plazoFactura);
					$tmpFP = explode(',', $rowplazoFactura['ContenidoValor']);
					$CbteFch =strtotime($rowFechaId[0]."+ ".$tmpFP[1]." days");	
					if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB'){$datee= date("d/m/Y", $CbteFch);} else {$datee="--/--/--";}	
					$Faltan=date("z", $CbteFch-time());
					if ((($Faltan<10)&&($Faltan>=1)&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')) {
						//Faltan menos de 10 días para el vencimiento 
						$html = $html ."<td bgcolor='#FFFF00'> ".$datee."</td>";
					} else {
						if (((($Faltan<1)||($CbteFch<=time()))&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')){
							//Faltan menos de 1 día para el vencimiento 
							$html = $html ."<td bgcolor='#FF0000'> ".$datee."</td>";
						} else {
							//Falta....
							$html = $html ."<td> ".$datee."</td>";
						}
					}
					$html = $html ."</tr>";
					//ACA TENGO QUE LISTAR LOS PAGOS				
					$html = $html .<<<EOD
					<tr>
					<td colspan="1">
					</td>
					<td colspan="6">
EOD;
						//Busco los pagos
						if(!$resultPagos = mysqli_query($conexion_sp, "select * from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondos2");
						if (mysqli_num_rows($resultPagos)>0){
							$html = $html .<<<EOD
							<table border="0.1" width="100%" cellspacing="2" cellpadding="2" style="font-size:11px">
							<tr>
							<td colspan="5"> Movimientos asociados a este comprobante:</td>
							</tr>
							<tr>   
							<th width='10'> Fecha</th>  
							<th width='12'> Forma de pago</th>
							<th width='4'> Moneda</th>
							<th width='4'> Importe</th> 
							<th width='16'> Descripcion</th>
							</tr>
EOD;
							while ($regresultPagos = mysqli_fetch_row($resultPagos)){  
								//Busco todos los pagos
								if(!$monedaPago = mysqli_query($conexion_sp, "select Origen from monedaorigen where IdRegistroCambio='".$regresultPagos[6]."' limit 1")) die("Problemas con la consulta2");
								$rowmonedaPago = mysqli_fetch_array($monedaPago);
								if(!$formaPago = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$regresultPagos[5]."' limit 1")) die("Problemas con la consulta3");
								$rowformaPago = mysqli_fetch_array($formaPago);
								$html = $html . "<tr id='pago&$regresultPagos[0]'>";    
								$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]' height='50'> ".substr($regresultPagos[2],8,2)."/".substr($regresultPagos[2],5,2)."/".substr($regresultPagos[2],0,4)."</td>";  
								$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".$rowformaPago['Descripcion']."</td>";	
								$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".$rowmonedaPago['Origen']."</td>";
								$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".number_format($regresultPagos[7],2)."</td>";
								$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> $regresultPagos[3]</td>";
								$html = $html . "</tr>";	
							}  
							$html = $html . "<tr>";	
							$html = $html . "</tr>";
							$html = $html . "</table>";
						} else {
							$html = $html .<<<EOD
							<table border="0.1" width="100%"{border-collapse: collapse;} style="font-size:11px; bordercolor=#ff0000">
							<tr>
							<td colspan="5"> No se registran movimientos asociados a este comprobante.</td>
							</tr>
							</table>
EOD;
						}
					$html = $html . "</td>";
					$html = $html . "</tr>";
				}
			}
			$html = $html . "</table>";	
		
	} else {
		//mostrar solo las adeudadas
		//echo "adeudadas";
			$Suma=0;
			if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$_REQUEST['CUIT']."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
			$reg = mysqli_fetch_array($result);
			//echo "Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")";
			//$html = "Comprobantes de este cliente SIN CANCELAR desde: ".substr($_REQUEST['desde'],8,2)."/".substr($_REQUEST['desde'],5,2)."/".substr($_REQUEST['desde'],0,4)." hasta: ".substr($_REQUEST['hasta'],8,2)."/".substr($_REQUEST['hasta'],5,2)."/".substr($_REQUEST['hasta'],0,4);
			$html = <<<EOD
			<table border="0.1" width="105%"{border-collapse: collapse;}> 
			<tr>   
			<th width='2'> Tipo</th>
			<th width='4'> Numero</th>  
			<th width='6'> Fecha</th>
			<th width='6'> Importe Total</th>
			<th width='6'> Pagado</th>
			<th width='6'> Acumulado</th>
			<th width='6'> Vencimiento</th> 
			</tr>
EOD;
			if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "SELECT fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal FROM fondosyfacturas INNER JOIN caeafip ON fondosyfacturas.idCaeAfip = caeafip.Id GROUP BY fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal HAVING (fondosyfacturas.CUIT='".$_REQUEST['CUIT']."') ORDER BY fondosyfacturas.CUIT")) die("Problemas con la consulta FondosyFacturas");
			while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){
				//Tengo que conseguir la fecha y el vencimiento de la factura
				if(!$resultDetalle = mysqli_query($conexion_sp, "select FechaFactura, IdComprobante, IdEnviado from caeafip where Id='".$rowFyF[1]."' order by Id limit 1")) die("Problemas con la consulta2");
				$rowFechaId = mysqli_fetch_row($resultDetalle);
				//Verifico si la fecha esta dentro de lo pedido
				$entraPorFecha=0;
				$CbteFch1 =intval(substr($rowFechaId[0],0,4)."".substr($rowFechaId[0],5,2)."".substr($rowFechaId[0],8,2));
				$CbteFch2=intval(substr($_REQUEST['desde'],0,4)."".substr($_REQUEST['desde'],5,2)."".substr($_REQUEST['desde'],8,2));
				if ($CbteFch2<=$CbteFch1) {
					$CbteFch2=intval(substr($_REQUEST['hasta'],0,4)."".substr($_REQUEST['hasta'],5,2)."".substr($_REQUEST['hasta'],8,2));
					if ($CbteFch2>=$CbteFch1) {
						$entraPorFecha=1;
						//echo "<td>Entra por fecha</td>"; 
						;}
					;}
				if ($entraPorFecha==1) {
					//Busco el vencimiento de la factura desde la tabla comprobantes
					if(!$resultComprobante = mysqli_query($conexion_sp, "select CondicionesPago from comprobantes where TipoComprobante=3 and IdComprobante='".$rowFechaId[1]."' limit 1")) die("Problemas con la consulta comprobantes");
					$regComprobante = mysqli_fetch_array($resultComprobante);	
					//Ahora tengo que buscar los pagos
					$Pagos=0;
					$errorTcPagoFactura=0;
					//echo "idCaeAfip='".$rowFyF[1]."'";
					if(!$resultRegFyF = mysqli_query($conexion_sp, "select ID, importe, MonedaPago from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondosyfacturas2");
					while ($regRegFyF = mysqli_fetch_row($resultRegFyF)){
						if ($regRegFyF[2]==($rowFechaId[2]+1)) {
							$Pagos=$Pagos + $regRegFyF[1];
						} else {
							//No coincide la moneda del pago con la moneda de la factura
							//$pagos="Error en TC";
							$pagos=0;
							$errorTcPagoFactura=1;
						}
					}
					//ESTA ES LA UNICA DIFERENCIA CON RESPECTO A TODOS
					//SOLO LO MUESTRO SI PAGOS ES MENOR QUE $rowFyF[4]
					if (((round($rowFyF[4],2) > round($Pagos,2))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')&&($errorTcPagoFactura==0))||(($errorTcPagoFactura==1)&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB'))){							
						$html = $html . "<tr>";   
						$html = $html . "<td> $rowFyF[2]</td>";   
						$html = $html . "<td> $rowFyF[3]</td>"; 
						$html = $html . "<td> ".substr($rowFechaId[0],8,2)."/".substr($rowFechaId[0],5,2)."/".substr($rowFechaId[0],0,4)."</td>"; 
						
					
						if ($rowFechaId[2]==60) {//Euros
							$html = $html ."<td> € ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html = $html ."<td> € ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html = $html ."<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$euro);}
						}
						
						if ($rowFechaId[2]==1) {//Dolares
							$html = $html ."<td> USD ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html = $html ."<td> USD ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html = $html ."<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$Dolar);}
						}
						
						if ($rowFechaId[2]==0) {//Pesos
							$html = $html ."<td> $ ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html = $html ."<td> $ ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html = $html ."<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ round($rowFyF[4],2)-round($Pagos,2);}
						}	
						//Comun a todas las monedas
						$html = $html ."<td> $ ".number_format($Suma,2,'.',',')."</td>";
					
						//generamos la consulta para el vencimiento de la factura.	
						//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
						//Padre 17 es la forma de pago. No lo puedo cambiar
						if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17'")) die("Problemas con la consulta forma de pago en controlpanel");
						$rowplazoFactura = mysqli_fetch_array($plazoFactura);
						$tmpFP = explode(',', $rowplazoFactura['ContenidoValor']);
						$CbteFch =strtotime($rowFechaId[0]."+ ".$tmpFP[1]." days");	
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB'){$datee= date("d/m/Y", $CbteFch);} else {$datee="--/--/--";}	
						$Faltan=date("z", $CbteFch-time());
						if ((($Faltan<10)&&($Faltan>=1)&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')) {
							//Faltan menos de 10 días para el vencimiento 
							$html = $html . "<td bgcolor='#FFFF00'> ".$datee."</td>";
						} else {
							if (((($Faltan<1)||($CbteFch<=time()))&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')){
								//Faltan menos de 1 día para el vencimiento 
								$html = $html . "<td bgcolor='#FF0000'> ".$datee."</td>";
							} else {
								//Falta....
								$html = $html . "<td> ".$datee."</td>";
							}
						}
						$html = $html . "</tr>";
						//ACA TENGO QUE LISTAR LOS PAGOS	
						$html = $html .<<<EOD
						<tr border="2" cellspacing="2">
						<td colspan="1">
						</td>
						<td colspan="6">
EOD;
							//Busco los pagos
							if(!$resultPagos = mysqli_query($conexion_sp, "select * from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondos2");
							if (mysqli_num_rows($resultPagos)>0){
								$html = $html .<<<EOD
								<table border="0.1" width="100%" cellspacing="2" cellpadding="2" style="font-size:11px">
								<tr>
								<td colspan="5"> Movimientos asociados a este comprobante:</td>
								</tr>
								<tr>   
								<th width='10'> Fecha</th>  
								<th width='12'> Forma de pago</th>
								<th width='4'> Moneda</th>
								<th width='4'> Importe</th> 
								<th width='16'> Descripcion</th>
								</tr>
EOD;
								while ($regresultPagos = mysqli_fetch_row($resultPagos)){  
									//Busco todos los pagos
									if(!$monedaPago = mysqli_query($conexion_sp, "select Origen from monedaorigen where IdRegistroCambio='".$regresultPagos[6]."' limit 1")) die("Problemas con la consulta2");
									$rowmonedaPago = mysqli_fetch_array($monedaPago);
									if(!$formaPago = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$regresultPagos[5]."' limit 1")) die("Problemas con la consulta3");
									$rowformaPago = mysqli_fetch_array($formaPago);
									$html = $html . "<tr id='pago&$regresultPagos[0]'>";    
									$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]' height='50'> ".substr($regresultPagos[2],8,2)."/".substr($regresultPagos[2],5,2)."/".substr($regresultPagos[2],0,4)."</td>";  
									$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".$rowformaPago['Descripcion']."</td>";	
									$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".$rowmonedaPago['Origen']."</td>";
									$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> ".number_format($regresultPagos[7],2)."</td>";
									$html = $html . "<td name='xxxx' id='pago&$regresultPagos[0]'> $regresultPagos[3]</td>";
									$html = $html . "</tr>";	
								}  
								$html = $html . "<tr>";	
								$html = $html . "</tr>";	
								$html = $html . "</table>";
						} else {
							$html = $html .<<<EOD
							<table border="0.1" width="100%"{border-collapse: collapse;} style="font-size:11px; bordercolor=#ff0000">
							<tr>
							<td colspan="5"> No se registran movimientos asociados a este comprobante.</td>
							</tr>
							</table>
EOD;
						}
						$html = $html . "</td>";
						$html = $html . "</tr>";
					}
				}
			}
				$html = $html . "</table>";	
			
	}
$pdf->writeHTML($html, true, false, true, false, ''); 
// ---------------------------------------------------------

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
//if (file_exists($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\')== true) {
//		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].'\\'.$regEmp['Organizacion'].' Cotiz('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'I');}
//	else {
//		$pdf->Output($rowresultRutaPresup['ContenidoValor'].$regEmp['Organizacion'].' Cotiz('.$reg['NumeroComprobante'].')'.date("dmy").'.pdf', 'I');
//	};
//Change To Avoid the PDF Error
ob_end_clean();
$pdf->Output('Informe CC '.date("dmy").'.pdf', 'I');
ob_end_flush();
//============================================================+
// END OF FILE
//============================================================+
