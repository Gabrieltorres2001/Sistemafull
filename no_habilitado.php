<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>SISTEMAPLUS: En construcción</title>
	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/styleAncho.css">
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
                <div class="container">
				<div class="top">
					<h1 id="title" class="hidden"><span id="logo">Sistema<span>Plus</span></span></h1>
				</div>
				<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>Opss, <?php echo htmlentities($_SESSION['username']); ?>!</h2>
				</div>
            <p>
                Lamentablemente esta función no se encuentra habilitada.
                <p>Regresar al <a href="protected_page2.php">Sistema</a></p>
            </p>
        <?php else : ?>
            	<div class="container">
				<div class="top">
					<h1 id="title" class="hidden"><span id="logo">Sistema<span>Plus</span></span></h1>
				</div>
				<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>Ingreso</h2>
				</div>
					<span class="error">No está autorizado para acceder a esta página.</span> Por favor vaya al <a href="index.html">login</a>.
            		</p>
				</div>
        <?php endif; ?>
    </body>
</html>