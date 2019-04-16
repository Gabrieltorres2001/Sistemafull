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
	
	<!-- page js libs -->
	<script src="js/funcionesindex.js"></script>

</head>

<body>
	<div class="container login">
		<div class="mx-auto text-center animated fadeInDown">
			<h1 id="title" class=""><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="card w-50 animated fadeInUp text-center mx-auto"  id="botonLogInicial">
			<div class="card-header">
				<h2>Ingreso</h2>
			</div>
			<form class="card-body" action="includes/process_login.php" method="post" name="login_form">
				<div class="form-group">
					<label for="email">Correo electrónico:</label>
					 <input class="form-control" type="text" name="email" id="email" placeholder="Ingrese su email">
				</div>
				<div class="form-group">
					<label for="password">Contraseña:</label>	
					<input class="form-control" type="password" name="password" id="password" placeholder="Password">
				</div>
				<input class="btn btn-primary" type="Submit" value="Login" onclick="formhash(this.form, this.form.password);" hidefocus="true"/> 
        	</form>
			<p> Si olvidó su contraseña, por favor ingrese su email y haga click 
				<a class="btn btn-light" href="#" onclick="event.preventDefault(); recuperarClave(document.getElementById('email').value);">aquí.</a>
			</p>
			<p> Si no tiene una cuenta, por favor <a class="btn btn-light" href="register.php">regístrese.</a></p>
		</div>
	</div>
	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" id="mensajeAlertaAviso">Mensaje de información.</div>
</body>

</html>