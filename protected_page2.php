<?php
$titulo = "SISTEMAPLUS - Ventana principal";

include 'includes/funciones_pp2.php';

include 'header.php';
 
sec_session_start();
?>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/pp2.css" rel="stylesheet">
    
	<script type="text/javascript" src="js/jqyer.js"></script>
<script src="js/jquery.cycle.all.js"></script>
<script src="js/funcionespp2.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#rotar').cycle({
			fx:     'scrollUp',
			timeout: 6000,
			delay:  -10
		});
		$('#rotar').css("display", "block");
	});    
</script>

  </head>

	
  <body>

    	<!-- SI ESTOY LOGEADO. BIEN. PUEDO INGRESAR. -->
        <?php if (login_check($mysqli) == true) { ?>
		<?php upperMenu('pp2') ?>

	<div class="dash-unit" style="height:25px; width:98%; text-align:center; color:white;">
		<a href="novedades.php">
				<div id="importantchart" style="height:25px; width:98%; text-align:center; color:white;">
			      <?php
					Llenar_novedades2_pp2();
				   ?>
			    </div>
		</a>		
	</div>
	  
    <div class="container">

	  <!-- PRIMERA FILA DE BLOCKS -->     
      <div class="row">

      <!-- USER PROFILE BLOCK -->
			<div class="col-sm-3 col-lg-3">
					<a href="perfil.php">
						<div class="dash-unit">
									<dtitle>Perfil del usuario</dtitle>
									<hr>
							<div class="thumbnail">
											<?php Buscar_Usuario($_SESSION['user_id']); ?>
								<img style=" max-height: 80px;  max-width: 80px;"src="<?php echo htmlentities($_SESSION['Foto']); ?>" alt="Marcel Newman" class="img-circle">
							</div><!-- /thumbnail -->
							<h1><?php echo htmlentities($_SESSION['Nombre']); ?> <?php echo htmlentities($_SESSION['Apellido']); ?></h1>
							<h3><?php echo htmlentities($_SESSION['username']); ?></h3>
							<br>
								<div class="info-user">
									<span aria-hidden="true" class="li_user fs1"></span>
									<span aria-hidden="true" class="li_settings fs1"></span>
									<span aria-hidden="true" class="li_mail fs1"></span>
									<span aria-hidden="true" class="li_key fs1"></span>
								</div>
						</div>
					</a>
					</div>
      <!-- DONUT CHART BLOCK -->
        <div class="col-sm-3 col-lg-3">
						<a href="Presupuestos.php">
							<div class="dash-unit">
								<dtitle>Presupuestos</dtitle>
								<hr>
								<div class="cont">
									<p><bold>
									Presupuestos
									</bold></p>
								</div>
							</div>
						</a>
        </div>
      <!-- DONUT CHART BLOCK -->
        <div class="col-sm-3 col-lg-3">
			<a href="Contactos.php">
			<div class="half-unit">
	      		<dtitle>Contactos</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Contactos
					</bold></p>
				</div>
			</div>
			</a>
			
			<a href="Empresas.php">
			<div class="half-unit">
	      		<dtitle>Empresas</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Empresas
					</bold></p>
				</div>
			</div>
			</a>
        </div>
        
        <div class="col-sm-3 col-lg-3">
			<a href="cambioMonedas.php">
      		<div class="half-unit">
	      		<dtitle>Dolar</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					<?php
						Llenar_Dolar();
					?>
					</bold></p>
				</div>
        </div>
		</a>

			<a href="cambioMonedas.php">
			<div class="half-unit">
	      		<dtitle>Euro</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					<?php
						Llenar_Euro();
					?>
					</bold></p>
				</div>
			</div>
			</a>
        </div>
      </div><!-- /row -->
      
      
<!-- SEGUNDA FILA DE BLOCKS -->     
<div class="row">
	<!-- Primer Block -->       
	<div class="col-sm-3 col-lg-3">
		<!-- Primer Medio Block: Cuentas Corrientes-->   
		<?php if (formulario_habilitado("CuentasCorrientes") == true): ?>     
				<a href="Cuentascorrientes.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>
			<div class="half-unit">
				<dtitle>Cuentas corrientes</dtitle>
				<hr>
				<div class="cont">
					<p><bold>
					Cuentas corrientes
					</bold></p>
				</div>
			</div>
			</a>
		<!-- Fin Cuentas Corrientes -->	
		<!-- Segundo Medio Block: Recibos--> 		
		<?php if (formulario_habilitado("Recibo") == true): ?>   
			<a href="Recibos.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>
			<div class="half-unit">
	      <dtitle>Recibos</dtitle>
	      <hr>
	      <div class="cont">
					<p><bold>
					Recibos
					</bold></p>
				</div>
			</div>
			</a>
			<!-- Fin Recibos --> 
		</div>
		<!-- Fin Primer Block --> 

		<!-- Segundo Block --> 
    <div class="col-sm-3 col-lg-3">
			<a href="Remitos.php">
			<div class="half-unit">
	      		<dtitle>Ventas</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Remitos y Facturas
					</bold></p>
				</div>
			</div>
			</a>
			
			<?php if (formulario_habilitado("ComprobantesGenerados") == true): ?>     
			<a href="Ferrreto.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>
			<div class="half-unit">
	      		<dtitle>Resumen de comprobantes emitidos</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Comprobantes
					</bold></p>
				</div>
			</div>
			</a>
    </div>
	
	  <!-- Articulos -->     
        <div class="col-sm-3 col-lg-3">
			<a href="Articulos.php">
			<div class="half-unit">
	      		<dtitle>Articulos</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Articulos
					</bold></p>
				</div>
			</div>
			</a>
			
			<?php if (formulario_habilitado("ComprobantesGenerados") == true): ?>     
			<a href="AjustesStock.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>
			<div class="half-unit">
	      		<dtitle>Ajustes de Stock</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Ajustes de Stock
					</bold></p>
				</div>
			</div>
			</a>
        </div>
	
	  <!-- Ordenes de compra -->    
        <div class="col-sm-3 col-lg-3">		
			<?php if (formulario_habilitado("OrdenesCompra") == true): ?>     
			<a href="OrdenesCompra.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>
			<div class="dash-unit">
	      		<dtitle>Ordenes de compra</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Ordenes de compra
					</bold></p>
				</div>
			</div>
			</a>
		</div>	
      </div><!-- /row -->
     
 
	  <!-- TERCERA FILA DE BLOCKS -->     
      <div class="row">
      	<div class="col-sm-3 col-lg-3">
				<?php if (formulario_habilitado("listadoClientes") == true): ?>     
				<a href="listadoClientes.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>				
	  <!-- BARS CHART - lineandbars.js file -->     
      		<div class="dash-unit">
	      		<dtitle>Listado de contactos</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Listado de contactos
					</bold></p>
				</div>
      		</div>
			</a>
      	</div>

	<div class="col-sm-3 col-lg-3">
	<?php if (formulario_habilitado("Legajos") == true): ?>     
			<a href="Legajos.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>	
	  <!-- BARS CHART - lineandbars.js file -->     
      		<div class="dash-unit">
	      		<dtitle>Legajos digitales</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Legajos digitales
					</bold></p>
				</div>
      		</div>
			</a>
      	</div>
		
	<div class="col-sm-3 col-lg-3">
		<a id="cp" href="">
	  <!-- BARS CHART - lineandbars.js file -->     
      		<div class="dash-unit">
	      		<dtitle>Panel de control</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Panel de control
					</bold></p>
			<form autocomplete="off"  action="includes/process_login.php" method="post" name="login_form" id="frmpanelfake" style=" visibility:hidden;">
			</br>                      
            Repita su Contraseña: <input type="input" 
                             name="fakepasswordremembered" 
                             id="fakepasswordremembered" 
							 align="center"/>
							 </br>
							 <input type="hidden" name="claveoculata" id="claveoculata"/> 
							 </br>
            <input type="button" 
                   value="Login" 
				   id="btnsbmt"
				   onclick="preventDefault();"/> 
        </form>
				</div>
      		</div>
			</a>
      	</div>
		
        <div class="col-sm-3 col-lg-3">
			<?php if (formulario_habilitado("RemitosSinFactura") == true): ?>     
				<a href="RemitosSinFactura.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>					
			<div class="half-unit">
	      		<dtitle>Ventas sin facturar</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Ventas sin facturar
					</bold></p>
				</div>
			</div>
			</a>
			
			<?php if (formulario_habilitado("UltimasVentas") == true): ?>     
			<a href="UltimasVentas.php">
			<?php else : ?>
				<a href="no_habilitado.php">
			<?php endif; ?>	
			<div class="half-unit">
	      		<dtitle>Ultimas ventas por proveedor</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Ultimas ventas
					</bold></p>
				</div>
			</div>
			</a>
        </div>

      </div><!-- /row -->
      
	  <!-- FOURTH ROW OF BLOCKS -->     
<div class="row">
	
	<div class="col-sm-3 col-lg-3">
	<?php if (formulario_habilitado("ProductosAlPublico") == true): ?> <a href="ArticulosPublicos.php"> <?php else : ?>	<a href="no_habilitado.php"> <?php endif; ?>	
	  <!-- AJUSTE DE STOCK BLOCK -->     
      		<div class="dash-unit">
	      		<dtitle>Ventas online</dtitle>
	      		<hr>
	      		<div class="cont">
					<p><bold>
					Productos al público
					</bold></p>
				</div>
      		</div>
		</a>
    </div>
	  <!-- TWITTER WIDGET BLOCK -->     
		<div class="col-sm-3 col-lg-3"  style=" visibility:hidden;">
			<div class="dash-unit">
	      		<dtitle>Twitter Widget</dtitle>
	      		<hr>
				<div class="info-user">
					<span aria-hidden="true" class="li_megaphone fs2"></span>
				</div>
				<br>
		 		<div id="jstwitter" class="clearfix">
					<ul id="twitter_update_list"></ul>
				</div>
				<!-- <script src="http://twitter.com/javascripts/blogger.js"></script><!-- Script Needed to load the Tweets -->
				<!-- <script src="http://api.twitter.com/1/statuses/user_timeline/wrapbootstrap.json?callback=twitterCallback2&amp;count=1"></script> --> -->
				<!-- To show your tweets replace "wrapbootstrap", in the line above, with your user. -->
				<div class="text">
				<p><grey>Show your tweets here!</grey></p>
				</div>
			</div>
		</div>

	  <!-- NOTIFICATIONS BLOCK -->     
		<div class="col-sm-3 col-lg-3"  style=" visibility:hidden;">
			<div class="dash-unit">
	      		<dtitle>Notifications</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_bubble fs2"></span>
				</div>
	      		<div class="cont">
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is a success notification&quot;,&quot;layout&quot;:&quot;topRight&quot;,&quot;type&quot;:&quot;success&quot;}">Top Right</button></p>
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is an informaton notification&quot;,&quot;layout&quot;:&quot;topLeft&quot;,&quot;type&quot;:&quot;information&quot;}">Top Left</button></p>
	      			<p><button class="btnnew noty" data-noty-options="{&quot;text&quot;:&quot;This is an alert notification with fade effect.&quot;,&quot;layout&quot;:&quot;topCenter&quot;,&quot;type&quot;:&quot;alert&quot;,&quot;animateOpen&quot;: {&quot;opacity&quot;: &quot;show&quot;}}">Top Center (fade)</button></p>
	      		</div>
			</div>
		</div>

	  <!-- SWITCHES BLOCK -->     
		<div class="col-sm-3 col-lg-3"  style=" visibility:hidden;">
			<div class="dash-unit">
	      		<dtitle>Switches</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_params fs2"></span>
				</div>
				<br>
				<div class="switch">
					<input type="radio" class="switch-input" name="view" value="on" id="on" checked="">
					<label for="on" class="switch-label switch-label-off">On</label>
					<input type="radio" class="switch-input" name="view" value="off" id="off">
					<label for="off" class="switch-label switch-label-on">Off</label>
					<span class="switch-selection"></span>
				</div>
				<div class="switch switch-blue">
					<input type="radio" class="switch-input" name="view2" value="week2" id="week2" checked="">
					<label for="week2" class="switch-label switch-label-off">Week</label>
					<input type="radio" class="switch-input" name="view2" value="month2" id="month2">
					<label for="month2" class="switch-label switch-label-on">Month</label>
					<span class="switch-selection"></span>
				</div>
				
				<div class="switch switch-yellow">
					<input type="radio" class="switch-input" name="view3" value="yes" id="yes" checked="">
					<label for="yes" class="switch-label switch-label-off">Yes</label>
					<input type="radio" class="switch-input" name="view3" value="no" id="no">
					<label for="no" class="switch-label switch-label-on">No</label>
					<span class="switch-selection"></span>
				</div>
			</div>
		</div>

	  <!-- GAUGE CHART BLOCK -->     
		<div class="col-sm-3 col-lg-3"  style=" visibility:hidden;">
			<div class="dash-unit">
	      		<dtitle>Gauge Chart</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_lab fs2"></span>
				</div>
				<canvas id="canvas" width="300" height="300">
			</canvas></div>
		</div>
	
	</div><!--/row -->     
      
 	  <!-- FOURTH ROW OF BLOCKS -->     
		<div class="row" style=" visibility:hidden;">

 	  <!-- ACCORDION BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Accordion</dtitle>
	      		<hr>
					<div class="accordion" id="accordion2">
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
		                        Collapsible Group Item #1
		                        </a>
		                    </div>
		                    <div id="collapseOne" class="accordion-body collapse in">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                        
								</div>
		                    </div>
		                </div>
		
		                <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
		                        Collapsible Group Item #2
		                        </a>
		                    </div>
		                    <div id="collapseTwo" class="accordion-body collapse">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                      
								</div>
		                    </div>
		                </div>
		
		                 <div class="accordion-group">
		                    <div class="accordion-heading">
		                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
		                        Collapsible Group Item #3
		                        </a>
		                    </div>
		                    <div id="collapseThree" class="accordion-body collapse">
		                        <div class="accordion-inner">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla iaculis mattis lorem.                        
		                        </div>
		                    </div>
		                </div>
		            </div><!--/accordion -->
				</div>
			</div>
			
			<div class="col-sm-3 col-lg-3">

 	  		<!-- LAST USER BLOCK -->     
				<div class="half-unit">
	      		<dtitle>Last Registered User</dtitle>
	      		<hr>
	      			<div class="cont2">
	      				<img src="assets/img/user-avatar.jpg" alt="">
	      				<br>
	      				<br>
	      				<p>Paul Smith</p>
	      				<p><bold>Liverpool, England</bold></p>
	      			</div>
				</div>
				
 	  		<!-- MODAL BLOCK -->     
				<div class="half-unit">
	      		<dtitle>Modal</dtitle>
	      		<hr>
		            <div class="cont">
		                <a href="#myModal" role="button" class="btnnew" data-toggle="modal">Example Modal Window</a>
		            </div>
				</div>
			</div>
			<!-- Modal -->
			  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			          <h4 class="modal-title">Modal title</h4>
			        </div>
			        <div class="modal-body">
			          ...
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          <button type="button" class="btn btn-primary">Save changes</button>
			        </div>
			      </div><!-- /.modal-content -->
			    </div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->
 	  		<!-- FAST CONTACT BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Fast Contact</dtitle>
	      		<hr>
	      		<div class="cont">
                	<form action="#get-in-touch" method="POST" id="contact">
                    	<input type="text" id="contactname" name="contactname" placeholder="Name">
                    	<input type="text" id="email" name="email" placeholder="Email">
                    	<div class="textarea-container"><textarea id="message" name="message" placeholder="Message"></textarea></div>
                    	<input type="submit" id="submit" name="submit" value="Send">
                    </form>
				</div>
				</div>
			</div>

 	  		<!-- INFORMATION BLOCK -->     
			<div class="col-sm-3 col-lg-3">
				<div class="dash-unit">
	      		<dtitle>Block Dashboard</dtitle>
	      		<hr>
	      		<div class="info-user">
					<span aria-hidden="true" class="li_display fs2"></span>
				</div>
				<br>
				<div class="text">
				<p>Block Dashboard created by Basicoh.</p>
				<p>Special Thanks to Highcharts, Linecons and Bootstrap for their amazing tools.</p>
				</div>

				</div>
			</div>

		</div><!--/row -->
     

