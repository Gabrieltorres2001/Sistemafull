<?php
include 'appConfig.php';

//changue app config.
$app = $homeLinks['test'];

//inlcude own app function
include 'includes/funcEmpresas.php';

include 'header.php';

sec_session_start();

?>
    <!-- app js -->
  	<!-- DataTables Initialization -->
    <script src="js/funcionesEmpresas.js"></script>
	
    
  </head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) { ?>  
	<?php echo upperMenu('Empresas') ?>

    <div class="container">

    <div class="card-group">
        <div class="card card-h card-left">
          <div class="card-header">
            <?php 
            echo searchOption('Empresas'); 
            ?>
          </div>
          <div class="card-body">
            <?php
            echo llenar_listado_empresas();
            ?>
          </div>
        </div>
        <div class="card card-h card-right">
          <div class="card-header">
          <div id="accionesDetalle">
            <?php
            //llenar_acciones_empresas(htmlentities($_SESSION['user_id']));
            echo actionBar('Contactos', 'empresa');
            ?>
            </div> <!-- /accionesDetalle -->
          </div>
          <div class="card-body">
              <!-- cuerpo de la tarjeta -->
              <div id="detallesdeempresas">

              </div> <!-- /detallesdeempresas -->
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div id="button-card" class="card collapsed-card card-button">
            <div class="card-header">
              <label>titulo</label>
              <div class="card-tools">
                <button id = "refresh" type="button" class="btn btn-tool" ><i class="fa fa-refresh"></i></button>
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <!-- cuerpo de la tarjeta  -->
              <div id="empresaenafip">

              </div> <!-- /empresaenafip -->
            </div>
          </div>
        </div>
      </div>



      	
       
	<div id="empresas">
<?php

?>
</div> <!-- /empresas -->





		 </div> <!-- /container -->
		 
	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	<?php 
		}
		include 'footer.php';