<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

	echo"<input type='button' id='nuevoRecibo' value='Nuevo recibo'/>";

include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de buscar proximo numero de Remito
	
	if(!$resultProxRemito = mysqli_query($conexion_sp, "select max(cast(NumeroComprobante as unsigned)) from comprobantes where TipoComprobante='14' limit 1")){
		echo"Recibo NO creado";
		 die("Problemas con la consulta de busqueda de proximo NumeroComprobante");
	}
	$rowresultProxRemito = mysqli_fetch_row($resultProxRemito);
	
	//Septiembre 2018. No se que pasó, pero esto debería haber estado aca y no lo encuentro. Busco la organizacion para cargarle al comprobante la condicion de pago
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select CondDePago from organizaciones where id='".$_REQUEST['numempresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

//generamos la consulta de agregar	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into comprobantes (TipoComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, CondicionesPago, Notas, MantiniemtoOferta, Responsable, Confecciono, Transporte, PlazoEntrega, Propietario, NumeroComprobante01, NumeroComprobante02, UsuarioModificacion, UsuarioFC, UsuarioFM, OCFechaEnvio, ConddeIva, Solicito, actualiz) values ('14', '".($rowresultProxRemito[0] + 1)."', '".date('Y-m-d')."', '".$_REQUEST['numempresa']."', '".$regContEmp['CondDePago']."', '', '5', '1', '".$_REQUEST['sesses']."', '', '', '', '', '', '', '', '', '', '', '', now())")){
		echo"Remito NO creado";
		 die("Problemas con la consulta de nueva venta");
	}
	else {
	//generamos la consulta de buscar proximo numero de Idcomprobante
	//Ya no hace falta generar la consulta, hay una funcion que lo hace sola
		$id=mysqli_insert_id($conexion_sp);
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Item de recibo creado</label>";
		echo"<label id='NumeroRemitoRecienCreado' style='font-size:1em; font-weight:bold; color:red; visibility:hidden;'>".$id."</label>";
		echo"<br />";
	};	
	


 

