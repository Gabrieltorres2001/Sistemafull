<?php
$titulo = "SISTEMAPLUS - Listas de clientes";

include 'header.php';

sec_session_start();
?>
	<script src="js/funcioneslistaclientes.js"></script>
    <link href="css/table.css" rel="stylesheet"> 
    <link href="css/listaclientes.css" rel="stylesheet"> 
	<!-- de EDITABLEGRID-->
		<script src="./editablegrid/editablegrid.js"></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_renderers.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_editors.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_validators.js" ></script>
		<!-- [DO NOT DEPLOY] --> <script src="./editablegrid/editablegrid_utils.js" ></script>
		<!-- [DO NOT DEPLOY] --><script src="./editablegrid/editablegrid_charts.js" ></script> 
		<link rel="stylesheet" href="./editablegrid/editablegrid.css" type="text/css" media="screen">
    <!-- de EDITABLEGRID-->
    <style type="text/css">

    </style>

  	<!-- DataTables Initialization -->
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
  			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {$('#dt1').dataTable();});
	</script>

		<!--  otro agregado para que anden datepicker Y A LA VEZ select2-->
		   <script src="js/jquery-ui.js"></script>
		  <script>
		  $( function() {
			$( "#datepicker" ).datepicker();
		  } );
		  </script>
		  
</head>
<body>  
    <!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
    <?php if ((login_check($mysqli) == true) && (formulario_habilitado("listadoClientes") == true)) { ?>   
	<?php echo upperMenu($app) ?>

    <div class="container">
      <!-- CONTENT -->
<div id="Listas">
</div> <!-- /Listas -->

<div id="ClientesEnLista">
</div> <!-- /ClientesEnLista -->

<div id="accionesContactos">
</div> <!-- /accionesContactos -->

<div id="ContactosFueraLista">
</div> <!-- /ContactosFueraLista -->

<div id="detallesdePagos">
</div> <!-- /detallesdePagos -->

<div id="informepresupuesto">
</div> <!-- /informepresupuesto -->

<div id="fondoClaro">
</div> <!-- /fondoClaro -->

<div id="nuevoItem">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Agregar pago</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraMovsAgPago' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:96px;
		  	  width:100%;
              border:1px solid #555" id="agregarPagoFRMAcciones">
					<table class='display' style='background-color: #f5f5f5; font-size:1.15em' id='tablaDetallePagoNuev'>
					<tr>
					<th width='10'>Fecha</th>
					<th width='12'>Forma de pago</th>
					<th width='4'>Moneda</th>
					<th width='4'>Importe</th>
					<th width='16'>Descripcion</th>
					<th width='1'></th>
					</tr>
					<tr id='R00'>
					<td name='xxxx00' id='00&Fecha'  height='50'> </td>
					<td name='xxxx00' id='00&Forma'> </td>
					<td name='xxxx00' id='00&Moneda'> </td>
					<td name='xxxx00' id='00&Importe'> </td>
					<td name='xxxx00' id='00&Descripcion'> </td>
					<td name='xxxx00' id='00&0&action'><img name='xxxxA' src='./images/Ok.jpg' width='32' height='32'></td>
					</tr>
					</table>  
    </div><!-- /detallesdemovimientosFRMAcciones -->
</div> <!-- /fondoClaro -->

<div id="informeDeDeudores">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label style="font-size:1.45em; font-weight:normal; color:#FFF">Deudores</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraDeudores' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:95.5%;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verDeudores">  
    </div><!-- /detallesdemovimientosFRMAcciones -->
</div> <!-- /informeDeDeudores -->

<div id="informeDeCliente">
	<div style="position:absolute;
              left:0px;
              top:0px;
              height:26px;
		  	  width:100%;
              border-width:1px;
              border-style:solid;
              border-color:#000;
              background-color:#30F">
        <label id="tituloCCC" style="font-size:1.05em; font-weight:normal; color:#FFF">Cuenta de cliente</label>
        <div style="position:absolute;
                  left:97.8%;
                  top:0px;
                  float=right"><input type='button' id='cierraInfCliente' value='X'/>
        </div>
	</div>
    <div style="position:absolute;
              left:0px;
              top:27px;
              height:32px;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verInfClienteOPCS">  
    </div><!-- /verInfClienteOPCS -->
    <div style="position:absolute;
              left:0px;
              top:60px;
              height:89%;
		  	  width:100%;
			  overflow: auto;
              border:1px solid #555" id="verInfCliente">  
    </div><!-- /verInfCliente -->
</div> <!-- /informeDeCliente -->

     </div> <!-- /container -->
    	<br>	
      	<br>

<div id="estapsesion" style="visibility:hidden;">
<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->

	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
	<?php }

	include 'footer.php';