<?php
include 'appConfig.php';

//changue app config.
$app = $homeLinks['test'];

//inlcude own app function
//include 'includes/funcArticulos.php';

include 'header.php';

sec_session_start();

?>
<!-- app js -->
<!-- <script src="js/funcionesArticulos.js"></script> -->

</head>

<body>

  <?php
  if (login_check($mysqli) == true) {
    // SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR
    //echo upperMenu($app['title']);
    ?>

    <div class="container">

      <div class="card-group">
        <div class="card card-h card-left">
          <div class="card-header">
            <?php 
            //echo searchOption('Articulos'); 
            ?>
          </div>
          <div class="card-body">
            <?php
            //echo llenar_listado_articulos();
            ?>
          </div>
        </div>
        <div class="card card-h card-right">
          <div class="card-header">
            <?php
            //echo actionBar('Articulos', 'artículo');
            ?>
          </div>
          <div class="card-body">
              <!-- cuerpo de la tarjeta -->
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
            
            </div>
          </div>
        </div>
      </div>

      <div id="new-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="new-modal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
          <div class="modal-content bg-gray-light">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle">titulo ventana modal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <!-- cuerpo de la ventana -->
            </div>
          </div>
        </div>
      </div>

    </div>

  <?php }

include 'footer.php';
