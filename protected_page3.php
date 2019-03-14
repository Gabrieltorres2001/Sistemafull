<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/funcionesg.php';
include 'includes/funciones_Cambio_Moneda.php';
include 'funcionesPHP.php';
sec_session_start();
?>
<!doctype html>
<html><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>SISTEMAPLUS - Perfil de usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">
    <link href="css/pp3.css" rel="stylesheet">


	<script type="text/javascript" src="js/jqyer.js"></script>
    <script src="js/funciones.js"></script>

    <style type="text/css">

    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  	<!-- Google Fonts call. Font Used Open Sans & Raleway -->
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    
    <script type="text/JavaScript" src="js/Untitled.js"></script>
	</head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) : ?>
	<?php barraSuperior('pp3') ?>

    <div class="container">
        <div class="row">

        	<div class="col-lg-6">
        		
        		<div class="register-info-wraper">
        			<div id="register-info">
        				<div class="cont2">
        					<div class="thumbnail">
                                <?php Buscar_Usuario($_SESSION['user_id']); ?>
                            	<!--ver codigo para cargar una foto y que pasa si no existe la ruta -->
								<img style=" max-height: 150px;  max-width: 150px;"src="<?php echo htmlentities($_SESSION['Foto']); ?>" alt="<?php echo htmlentities($_SESSION['Nombre']); ?> <?php echo htmlentities($_SESSION['Apellido']); ?>" class="img-circle">
							</div><!-- /thumbnail -->
							<h2 id="completoActualizado"><?php echo htmlentities($_SESSION['Nombre']); ?> <?php echo htmlentities($_SESSION['Apellido']); ?></h2>
        				</div>
        				<div class="row">
        					<div class="col-lg-3">
        						<div class="cont3">

        							<p><ok>Username:</ok><label id="userActualizado"><?php echo htmlentities($_SESSION['username']); ?></label></p>
        							<p><ok>Nombre:</ok><label id="nombreActualizado"><?php echo htmlentities($_SESSION['Nombre']); ?></label></p>
        							<p><ok>Apellido:</ok><label id="apellActualizado"> <?php echo htmlentities($_SESSION['Apellido']); ?></label></p>
        							<p><ok>Horarios:</ok><label id="horariosActualizado"> <?php echo htmlentities($_SESSION['Horarios']); ?></label></p>
        						</div>
        					</div>
        					<div class="col-lg-4">
        						<div class="cont3">
        						<p><ok>FechaActualizacion:</ok><label id="horaActualizacion"> <?php echo htmlentities($_SESSION['FechaActualizacion']); ?></p>
        						<p><ok>Ultimo Login (anterior a este):</ok> <?php ultimo_inicio_sesion($_SESSION['user_id']); ?></p>
        						<p style="margin-right:0; margin-left:0; padding-right: 2px; padding-left: 2px;";><ok>eMail (usado para el inicio de sesión):</ok> <label id="eMailActualizado"> <?php echo htmlentities($_SESSION['email']); ?> </label></p>
        						</div>
        					</div>
        				</div><!-- /inner row -->
						<hr>
						<div class="cont2">
							<h2>Sistema Plus</h2>
						</div>
						<br>
							<div class="info-user2">
								<span aria-hidden="true" class="li_user fs1"></span>
								<span aria-hidden="true" class="li_settings fs1"></span>
								<span aria-hidden="true" class="li_mail fs1"></span>
								<span aria-hidden="true" class="li_key fs1"></span>
								<span aria-hidden="true" class="li_lock fs1"></span>
								<span aria-hidden="true" class="li_pen fs1"></span>
							</div>

        				
        			</div>
        		</div>

        	</div>

        	<div class="col-sm-6 col-lg-6">
        		<div id="register-wraper">
        		    <!-- <form id="Actualizar-form" class="form" name="Actualizar_form"> -->
        		        <legend>Quiero modificar algunos de mis datos</legend>
        		    
        		        <div class="body">
        		        	<!-- first name -->
    		        		<label for="name">Nombre</label>
    		        		<input name='name' id='name' class="input-huge" type="text">
        		        	<!-- last name -->
    		        		<label for="surname">Apellido</label>
    		        		<input name="surname" id='surname' class="input-huge" type="text">
        		        	<!-- username -->
        		        	<label for="horarios">Horarios</label>
        		        	<input name="horarios" id='horarios' class="Horarios" type="text">
        		        	<!-- email -->
        		        	<label for="email">eMail</label>
        		        	<input name="email" id='email' class="email" type="text">
        		        	<!-- password -->
        		        	<label for="username">Username (Se actualizará en el próximo inicio de sesión)</label>
        		        	<input name="username" id='username' class="username" type="text">
                            <input name='numerosesion' id='numerosesion' class='numerosesion' type='hidden' value=<?php echo htmlentities($_SESSION['user_id']); ?>>
        		            <label class="checkbox inline">
        		                Si no desea modificar algún campo, déjelo en blanco
        		            </label>
        		        </div>
        		    
        		        <div class="footer">
                        <input type="submit" id="boton1" value="Aceptar"/>   
        		        </div>
        		    <!-- </form> -->
        		</div>
        	</div>

        </div>
    </div>

	<!-- FOOTER -->	
	<div id="footerwrap">
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
      			<p><img src="assets/img/logo.png" alt=""></p>
      			<p>SistemaPlus - Copyright 2016-2018</p>
      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div><!-- /footerwrap -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/admin.js"></script>
	<?php else : ?>
    <link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/styleAncho.css">
    
            	<div class="container">
				<div class="top">
					<h1 id="title" class="hidden"><span id="logo">log<span>in</span></span></h1>
				</div>
				<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>Ingreso</h2>
				</div>
					<span class="error">No está autorizado para acceder a esta página.</span> Por favor vaya al <a href="index.html">login</a>.
            		</p>
				</div>
     <?php endif; ?>
  
</body></html>