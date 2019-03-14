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
	
	//echo $_REQUEST['Canceladas'];
	if ($_REQUEST['Canceladas']=='true'){
		//echo "todas";
		//mostrar todas
			$Suma=0;
			if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$_REQUEST['CUIT']."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
			$reg = mysqli_fetch_array($result);
			echo "Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")";
			echo "Comprobantes de este cliente desde: ".substr($_REQUEST['desde'],8,2)."/".substr($_REQUEST['desde'],5,2)."/".substr($_REQUEST['desde'],0,4)." hasta: ".substr($_REQUEST['hasta'],8,2)."/".substr($_REQUEST['hasta'],5,2)."/".substr($_REQUEST['hasta'],0,4);
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
					if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
					$rowplazoFactura = mysqli_fetch_array($plazoFactura);
					$tmpplazoFactura = explode(',', $rowplazoFactura['ContenidoValor']);	
					$CbteFch =strtotime($rowFechaId[0]."+ ".$tmpplazoFactura[1]." days");	
					if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB'){$datee= date("d/m/Y", $CbteFch);} else {$datee="--/--/--";}	
					$Faltan=date("z", $CbteFch-time());
					if ((($Faltan<10)&&($Faltan>=1)&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')) {
						//Faltan menos de 10 días para el vencimiento 
						echo "<td bgcolor='#FFFF00'>".$datee."</td>";
					} else {
						if (((($Faltan<1)||($CbteFch<=time()))&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')){
							//Faltan menos de 1 día para el vencimiento 
							echo "<td bgcolor='#FF0000'>".$datee."</td>";
						} else {
							//Falta....
							echo "<td>".$datee."</td>";
						}
					}
					echo "</tr>";
					//ACA TENGO QUE LISTAR LOS PAGOS				
					echo "<tr>";
					echo "<td colspan='1'>";
					echo "</td>";
					echo "<td colspan='6'>";
						//Busco los pagos
						if(!$resultPagos = mysqli_query($conexion_sp, "select * from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondos2");
						if (mysqli_num_rows($resultPagos)>0){
							echo "Movimientos asociados a este comprobante:";
							echo"<ul class='nav navbar-nav'>";
							echo"</ul>";
							echo "<table class='display' id='tablaDetallePagos' style='font-size:10px'>";  
							echo "<tr>";   
							echo "<th width='10'>Fecha</th>";   
							echo "<th width='12'>Forma de pago</th>"; 
							echo "<th width='4'>Moneda</th>"; 
							echo "<th width='4'>Importe</th>"; 
							echo "<th width='16'>Descripcion</th>";
							echo "</tr>";  
							while ($regresultPagos = mysqli_fetch_row($resultPagos)){  
								//Busco todos los pagos
								if(!$monedaPago = mysqli_query($conexion_sp, "select Origen from monedaorigen where IdRegistroCambio='".$regresultPagos[6]."' limit 1")) die("Problemas con la consulta2");
								$rowmonedaPago = mysqli_fetch_array($monedaPago);
								if(!$formaPago = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$regresultPagos[5]."' limit 1")) die("Problemas con la consulta3");
								$rowformaPago = mysqli_fetch_array($formaPago);
								echo "<tr id='pago&$regresultPagos[0]'>";    
								echo "<td name='xxxx' id='pago&$regresultPagos[0]' height='50'>".substr($regresultPagos[2],8,2)."/".substr($regresultPagos[2],5,2)."/".substr($regresultPagos[2],0,4)."</td>";  
								echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".$rowformaPago['Descripcion']."</td>";	
								echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".$rowmonedaPago['Origen']."</td>";
								echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".number_format($regresultPagos[7],2)."</td>";
								echo "<td name='xxxx' id='pago&$regresultPagos[0]'>$regresultPagos[3]</td>";
								echo "</tr>";	
							}  
							echo "</table>";
						} else {
								echo "No se registran movimientos asociados a este comprobante.";
						}
					echo "</td>";
					echo "</tr>";
				}
			}
			echo "</table>";	
		
	} else {
		//mostrar solo las adeudadas
		//echo "adeudadas";
			$Suma=0;
			if(!$result = mysqli_query($conexion_sp, "select distinct Organizacion, CUIT from organizaciones where CUIT='".$_REQUEST['CUIT']."' ORDER BY Organizacion asc limit 1")) die("Problemas con la consulta");
			$reg = mysqli_fetch_array($result);
			echo "Empresa: ".substr($reg['Organizacion'],0,33)." (".substr($reg['CUIT'],0,18).")";
			echo "Comprobantes de este cliente SIN CANCELAR desde: ".substr($_REQUEST['desde'],8,2)."/".substr($_REQUEST['desde'],5,2)."/".substr($_REQUEST['desde'],0,4)." hasta: ".substr($_REQUEST['hasta'],8,2)."/".substr($_REQUEST['hasta'],5,2)."/".substr($_REQUEST['hasta'],0,4);
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
						if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
						$rowplazoFactura = mysqli_fetch_array($plazoFactura);
						$tmpplazoFactura = explode(',', $rowplazoFactura['ContenidoValor']);	
						$CbteFch =strtotime($rowFechaId[0]."+ ".$tmpplazoFactura[1]." days");	
						if (($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB'){$datee= date("d/m/Y", $CbteFch);} else {$datee="--/--/--";}
						$Faltan=date("z", $CbteFch-time());
						if ((($Faltan<10)&&($Faltan>=1)&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')) {
							//Faltan menos de 10 días para el vencimiento 
							echo "<td bgcolor='#FFFF00'>".$datee."</td>";
						} else {
							if (((($Faltan<1)||($CbteFch<=time()))&&(round($rowFyF[4],2) > round($Pagos,2)))&&(($rowFyF[2])<>'NCA' And ($rowFyF[2])<>'NCB')){
								//Faltan menos de 1 día para el vencimiento 
								echo "<td bgcolor='#FF0000'>".$datee."</td>";
							} else {
								//Falta....
								echo "<td>".$datee."</td>";
							}
						}
						echo "</tr>";
						//ACA TENGO QUE LISTAR LOS PAGOS				
						echo "<tr>";
						echo "<td colspan='1'>";
						echo "</td>";
						echo "<td colspan='6'>";
							//Busco los pagos
							if(!$resultPagos = mysqli_query($conexion_sp, "select * from fondos where IDComprobante='".$rowFyF[1]."' and Tipo='1' order by ID")) die("Problemas con la consulta fondos2");
							if (mysqli_num_rows($resultPagos)>0){
								echo "Movimientos asociados a este comprobante:";
								echo"<ul class='nav navbar-nav'>";
								echo"</ul>";
								echo "<table class='display' id='tablaDetallePagos' style='font-size:10px'>";  
								echo "<tr>";   
								echo "<th width='10'>Fecha</th>";   
								echo "<th width='12'>Forma de pago</th>"; 
								echo "<th width='4'>Moneda</th>"; 
								echo "<th width='4'>Importe</th>"; 
								echo "<th width='16'>Descripcion</th>";
								echo "</tr>";  
								while ($regresultPagos = mysqli_fetch_row($resultPagos)){  
									//Busco todos los pagos
									if(!$monedaPago = mysqli_query($conexion_sp, "select Origen from monedaorigen where IdRegistroCambio='".$regresultPagos[6]."' limit 1")) die("Problemas con la consulta2");
									$rowmonedaPago = mysqli_fetch_array($monedaPago);
									if(!$formaPago = mysqli_query($conexion_sp, "select Descripcion from tipos where ID='".$regresultPagos[5]."' limit 1")) die("Problemas con la consulta3");
									$rowformaPago = mysqli_fetch_array($formaPago);
									echo "<tr id='pago&$regresultPagos[0]'>";    
									echo "<td name='xxxx' id='pago&$regresultPagos[0]' height='50'>".substr($regresultPagos[2],8,2)."/".substr($regresultPagos[2],5,2)."/".substr($regresultPagos[2],0,4)."</td>";  
									echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".$rowformaPago['Descripcion']."</td>";	
									echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".$rowmonedaPago['Origen']."</td>";
									echo "<td name='xxxx' id='pago&$regresultPagos[0]'>".number_format($regresultPagos[7],2)."</td>";
									echo "<td name='xxxx' id='pago&$regresultPagos[0]'>$regresultPagos[3]</td>";
									echo "</tr>";
								}  
								echo "</table>";
							} else {
									echo "No se registran movimientos asociados a este comprobante.";
							}								
						echo "</td>";
						echo "</tr>";
					}
				}
			}
				echo "</table>";	
			
	}