<div id="estapsesion" style="visibility:hidden;">
<input type="text" id="numberses" name="number" value="<?php echo htmlentities($_SESSION['user_id']);?>"/>
</div> <!-- /estapsesion -->

	<!-- /mensaje auto ocultable -->
	<div class="alert alert-success" style="position:fixed;left:25%;top:100px;width:50%;float=center;text-align:center;visibility:hidden;" id="mensajeAlertaAviso">Mensaje de información.</div>
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="assets/js/lineandbars.js"></script>
    
	<script type="text/javascript" src="assets/js/dash-charts.js"></script>
	<script type="text/javascript" src="assets/js/gauge.js"></script>
	
	<!-- NOTY JAVASCRIPT -->
	<script type="text/javascript" src="assets/js/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/top.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topLeft.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topRight.js"></script>
	<script type="text/javascript" src="assets/js/noty/layouts/topCenter.js"></script>
	
	<!-- You can add more layouts if you want -->
	<script type="text/javascript" src="assets/js/noty/themes/default.js"></script>
    <!-- <script type="text/javascript" src="assets/js/dash-noty.js"></script> This is a Noty bubble when you init the theme-->
	<!-- <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script> -->
	<script src="assets/js/jquery.flexslider.js" type="text/javascript"></script>

             
<?php }

	include 'footer.php';			