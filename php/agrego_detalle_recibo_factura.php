<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");

//Nueva Marzo 2019. Primero pregunto si lo que voy a agregar NO ES una factura, sino un REDONDEO o ACUENTA
if ($_REQUEST['idcomprobante']=='99999999017') {
	//Redondeo
	if(!$resultact = mysqli_query($conexion_sp, "insert into detallecomprobante (idcomprobante, IdProducto, Moneda, CostoUnitario, Descuento, Subtotal, Destino) values ('".$_REQUEST['idRecibo']."', '0', '1', '0', '1', '0', 'REDONDEO')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		die("Problemas con la consulta de agregar item al comprobante");
	}	else {
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo agregado</label>";
	};
} else {if ($_REQUEST['idcomprobante']=='99999999025') {
			//A Cuenta
			if(!$resultact = mysqli_query($conexion_sp, "insert into detallecomprobante (idcomprobante, IdProducto, Moneda, CostoUnitario, Descuento, Subtotal, Destino) values ('".$_REQUEST['idRecibo']."', '0', '1', '0', '1', '0', 'ACUENTA')")){
				echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
				die("Problemas con la consulta de agregar item al comprobante");
			}	else {
				echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo agregado</label>";
			};
	} else {
		//Ahora si es una factura
				
				
			//Primero busco los pagos que ya pueda tener efectuados la factura seleccionada
			if(!$resultComprobante = mysqli_query($conexion_sp, "select FechaFactura, TipoFactura, NumeroFactura, ImporteTotal, IdEnviado, CAE from caeafip where Id='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta2");
			$rowComprobante = mysqli_fetch_array($resultComprobante);
			//Luego busco el tipo de cambio usado, en la tabla 
			if(!$tipoCambioUsado = mysqli_query($conexion_sp, "select tipoCambio from datosauxfacturasemitidas where CAE = '".$rowComprobante['CAE']."' limit 1")) die("Problemas con la consulta forma de pago en datosauxfacturasemitidas");	
			$rowtipoCambioUsado = mysqli_fetch_array($tipoCambioUsado);

			//Luego busco el símbolo para la moneda facturada
			$codigoMoneda=$rowComprobante['IdEnviado']+1;
			if(!$monedaComprobante = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$codigoMoneda."' limit 1")) die("Problemas con la consulta monedaorigen");
			$rowMonedaComprobante = mysqli_fetch_array($monedaComprobante);
				//Importe a cancelar (en moneda original). NO es el total de la factura, es lo restante de pagar.
			if ($rowComprobante['IdEnviado']==60) {
				//La factura o ND es en Euros
				//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" 
				if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1'")) die("Problemas con la consulta fondos");	
				$pagos=0;
				$errorTcPagoFactura=0;
				while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
					if ($rowresultPagosFondos[1]==($rowComprobante['IdEnviado']+1)) {
						$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
					} else {
						//No coincide la moneda del pago con la moneda de la factura
						//$pagos="Error en TC";
						$pagos=0;
						$errorTcPagoFactura=1;
					}
				}
				$pendiente=(number_format($rowComprobante['ImporteTotal'],2,'.',''))-$pagos;
				} elseif ($rowComprobante['IdEnviado']==1) {
					//La factura o ND es en Dolares
					//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" 
					if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1'")) die("Problemas con la consulta fondos");
					$pagos=0;
					$errorTcPagoFactura=0;
					while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
						if (($rowComprobante['IdEnviado']+1)==$rowresultPagosFondos[1]) {
							$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
						} else {
							//No coincide la moneda del pago con la moneda de la factura
							//$pagos="Error en TC";
							$pagos=0;
							$errorTcPagoFactura=1;
						}
					}
					$pendiente=(number_format($rowComprobante['ImporteTotal'],2,'.',''))-$pagos;
						} else {
							//La factura o ND es en Pesos
							//aca tengo que buscar los pagos registrados, ponerlos en la columna "Pendiente" 
							if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe, MonedaPago from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1'")) die("Problemas con la consulta fondos");
							$pagos=0;
							$errorTcPagoFactura=0;
							while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
								if ($rowresultPagosFondos[1]==($rowComprobante['IdEnviado']+1)) {
									$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
								} else {
									//No coincide la moneda del pago con la moneda de la factura
									//$pagos="Error en TC";
									$pagos=0;
									$errorTcPagoFactura=1;
								}
							}
							$pendiente=(number_format($rowComprobante['ImporteTotal'],2,'.',''))-$pagos;					
							}


			if ($errorTcPagoFactura==0){//Todo bien con los pagos (se hicieron enla misma moneda que la factura)
			} else {//Mal con los pagos, pongo el pendiente en cero 
			$pendiente=0;}

			$SubTotAPagar=(number_format($pendiente*$rowtipoCambioUsado['tipoCambio'],2,'.',''));

				//generamos la consulta de actualizacion
				if(!$resultact = mysqli_query($conexion_sp, "insert into detallecomprobante (idcomprobante, IdProducto, Moneda, CostoUnitario, Descuento, Subtotal, Destino) values ('".$_REQUEST['idRecibo']."', '".$_REQUEST['idcomprobante']."', '".$rowComprobante['IdEnviado']."', '".$pendiente."', '".$rowtipoCambioUsado['tipoCambio']."', '".$SubTotAPagar."', 'LIQUIDACION')")){
					echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
					die("Problemas con la consulta de agregar item al comprobante");
				}	else {
					echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo agregado</label>";
				};
				
			}
		}