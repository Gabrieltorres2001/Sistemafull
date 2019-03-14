<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Ingreso diario: Formulario de registro</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/styleAncho.css">
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
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
				<h2>Registro de nuevo usuario</h2>
			</div>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form">
            Nombre de usuario: <input type='text' 
                name='username' 
                id='username'/>
            <div id="UsuarioAdvertencia" style="display: none;">
				
			</div><br>
            Correo electrónico: <input type="text" name="email" id="email" />
            <div id="eMailAdvertencia" style="display: none;">
				
			</div><br>
            Contraseña: <input type="password"
                             name="password" 
                             id="password"/>
            <div id="passwordAdvertencia" style="display: none;">
				
			</div><br>
            Confirmar contraseña: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" />
            <div id="confirmpwdAdvertencia" style="display: none;">
				
			</div><br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p>Regresar a la página de <a href="index.html">login</a>.</p>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>

</html>