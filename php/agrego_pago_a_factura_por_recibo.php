<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$pagos=0;
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//Transformo los fondos tipo 2 (recibos) en tipo 1 (facturas). PERO NO UNO A UNO!!, sino por número de recibo
//Primero tengo que buscar todas las facturas que el usuario seleccionó pagar en la venta de recibos, junto con el importe que elijió pagar (el TC y el importe en pesos no importan)
if(!$resultComprobante = mysqli_query($conexion_sp, "select idcomprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, Notas, Confecciono, Solicito, NumeroComprobante02, UsuarioModificacion, OCEnviada from comprobantes where NumeroComprobante='".$_REQUEST['idrecibo']."' and TipoComprobante='14' limit 1")) die("Problemas con la consulta1");
$regComprobante = mysqli_fetch_array($resultComprobante);  
//Busco todas las facturas que tiene este recibo (por que las facturas? porque a cada una de las facturas le voy a asignar EL RECIBO (no los fondos) como un pago)
//Donde estan las facturas? En detalle comprobante
if(!$resultFacturas = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$regComprobante['idcomprobante']."' and Destino='LIQUIDACION' order by Orden")) die("Problemas con la consulta detallecomprobante");
$ultimoIdFactura=0;
while ($row = mysqli_fetch_array($resultFacturas)){  
	//Busco datos auxiliares en otras tablas
	if(!$resultCaeAfip = mysqli_query($conexion_sp, "select * from caeafip where Id='".$row['IdProducto']."' limit 1")) die("Problemas con la consulta caeafip");
	$regCaeAfip = mysqli_fetch_array($resultCaeAfip); 
	//generamos la consulta de actualizacion
	$monedaPAgo=$regCaeAfip['IdEnviado']+1;
	$ultimoIdFactura=$row['IdProducto'];
	if(!$resultact = mysqli_query($conexion_sp, "insert into fondos (Tipo, IDComprobante, Fecha, Descripcion, TipoValor, MonedaPago, Importe, CUIT,  	actualiz) values ('1', '".$row['IdProducto']."', '".$regComprobante['FechaComprobante']."', 'Recibo Nº 0002 - ".str_pad($regComprobante['NumeroComprobante'], 8,"0", STR_PAD_LEFT)."', '20', '".$monedaPAgo."', '".$row['CostoUnitario']."', '".$regCaeAfip['CUITCliente']."', now())")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar pago");
	}	else {
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Pago agregado</label>";
		$idresultact=mysqli_insert_id($conexion_sp);
	};
	//Tambien registrar el pago en la tabla fondosyfacturas. En este caso asociado a una factura. Primero tengo que ver si la factura tiene algun pago (campo idFondo NULL), si ya tiene tengo que agregar un nuevo registro con numero de factura, fondo y CAE.
	if(!$resultFyF = mysqli_query($conexion_sp, "select idRegistro from fondosyfacturas where idCaeAfip='".$row['IdProducto']."' and idFondo = NULL limit 1")) die("Problemas con la consulta2");
	if ($rowresultFyF = mysqli_fetch_array($resultFyF)){  
		//Hay registro que cumple
		if(!$resultactFyF = mysqli_query($conexion_sp, "update fondosyfacturas set idFondo = '".$idresultact."' where idRegistro = '".$rowresultFyF['idRegistro']."'")){
			//echo"FyF NO actualizado";
			die("Problemas con la consulta de actualizacion FyF");
		}
		else {
			//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF actualizado</label>";
			//echo"<br />";
		};		
		} else {
			//No hay registro. Tengo que hacer uno
			if(!$resultagrFyF = mysqli_query($conexion_sp, "insert into fondosyfacturas (idFondo, idCaeAfip, CUIT) values ('".$idresultact."', '".$row['IdProducto']."', '".$regCaeAfip['CUITCliente']."')")){
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF No agregado</label>";
				 die("Problemas con la consulta de agregar pago");
			}	else {
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF agregado</label>";
			};
		}
	}
