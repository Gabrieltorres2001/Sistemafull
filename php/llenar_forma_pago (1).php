<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

	echo"<input type='button' id='nuevoPresupuesto' value='Nuevo presupuesto'/>";

include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//generamos la consulta de buscar proximo numero de Presupuesto
	
	if(!$resultProxPresupuesto = mysqli_query($conexion_sp, "select max(NumeroComprobante) from comprobantes where TipoComprobante='5' limit 1")){
		echo"Presupuesto NO creado";
		 die("Problemas con la consulta de busqueda de proximo NumeroComprobante");
	}
	$rowresultProxPresupuesto = mysqli_fetch_row($resultProxPresupuesto);

//generamos la consulta de buscar ApellidoContacto en contactos2
	
	if(!$resultApellidoContacto = mysqli_query($conexion_sp, "select NombreCompleto from contactos2 where IdContacto='".$_REQUEST['numempresa']."' limit 1")){
		echo"Presupuesto NO creado";
		 die("Problemas con la consulta de busqueda de ApellidoContacto en contactos2");
	}
	$rowresultApellidoContacto = mysqli_fetch_row($resultApellidoContacto);

//generamos la consulta de agregar	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into comprobantes (TipoComprobante, NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, MantiniemtoOferta, Responsable, Confecciono, Transporte, PlazoEntrega, Propietario, NumeroComprobante01, NumeroComprobante02, UsuarioModificacion, UsuarioFC, UsuarioFM, OCFechaEnvio, ConddeIva, Solicito, actualiz) values ('5', '".($rowresultProxPresupuesto[0] + 1)."', '".date('Y-m-d')."', '".$_REQUEST['numempresa']."', '".$rowresultApellidoContacto[0]."', '', '', '5', '1', '".$_REQUEST['sesses']."', '', '', '', '', '', '', '', '', '', '', '', now())")){
		echo"Presupuesto NO creado";
		 die("Problemas con la consulta de nuevo Presupuesto");
	}
	else {
	//generamos la consulta de buscar proximo numero de Idcomprobante
		//if(!$resultProxIdComprobante = mysqli_query($conexion_sp, "select max(IdComprobante) from comprobantes where TipoComprobante='5' limit 1")){
		//	echo"Presupuesto NO creado";
		//	 die("Problemas con la consulta de busqueda de proximo IdComprobante");
		//}
		//$rowresultProxIdComprobante = mysqli_fetch_row($resultProxIdComprobante);
	//Ya no hace falta generar la consulta, hay una funcion que lo hace sola
		$id=mysqli_insert_id($conexion_sp);
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Presupuesto creado</label>";
		echo"<label id='NumeroPresupuestoRecienCreado' style='font-size:1em; font-weight:bold; color:red; visibility:hidden;'>".$id."</label>";
		echo"<br />";
	};	
	

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA ASEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

		//if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$id."' limit 1")) die("Problemas con la consulta");  

	//imprimir_detalle_contactos($resultc, $conexion_sp, '');
			
	//echo"<input type='button' id='botonActualizaContactoNuevo' value='Actualizar datos'/><br />";

 

