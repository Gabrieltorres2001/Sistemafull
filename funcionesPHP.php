<?php
function barraSuperior($pagina) {
	echo '
  	<!-- NAVIGATION MENU -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
    </nav>
';}


function upperMenu($current){

  include "appConfig.php"; //configure options menu

  $html = "";
  foreach($homeLinks as $link){
    if (!$link['navBar']) continue;
    if(!isset($link['url']) || !isset($link['title'])) continue;
    $active = $link['title'] == $current ? "active" : "";
    $title =  ucwords(strtolower($link['title']));
    $html .= '<li class="nav-item '.$active.'">';
    $html .= '    <a class="nav-link" href="'. $link['url'].'" title="'.$link['description'].'">';
    $html .= '             '. ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); 
    $html .= '             '. $title;
    $html .= '    </a>';
    $html .= '</li>';
  }

  ob_start();
  //navCode
  ?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="protected_page2.php"><img src="assets/img/logo30.png" alt=""> SistemaPlus 2.1</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php echo $html ?>
    </ul>
    <ul class="navbar-nav">
    <li class="nav-item clockcenter">
      <span class="navbar-text"><span class = "fa fa-clock-o"></span>  <digiclock>12:45:25</digiclock></span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="cambioMonedas.php">
        <i class="fa fa-dollar"></i>
        <?php Llenar_Dolar(); ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="cambioMonedas.php">
        <i class="fa fa-euro"></i>
        <?php Llenar_Dolar(); ?>
      </a>
    </li>
      <li class="nav-item">
        <a class="btn btn-outline-warning" href="includes/logout.php"><span class = "fa fa-sign-out"></span>LogOUT</a>
      </li>
    </ul>
  </div>
</nav>


  <?php
  $nav = ob_get_contents();
  ob_clean();
  echo $nav;

}