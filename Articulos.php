<?php
include 'appConfig.php';

$app = $homeLinks['Articulos'];

include 'includes/funcArticulos.php';
include 'header.php';

sec_session_start();

?>
<!-- app js -->
<script src="js/funcionesArticulos.js"></script>

</head>

<body>

  <?php
  if (login_check($mysqli) == true) {
    // SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR
    echo upperMenu($app['title']);
    ?>

    <div class="container">

      <div class="card-group">
        <div class="card card-h card-left">
          <div class="card-header">
            <?php echo searchOption('Articulos'); ?>
          </div>
          <div class="card-body">
            <?php
            echo llenar_listado_articulos();
            ?>
          </div>
        </div>
        <div class="card card-h card-right">
          <div class="card-header">
            <?php
            echo actionBar('Articulos', 'artículo');
            ?>
          </div>
          <div class="card-body">
            <div id="detallesdearticulo"></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div id="detallesdemovimientos" class="card collapsed-card card-button">
            <div class="card-header">
              <label>Movimientos</label>
              <div class="card-tools">
                <button id = "refresh" type="button" class="btn btn-tool" ><i class="fa fa-refresh"></i></button>
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div id="movimientosdearticulo">No se seleccionó ningún artículo</div>
            </div>
          </div>
        </div>
      </div>

      <div id="movimientos-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="movimientos-modal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
          <div class="modal-content bg-gray-light">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle">Detalle del documento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="detallesdemovimientosFRMSup">
              </div>
              <div id="detallesdemovimientosFRMInf">
              </div>
            </div>
          </div>
        </div>
      </div>


      


      <div id="estapsesion" style="visibility:hidden;">
        <input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']); ?>" />
      </div>

      <div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float:center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
    </div>

  <?php }

include 'footer.php';
