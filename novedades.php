<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/funcionesg.php';
include 'includes/funciones_Novedades.php';
include 'funcionesPHP.php';
sec_session_start();
?>
<!doctype html>
<html><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>SISTEMAPLUS - Novedades</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- scripts 	-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/funcionesNovedades.js"></script>
	<!-- scripts 	-->

    <!-- Le styles 	-->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- <link href="css/main.css" rel="stylesheet">
    <!-- DATA TABLE CSS-->
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/novedades.css" rel="stylesheet"> 
	<!-- de EDITABLEGRID-->
		<script src="./editablegrid/editablegrid.js"></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_renderers.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_editors.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_validators.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_utils.js" ></script>
		<!-- [DO NOT DEPLOY] --><script src="./editablegrid/editablegrid_charts.js" ></script> 
		<link rel="stylesheet" href="./editablegrid/editablegrid.css" type="text/css" media="screen">
    <!-- de EDITABLEGRID-->
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

  	<!-- Google Fonts call. Font Used Open Sans -->
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {$('#dt1').dataTable();});
	</script>

	<!-- include javascript and css files for jQuery UI, in order to have the datepicker 
		<script src="js/jquery-ui-1.8.16.custom.min.js" ></script>
		<link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css" type="text/css" media="screen">
		<script src="js/jquery-1.6.4.min.js" ></script>-->
	
<!-- a verr -->	
			<script src="./editablegrid/editablegrid.js"></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_renderers.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_editors.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_validators.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/	editablegrid_utils.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="js/editablegrid_charts.js" ></script>
		<!--<link rel="stylesheet" href="css/editablegrid.css" type="text/css" media="screen"> -->

		<!--  include javascript and css files for jQuery UI, in order to have the datepicker -->
		<script src="js/jquery-1.6.4.min.js" ></script>
		<script src="js/jquery-ui-1.8.16.custom.min.js" ></script>
		<link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css" type="text/css" media="screen">
	
		<!-- para select2 -->
		<link href="css/select2custom.css" rel="stylesheet">
		<script src="js/jquery.js"></script>
		<script src="js/select2.js"></script>


		<!--  otro agregado para que anden datepicker Y A LA VEZ select2-->
		   <script src="js/jquery-ui.js"></script>
		  <script>
		  $( function() {
			$( "#datepicker" ).datepicker();
		  } );
		  </script>
		  
</head>
<body>  
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) : ?>   
	<?php barraSuperior('Novedades') ?>

    <div class="container">
      <!-- CONTENT -->
<div id="HistorialNovedades">
		
</div> <!-- /HistorialNovedades -->

<div id="CambioMonedaActual">
</div> <!-- /CambioMonedaActual -->

<div id="CambioMonedaNuevo">
	<fieldset style='width:95%'>
		<legend>Cargar una nueva novedad</legend>
		<P style='font-size:15px' align='center' id="horaMonedaNuevo"></P>

				<textarea cols="40" rows="9" style="width:100%; height:70px;" name="NuevaNovedad" id="NuevaNovedad" maxlength="120" value=""></textarea>

		<P align='center'><input type='button' id='nuevoCambio' value='Guardar cambios'/></P>
	</fieldset>
</div> <!-- /CambioMonedaNuevo -->

<div id="datosAfip">
</div> <!-- /datosAfip -->

     </div> <!-- /container -->
    	<br>	
      	<br>
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

<div id="estapsesion" style="visibility:hidden;">
<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->

	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
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