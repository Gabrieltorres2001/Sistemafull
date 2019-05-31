<?php
$titulo = "SISTEMAPLUS - Empresa";

include 'includes/funcEmpresas.php';
include 'header.php';
sec_session_start();
?>
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/formulario2.css" rel="stylesheet">

	<script src="js/funcionesempresas.js"></script>
    
  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  	<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#dt1').dataTable();
			} );
	</script>

	
	<script type="text/javascript">
	$(document).ready(function() {$("#empresa").select2();});
	</script>
    
  </head>
  <body>
    
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if (login_check($mysqli) == true) { ?>  
	<?php echo upperMenu('Empresas') ?>

    <div class="container">
      <!-- CONTENT -->
      	<div id="acciones">
        <p>
        <!--<ul class="nav navbar-nav">
              <li>  Ordenar por:  </li>
        </ul>-->

         <label style="font-size:1em; font-weight:normal" for="buscadorEmpresa">Buscar: </label>
         <input type="text" class='input' style="width:68%" name="buscadorEmpresa" id='buscadorEmpresa'>
         <input type="button" id="botonBuscadorEmpresa" value="Buscar"/>
         </br>
         </p>
         <p>
         <input type="button" id="botonBuscarPor" value="Buscar por:"/>
         <label id="buscarPor" style="font-size:0.8em; font-weight:normal">Organización, Actividad Empresa, CUIT</label>
         </p>
        </div> <!-- /acciones -->
        <div id="accionesDetalle">
        <?php
         //llenar_acciones_empresas(htmlentities($_SESSION['user_id']));
		    ?>
        </div> <!-- /accionesDetalle -->
	<div id="empresas">
<?php
llenar_listado_empresas();
?>
</div> <!-- /empresas -->

<div id="detallesdeempresas">

</div> <!-- /detallesdeempresas -->

<div id="empresaenafip">

</div> <!-- /empresaenafip -->

<div id="caja2">
<p>Selector de campos de búsqueda</p>
<p>
     <input type="checkbox" name="listaCamposBusquedaNombre" checked>Nombre completo de la empresa</br>
     <input type="checkbox" name="listaCamposBusquedaActividad" checked>Actividad de la empresa</br>
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

<div id="fondoClaro">

</div> <!-- /fondoClaro -->

<div id="detallesdemovimientos">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	      width:498px;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F;">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Agregar nuevo descuento</label>
        <div style="position:absolute;
                  left:470px;
                  top:0px;
                  float=right;"><input type='button' id='cierraMovs' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:102px;
		  	      width:497px;
              border:1px solid #555;" id="detallesdemovimientosFRMAcciones">
    <table>
		<tr>
		<th>Porcentaje</th>
		<th>Fecha</th>
		<th>Tipo</th>
		</tr>
		<tr name='DescuentoEmpresa'>
			<th><input id='Porcentaje' class='input' type='text' size='14' value=''>%</th>
			<th><input id='Fecha' class='input' type='text' size='20' value='' readonly='readonly'></th>
			<th id='Tipo'></th>
			</tr>
		</table>	
    <label style="font-size:0.75em;">Porcentaje positivo es descuento, negativo es recargo.</label> 
		<br />
        <input type='button' id='botonAgregaDescuento' value='Agregar'/>   
    </div><!-- /detallesdemovimientosFRMAcciones -->
    
    
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
	<?php 
		}
		include 'footer.php';