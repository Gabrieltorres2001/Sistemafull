<?php
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
			echo "Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")";
			echo "Comprobantes de este cliente SIN CANCELAR:";
			echo "<table class='display' id='tablaDetalleFacturas'>";  
			echo "<tr>";   
			echo "<th width='2'>Tipo</th>"; 
			echo "<th width='4'>Numero</th>";  
			echo "<th width='6'>Fecha</th>"; 
			echo "<th width='6'>Importe Total</th>"; 
			echo "<th width='6'>Pagado</th>";
			echo "<th width='6'>Acumulado</th>"; 
			echo "<th width='6'>Vencimiento</th>"; 
			echo "</tr>"; 			
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
					echo "<tr>";   
					echo "<td>$rowFyF[2]</td>";   
					echo "<td>$rowFyF[3]</td>"; 
					echo "<td>".substr($rowFechaId[0],8,2)."/".substr($rowFechaId[0],5,2)."/".substr($rowFechaId[0],0,4)."</td>"; 
						
						if ($rowFechaId[2]==60) {//Euros
							echo "<td>€ ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								echo "<td>€ ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									echo "<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$euro);}
						}
						
						if ($rowFechaId[2]==1) {//Dolares
							echo "<td>USD ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								echo "<td>USD ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									echo "<td>Dif. en TC</td>";
							}			
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ ((round($rowFyF[4],2)-round($Pagos,2))*$Dolar);}
						}
						
						if ($rowFechaId[2]==0) {//Pesos
							echo "<td>$ ".number_format($rowFyF[4],2,'.',',')."</td>";
							if ($errorTcPagoFactura==0){
								echo "<td>$ ".number_format($Pagos,2,'.',',')."</td>";	
								} else {
									echo "<td>Dif. en TC</td>";
							}		
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB') {$Suma=$Suma+ round($rowFyF[4],2)-round($Pagos,2);}
						}	
						//Comun a todas las monedas
					echo "<td>$ ".number_format($Suma,2,'.',',')."</td>";
					
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
						echo "<td bgcolor='#FFFF00'>".$datee."</td>";
					} else {
						if ((($Faltan<1)||($CbteFch<=time()))){
							//Faltan menos de 1 día para el vencimiento 
							echo "<td bgcolor='#FF0000'>".$datee."</td>";
						} else {
							//Falta....
							echo "<td>".$datee."</td>";
						}
					}
					echo "</tr>";

			
	
				}
			}
			echo "</table>";
			
			$totalGeneral=$totalGeneral+$Suma;
			//echo "Total $ ".$totalGeneral."</td>";
		}
	}
	echo "<table class='display' id='tablaTotalGral'>";  
			echo "<tr>";   
			echo "<th width='12'>Total</th>"; 
			echo "</tr>"; 
			echo "<tr>";
			echo "<td> $ ".number_format($totalGeneral,2,'.',',')."</td>";
			echo "</tr>"; 
	echo "</table>";
	echo"<input type='button' id='imprimirDeudoresPDF' value='Exportar PDF'>";
	
	
	
	



	


	
	
