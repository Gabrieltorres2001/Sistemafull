<?php
include 'php/globalFunctions.php';

 function searchOption($tn)
{
  ob_start();
  ?>
  <div class="input-group">
    <input id="buscador" type="text" class="form-control" placeholder="ingrese su búsqueda..." aria-label="ingrese su búsqueda..." aria-describedby="buscar">
    <div class="input-group-append">
      <button id="botonBuscador" class="btn btn-secondary" type="button" id="buscar" value="Buscar"><i class="fa fa-search"></i></button>
      <button id="botonBorrar" class="btn btn-secondary" type="button" id="borrar" value="Borrar"><i class="fa fa-close"></i></button>
    </div>
  </div>
  <script>
    $('#buscador').focus();
  </script>
  <?php
  $ret = ob_get_contents();
  ob_clean();
  return $ret;
}

function actionBar($tn, $caption)
{
  $userInfo = consultaMembers($_SESSION["user_id"]);
  if ($userInfo['PuedeModificar' . $tn]) {
    ob_start();
    ?>
    <button class="btn btn-success btn-sm" id="botonActualiza-<?php echo $tn; ?>">Actualizar
      <?php echo $caption; ?></button>
    <button class="btn btn-success btn-sm" id="botonCopia-<?php echo $tn; ?>">Duplicar
      <?php echo $caption; ?></button>
    <button class="btn btn-success btn-sm" id="botonNuevo-<?php echo $tn; ?>">Nuevo
      <?php echo $caption; ?></button>
  <?php
} else {
  ?>
    <div class="alert alert-warning alert-dismissible">
      <h5><i class="icon fa fa-warning"></i> Alert!</h5>
      Atención! solo puede visualisar
      <?php echo $caption; ?>
    </div>
  <?php
};
$ret = ob_get_contents();
ob_end_clean();
return $ret;
}

function upperMenu($current)
{

  include "appConfig.php"; //configure options menu

  $html = "";
  foreach ($homeLinks as $link) {
    $active = "";
    if (!$link['navBar']) continue;
    if (!isset($link['url']) || !isset($link['title'])) continue;
    $active = $link['title'] == $current['title'] ? "active border border-warning" : "";
    $title =  ucwords(strtolower($link['title']));
    $html .= '<li class="nav-item ' . $active . '">';
    $html .= '    <a class="nav-link" href="' . $link['url'] . '" title="' . $link['description'] . '">';
    $html .= '             ' . ($link['icon'] ? '<img src="' . $link['icon'] . '">' : '');
    $html .= '             ' . $title;
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
        <?php echo $html; ?>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item clockcenter">
          <span class="navbar-text"><span class="fa fa-clock-o"></span>
            <digiclock>12:45:25</digiclock>
          </span>
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
            <?php Llenar_Euro(); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-warning" href="includes/logout.php"><span class="fa fa-sign-out"></span>LogOUT</a>
        </li>
      </ul>
    </div>
  </nav>

  <?php
  $nav = ob_get_contents();
  ob_clean();
  return $nav;
}

function selectCombo($conexion_sp,$selected,$text,$id){
  ob_start();
  ?>
  <select id='IdTipoContacto' class='input' name='IdTipoContacto'>
	<?php
	if(!$resultTC = mysqli_query($conexion_sp, "SELECT * from z_tipocontacto")) die("Problemas con la consulta z_tipocontacto");
	while ($row = mysqli_fetch_row($resultTC)){ 
		if ($selected==$row[0]){
			echo"<option selected value=".$row[0].">".$row[1]."</option>";
			}else{
				echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
	}
	if ($selected=='' or $selected=='0'){
	echo"<option selected value=''></option>";
	}
	?>
    </select>
    <?php
  $html = ob_get_contents();
  ob_clean();
  return $html;
}