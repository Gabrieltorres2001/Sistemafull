<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//generamos la consulta
//Primero busco mi nivel de usuario para determinar hasta que usuarios puedo mostrar
   if(!$resultMail = mysqli_query($conexion_db, "select id, Nombre from members where email='".$_REQUEST['email']."' limit 1")) die("Problemas con la consulta members1");
   if (mysqli_num_rows($resultMail)<1) {
	   echo "La direccion de email ingresada No tiene cuenta.";
   } else {
		$regMail = mysqli_fetch_array($resultMail);
		$user_id = $regMail['id'];
		$nombre = $regMail['Nombre'];
		$email = $_REQUEST['email'];
		
		$token = hash('sha512', $_REQUEST['email'] . $_REQUEST['rnadom']);
		if(!$resultToken = mysqli_query($conexion_db, "update members set Token = '".$token."', venceToken = ".time()." where email='".$_REQUEST['email']."'")) die("Problemas con la consulta members2");
		
		$url = 'http://'.$_SERVER["SERVER_NAME"].'/login/cambia_pass.php?user_id='.$user_id.'&token='.$token;
	
		$asunto = 'Recuperar Password - SistemaPlus';
		$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contrase&ntilde;a. <br/><br/>Para restaurar la contrase&ntilde;a, visita la siguiente direcci&oacute;n: <a href='$url'>$url</a><br /><br />Tiene 10 minutos desde que se envi&oacute; el correo, sino debera volver a solicitar otro reinicio.";
		
		if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
			echo "Hemos enviado un correo electronico a la direcion $email para restablecer tu password.<br />";
		} else {
			echo "Ocurrió un error al enviar el email";
		}
   }