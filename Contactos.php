<?php
$titulo = "Contactos";

include 'includes/funcContactos.php';
include 'header.php';
sec_session_start();
?>
    <link href="css/table.css" rel="stylesheet">     
    <link href="css/formulario2.css" rel="stylesheet">

	  <script src="js/funcionescontactos.js"></script>
    
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
  <?php 
  echo upperMenu($titulo);
  ?>

    <div class="container">
      <!-- CONTENT -->
      	<div id="acciones">
        <p>
        <!--<ul class="nav navbar-nav">
              <li>  Ordenar por:  </li>
        </ul>-->

        Ordenar por:  
        <select id="ordenPor" class='input' name="ordenPor">
            <!--<option selected value="1">id</option>-->
            <option value="2">Contacto</option>
            <option selected value="3">Empresa</option>
         </select>
         <label style="font-size:1em; font-weight:normal" for="buscadorContacto">Buscar: </label>
         <input type="text" class='input' style="width:32%" name="buscadorContacto" id='buscadorContacto'>
         <input type="button" id="botonBuscadorContacto" value="Buscar"/>
         </br>
         </p>
         <p>
         <input type="button" id="botonBuscarPor" value="Buscar por:"/>
         <label id="buscarPor" style="font-size:0.8em; font-weight:normal">Nombre, Organización, Actividad Empresa, Función, Palabras clave, CUIT</label>
         </p>
        </div> <!-- /acciones -->
        <div id="accionesDetalle">

        </div> <!-- /accionesDetalle -->
	<div id="contactos">
<?php
llenar_listado_contactos();
?>
</div> <!-- /contactos -->

<div id="detallesdecontacto">

</div> <!-- /detallesdecontacto -->

<div id="movimientosdecontacto">

</div> <!-- /movimientosdecontacto -->

<div id="caja2">
<p>Selector de campos de búsqueda</p>
<p>
     <input type="checkbox" name="listaCamposBusquedaNombre" checked>Nombre completo del contacto</br>
     <input type="checkbox" name="listaCamposBusquedaEmpresa" checked>Empresa</br>
     <input type="checkbox" name="listaCamposBusquedaActividad" checked>Actividad de la empresa</br>
     <input type="checkbox" name="listaCamposBusquedaFuncion" checked>Funcion en la empresa</br>
     <input type="checkbox" name="listaCamposBusquedaPalClave" checked>Palabras clave</br>
     <input type="checkbox" name="listaCamposBusquedaCUIT" checked>CUIT</br>                         
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