<?php
include 'appConfig.php';

$app = $homeLinks['ArticulosPublicos'];


include 'includes/funcArticulos.php';
include 'header.php';

sec_session_start();
?>
  <link href="css/table.css" rel="stylesheet"> 
  <script src="js/funcionesarticulospublicos.js"></script>   
    
  <!-- DataTables Initialization -->
  <script type="text/javascript" src="js/jquery.dataTables.js"></script>

  <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
          $('#dt1').dataTable();
        } );
  </script>	
    
</head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) { ?>
  <?php 
  echo upperMenu('Articulos') ?>

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

<div id="estapsesion" style="visibility:hidden;">
<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->


	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>

    <?php }
    include 'footer.php';
    