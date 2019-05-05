<?php
include 'appConfig.php';
$titulo = "Ingreso diario: Error";
include 'header.php';
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
  $error = 'Ocurrió un error desconocido';
}
?>

	<!-- page Stylesheet -->
	<link rel="stylesheet" href="css/style.css">
	<!-- page js libs -->

</head>

<body>

	<div class="container login">
		<div class="mx-auto text-center animated fadeInDown">
			<h1 id="title"><span id="logo">log<span>in</span></span></h1>
		</div>
		<div class="card w-50 animated fadeInUp text-center mx-auto">
			<div class="card-header">
				<h2>Hubo un problema</h2>
			</div>
        <p class="error"><?php echo $error; ?></p>  
        <p>Regresar a la página de <a class = "btn btn-light" href="index.php">login</a></p>
		</div>
	</div>
</body>

</html>