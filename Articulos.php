<?php
include 'appConfig.php';

$app = $homeLinks['Articulos'];

include 'includes/funcArticulos.php';
include 'header.php';

sec_session_start();

?>
<!-- app js -->
<script src="js/funcionesarticulos.js"></script>

</head>

<body>

  <?php
  if (login_check($mysqli) == true) {
    // SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR
    upperMenu($app['title']);
    ?>

    <div class="container">

      <!-- parte inferior -->
      <div class="card-group">
          <div class="card card-h">
            <div class="card-header">
              <div class="input-group">
                <input id="buscadorArticulo" type="text" class="form-control" placeholder="ingrese su búsqueda..." aria-label="ingrese su búsqueda..." aria-describedby="buscar" name="buscadorArticulo">
                <div class="input-group-append">
                  <button id="botonBuscadorArticulo" class="btn btn-secondary" type="button" id="buscar" value="Buscar"><i class="fa fa-search"></i></button>
                  <button id="botonBuscadorborrar" class="btn btn-secondary" type="button" id="borrar" value="Borrar"><i class="fa fa-close"></i></button>
                </div>
              </div>
            </div>
            <!-- listado -->
            <div class="card-body">
              <?php
                echo llenar_listado_articulos();
              ?>
            </div>
          </div>
        <!-- acciones detalle -->
          <div class="card card-h">
            <div class="card-header">
              <?php
                include('php/llenar_acciones_articulos.php');
              ?>
            </div>
            <!-- detalle -->
            <div class="card-body">
              <div id="detallesdearticulo"></div>
            </div>
          </div>
        </div>

      <!-- /parte inferior -->

      <!-- cajas inferiores -->
      <div class="row">
        <div class="col-md-12">
          <div id="detallesdemovimientos" class="card collapsed-card">
            <div class="card-header">
              <label>Detalle de movimientos</label>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div id="movimientosdearticulo"></div>
            </div>
          </div>

          <div id="detallesdemovimientosFRMSup">
            1
          </div><!-- /detallesdemovimientosFRMSup -->
          <div id="detallesdemovimientosFRMInf">
            2
          </div><!-- /detallesdemovimientosFRMInf -->
        </div>
      </div>

    </div>

    <div id="estapsesion" style="visibility:hidden;">
      <input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']); ?>" />
    </div> <!-- /estapsesion -->

    <!-- /mensaje auto ocultable -->
    <div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float:center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>

  <?php }

include 'footer.php';
