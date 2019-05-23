<?php
$titulo ="SISTEMAPLUS - Ultimas Ventas";
include 'header.php';

include 'includes/funcArticulos.php';
sec_session_start();
?>
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/formulario2.css" rel="stylesheet"> 
	<script src="js/funcionesultimasventas.js"></script>   
	
  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {$('#dt1').dataTable();});
	</script>	
    
  </head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if ((login_check($mysqli) == true) && (formulario_habilitado("UltimasVentas") == true)) { ?>
	<?php echo upperMenu($app) ?>

    <div class="container">
      <!-- CONTENT -->
      	<div id="acciones">

        </div> <!-- /acciones -->
        <div id="accionesDetalle">
        <?php
         //llenar_acciones_articulos(htmlentities($_SESSION['user_id']));
		 ?>
        </div> <!-- /accionesDetalle -->
	<div id="articulos">
Seleccione un proveedor.
</div> <!-- /articulos -->

<div id="detallesdearticulo">

</div> <!-- /detallesdearticulo -->

<div id="movimientosdearticulo">

</div> <!-- /movimientosdearticulo -->

<div id="caja2">

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
    <?php }
    include 'footer.php';