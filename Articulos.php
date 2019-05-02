<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'includes/funcionesg.php';
include 'includes/funcArticulos.php';
include 'includes/funciones_Cambio_Moneda.php';
include 'funcionesPHP.php';
sec_session_start();
?>
<!doctype html>
<html><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>SISTEMAPLUS - Articulos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- <link href="css/main.css" rel="stylesheet">-->
    <!-- DATA TABLE CSS -->
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/formulario2.css" rel="stylesheet"> 
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/funcionesarticulos.js"></script>   
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

	<link href="css/select2.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<script src="js/select2.js"></script>
	
  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {$('#dt1').dataTable();});
	</script>	
    
  </head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) : ?>
	<?php barraSuperior('Articulos') ?>

    <div class="container">
      <!-- CONTENT -->
      	<div id="acciones">
        <p>
        Ordenar por:
        <select id="ordenPor" class='input' name="ordenPor">
            <option selected value="1">id</option>
            <option value="2">Descripción</option>
            <option value="3">Proveedor</option>
            <option value="4">Valor - a +</option>
            <option value="5">Valor + a -</option>
            <option value="6">Stock - a +</option>
            <option value="7">Stock + a -</option>
         </select>
         <label style="font-size:1em; font-weight:normal" for="buscadorArticulo">Buscar: </label>
         <input type="text" class='input' style="width:36%" name="buscadorArticulo" id='buscadorArticulo'>
         <input type="button" id="botonBuscadorArticulo" value="Buscar"/>
         </br>
         </p>
         <p>
         <input type="button" id="botonBuscarPor" value="Buscar por:"/>
         <label id="buscarPor" style="font-size:0.8em; font-weight:normal">Codigo, Descripción, Proveedor, Código del proveedor</label>
         </p>
        </div> <!-- /acciones -->
        <div id="accionesDetalle">
        <?php
         //llenar_acciones_articulos(htmlentities($_SESSION['user_id']));
		 ?>
        </div> <!-- /accionesDetalle -->
	<div id="articulos">
<?php
llenar_listado_articulos();
?>
</div> <!-- /articulos -->

<div id="detallesdearticulo">

</div> <!-- /detallesdearticulo -->

<div id="movimientosdearticulo">

</div> <!-- /movimientosdearticulo -->

<div id="caja2">
<p>Selector de campos de búsqueda</p>
<p>
     <input type="checkbox" name="listaCamposBusquedaNombre" checked>Descripción del artículo</br>
     <input type="checkbox" name="listaCamposBusquedaEmpresa" checked>Código</br>
     <input type="checkbox" name="listaCamposBusquedaActividad" checked>Proveedor</br>
     <input type="checkbox" name="listaCamposBusquedaFuncion" checked>Código del proveedor</br>                         
</p>
<p>
<label style="font-size:0.7em; font-weight:bold; color:red">Esta funcionalidad aún no se encuentra implementada.</label>
</br>
<label style="font-size:0.7em; font-weight:bold; color:red">La búsqueda se hará en todos los campos.</label>
</p>
<p>
       <input type='button' id='botonAceptarBuscarPor' value='Aceptar'/>
</p>
</div> <!-- /caja2 -->
<div id="detallesdemovimientos">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F;">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Detalle de movimientos</label>
        <div style="position:absolute;
                  left:97.4%;
                  top:0px;
                  float=right;"><input type='button' id='cierraMovs' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:137px;
		  	  width:100%;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMSup">
        
    </div><!-- /detallesdemovimientosFRMSup -->
    <div style="position:absolute;
              left:0px;
              top:165px;
              height:312px;
		  	  width:100%;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMInf">
        
    </div><!-- /detallesdemovimientosFRMInf -->
</div> <!-- /detallesdemovimientos -->

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