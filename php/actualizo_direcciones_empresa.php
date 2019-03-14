<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcEmpresas.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
//un for por cada direccion que recibi
$Canti=$_REQUEST['cantidadDirecciones']-1;
	for ($i=0; $i<$Canti; $i++) {
		//Al pedo que lo busque
		//if(!$resultDirec = mysqli_query($conexion_sp, "select * from direcciones where id = '".$_REQUEST['id'.(string)($i)]."' limit 1")) die("Problemas con la consulta direcciones".(string)($i));
		//$reg = mysqli_fetch_array($resultDirec);  
		if ((strlen($_REQUEST['Direccion'.(string)($i)]) < 1) && (strlen($_REQUEST['Ciudad'.(string)($i)]) < 1) && (strlen($_REQUEST['CP'.(string)($i)]) < 1) && (strlen($_REQUEST['Provincia'.(string)($i)]) < 1) && (strlen($_REQUEST['Pais'.(string)($i)]) < 1)){
			//Todos vacios
			if(!$resultDirec = mysqli_query($conexion_sp, "delete from direcciones where id = '".$_REQUEST['id'.(string)($i)]."'")) die("Problemas con la consulta delete".(string)($i));
		} else {
			//Al menos uno tiene datos
			if(!$resultact = mysqli_query($conexion_sp, "update direcciones set Direccion = '".$_REQUEST['Direccion'.(string)($i)]."', Ciudad = '".$_REQUEST['Ciudad'.(string)($i)]."', Codigopostal = '".$_REQUEST['CP'.(string)($i)]."', Provoestado = '".$_REQUEST['Provincia'.(string)($i)]."', Pais = '".$_REQUEST['Pais'.(string)($i)]."'  where id = '".$_REQUEST['id'.(string)($i)]."'")){
			die("Problemas con la consulta de actualizacion".(string)($i));}			
		}
	}
	//Por ultimo verifico el campo nuevo (No lo busco en la BD porque ya se que no esta. Solo pregunto si tiene datos, si es asi lo agrego)
	if ((strlen($_REQUEST['Direccion'.(string)($Canti)]) < 1) && (strlen($_REQUEST['Ciudad'.(string)($Canti)]) < 1) && (strlen($_REQUEST['CP'.(string)($Canti)]) < 1) && (strlen($_REQUEST['Provincia'.(string)($Canti)]) < 1) && (strlen($_REQUEST['Pais'.(string)($Canti)]) < 1)){
			//Todos vacios
			//Siplemente no hago nada
	} else {
			if(!$resultagr = mysqli_query($conexion_sp, "insert into direcciones (CUIT, Direccion, Ciudad, Codigopostal, Provoestado, Pais) values ('".$_REQUEST['idemp']."', '".$_REQUEST['Direccion'.(string)($Canti)]."', '".$_REQUEST['Ciudad'.(string)($Canti)]."', '".$_REQUEST['CP'.(string)($Canti)]."', '".$_REQUEST['Provincia'.(string)($Canti)]."', '".$_REQUEST['Pais'.(string)($Canti)]."')")){
			die("Problemas con la consulta de agregar");}
			$i++;			 
		}
	echo"<label style='font-size:1em; font-weight:bold; color:red'>Empresa actualizada</label>";
	echo"<br />";

	if(!$resultc = mysqli_query($conexion_sp, "select * from organizaciones where id = '".$_REQUEST['idemp']."' limit 1")) die("Problemas con la consulta");  
	//Vuelvo a imprimir los detalles para asegurarme que salio todo OK (los vuelvo a leer de la BD)
	
	imprimir_detalle_empresas($resultc, $conexion_sp, '');
	