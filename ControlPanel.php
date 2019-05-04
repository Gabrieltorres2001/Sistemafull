<?php
$titulo = 'SISTEMAPLUS - Panel de control';
include 'includes/funcContactos.php';
include 'includes/funcionesPanel.php';
include 'header.php';
sec_session_start();
?>
    <link href="css/table.css" rel="stylesheet">     
    <link href="css/formulario2.css" rel="stylesheet">

	<script src="js/funcionesPanel.js"></script>
    

  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {$('#dt1').dataTable();});
	</script>

	<script type="text/javascript">
	$(document).ready(function() {$("#empresa").select2();});
	</script>
    
  </head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) { ?>  
	<?php upperMenu('ControlPanel') ?>

    <div class="container">
      <!-- CONTENT -->
      	<div id="acciones">
			<?php
			 //sideBar();
			 ?>
        </div> <!-- /acciones -->
        <div id="accionesDetalle">
			<?php
			 //llenar_acciones_contactos(htmlentities($_SESSION['user_id']));
			 ?>
        </div> <!-- /accionesDetalle -->
		<div id="ControlPanelMenu">
			<?php
			llenar_listado_Panel();
			?>
		</div> <!-- /ControlPanelMenu -->

		<div id="ControlPanelDetalles">

		</div> <!-- /ControlPanelDetalles -->

		<div id="movimientosControlP">

		</div> <!-- /movimientosControlP -->

     </div> <!-- /container -->

<div id="estapsesion"  style="visibility:hidden;">
	<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->


	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
		<?php }

		include 'footer.php';