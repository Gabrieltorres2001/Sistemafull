<?php
//============================================================+
	   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Euro, Dolar from cotizacionesnew ORDER BY Id desc limit 1")) die("Problemas con la consulta");
	$regMon = mysqli_fetch_array($result);  
	$euro=$regMon['Euro'];	
	$Dolar=$regMon['Dolar'];
	
	$totalGeneral=0;
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
		
		$this->SetY(16);
		$this->SetX(104);
		$this->SetFont('helvetica', 'bi', 21);
		$this->Cell(1, 1, 'INFORME DEUDORES', 0, false, 'L', 0, '', 0, false, 'M', 'M');
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
$pdf->SetTitle('DEUDORES');
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
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage('P', 'A4');
$html ="";
	$totalGeneral=0;
	
	//Primero recorro todos los cuits a los que les hice facturas
	if(!$resultFondosyFacturasGeneral = mysqli_query($conexion_sp, "select distinct CUIT from fondosyfacturas")) die("Problemas con la consulta FondosyFacturas General");
	while ($rowFyFGral = mysqli_fetch_row($resultFondosyFacturasGeneral)){
		$Deudor=0;
		//Primero busco los CUITs cargados en la tabla de pagosyfacturas, así solo listo los que tienen factura registrada
		if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "SELECT fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal, Sum(fondos.Importe) AS SumaDeImporte FROM (fondosyfacturas INNER JOIN caeafip ON fondosyfacturas.idCaeAfip = caeafip.Id) LEFT JOIN fondos ON fondosyfacturas.idFondo = fondos.ID GROUP BY fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal HAVING (((fondosyfacturas.CUIT)='".$rowFyFGral[0]."') AND ((caeafip.TipoFactura)<>'NCA' And (caeafip.TipoFactura)<>'NCB')) ORDER BY fondosyfacturas.CUIT")) die("Problemas con la consulta FondosyFacturas");
		while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){
		if (round($rowFyF[4],2) > round($rowFyF[5],2)) {$Deudor=1;}
		}
		if ($Deudor==1) {
			$Suma=0;
			if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$rowFyFGral[0]."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
			$reg = mysqli_fetch_array($result);
			

	$html = $html ."Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).") Comprobantes de este cliente SIN CANCELAR:";
	$html = $html ."<br></br>";
	$html = $html . 
	<<<EOD
			<table border="1" width="105%"{border-collapse: collapse;}> 
			<tr>   
			<th width='2'>Tipo</th> 
			<th width='4'>Numero</th>  
			<th width='6'>Fecha</th> 
			<th width='6'>Importe Total</th> 
			<th width='6'>Pagado</th>
			<th width='6'>Acumulado</th> 
			<th width='6'>Vencimiento</th> 
			</tr>
EOD;
				
			if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "SELECT fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal, Sum(fondos.Importe) AS SumaDeImporte FROM (fondosyfacturas INNER JOIN caeafip ON fondosyfacturas.idCaeAfip = caeafip.Id) LEFT JOIN fondos ON fondosyfacturas.idFondo = fondos.ID GROUP BY fondosyfacturas.CUIT, fondosyfacturas.idCaeAfip, caeafip.TipoFactura, caeafip.NumeroFactura, caeafip.ImporteTotal HAVING (((fondosyfacturas.CUIT)='".$rowFyFGral[0]."') AND ((caeafip.TipoFactura)<>'NCA' And (caeafip.TipoFactura)<>'NCB')) ORDER BY fondosyfacturas.CUIT")) die("Problemas con la consulta FondosyFacturas");
			while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){
				if (round($rowFyF[4],2) > round($rowFyF[5],2)) {
					//Tengo que conseguir la fecha y el vencimiento de la factura
					if(!$resultDetalle = mysqli_query($conexion_sp, "select FechaFactura, IdComprobante, IdEnviado from caeafip where Id='".$rowFyF[1]."' order by Id limit 1")) die("Problemas con la consulta2");
					$rowFechaId = mysqli_fetch_row($resultDetalle);
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
					$html =$html ."<tr>   
					<td>$rowFyF[2]</td>   
					<td>$rowFyF[3]</td> 
					<td>".substr($rowFechaId[0],8,2)."/".substr($rowFechaId[0],5,2)."/".substr($rowFechaId[0],0,4)."</td>"; 
						
						if ($rowFechaId[2]==60) {//Euros
							$html =$html ."<td>€ ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html =$html ."<td>€ ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html =$html ."<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$euro);}
						}
						
						if ($rowFechaId[2]==1) {//Dolares
							$html =$html ."<td>USD ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html =$html ."<td>USD ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html =$html ."<td>Dif. en TC</td>";
							}			
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$Dolar);}
						}
						
						if ($rowFechaId[2]==0) {//Pesos
							$html =$html ."<td>$ ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								$html =$html ."<td>$ ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									$html =$html ."<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ round($rowFyF[4],2)-round($Pagos,2);}
						}	
						//Comun a todas las monedas
					$html =$html ."<td>$ ".number_format($Suma,2,'.',',')."</td>";
					
					//generamos la consulta para el vencimiento de la factura.	
					//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
					//Padre 17 es la forma de pago. No lo puedo cambiar
					if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17'")) die("Problemas con la consulta forma de pago en controlpanel");
					$rowplazoFactura = mysqli_fetch_array($plazoFactura);
					$tmpFP = explode(',', $rowplazoFactura['ContenidoValor']);
					$CbteFch =strtotime($rowFechaId[0]."+ ".$tmpFP[1]." days");	
					$datee= date("d/m/Y", $CbteFch);	
					$Faltan=date("z", $CbteFch-time());
					if ((($Faltan<10)&&($Faltan>=1))) {
						//Faltan menos de 10 días para el vencimiento 
						$html =$html ."<td bgcolor='#FFFF00'>".$datee."</td>";
					} else {
						if ((($Faltan<1)||($CbteFch<=time()))){
							//Faltan menos de 1 día para el vencimiento 
							$html =$html ."<td bgcolor='#FF0000'>".$datee."</td>";
						} else {
							//Falta....
							$html =$html ."<td>".$datee."</td>";
						}
					}
					$html =$html ."</tr>";

			
	
				}
			}
			$html =$html ."</table>";
			$html = $html ."<br></br>";
			$totalGeneral=$totalGeneral+$Suma;
			//echo "Total $ ".$totalGeneral."</td>";
		}
	}
	$html = $html ."<br></br>";
	$html =$html ."Total:    $ ".number_format($totalGeneral, 2, ',', '.')."";

	
	


$pdf->writeHTML($html, true, false, true, false, '');




- - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------



	
//Close and output PDF document
		$pdf->Output('Deudores '.date("dmy").'.pdf', 'I');
	

//============================================================+
// END OF FILE
//============================================================+
