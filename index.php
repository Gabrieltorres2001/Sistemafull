<?php
$titulo = "Ingreso diario";
include 'header.php';

sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
	<!-- page Stylesheet -->
	<link rel="stylesheet" href="css/style.css" >
	<link rel="stylesheet" href="css/animate.css" >
    <link rel="stylesheet" href="css/index.css" > 	
	
	<!-- page js libs -->
	<script src="js/funcionesindex.js"></script>
</head>

<body>

	<div class="container">
		<div class="top">
			<h1 id="title" class="hidden"><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="login-box animated fadeInUp" id="botonLogInicial">
			<div class="box-header">
				<h2>Ingreso</h2>
			</div>
			<form action="includes/process_login.php" method="post" name="login_form">
			
				Correo electrónico: <input type="text" name="email" id="email"/>
				Contraseña: <input type="password" name="password" id="password"/>
				<input type="Submit" value="Login" onclick="formhash(this.form, this.form.password);" hidefocus="true"/> 
        	</form>
			<p> Si olvidó su contraseña, por favor ingrese su email y haga click 
				<a class="btn btn-default" href="#" onclick="event.preventDefault(); recuperarClave(document.getElementById('email').value);">aquí.</a>
			</p>
			<p> Si no tiene una cuenta, por favor <a class="btn btn-default" href="register.php">regístrese.</a></p>
		</div>
	</div>
	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
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