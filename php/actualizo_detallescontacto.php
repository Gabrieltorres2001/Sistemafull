<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultact = mysqli_query($conexion_sp, "update contactos2 set NombreCompleto = '".$_REQUEST['NombreCompleto']."', idOrganizacion = '".$_REQUEST['Organizacion']."', FuncionEnLaEmpresa = '".$_REQUEST['FuncionEnLaEmpresa']."', PalabrasClave = '".$_REQUEST['PalabrasClave']."', PoderDecision = '".$_REQUEST['PoderDecision']."' where IdContacto = '".$_REQUEST['idcto']."'")){
		echo"Contacto NO actualizado";
		 die("Problemas con la consulta de actualizacion");
	}
	else {
		echo"OkOKo";
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto actualizado</label>";
		//echo"<br />";
	};

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	//if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$_REQUEST['idcto']."' limit 1")) die("Problemas con la consulta");  
	//Vuelvo a imprimir los detalles para asegurarme que salio todo OK (los vuelvo a leer de la BD)
	//imprimir_detalle_contactos($resultc, $conexion_sp, '');