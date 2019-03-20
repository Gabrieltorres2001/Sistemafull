<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/funcionesg.php';
include 'includes/funcPresupuestos.php';
include 'includes/funciones_Cambio_Moneda.php';
include 'funcionesPHP.php';
sec_session_start();
?>
<!doctype html>
<html><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>SISTEMAPLUS - Ordenes de compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- scripts 	-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/funcionesOC.js"></script>
	<script src="js/select2.min.js"></script>
	<!-- scripts 	-->

    <!-- Le styles 	-->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- <link href="css/main.css" rel="stylesheet">
    <!-- DATA TABLE CSS-->
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/formulario1.css" rel="stylesheet"> 	
	<!-- de EDITABLEGRID-->
		<script src="./editablegrid/editablegrid.js"></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_renderers.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_editors.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_validators.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_utils.js" ></script>
		<!-- [DO NOT DEPLOY] --><script src="./editablegrid/editablegrid_charts.js" ></script> 
		<link rel="stylesheet" href="./editablegrid/editablegrid.css" type="text/css" media="screen">
    <!-- de EDITABLEGRID-->

	<!-- de EDITABLEGRID
			body { font-family:'lucida grande', tahoma, verdana, arial, sans-serif; font-size:11px; }
			h1 { font-size: 15px; }
			a { color: #548dc4; text-decoration: none; }
			a:hover { text-decoration: underline; }
			table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 800px; }
			table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
			table.testgrid th { background: #E5E5E5; text-align: left; }
			input.invalid { background: red; color: #FDFDFD; }
	 de EDITABLEGRID-->
	<link href="css/select2.min.css" rel="stylesheet">
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif] -->

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
	<!-- include javascript and css files for jQuery UI, in order to have the datepicker -->
		<script src="js/jquery-1.6.4.min.js" ></script>

<link href="css/select2.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/select2.js"></script>

	
	<script type="text/javascript">
	$(document).ready(function() {
	  $("#empresa").select2();
	});
	</script>
	

    
  </head>
  <body>

    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if ((login_check($mysqli) == true) && (formulario_habilitado("OrdenesCompra") == true)) : ?>   
	<?php barraSuperior('OrdenesCompra') ?>

    <div class="container">
      <!-- CONTENT -->
<div id="acciones">
 
</div> <!-- /acciones -->
<div id="portada">

</div> <!-- /portada -->
<div id="listaComprobantes">

</div> <!-- /listaComprobantes -->

<div id="detallesdecomprobante">
</div> <!-- /detallesdecomprobante -->

<div id="informepresupuesto">
</div> <!-- /informepresupuesto -->

<div id="informeRemito">
</div> <!-- /informeRemito -->

<div id="fondoClaro">
</div> <!-- /fondoClaro -->

<div id="detallesdemovimientos">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:698px;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F;">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Detalle de articulo</label>
        <div style="position:absolute;
                  left:670px;
                  top:0px;
                  float=right;"><input type='button' id='cierraMovs' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:26px;
		  	  width:697px;
              border:1px solid #555;" id="detallesdemovimientosFRMAcciones">
        <input type='button' id='botonActualizaArticuloEnPresupuesto' value='Actualizar datos'/><label style="font-size:1.45em; font-weight:bold"> OJO! Los cambios se actualizarán automáticamente al cerrar esta ventana.</label>    
    </div><!-- /detallesdemovimientosFRMAcciones -->
    <div style="position:absolute;
              left:0px;
              top:54px;
              height:278px;
		  	  width:697px;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMSup">
        
    </div><!-- /detallesdemovimientosFRMSup -->
    <div style="position:absolute;
              left:0px;
              top:333px;
              height:262px;
		  	  width:697px;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMInf">
        
    </div><!-- /detallesdemovimientosFRMInf -->
</div> <!-- /detallesdemovimientos -->


<div id="agregarItemAlComprobante">
	<div style="position:absolute;
			  left:0px;
			  top:0px;
			  height:26px;
			  width:698px;
			  border-width:1px;
			  border-style:solid;
			  border-color:#000;
			  background-color:#30F;">
		<label style="font-size:1.45em; font-weight:normal; color:#FFF">Buscar y agregar articulo (un click muestra el detalle, doble click lo agrega)</label>
		<div style="position:absolute;
				  left:670px;
				  top:0px;
				  float=right;"><input type='button' id='cierraAgregarIt' value='X'/>
		</div>
	</div>
	<div style="position:absolute;
			  left:0px;
			  top:27px;
			  height:26px;
			  width:697px;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMAcciones">
		<label style="font-size:1.25em; font-weight:normal; color:#000">Buscar:</label>
		<input id='itemABuscar' class='input' name='itemABuscar' type='text' size='100'>
		<input type='button' id='botonBuscarArticuloEnPresupuesto' value='Buscar'/>    
	</div><!-- /agregarItemAlComprobanteFRMAcciones -->
	<div style="position:absolute;
			  left:0px;
			  top:54px;
			  height:278px;
			  width:697px;
			  overflow: auto;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMSup">
		
	</div><!-- /agregarItemAlComprobanteFRMSup -->
	<div style="position:absolute;
			  left:0px;
			  top:333px;
			  height:262px;
			  width:697px;
			  overflow: auto;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMInf">
		
	</div><!-- /agregarItemAlComprobanteFRMInf -->
</div> <!-- /agregarItemAlComprobante -->

<div id="unificarFormaPagoCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Definir forma de pago</label>
        <div style="position:absolute;
                  left:96.8%;
                  top:0px;
                  float=right;
				  visibility:hidden;"><input type='button' id='cierraFormaPago' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:85%;
		  	  width:100%;
              border:1px solid #555" id="unificarFormaPagoClienteFRMAcciones">
			  <label><b>La forma de pago registrada para este cliente no existe o no es clara.</b></label>
			  </br>
			  <label><b>La información que hoy tiene es:</b></label>
			  </br>
			  <label id='formaPagoHoy'></label>
			  </br>
			  </br>
			  <label><b>Por favor seleccione una forma de pago válida para este cliente, desde el siguiente listado:</b></label>
			  </br>
			  <div id='CondPagodiv'>

			  </div><!-- /CondPagodiv -->
			  <br />
			  <input type='button' id='botonActualizarCPContacto' value='Actualizar datos'/>
			  <label><b>Al presionar el botón se generará un nuevo presupuesto.</b></label>
    </div><!-- /unificarFormaPagoClienteFRMAcciones -->
</div> <!-- /unificarFormaPagoCliente -->

<div id="unificarTipoFacturaCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Definir tipo de comprobante</label>
        <div style="position:absolute;
                  left:96.8%;
                  top:0px;
                  float=right;
				  visibility:hidden;"><input type='button' id='cierraTipoFactura' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:85%;
		  	  width:100%;
              border:1px solid #555" id="unificarTipoFacturaClienteFRMAcciones">
			  <label><b>El tipo de comprobante registrado para este cliente no existe o no es claro.</b></label>
			  </br>
			  <label><b>La información que hoy tiene es:</b></label>
			  </br>
			  <label id='TipoFacturaHoy'></label>
			  </br>
			  </br>
			  <label><b>Por favor seleccione un tipo de comprobante válido para este cliente, desde el siguiente listado:</b></label>
			  </br>
			  <div id='TipoFacturadiv'>

			  </div><!-- /TipoFacturadiv -->
			  <br />
			  <input type='button' id='botonActualizarTFContacto' value='Actualizar datos'/>
			  <label><b>Al presionar el botón se generará un nuevo presupuesto.</b></label>
    </div><!-- /unificarTipoFacturaClienteFRMAcciones -->
</div> <!-- /unificarTipoFacturaCliente -->

</div> <!-- /tipoCambioAlPresupuesto -->

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