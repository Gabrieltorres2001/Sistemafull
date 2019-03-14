<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$pagos=0;
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
//Primero pregunto si es una NC, sino no hago nada.
if ($_REQUEST['tipoComprob']=='NC'){
	//lo hago porque es una NC, sino nada
	if(!$resultact = mysqli_query($conexion_sp, "insert into fondos (Tipo, IDComprobante, Fecha, Descripcion, TipoValor, MonedaPago, Importe, CUIT, actualiz) values ('1', '".$_REQUEST['idcomprobante']."', '".substr($_REQUEST['Fecha'],6,4)."-".substr($_REQUEST['Fecha'],3,2)."-".substr($_REQUEST['Fecha'],0,2)."', '".$_REQUEST['Descripcion']."', '".$_REQUEST['TipoValor']."', '".$_REQUEST['MonedaPago']."', '".$_REQUEST['Importe']."', '".$_REQUEST['cuit']."', now())")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar pago");
	}	else {
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Pago agregado</label>";
		$idresultact=mysqli_insert_id($conexion_sp);
	};
	//Tambien registrar el pago en la tabla fondosyfacturas. En este caso asociado a una factura. Primero tengo que ver si la factura tiene algun pago (campo idFondo NULL), si ya tiene tengo que agregar un nuevo registro con numero de factura, fondo y CAE.
	if(!$resultFyF = mysqli_query($conexion_sp, "select idRegistro from fondosyfacturas where idCaeAfip='".$_REQUEST['idcomprobante']."' and idFondo = NULL limit 1")) die("Problemas con la consulta2");
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
			if(!$resultagrFyF = mysqli_query($conexion_sp, "insert into fondosyfacturas (idFondo, idCaeAfip, CUIT) values ('".$idresultact."', '".$_REQUEST['idcomprobante']."', '".$_REQUEST['cuit']."')")){
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF No agregado</label>";
				 die("Problemas con la consulta de agregar pago");
			}	else {
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>FyF agregado</label>";
			};
		}
	
	if(!$resultDetalle = mysqli_query($conexion_sp, "select ImporteTotal, IdEnviado from caeafip where Id='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta2");
	while ($row = mysqli_fetch_array($resultDetalle)){  
		if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1'")) die("Problemas con la consulta fondos");
		while ($rowresultPagosFondos = mysqli_fetch_array($resultPagosFondos)){  
			//falta ver que hago con pagos en otras monedas (por ahora no le doy bola)
			$pagos=$pagos+(number_format($rowresultPagosFondos['Importe'],2,'.',''));
		}
		$pendiente=(number_format($row['ImporteTotal'],2,'.',''))-$pagos;
		$moneda=$row['IdEnviado'];
	}
}
//si llegue hasta aca es porque no hubo DIE, asi que todo ok
echo"OkOko";
