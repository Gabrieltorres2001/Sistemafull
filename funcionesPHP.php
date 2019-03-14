<?php
function barraSuperior($pagina) {
	echo '
  	<!-- NAVIGATION MENU -->

    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="protected_page2.php" class="navbar-brand"><img src="assets/img/logo30.png" alt=""> SistemaPlus 2.0</a>
        </div> 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li';if ($pagina=='Presupuestos') {echo ' class="active"';};echo'><a href="Presupuestos.php"><i class="icon-folder-open icon-white"></i> Presupuestos</a></li>
              <li';if ($pagina=='Remitos') {echo ' class="active"';};echo'><a href="Remitos.php"><i class="icon-calendar icon-white"></i> Ventas</a></li>
              <li';if ($pagina=='Contactos') {echo ' class="active"';};echo'><a href="Contactos.php"><i class="icon-th icon-white"></i> Contactos</a></li>
			  <li';if ($pagina=='Empresas') {echo ' class="active"';};echo'><a href="Empresas.php"><i class="icon-lock icon-white"></i> Empresas</a></li>
              <li';if ($pagina=='Articulos') {echo ' class="active"';};echo'><a href="Articulos.php"><i class="icon-lock icon-white"></i> Artículos</a></li>
              <li><a href="includes/logout.php"><i class="icon-folder-open icon-white"></i> LogOUT</a></li>
              <li class="clockcenter"><digiclock>12:45:25</digiclock></li>
			  <li><a href="cambioMonedas.php"><i class="icon-folder-open icon-white"></i><label>  USD </label> <label id="DolarHoy">'; Llenar_Dolar(); echo'</label></a></li>
			  <li><a href="cambioMonedas.php"><i class="icon-folder-open icon-white"></i><label> € </label> <label id="EuroHoy">'; Llenar_Euro(); echo'</label></a></li>
            </ul>			
          </div><!--/.nav-collapse -->
		  </div>
    </div>
';}