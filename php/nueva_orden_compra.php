<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

	echo"<input type='button' id='nuevaOrdenCompra' value='Nueva OC'/>";

include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta de buscar proximo numero de OC
	
	if(!$resultProxOC = mysqli_query($conexion_sp, "select max(cast(NumeroComprobante as unsigned)) from comprobantes where TipoComprobante='9' limit 1")){
		echo"OC NO creado";
		 die("Problemas con la consulta de busqueda de proximo NumeroComprobante");
	}
	$rowresultProxOC = mysqli_fetch_row($resultProxOC);

//generamos la consulta de buscar ApellidoContacto en contactos2
	
	if(!$resultApellidoContacto = mysqli_query($conexion_sp, "select NombreCompleto, idOrganizacion from contactos2 where IdContacto='".$_REQUEST['numempresa']."' limit 1")){
		echo"OC NO creado";
		 die("Problemas con la consulta de busqueda de ApellidoContacto en contactos2");
	}
	$rowresultApellidoContacto = mysqli_fetch_array($resultApellidoContacto);
	
	//Septiembre 2018. No se que pasó, pero esto debería haber estado aca y no lo encuentro. Busco la organizacion para cargarle al comprobante la condicion de pago
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select CondDePago from organizaciones where id='".$rowresultApellidoContacto['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

//generamos la consulta de agregar
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into comprobantes (TipoComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, MantiniemtoOferta, Responsable, Confecciono, Transporte, PlazoEntrega, Propietario, NumeroComprobante01, NumeroComprobante02, UsuarioModificacion, UsuarioFC, UsuarioFM, OCFechaEnvio, ConddeIva, Solicito, actualiz) values ('9', '".($rowresultProxOC[0] + 1)."', '".date('Y-m-d')."', '".$_REQUEST['numempresa']."', '".$rowresultApellidoContacto['NombreCompleto']."', '".$regContEmp['CondDePago']."', '', '5', '1', '".$_REQUEST['sesses']."', '', '', '', '', '', '', '', '', '', '', '', now())")){
		echo"OC NO creado";
		 die("Problemas con la consulta de nuevo OC");
	}
	else {
	//generamos la consulta de buscar proximo numero de Idcomprobante
		//if(!$resultProxIdComprobante = mysqli_query($conexion_sp, "select max(IdComprobante) from comprobantes where TipoComprobante='5' limit 1")){
		//	echo"OC NO creado";
		//	 die("Problemas con la consulta de busqueda de proximo IdComprobante");
		//}
		//$rowresultProxIdComprobante = mysqli_fetch_row($resultProxIdComprobante);
	//Ya no hace falta generar la consulta, hay una funcion que lo hace sola
		$id=mysqli_insert_id($conexion_sp);
		echo"<label style='font-size:1em; font-weight:bold; color:red'>OC creado</label>";
		echo"<label id='NumeroOCRecienCreado' style='font-size:1em; font-weight:bold; color:red; visibility:hidden;'>".$id."</label>";
		echo"<br />";
	};	
	

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA ASEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

		//if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$id."' limit 1")) die("Problemas con la consulta");  

	//imprimir_detalle_contactos($resultc, $conexion_sp, '');
			
	//echo"<input type='button' id='botonActualizaContactoNuevo' value='Actualizar datos'/><br />";

 

