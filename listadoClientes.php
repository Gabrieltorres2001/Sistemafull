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
    <title>SISTEMAPLUS - Listas de clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- scripts 	-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/funcioneslistaclientes.js"></script>
	<!-- scripts 	-->

    <!-- Le styles 	-->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- <link href="css/main.css" rel="stylesheet">
    <!-- DATA TABLE CSS-->
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/listaclientes.css" rel="stylesheet"> 
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
			$(document).ready(function() {
				$('#dt1').dataTable();
			} );
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
	<?php barraSuperior('ListasClientes') ?>

    <div class="container">
      <!-- CONTENT -->
<div id="Listas">
</div> <!-- /Listas -->

<div id="ClientesEnLista">
</div> <!-- /ClientesEnLista -->

<div id="accionesContactos">
</div> <!-- /accionesContactos -->

<div id="ContactosFueraLista">
</div> <!-- /ContactosFueraLista -->

<div id="detallesdePagos">
</div> <!-- /detallesdePagos -->

<div id="informepresupuesto">
</div> <!-- /informepresupuesto -->

<div id="fondoClaro">
</div> <!-- /fondoClaro -->

<div id="nuevoItem">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Agregar pago</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraMovsAgPago' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:96px;
		  	  width:100%;
              border:1px solid #555" id="agregarPagoFRMAcciones">
					<table class='display' style='background-color: #f5f5f5; font-size:1.15em' id='tablaDetallePagoNuev'>
					<tr>
					<th width='10'>Fecha</th>
					<th width='12'>Forma de pago</th>
					<th width='4'>Moneda</th>
					<th width='4'>Importe</th>
					<th width='16'>Descripcion</th>
					<th width='1'></th>
					</tr>
					<tr id='R00'>
					<td name='xxxx00' id='00&Fecha'  height='50'> </td>
					<td name='xxxx00' id='00&Forma'> </td>
					<td name='xxxx00' id='00&Moneda'> </td>
					<td name='xxxx00' id='00&Importe'> </td>
					<td name='xxxx00' id='00&Descripcion'> </td>
					<td name='xxxx00' id='00&0&action'><img name='xxxxA' src='./images/Ok.jpg' width='32' height='32'></td>
					</tr>
					</table>  
    </div><!-- /detallesdemovimientosFRMAcciones -->
</div> <!-- /fondoClaro -->

<div id="informeDeDeudores">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Deudores</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraDeudores' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:95.5%;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verDeudores">  
    </div><!-- /detallesdemovimientosFRMAcciones -->
</div> <!-- /informeDeDeudores -->

<div id="informeDeCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label id="tituloCCC" style="font-size:1.05em; font-weight:normal; color:#FFF">Cuenta de cliente</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraInfCliente' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:32px;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verInfClienteOPCS">  
    </div><!-- /verInfClienteOPCS -->
    <div style="position:absolute;
              left:0px;
              top:60px;
              height:89%;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verInfCliente">  
    </div><!-- /verInfCliente -->
</div> <!-- /informeDeCliente -->

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
<input type="text" id="estaEmpresa" name="estaEmpresa" value="<?php que_empresa_soy();?>"/>
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