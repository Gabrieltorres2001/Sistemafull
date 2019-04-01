<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
   //Creamos la conexión
   $conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
   die("Problemas con la conexión");
   mysqli_query($conexion_db,"set names 'utf8'");
   if (isset($_REQUEST['user_id'], $_REQUEST['token'])){
	$userid=$_REQUEST['user_id'];
	if(!$resultMail = mysqli_query($conexion_db, "select username, email, Token, venceToken from members where id='".$_REQUEST['user_id']."' limit 1")) die("Problemas con la consulta members1");
	$regMail = mysqli_fetch_array($resultMail);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Ingreso diario: Cambio de clave</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/styleAncho.css">
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/formsCP.js"></script>
    <script type="text/JavaScript" src="js/Untitled.js"></script>

	<script type="text/javascript">
      addEventListener('load',inicio,false);
    </script>
	
</head>

<body>

	<div class="container">
		<div class="top">
			<h1 id="title" class="hidden"><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Reestablecer contraseña</h2>
			</div>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
		} 
		//echo "</BR>";
		//echo $regMail['venceToken']+600;
		//echo "</BR>";
		//echo time();
		//echo "</BR>";
		if ((!($_REQUEST['token']==$regMail['Token']))||($regMail['venceToken']+600<time())) {
            echo "Su pedido para reestablecer la clave ha expirado. Debe solicitar un nuevo email.";
		} else {
        ?>
        <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form">
            Nombre de usuario: <input type='text' name='username' id='username' value='<?php echo $regMail['username']; ?>' disabled/><br>
            Correo electrónico: <input type="text" name="email" id="email" value="<?php echo $regMail['email']; ?>" disabled/><br>
            Contraseña: <input type="password" name="password" id="password"/>
            <div id="passwordAdvertencia" style="display: none;">	
			</div><br>
            Confirmar contraseña: <input type="password" name="confirmpwd" id="confirmpwd" />
            <div id="confirmpwdAdvertencia" style="display: none;">	
			</div><br>
			<input type='hidden' name='iduser' id='iduser' value='<?php echo $userid; ?>'/>
			   <input type="button" 
                   value="Actualizar contraseña" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
								   this.form.confirmpwd,
								   this.form.iduser);" /> 
        </form>
        <?php
		}
	}
        ?>				
        <p>Regresar a la página de <a href="index.html">login</a>.</p>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
		$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>

</html>