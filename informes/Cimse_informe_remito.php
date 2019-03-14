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
	public function Header() {
//============================================================+
//TEXTOS DEL HEADER
		
$this->SetY(44);
$this->SetX(159);
$this->SetFont('helvetica', 'B', 12);
$this->Cell(1, 1, date('d').'/'.date('m').'/'.date('Y'), 0, false, 'L', 0, '', 0, false, 'M', 'M');

//============================================================+
// LOGOS DEL HEADER
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
		$this->SetY(-14);
		//$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//margin top indica donde termina el header y empieza el formulario
$pdf->SetMargins(PDF_MARGIN_LEFT-5, PDF_MARGIN_TOP+8, PDF_MARGIN_RIGHT);
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
$pdf->MultiCell(20, 12, '', 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');

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
$pdf->MultiCell(100, 6, $txt, 0, 'L', 0, 0, '', '', true, 0, false, true, 40, 'T');
//Luego el numero de Factura (alcanza hasta 3). $ln=1 para si hacer salto de linea.
$txt = substr($reg['UsuarioModificacion'],0,27);
$pdf->MultiCell(90, 6, $txt, 0, 'L', 0, 1, '', '', true, 0, false, true, 40, 'T');


// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
	$html = '
<table border="0" width="105%"{border-collapse: collapse;}>
	<tr>
		<th align="left" width="4%"></th>
		<th align="left" width="8%"></th>
		<th align="left" width="88%"></th>';
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
	<td ></td>
	<td style="font-size:0.95em; font-weight:normal; text-align: left">'.$rowDetalle['Cantidad'].'</td>
		<td style="font-size:0.95em; font-weight:normal">'.$rowProd['descricpcion'].'</td>


	</tr>';
	
	//DETALLE DEL ARTICULO
	IF ($_REQUEST['descr']=='1'){
	$html = $html .'<tr>
	<td ></td>
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
