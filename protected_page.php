<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Inicio de sesión segura: Página protegida</title>
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
					<h1 id="title" class="hidden"><span id="logo">log<span>in</span></span></h1>
				</div>
				<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>Bienvenid@, <?php echo htmlentities($_SESSION['username']); ?>!</h2>
				</div>
            <p>
                Este es el acceso a Sistema Plus. Aquí comienzan las páginas protegidas. Para acceder a esta página, los usuarios
                deberán iniciar su sesión.  Más adelante, también verificaremos el rol del usuario para que las páginas puedan determinar el tipo de usuario autorizado para acceder a cada página. Además se comenzarán a registrar las acciones, como modificaciones en los datos del sistema, y relacionarlos con los usuarios para mejorar el seguimiento de los trabajos.
                <p>Ingresar al <a href="protected_page2.php">Sistema</a></p>
            </p>
            <p>Regresar a la <a href="index.html">página de inicio de sesión.</a></p>
        <?php else : ?>
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
    </body>
</html>