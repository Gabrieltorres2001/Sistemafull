<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into contactos2 (NombreCompleto, idOrganizacion, FuncionEnLaEmpresa, PalabrasClave, PoderDecision) values ('', '', '', '', '')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto NO creado. Error en tabla Contactos.</label>";
		 die("Problemas con la consulta de creacion");
	}
	else {
		$id=mysqli_insert_id($conexion_sp);
		//Ahora los telefonos. El ID de la tabla telefonos debe ser igual que el de la tabla contactos
		if(!$resultcopia = mysqli_query($conexion_sp, "insert into telefonos (IdContacto, Telefono, Faxdeltrabajo, Telefonomovil, Telefonoprivado2, OtroTelefono) values ('".$id."', '', '', '', '', '')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto NO creado. Error en tabla Telefonos.</label>";
		 die("Problemas con la consulta de creacion");
		} else {
			//Ahora los EMAILS. El ID de la tabla direcciones es autoincrement
			//No agrego mails
			echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto creado.</label>";
			echo"<br />";
		}
	};

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$id."' limit 1")) die("Problemas con la consulta de busqueda");  

	imprimir_detalle_contactos($resultc, $conexion_sp, '');
			
	echo"<input type='button' id='botonActualizaContactoNuevo' value='Actualizar datos'/><br />";

 

