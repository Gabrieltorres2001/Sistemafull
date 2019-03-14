<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//Primero busco todas las facturas registradas para el CUIT en la tabla FondosyFacturas
	if(!$resultFondosyFacturas = mysqli_query($conexion_sp, "select distinct idCaeAfip from fondosyfacturas where CUIT='".$_REQUEST['cuitemp']."'")) die("Problemas con la consulta FondosyFacturas");
	//$regFondosyFacturas = mysqli_fetch_array($resultFondosyFacturas);
	
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Euro, Dolar from cotizacionesnew ORDER BY Id desc limit 1")) die("Problemas con la consulta");
	$reg = mysqli_fetch_array($result);  
	$euro=$reg['Euro'];	
	$Dolar=$reg['Dolar'];
	
//Falta buscar todos los pagos (1. Para listar los que NO tienen facturas asociadas y 2. Para listar los que SI tienen facturas asociadas)

//echo"<ul class='nav navbar-nav'>";
//echo"</ul>";
$Total=0;
$notaCredito=0;
//echo "<img name='xxxxB' id='$row[0]&$row[2]&imagenOk' src='./images/recargar.png' width='32' height='32'>";
echo "Comprobantes de este cliente SIN CANCELAR:";
echo "<table class='display' id='tablaDetalleFacturas'>";  
echo "<tr>";   
echo "<th width='2'>Tipo</th>"; 
echo "<th width='4'>Numero</th>";  
echo "<th width='6'>Fecha</th>"; 
echo "<th width='6' align='center'>Importe Total</th>"; 
echo "<th width='6'>Pendiente</th>";
echo "<th width='6' align='center'>Acumulado (en $)</th>";; 
echo "<th width='6'>Vencimiento</th>"; 
//echo "<th width='4'></th>"; 
echo "</tr>";   
while ($rowFyF = mysqli_fetch_row($resultFondosyFacturas)){  
	//generamos la consulta DE BUSCAR LAS FACTURAS EMITIDAS
	if(!$resultDetalle = mysqli_query($conexion_sp, "select Id, NumeroFactura, TipoFactura, FechaFactura, ImporteTotal, IdComprobante, IdEnviado from caeafip where Id='".$rowFyF[0]."' order by Id")) die("Problemas con la consulta2");
	if ($row = mysqli_fetch_row($resultDetalle)){  	
		if ($row[2]=='NCA'||$row[2]=='NCB'){$notaCredito=1;
		} else {
			$notaCredito=0;
		}
		//Hasta aca es igual que buscar_facturas_x_cuit.php voy a tratar de hacer el codigo a partir de ese
		if ($notaCredito==1){
					
		} else {
			//$notaCredito<>1: factura o ND		
			if ($row[6]==60) {
			//La factura o ND es en Euros

			//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" y ademas
			//restarlos del total
			if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$row[0]."' and Tipo='1'")) die("Problemas con la consulta fondos");	
			$pagos=0;
			$errorTcPagoFactura=0;
			while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
				if ($rowresultPagosFondos[1]==($row[6]+1)) {
					$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
				} else {
					//No coincide la moneda del pago con la moneda de la factura
					//$pagos="Error en TC";
					$pagos=0;
					$errorTcPagoFactura=1;
				}
			}
			$pendiente=(number_format($row[4],2,'.',''))-$pagos;

			if ($pendiente>0){
				echo "<tr id='$row[0]'>";   
				echo "<td name='FilaFactura' id='$row[0]'>$row[2]</td>";   
				echo "<td name='FilaFactura' id='$row[0]'>$row[1]</td>"; 
				echo "<td name='FilaFactura' id='$row[0]'>".substr($row[3],8,2)."/".substr($row[3],5,2)."/".substr($row[3],0,4)."</td>";
		
				echo "<td name='FilaFactura' id='$row[0]'>€ ".number_format($row[4],2,'.',',')."</td>";
				
				if ($errorTcPagoFactura==0){
					echo "<td name='FilaFactura' id='$row[0]'>€ ".number_format($pendiente,2,'.',',')."</td>";	
				} else {
					echo "<td name='FilaFactura' id='$row[0]'>Dif. en TC</td>";
				}
					
				//Tengo que multiplicar el pendiente por el tipo de cambio para sumarlo al total pendiente
				$Total=$Total+($pendiente*$euro);	
				echo "<td name='FilaFactura' id='$row[0]'>$ ".number_format($Total,2,'.',',')."</td>";
				
				//Busco el vencimiento de la factura desde la tabla comprobantes
				if(!$resultComprobante = mysqli_query($conexion_sp, "select CondicionesPago from comprobantes where TipoComprobante=3 and IdComprobante='".$row[5]."' limit 1")) die("Problemas con la consulta comprobantes");
				$regComprobante = mysqli_fetch_array($resultComprobante);  	
				//generamos la consulta para el vencimiento de la factura.	
				//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
				//Padre 17 es la forma de pago. No lo puedo cambiar
				if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
				$rowplazoFactura = mysqli_fetch_array($plazoFactura);
				$tmpplazoFactura = explode(',', $rowplazoFactura['ContenidoValor']);	
				$CbteFch =strtotime($row[3]."+ ".$tmpplazoFactura[1]." days");	
				$datee= date("d/m/Y", $CbteFch);	
				$Faltan=date("z", $CbteFch-time());
				if ((($Faltan<10)&&($Faltan>=1))&&($pendiente>0)) {
					//Faltan menos de 10 días para el vencimiento 
					echo "<td name='FilaFactura' bgcolor='#FFFF00' id='$row[0]'>".$datee."</td>";
				} else {
					if ((($Faltan<1)||($CbteFch<=time()))&&($pendiente>0)){
						//Faltan menos de 1 día para el vencimiento 
						echo "<td name='FilaFactura' bgcolor='#FF0000' id='$row[0]'>".$datee."</td>";
					} else {
						//Falta....
						echo "<td name='FilaFactura' id='$row[0]'>".$datee."</td>";
					}
				}			
				echo "</tr>";
			}			
			
			} elseif ($row[6]==1) {
				//La factura o ND es en Dolares
				
				//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" y ademas
				//restarlos del total
				if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$row[0]."' and Tipo='1'")) die("Problemas con la consulta fondos");
				$pagos=0;
				$errorTcPagoFactura=0;
				while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
					if (($row[6]+1)==$rowresultPagosFondos[1]) {
						$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
					} else {
						//No coincide la moneda del pago con la moneda de la factura
						//$pagos="Error en TC";
						$pagos=0;
						$errorTcPagoFactura=1;
					}
				}
				$pendiente=(number_format($row[4],2,'.',''))-$pagos;
				if ($pendiente>0){
					echo "<tr id='$row[0]'>";   
					echo "<td name='FilaFactura' id='$row[0]'>$row[2]</td>";   
					echo "<td name='FilaFactura' id='$row[0]'>$row[1]</td>"; 
					echo "<td name='FilaFactura' id='$row[0]'>".substr($row[3],8,2)."/".substr($row[3],5,2)."/".substr($row[3],0,4)."</td>";
			
					echo "<td name='FilaFactura' id='$row[0]'>USD ".number_format($row[4],2,'.',',')."</td>";
					
					if ($errorTcPagoFactura==0){
						echo "<td name='FilaFactura' id='$row[0]'>USD ".number_format($pendiente,2,'.',',')."</td>";	
					} else {
						echo "<td name='FilaFactura' id='$row[0]'>Dif. en TC</td>";
					}
						
					//Tengo que multiplicar el pendiente por el tipo de cambio para sumarlo al total pendiente
					$Total=$Total+($pendiente*$Dolar);	
					echo "<td name='FilaFactura' id='$row[0]'>$ ".number_format($Total,2,'.',',')."</td>";

					//Busco el vencimiento de la factura desde la tabla comprobantes
					if(!$resultComprobante = mysqli_query($conexion_sp, "select CondicionesPago from comprobantes where TipoComprobante=3 and IdComprobante='".$row[5]."' limit 1")) die("Problemas con la consulta comprobantes");
					$regComprobante = mysqli_fetch_array($resultComprobante);  	
					//generamos la consulta para el vencimiento de la factura.	
					//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
					//Padre 17 es la forma de pago. No lo puedo cambiar
					if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
					$rowplazoFactura = mysqli_fetch_array($plazoFactura);
					$tmpplazoFactura = explode(',', $rowplazoFactura['ContenidoValor']);	
					$CbteFch =strtotime($row[3]."+ ".$tmpplazoFactura[1]." days");	
					$datee= date("d/m/Y", $CbteFch);	
					$Faltan=date("z", $CbteFch-time());
					if ((($Faltan<10)&&($Faltan>=1))&&($pendiente>0)) {
						//Faltan menos de 10 días para el vencimiento 
						echo "<td name='FilaFactura' bgcolor='#FFFF00' id='$row[0]'>".$datee."</td>";
					} else {
						if ((($Faltan<1)||($CbteFch<=time()))&&($pendiente>0)){
							//Faltan menos de 1 día para el vencimiento 
							echo "<td name='FilaFactura' bgcolor='#FF0000' id='$row[0]'>".$datee."</td>";
						} else {
							//Falta....
							echo "<td name='FilaFactura' id='$row[0]'>".$datee."</td>";
						}
					}			

					echo "</tr>";
					}	
							
					} else {
						//La factura o ND es en Pesos
						
						//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" y ademas
						//restarlos del total
						if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$row[0]."' and Tipo='1'")) die("Problemas con la consulta fondos");
						$pagos=0;
						$errorTcPagoFactura=0;
						while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
							if ($rowresultPagosFondos[1]==($row[6]+1)) {
								$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
							} else {
								//No coincide la moneda del pago con la moneda de la factura
								//$pagos="Error en TC";
								$pagos=0;
								$errorTcPagoFactura=1;
							}
						}
						$pendiente=(number_format($row[4],2,'.',''))-$pagos;
						if ($pendiente>0){
							echo "<tr id='$row[0]'>";   
							echo "<td name='FilaFactura' id='$row[0]'>$row[2]</td>";   
							echo "<td name='FilaFactura' id='$row[0]'>$row[1]</td>"; 
							echo "<td name='FilaFactura' id='$row[0]'>".substr($row[3],8,2)."/".substr($row[3],5,2)."/".substr($row[3],0,4)."</td>";
					
							echo "<td name='FilaFactura' id='$row[0]'>$ ".number_format($row[4],2,'.',',')."</td>";
							
							if ($errorTcPagoFactura==0){
								echo "<td name='FilaFactura' id='$row[0]'>$ ".number_format($pendiente,2,'.',',')."</td>";	
							} else {
								echo "<td name='FilaFactura' id='$row[0]'>Dif. en TC</td>";
							}
								
							//Tengo que multiplicar el pendiente por el tipo de cambio para sumarlo al total pendiente
							$Total=$Total+($pendiente);	
							echo "<td name='FilaFactura' id='$row[0]'>$ ".number_format($Total,2,'.',',')."</td>";

							//Busco el vencimiento de la factura desde la tabla comprobantes
							if(!$resultComprobante = mysqli_query($conexion_sp, "select CondicionesPago from comprobantes where TipoComprobante=3 and IdComprobante='".$row[5]."' limit 1")) die("Problemas con la consulta comprobantes");
							$regComprobante = mysqli_fetch_array($resultComprobante);  	
							//generamos la consulta para el vencimiento de la factura.	
							//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
							//Padre 17 es la forma de pago. No lo puedo cambiar
							if(!$plazoFactura = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regComprobante['CondicionesPago']."' and padre='17' limit 1")) die("Problemas con la consulta forma de pago en controlpanel");
							$rowplazoFactura = mysqli_fetch_array($plazoFactura);
							$tmpplazoFactura = explode(',', $rowplazoFactura['ContenidoValor']);	
							$CbteFch =strtotime($row[3]."+ ".$tmpplazoFactura[1]." days");	
							$datee= date("d/m/Y", $CbteFch);	
							$Faltan=date("z", $CbteFch-time());
							if ((($Faltan<10)&&($Faltan>=1))&&($pendiente>0)) {
								//Faltan menos de 10 días para el vencimiento 
								echo "<td name='FilaFactura' bgcolor='#FFFF00' id='$row[0]'>".$datee."</td>";
							} else {
								if ((($Faltan<1)||($CbteFch<=time()))&&($pendiente>0)){
									//Faltan menos de 1 día para el vencimiento 
									echo "<td name='FilaFactura' bgcolor='#FF0000' id='$row[0]'>".$datee."</td>";
								} else {
									//Falta....
									echo "<td name='FilaFactura' id='$row[0]'>".$datee."</td>";
								}
							}			

							echo "</tr>";
							}							
												
						}
		}	
	} 
}
//Falta agregar los campos a cuenta y redondeo, despues veo como los agrego al detalle comprobante
//A CUENTA
echo "<tr>";   
echo "<td name='FilaFactura' id='99999999025'></td>"; 
echo "<td name='FilaFactura' id='99999999025'>A cuenta</td>";  
echo "<td name='FilaFactura' id='99999999025'></td>"; 
echo "<td name='FilaFactura' id='99999999025'></td>"; 
echo "<td name='FilaFactura' id='99999999025'></td>";
echo "<td name='FilaFactura' id='99999999025'></td>";; 
echo "<td name='FilaFactura' id='99999999025'></td>"; 
echo "</tr>";  
//REDONDEO
echo "<tr>";   
echo "<td name='FilaFactura' id='99999999017'></td>"; 
echo "<td name='FilaFactura' id='99999999017'>Redondeo</td>";  
echo "<td name='FilaFactura' id='99999999017'></td>"; 
echo "<td name='FilaFactura' id='99999999017'></td>"; 
echo "<td name='FilaFactura' id='99999999017'></td>";
echo "<td name='FilaFactura' id='99999999017'></td>";; 
echo "<td name='FilaFactura' id='99999999017'></td>"; 
echo "</tr>";  

echo "</table>";
		
		
		
		
		
		
		
		
		
		
		
		
		
	