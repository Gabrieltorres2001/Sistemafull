<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcContactos.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion

	//Primero veo cuantos mails ya tenia este contacto
	if(!$resultMail = mysqli_query($conexion_sp, "select id, Direccion from direcciones where CUIT = '".$_REQUEST['idcto']."' and Direccion Like '%@%'")) die("Problemas con la consulta eMail");
	if (mysqli_num_rows($resultMail)>$_REQUEST['cantidadMails'])
	{ //hay mas en la BD que en la pantalla
		$i=1;
		while ($row = mysqli_fetch_array($resultMail)){ 
			if ($i<=$_REQUEST['cantidadMails']) {//Hasta la misma cantidad
				if(!$resultact = mysqli_query($conexion_sp, "update direcciones set Direccion = '".$_REQUEST['email'.(string)($i-1)]."' where id = '".$row['id']."'")){
				die("Problemas con la consulta de actualizacion");}
				 $i++;
			} else {//Borro el resto
				if(!$resultact = mysqli_query($conexion_sp, "delete from direcciones where id = '".$row['id']."'")){
				die("Problemas con la consulta de borrar");}
				 $i++;			
			}
		}
	} else {//Hay la misma cantidad o menos en la BD que en la pantalla
		$i=1;
		//echo $i;
		while ($row = mysqli_fetch_array($resultMail)){//Por lo menos la misma cantidad 
			if(!$resultact = mysqli_query($conexion_sp, "update direcciones set Direccion = '".$_REQUEST['email'.(string)($i-1)]."' where id = '".$row['id']."'")){
			die("Problemas con la consulta de actualizacion");}
			 $i++;
			// echo $i;
		}
		while ($i<=$_REQUEST['cantidadMails']){ //Todavía había mas en la pantalla que en la BD
			//echo "entre donde queria";
			$vari='email'.(string)($i-1);
			if(!$resultagr = mysqli_query($conexion_sp, "insert into direcciones (CUIT, Direccion) values ('".$_REQUEST['idcto']."', '".$_REQUEST['email'.(string)($i-1)]."')")){
			die("Problemas con la consulta de agregar");}
			//echo $_REQUEST['email'.(string)($i-1)];
			 $i++;	
			//echo 'email'.(string)($i-1);			 
		}
	}
	echo"<label style='font-size:1em; font-weight:bold; color:red'>Contacto actualizado</label>";
	echo"<br />";

//ACAAAA ---- PRIMERO ACTUALIZAR DATOS. LUEGO SIGUE LO DE ABAJO COMO ESTA (MOSTRAR TODOS LOS DATOS
//PARA SEGURARME QUE LOS CARGO BIEN
//POR ESO LO DE ABAJO NO SE TOCA (VIENE DE DETALLESCONTACTO.PHP) SALVO QUE LLAME A DETALLES CONTACTO.PHP

	if(!$resultc = mysqli_query($conexion_sp, "select * from contactos2 where IdContacto = '".$_REQUEST['idcto']."' limit 1")) die("Problemas con la consulta");  
	//Vuelvo a imprimir los detalles para asegurarme que salio todo OK (los vuelvo a leer de la BD)
	imprimir_detalle_contactos($resultc, $conexion_sp, '');