<?php
include 'appConfig.php';

$app = $homeLinks['perfil'];

include 'includes/funcArticulos.php';
include 'header.php';

sec_session_start();

?>
<!-- app js -->
<script src="js/funciones.js"></script>

</head>

<body>

	<?php
	if (login_check($mysqli) == true) {
		// SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR
		upperMenu($app['title']);
		?>
		<div class="container">
			<div class="card-deck">
				<div class="card card-outline col-md-5">
					<div class="card-body box-profile" id="register-info">
						<div class="text-center">
							<?php Buscar_Usuario($_SESSION['user_id']); ?>
							<!--ver codigo para cargar una foto y que pasa si no existe la ruta -->
							<img src="<?php echo htmlentities($_SESSION['Foto']); ?>" alt="<?php echo htmlentities($_SESSION['Nombre']); ?> <?php echo htmlentities($_SESSION['Apellido']); ?>" class="profile-user-img img-fluid img-circle">
							<h3 class="profile-username text-center" id="completoActualizado"><?php echo htmlentities($_SESSION['Nombre']); ?> <?php echo htmlentities($_SESSION['Apellido']); ?></h3>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<p>
									Username: <label id="userActualizado"><?php echo htmlentities($_SESSION['username']); ?></label>
								</p>
								<p>
									Nombre: <label id="nombreActualizado"><?php echo htmlentities($_SESSION['Nombre']); ?></label>
								</p>
								<p>
									Apellido: <label id="apellActualizado"> <?php echo htmlentities($_SESSION['Apellido']); ?></label>
								</p>
								<p>
									Horarios: <label id="horariosActualizado"> <?php echo htmlentities($_SESSION['Horarios']); ?></label>
								</p>
							</div>
							<div class="col-md-6">
								<p>
									FechaActualizacion: <label id="horaActualizacion"> <?php echo htmlentities($_SESSION['FechaActualizacion']); ?>
								</p>
								<p>
									Ultimo Login (anterior a este): <?php ultimo_inicio_sesion($_SESSION['user_id']); ?>
								</p>
								<p style="margin-right:0; margin-left:0; padding-right: 2px; padding-left: 2px;" ;>
									eMail (usado para el inicio de sesión): <label id="eMailActualizado"> <?php echo htmlentities($_SESSION['email']); ?> </label>
								</p>
							</div>
						</div><!-- /inner row -->
					</div>
				</div>

				<div class="card">
					<div class="card-header p-2	">
						<h2 class="text-center">Quiero modificar algunos de mis datos</h2>
					</div>

					<div class="card-body">
						<form action="">
							<div class="form-group row">
								<label for="name" class="col-4 col-form-label">Nombre</label>
								<div class="col-8">
									<input id="name" name="name" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group row">
								<label for="surname" class="col-4 col-form-label">Apellido</label>
								<div class="col-8">
									<input id="surname" name="surname" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group row">
								<label for="horarios" class="col-4 col-form-label">Horarios</label>
								<div class="col-8">
									<input id="horarios" name="horarios" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-4 col-form-label">eMail</label>
								<div class="col-8">
									<input id="email" name="email" class="form-control" type="email">
								</div>
							</div>
							<div class="form-group row">
								<label for="username" class="col-4 col-form-label">Username (Se actualizará en el próximo inicio de sesión)</label>
								<div class="col-8">
									<input id="username" name="username" class="form-control" type="text">
								</div>
							</div>

							<input name='numerosesion' id='numerosesion' class='numerosesion' type='hidden' value=<?php echo htmlentities($_SESSION['user_id']); ?>>
							<label>
								Si no desea modificar algún campo, déjelo en blanco
							</label>
						</form>
					</div>
					<div class="card-footer">
						<input type="submit" id="boton1" value="Aceptar" />
					</div>
				</div>
			</div>
		</div>

	<?php }

include 'footer.php';
