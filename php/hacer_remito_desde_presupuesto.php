	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';


$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	if(!$resultComprobante = mysqli_query($conexion_sp, "select * from comprobantes where NumeroComprobante='".$_REQUEST['presup']."' and TipoComprobante='5' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);  
	
	if(!$resultProxRemito = mysqli_query($conexion_sp, "select max(cast(NumeroComprobante as unsigned)) from comprobantes where TipoComprobante='3' limit 1")){
		echo"Remito NO creado";
		 die("Problemas con la consulta de busqueda de proximo NumeroComprobante");
	}
	$rowresultProxRemito = mysqli_fetch_row($resultProxRemito);
	
	//generamos la consulta de agregar encabezadocomprobante	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into comprobantes (TipoComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, MantiniemtoOferta, Responsable, Confecciono, Transporte, PlazoEntrega, Propietario, NumeroComprobante01, NumeroComprobante02, UsuarioModificacion, UsuarioFC, UsuarioFM, OCFechaEnvio, ConddeIva, Solicito, actualiz) values ('3', '".($rowresultProxRemito[0] + 1)."', '".date('Y-m-d')."', '".$reg['NonmbreEmpresa']."', '".$reg['ApellidoContacto']."', '".$reg['CondicionesPago']."', '".$reg['Notas']."', '5', '1', '".$_REQUEST['sesses']."', '".$reg['Transporte']."', '".$reg['PlazoEntrega']."', '".$reg['Propietario']."', '".$_REQUEST['occlien']."', '".$_REQUEST['preimpres']."', '".$reg['UsuarioModificacion']."', '".$reg['UsuarioFC']."', '".$reg['UsuarioFM']."', '".$reg['OCFechaEnvio']."', '".$reg['ConddeIva']."', '".$reg['Solicito']."', now())")){
		echo"Remito NO creado";
		 die("Problemas con la consulta de nuevo Remito");
	}	else {
	//generamos la consulta de buscar proximo numero de Idcomprobante
		//if(!$resultProxIdComprobante = mysqli_query($conexion_sp, "select max(IdComprobante) from comprobantes where TipoComprobante='5' limit 1")){
		//	echo"Remito NO creado";
		//	 die("Problemas con la consulta de busqueda de proximo IdComprobante");
		//}
		//$rowresultProxIdComprobante = mysqli_fetch_row($resultProxIdComprobante);
	//Ya no hace falta generar la consulta, hay una funcion que lo hace sola
		$id=mysqli_insert_id($conexion_sp);
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Item de venta creado</label>";
		//echo"<label id='NumeroRemitoRecienCreadoDesdePResup' style='font-size:1em; font-weight:bold; color:red;'>".$id."</label>";
		//echo"<br />";
		echo $id;
	};	