//Ahora agrego ACUENTA y REDONDEO (si existen) a la última factura
//ACUENTA
if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$regComprobante['idcomprobante']."' and Destino='ACUENTA' limit 1")) die("Problemas con la consulta2");
while ($row = mysqli_fetch_array($resultDetalle)){
	if (!$ultimoIdFactura==0) {
		//Busco datos auxiliares en otras tablas
		if(!$resultCaeAfip = mysqli_query($conexion_sp, "select * from caeafip where Id='".$ultimoIdFactura."' limit 1")) die("Problemas con la consulta caeafip");
		$regCaeAfip = mysqli_fetch_array($resultCaeAfip); 
		//generamos la consulta de actualizacion
		$monedaPAgo=$regCaeAfip['IdEnviado']+1;
		//PERO ALTO!! NECESITO SABER EL TIPO DE MONEDA DE LA FACTURA, Y CONVERTIR LOS PESOS DE ACUENTA A ESA MISMA MONEDA. Que tipo de cambio? El de la factura o el de hoy?
		//El de hoy. Tengo que buscar el tipo de cambio de hoy de la moneda de la ultima factura
		if ($monedaPAgo=='1'){
				//Pesos
				$importeAContabilizar=$row['CostoUnitario'];
			} else {
				if ($monedaPAgo=='2'){
					//Dolares
					if(!$resultMonedaExtranjera = mysqli_query($conexion_sp, "select Dolar from cotizacionesnew order by Id desc limit 1")) die("Problemas con la consulta cotizacionesnew");
					$regMonedaExtranjera = mysqli_fetch_array($resultMonedaExtranjera); 
					$importeAContabilizar=$row['CostoUnitario']/$regMonedaExtranjera['Dolar'];
				} else {
					//Euros
					if(!$resultMonedaExtranjera = mysqli_query($conexion_sp, "select Euro from cotizacionesnew order by Id desc limit 1")) die("Problemas con la consulta cotizacionesnew");
					$regMonedaExtranjera = mysqli_fetch_array($resultMonedaExtranjera); 
					$importeAContabilizar=$row['CostoUnitario']/$regMonedaExtranjera['Euro'];					
				}
			}
	
		if(!$resultact = mysqli_query($conexion_sp, "insert into fondos (Tipo, IDComprobante, Fecha, Descripcion, TipoValor, MonedaPago, Importe, CUIT,  	actualiz) values ('1', '".$ultimoIdFactura."', '".$regComprobante['FechaComprobante']."', 'Recibo Nº 0002 - ".str_pad($regComprobante['NumeroComprobante'], 8,"0", STR_PAD_LEFT)."', '25', '".$monedaPAgo."', '".$importeAContabilizar."', '".$regCaeAfip['CUITCliente']."', now())")){
			//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
			die("Problemas con la consulta de agregar pago");
		}	else {
			//echo"<label style='font-size:1em; font-weight:bold; color:red'>Pago agregado</label>";
			$idresultact=mysqli_insert_id($conexion_sp);
		};
		//Tambien registrar el pago en la tabla fondosyfacturas. En este caso asociado a una factura. Primero tengo que ver si la factura tiene algun pago (campo idFondo NULL), si ya tiene tengo que agregar un nuevo registro con numero de factura, fondo y CAE.
		if(!$resultFyF = mysqli_query($conexion_sp, "select idRegistro from fondosyfacturas where idCaeAfip='".$ultimoIdFactura."' and idFondo = NULL limit 1")) die("Problemas con la consulta2");
		if ($rowresultFyF = mysqli_fetch_array($resultFyF)){  
			//Hay registro que cumple
			if(!$resultactFyF = mysqli_query($conexion_sp, "update fondosyfacturas set idFondo = '".$idresultact."' where idRegistro = '".$rowresultFyF['idRegistro']."'")){
				//echo"FyF NO actualizado";
				die("Problemas con la consulta de actualizacion FyF");
			}
			else {
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF actualizado</label>";
				//echo"<br />";
			};		
			} else {
				//No hay registro. Tengo que hacer uno
				if(!$resultagrFyF = mysqli_query($conexion_sp, "insert into fondosyfacturas (idFondo, idCaeAfip, CUIT) values ('".$idresultact."', '".$ultimoIdFactura."', '".$regCaeAfip['CUITCliente']."')")){
					//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF No agregado</label>";
					die("Problemas con la consulta de agregar pago");
				}	else {
					//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF agregado</label>";
				};
			}
	}
}
//REDONDEO
if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante='".$regComprobante['idcomprobante']."' and Destino='REDONDEO' limit 1")) die("Problemas con la consulta2");
while ($row = mysqli_fetch_array($resultDetalle)){
	if (!$ultimoIdFactura==0) {
		//Busco datos auxiliares en otras tablas
		if(!$resultCaeAfip = mysqli_query($conexion_sp, "select * from caeafip where Id='".$ultimoIdFactura."' limit 1")) die("Problemas con la consulta caeafip");
		$regCaeAfip = mysqli_fetch_array($resultCaeAfip); 
		//generamos la consulta de actualizacion
		$monedaPAgo=$regCaeAfip['IdEnviado']+1;
		//PERO ALTO!! NECESITO SABER EL TIPO DE MONEDA DE LA FACTURA, Y CONVERTIR LOS PESOS DE REDONDEO A ESA MISMA MONEDA. Que tipo de cambio? El de la factura o el de hoy?
		//El de hoy. Tengo que buscar el tipo de cambio de hoy de la moneda de la ultima factura
		if ($monedaPAgo=='1'){
				//Pesos
				$importeAContabilizar=$row['CostoUnitario'];
			} else {
				if ($monedaPAgo=='2'){
					//Dolares
					if(!$resultMonedaExtranjera = mysqli_query($conexion_sp, "select Dolar from cotizacionesnew order by Id desc limit 1")) die("Problemas con la consulta cotizacionesnew");
					$regMonedaExtranjera = mysqli_fetch_array($resultMonedaExtranjera); 
					$importeAContabilizar=$row['CostoUnitario']/$regMonedaExtranjera['Dolar'];
				} else {
					//Euros
					if(!$resultMonedaExtranjera = mysqli_query($conexion_sp, "select Euro from cotizacionesnew order by Id desc limit 1")) die("Problemas con la consulta cotizacionesnew");
					$regMonedaExtranjera = mysqli_fetch_array($resultMonedaExtranjera); 
					$importeAContabilizar=$row['CostoUnitario']/$regMonedaExtranjera['Euro'];					
				}
			}
	
		if(!$resultact = mysqli_query($conexion_sp, "insert into fondos (Tipo, IDComprobante, Fecha, Descripcion, TipoValor, MonedaPago, Importe, CUIT,  	actualiz) values ('1', '".$ultimoIdFactura."', '".$regComprobante['FechaComprobante']."', 'Recibo Nº 0002 - ".str_pad($regComprobante['NumeroComprobante'], 8,"0", STR_PAD_LEFT)."', '17', '".$monedaPAgo."', '".$importeAContabilizar."', '".$regCaeAfip['CUITCliente']."', now())")){
			//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
			die("Problemas con la consulta de agregar pago");
		}	else {
			//echo"<label style='font-size:1em; font-weight:bold; color:red'>Pago agregado</label>";
			$idresultact=mysqli_insert_id($conexion_sp);
		};
		//Tambien registrar el pago en la tabla fondosyfacturas. En este caso asociado a una factura. Primero tengo que ver si la factura tiene algun pago (campo idFondo NULL), si ya tiene tengo que agregar un nuevo registro con numero de factura, fondo y CAE.
		if(!$resultFyF = mysqli_query($conexion_sp, "select idRegistro from fondosyfacturas where idCaeAfip='".$ultimoIdFactura."' and idFondo = NULL limit 1")) die("Problemas con la consulta2");
		if ($rowresultFyF = mysqli_fetch_array($resultFyF)){  
			//Hay registro que cumple
			if(!$resultactFyF = mysqli_query($conexion_sp, "update fondosyfacturas set idFondo = '".$idresultact."' where idRegistro = '".$rowresultFyF['idRegistro']."'")){
				//echo"FyF NO actualizado";
				die("Problemas con la consulta de actualizacion FyF");
			}
			else {
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF actualizado</label>";
				//echo"<br />";
			};		
			} else {
				//No hay registro. Tengo que hacer uno
				if(!$resultagrFyF = mysqli_query($conexion_sp, "insert into fondosyfacturas (idFondo, idCaeAfip, CUIT) values ('".$idresultact."', '".$ultimoIdFactura."', '".$regCaeAfip['CUITCliente']."')")){
					//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF No agregado</label>";
					die("Problemas con la consulta de agregar pago");
				}	else {
					//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF agregado</label>";
				};
			}
	}
}

//Me queda quitar el permiso de modificacion al recibo para que ya no pueda volver a asignarse los pagos
if(!$resultactEnviada = mysqli_query($conexion_sp, "update comprobantes set OCEnviada = '1', actualiz = now() where idcomprobante = '".$regComprobante['idcomprobante']."'")){
	echo"<label style='font-size:1em; font-weight:bold; color:red'>No actualizado</label>";
	 die("Problemas con la consulta de actualizacion");
};

//Si llegué hasta acá es porque estuvo todo bien	
Echo "Todos los pagos agregados correctamente";

	