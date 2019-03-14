<?php


   //Creamos la conexión
include_once '../includes/db_connect.php';
include_once '../includes/sp_connect.php';
   
//busco mi usuario con mi sesion
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
	if(!$sesionSistPlus = mysqli_query($conexion_db, "select password, salt from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la consulta3");
	$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
	$passwordd = hash('sha512', $_REQUEST['clave'] . $rowSesionSistPlus['salt']);
	//echo " - Clave: " . $passwordd;
	if ($passwordd==$rowSesionSistPlus['password']) {echo "True";} else {echo "False";}
