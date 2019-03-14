<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
	
//generamos la consulta de actualizacion DE CONTACTO
	
	if(!$result = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$_REQUEST['idcto']."' limit 1")) die("Problemas con la consulta de lectura Contactos2");
	$regCopio = mysqli_fetch_array($result); 
	$Organ=$regCopio['idOrganizacion'];
	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into contactos2 (NombreCompleto, idOrganizacion, FuncionEnLaEmpresa, PalabrasClave, PoderDecision) values ('".$regCopio['NombreCompleto']."', '".$regCopio['idOrganizacion']."', '".$regCopio['FuncionEnLaEmpresa']."', '".$regCopio['PalabrasClave']."', '".$regCopio['PoderDecision']."')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto NO copiado. Error en tabla Contactos.</label>";
		 die("Problemas con la consulta de copia");
	}
	else {
		$id=mysqli_insert_id($conexion_sp);
		//Ahora los telefonos. El ID de la tabla telefonos debe ser igual que el de la tabla contactos
		if(!$result = mysqli_query($conexion_sp, "select * from telefonos where IdContacto = '".$_REQUEST['idcto']."' limit 1")) die("Problemas con la consulta de lectura Tels");
		$regCopio = mysqli_fetch_array($result); 
		if(!$resultcopia = mysqli_query($conexion_sp, "insert into telefonos (IdContacto, Telefono, Faxdeltrabajo, Telefonomovil, Telefonoprivado2, OtroTelefono) values ('".$id."', '".$regCopio['Telefono']."', '".$regCopio['Faxdeltrabajo']."', '".$regCopio['Telefonomovil']."', '".$regCopio['Telefonoprivado2']."', '".$regCopio['otrotelefono']."')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto NO copiado. Error en tabla Telefonos.</label>";
		 die("Problemas con la consulta de copia");
		} else {
			//Ahora los EMAILS. El ID de la tabla direcciones es autoincrement
			$regCopio = mysqli_fetch_array($result);
			if(!$result = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT='".$_REQUEST['idcto']."' and Direccion Like '%@%'")) die("Problemas con la consulta de lectura Mails");
			while ($regEmpMail = mysqli_fetch_row($result)){
				if(!$resultcopia = mysqli_query($conexion_sp, "insert into direcciones (CUIT, Direccion) values ('".$id."', '".$regEmpMail[0]."')")){
				echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto NO copiado. Error en tabla Mails.</label>";
				 die("Problemas con la consulta de copia");
				};
			}
			echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto copiado del id Nº ".$_REQUEST['idcto']."</label>";
			echo"<br />";
		}
	};	

	

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$id."' limit 1")) die("Problemas con la consulta");  

	imprimir_detalle_contactos($resultc, $conexion_sp, '');