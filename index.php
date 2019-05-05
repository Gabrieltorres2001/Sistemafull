<?php
include 'appConfig.php';
$app = $homeLinks['login'];
include 'header.php';

sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
	<!-- page Stylesheet -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<!-- page js libs -->
	<script src="js/funcionesindex.js"></script>

</head>

<body>
	<div class="login">
		<div class="text-center animated fadeInDown">
			<h1 id="title" class=""><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="card w-50 animated fadeInUp text-center mx-auto"  id="botonLogInicial">
			<div class="card-header">
				<h2>Ingreso</h2>
			</div>
			<div class="card-body" >
				<form action="includes/process_login.php" method="post" name="login_form">
					<div class="form-group row">
						<label class="col-md-3" for="email">Correo electrónico:</label>
						<input class="form-control col-md-9" type="text" name="email" id="email" placeholder="Ingrese su email">
					</div>
					<div class="form-group row">
						<label class="col-md-3" for="password">Contraseña:</label>	
						<input class="form-control col-md-9" type="password" name="password" id="password" placeholder="Password">
					</div>
					<button class="btn btn-primary" type="Submit" onclick="formhash(this.form, this.form.password);" hidefocus="true">Entrar</button> 
				</form>
			</div>
			<div class="card-footer">
				<p> Si olvidó su contraseña, por favor ingrese su email y haga click 
					<button class="btn btn-light btn-sm" onclick="event.preventDefault(); recuperarClave(document.getElementById('email').value);">aquí.</button>
				</p>
				<p> Si no tiene una cuenta, por favor <a class="btn btn-light btn-sm" href="register.php">regístrese.</a></p>
			</div>
		</div>
	</div>
	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" id="mensajeAlertaAviso" hidden>Mensaje de información.</div>
</body>

</html>