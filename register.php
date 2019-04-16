<?php
$titulo = "Registro de nuevo usuario";
include 'header.php';
?>
	<!-- page Stylesheet -->

	<!-- page js libs -->
    <script src="js/Untitled.js"></script>

</head>

<body>

    <div class="container login">
		<div class="mx-auto text-center animated fadeInDown">
			<h1 id="title"><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="card w-50 animated fadeInUp text-center mx-auto">
			<div class="card-header">
				<h2>Registro de nuevo usuario</h2>
			</div>
            <?php
            if (!empty($error_msg)) {
                echo $error_msg;
            }
            ?>
            <form class="card-body" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">

                <div class="form-group">
                    <label for="username">Nombre de usuario: </label>
                    <input class="form-control" type='text' name='username' id='username'/>
                    <small  id="UsuarioAdvertencia" style="display: none;">
                    </small >
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico: </label>
                    <input class="form-control" type="text" name="email" id="email" />
                    <small  id="eMailAdvertencia" style="display: none;">
                    </small >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña: </label>
                    <input class="form-control" type="password" name="password" id="password"/>
                    <small  id="passwordAdvertencia" style="display: none;">
                    </small >
                </div>
            
                <div class="form-group">
                    <label for="confirmpwd"> Confirmar contraseña: </label>
                    <input class="form-control" type="password" name="confirmpwd" id="confirmpwd" />
                    <small  id="confirmpwdAdvertencia" style="display: none;">
                    </small >
                </div>
                    
                <input class = "btn btn-primary" type="button" value="Register" onclick="return regformhash(this.form,
                                    this.form.username,
                                    this.form.email,
                                    this.form.password,
                                    this.form.confirmpwd);" /> 
            </form>
            <p>Regresar a la página de <a class="btn btn-light" href="index.html">login</a>.</p>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
        inicio();
    	$("input:text:visible:first").focus();
	});
</script>

</html>