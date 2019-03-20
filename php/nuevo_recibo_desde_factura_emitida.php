<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
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

	//Busco la empresa a la que le tengo que hacer el recibo en función del CAE de la factura (único dato que recibí)
	if(!$resultContacto = mysqli_query($conexion_sp, "select NonmbreEmpresa from caeafip where CAE='".$_REQUEST['numCAE']."' limit 1")) die("Problemas con la consulta caeafip");
	$regContacto = mysqli_fetch_array($resultContacto);

	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContactos = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$regContacto['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta contactos2");
	$regContactos = mysqli_fetch_array($resultContactos);

	//Busco la forma de pago de la empresa
	if(!$resultContEmp = mysqli_query($conexion_sp, "select CondDePago from organizaciones where id='".$regContactos['idOrganizacion']."' limit 1")) die("Problemas con la consulta organizaciones");
	$regContEmp = mysqli_fetch_array($resultContEmp);

//generamos la consulta de agregar	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into comprobantes (TipoComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, CondicionesPago, Notas, MantiniemtoOferta, Responsable, Confecciono, Transporte, PlazoEntrega, Propietario, NumeroComprobante01, NumeroComprobante02, UsuarioModificacion, UsuarioFC, UsuarioFM, OCFechaEnvio, ConddeIva, Solicito, actualiz) values ('14', '".($rowresultProxRemito[0] + 1)."', '".date('Y-m-d')."', '".$regContactos['idOrganizacion']."', '".$regContEmp['CondDePago']."', '', '5', '1', '".$_REQUEST['sesses']."', '', '', '', '', '', '', '', '', '', '', '', now())")){
		echo"Recibo NO creado";
		 die("Problemas con la consulta de nueva venta");
	}
	else {
	//generamos la consulta de buscar proximo numero de Idcomprobante
	//Ya no hace falta generar la consulta, hay una funcion que lo hace sola
		$id=mysqli_insert_id($conexion_sp);
		echo $id;
	};	
	


 

