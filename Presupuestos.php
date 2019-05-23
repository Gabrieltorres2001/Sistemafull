<?php
include 'appConfig.php';

//changue app config.
$app = $homeLinks['Presupuesto'];

//inlcude own app function
include 'includes/funcEmpresas.php';

include 'header.php';

sec_session_start();
?>
		<!-- scripts 	-->
		
		<script src="js/funcionespresupuestos.js"></script>

    <!-- DATA TABLE CSS-->	
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/formulario1.css" rel="stylesheet"> 	
		
    
  </head>
  <body>

    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if ((login_check($mysqli) == true) && (formulario_habilitado("Presupuesto") == true)){ ?>   
	<?php echo upperMenu($app) ?>
	
    <div class="container">
      <!-- CONTENT -->
<div id="acciones">
 
</div> <!-- /acciones -->
<div id="portada">

</div> <!-- /portada -->
<div id="listaComprobantes">
</div> <!-- /listaComprobantes -->

<div id="detallesdecomprobante">



</div> <!-- /detallesdecomprobante -->

<div id="informepresupuesto">

</div> <!-- /informepresupuesto -->

<div id="informeRemito">

</div> <!-- /informeRemito -->

<div id="fondoClaro">

</div> <!-- /fondoClaro -->

<div id="detallesdemovimientos">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:698px;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F;">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Detalle de articulo</label>
        <div style="position:absolute;
                  left:670px;
                  top:0px;
                  float=right;"><input type='button' id='cierraMovs' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:26px;
		  	  width:697px;
              border:1px solid #555;" id="detallesdemovimientosFRMAcciones">
        <input type='button' id='botonActualizaArticuloEnPresupuesto' value='Actualizar datos'/><label style="font-size:1.45em; font-weight:bold"> OJO! Los cambios se actualizarán automáticamente al cerrar esta ventana.</label>    
    </div><!-- /detallesdemovimientosFRMAcciones -->
    <div style="position:absolute;
              left:0px;
              top:54px;
              height:278px;
		  	  width:697px;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMSup">
        
    </div><!-- /detallesdemovimientosFRMSup -->
    <div style="position:absolute;
              left:0px;
              top:333px;
              height:262px;
		  	  width:697px;
              overflow: auto;
              border:1px solid #555;" id="detallesdemovimientosFRMInf">
        
    </div><!-- /detallesdemovimientosFRMInf -->
</div> <!-- /detallesdemovimientos -->


<div id="agregarItemAlComprobante">
	<div style="position:absolute;
			  left:0px;
			  top:0px;
			  height:26px;
			  width:698px;
			  border-width:1px;
			  border-style:solid;
			  border-color:#000;
			  background-color:#30F;">
		<label style="font-size:1.45em; font-weight:normal; color:#FFF">Buscar y agregar articulo (un click muestra el detalle, doble click lo agrega)</label>
		<div style="position:absolute;
				  left:670px;
				  top:0px;
				  float=right;"><input type='button' id='cierraAgregarIt' value='X'/>
		</div>
	</div>
	<div style="position:absolute;
			  left:0px;
			  top:27px;
			  height:26px;
			  width:697px;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMAcciones">
		<label style="font-size:1.25em; font-weight:normal; color:#000">Buscar:</label>
		<input id='itemABuscar' class='input' name='itemABuscar' type='text' size='100'>
		<input type='button' id='botonBuscarArticuloEnPresupuesto' value='Buscar'/>    
	</div><!-- /agregarItemAlComprobanteFRMAcciones -->
	<div style="position:absolute;
			  left:0px;
			  top:54px;
			  height:278px;
			  width:697px;
			  overflow: auto;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMSup">
		
	</div><!-- /agregarItemAlComprobanteFRMSup -->
	<div style="position:absolute;
			  left:0px;
			  top:333px;
			  height:262px;
			  width:697px;
			  overflow: auto;
			  border:1px solid #555;" id="agregarItemAlComprobanteFRMInf">
		
	</div><!-- /agregarItemAlComprobanteFRMInf -->
</div> <!-- /agregarItemAlComprobante -->

<div id="unificarFormaPagoCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Definir forma de pago</label>
        <div style="position:absolute;
                  left:96.8%;
                  top:0px;
                  float=right;
				  visibility:hidden;"><input type='button' id='cierraFormaPago' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:85%;
		  	  width:100%;
              border:1px solid #555" id="unificarFormaPagoClienteFRMAcciones">
			  <label><b>La forma de pago registrada para este cliente no existe o no es clara.</b></label>
			  </br>
			  <label><b>La información que hoy tiene es:</b></label>
			  </br>
			  <label id='formaPagoHoy'></label>
			  </br>
			  </br>
			  <label><b>Por favor seleccione una forma de pago válida para este cliente, desde el siguiente listado:</b></label>
			  </br>
			  <div id='CondPagodiv'>

			  </div><!-- /CondPagodiv -->
			  <br />
			  <input type='button' id='botonActualizarCPContacto' value='Actualizar datos'/>
			  <label><b>Al presionar el botón se generará un nuevo presupuesto.</b></label>
    </div><!-- /unificarFormaPagoClienteFRMAcciones -->
</div> <!-- /unificarFormaPagoCliente -->

<div id="unificarTipoFacturaCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Definir tipo de comprobante</label>
        <div style="position:absolute;
                  left:96.8%;
                  top:0px;
                  float=right;
				  visibility:hidden;"><input type='button' id='cierraTipoFactura' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:85%;
		  	  width:100%;
              border:1px solid #555" id="unificarTipoFacturaClienteFRMAcciones">
			  <label><b>El tipo de comprobante registrado para este cliente no existe o no es claro.</b></label>
			  </br>
			  <label><b>La información que hoy tiene es:</b></label>
			  </br>
			  <label id='TipoFacturaHoy'></label>
			  </br>
			  </br>
			  <label><b>Por favor seleccione un tipo de comprobante válido para este cliente, desde el siguiente listado:</b></label>
			  </br>
			  <div id='TipoFacturadiv'>

			  </div><!-- /TipoFacturadiv -->
			  <br />
			  <input type='button' id='botonActualizarTFContacto' value='Actualizar datos'/>
			  <label><b>Al presionar el botón se generará un nuevo presupuesto.</b></label>
    </div><!-- /unificarTipoFacturaClienteFRMAcciones -->
</div> <!-- /unificarTipoFacturaCliente -->

</div> <!-- /tipoCambioAlPresupuesto -->

     </div> <!-- /container -->
    	<br>	
      	<br>
<div id="estapsesion" style="visibility:hidden;">
<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->


	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<?php }
		 
		 include 'footer.php';