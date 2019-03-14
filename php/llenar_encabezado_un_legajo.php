	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
//generamos la consulta
   if(!$resultLegajo = mysqli_query($conexion_sp, "select Confecciono from legajos where id='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta legajos");
	$regLegajo = mysqli_fetch_array($resultLegajo);  
	//Busco en la tabla members datos de comprobante ya confeccionado
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$regLegajo['Confecciono']."' limit 1")) die("Problemas con la consulta members1");
	$rowConfecc = mysqli_fetch_array($confecc);
	$soyYo=0;
	if($_REQUEST['sesses']==$regLegajo['Confecciono'])$soyYo=1;
	//Grabo en un campo hidden si es mio el legajo o no.
	if ($soyYo==0) {echo"<input type='hidden' id='soyyoono' value='0'>";} else {echo"<input type='hidden' id='soyyoono' value='1'>";}
	//EScribo el numero, el responsable y (de corresponder) el boton de asignarmelo
	echo"<label for='NumeroComprobante'>Nº legajo:</label>";
	echo"<input id='NumeroComprobante' class='input' name='NumeroComprobante' type='text' size='5' value=".$_REQUEST['idcomprobante']."  Disabled>";
	echo"<label for='Confeccion'>Confeccionó:</label>";
	echo"<input id='Confeccion' class='input' name='Confeccion' type='text' size='18' value='".$rowConfecc['Nombre']." ".$rowConfecc['Apellido']."' disabled>";
	if ($soyYo==0) {
		//tengo que tener permiso para hacer legajos
		if(!$sesionSistPlus = mysqli_query($conexion_db, "select PuedeHacerLegajos from members where id='".$_REQUEST['sesses']."' limit 1")) die("Problemas con la members 2");
		$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
		$puedoCotizar=0;
		if($rowSesionSistPlus['PuedeHacerLegajos']!=0)$puedoCotizar=1;
		
		if ($puedoCotizar==0) {echo"<input type='button' id='asignarmePresup' value='Asignarme este legajo' disabled>";} else {echo"<input type='button' id='asignarmePresup' value='Asignarme este legajo'/>";}
		}
	echo"<br>";
	
	//Busco el detalle del legajo
   if(!$resultDetalleLegajo = mysqli_query($conexion_sp, "select idDetalle, idComprobante, textoComprobante, PDF, numComprobante, tipoComprobante, orden from detallelegajos where idLegajo='".$_REQUEST['idcomprobante']."' order by orden")) die("Problemas con la consulta detallelegajos");
   echo"<li>  Items de este legajo:  </li>";
   //Encabezado de la tabla que va a mostrar todos los items que tenga el legajo
	echo"<ul class='nav navbar-nav'>";
	echo"</ul>";
	echo "<table class='display' id='tablaDetalleLegajo'>";  
	echo "<tr>";  
	echo "<th width='2' style='text-align:center'>Nº Comprob.</th>";  
	echo "<th width='5' style='text-align:center'>Tipo</th>"; 
	echo "<th width='15' style='text-align:center'>Descripcion</th>";  
	echo "<th width='1' style='text-align:center'>Adjunto</th>"; 
	echo "<th width='1' style='text-align:center'>Borrar</th>";
	echo "<th width='1' style='text-align:center'>Orden</th>";
	echo "</tr>"; 
   //ACa va un while para insertar todos los items que tenga el legajo.
   while ($regDetalleLegajo = mysqli_fetch_array($resultDetalleLegajo)){
	   	//if(!$resultPresup = mysqli_query($conexion_sp, "select NumeroComprobante, NonmbreEmpresa, ApellidoContacto, FechaComprobante from comprobantes where IdComprobante='5' ORDER BY IdComprobante desc")) die("Problemas con la consulta");  
		//$regPresup = mysqli_fetch_array($resultPresup);
		echo "<tr id='$regDetalleLegajo[0]&IL'>";  
			//OJO: Cambio ordenitem por comprobItemLegajo
			echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'>".$regDetalleLegajo[4]."</td>"; 
			//Tipo de comprobantes
			if(!$tipoComprobantes = mysqli_query($conexion_sp, "select TipoComprobante, Abrev from z_tipocomprobante where IdTipoComprobante='".$regDetalleLegajo[5]."' limit 1")) die("Problemas con la consulta z_tipocomprobante");
			$rowtipoComprobantes = mysqli_fetch_array($tipoComprobantes);			
			echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'>".$rowtipoComprobantes[0]." (".$rowtipoComprobantes[1]."º)</td>";
			//Descripcion
			if ($soyYo==0) {echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'><textarea id='$regDetalleLegajo[0]&$regDetalleLegajo[1]&Descripcionitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='28' rows='1' disabled>".$regDetalleLegajo[2]."</textarea></td>";} else {echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'><textarea id='$regDetalleLegajo[0]&$regDetalleLegajo[1]&Descripcionitem&E' class='input' overflow='scroll' name='xxxxt' resize='none' cols='28' rows='1'>".$regDetalleLegajo[2]."</textarea></td>";}
			//Adjunto
			if ((is_null($regDetalleLegajo[3]))||($regDetalleLegajo[3]==0)){
				echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'>--</td>";
			} else {
				//Busco el tipo de adjunto
			   if(!$resultAdjunto = mysqli_query($conexion_sp, "select tipo from pdflegajos where id='".$regDetalleLegajo[3]."' limit 1")) die("Problemas con la consulta pdflegajos");
				$regresultAdjunto = mysqli_fetch_array($resultAdjunto); 
				if ($regresultAdjunto[0]=="application/pdf"){				
					echo "<td name='xxxxid' id='$regDetalleLegajo[0]&IL' style='text-align:center'><img id='$regDetalleLegajo[0]&IL' src='./images/adobepdf.png' width='42' height='42'></td>";}}
			//Borrar línea
			if ($soyYo==0) {echo "<td id='$regDetalleLegajo[0]&IL'> </td>";} else {echo "<td id='$regDetalleLegajo[0]&IL' style='text-align:center'><img name='xxxxx' id='$regDetalleLegajo[0]&$regDetalleLegajo[1]&imagenCanc' src='./images/canc.jpg' width='32' height='32'></td>";}	
			if ($soyYo==0) {echo "<td id='$regDetalleLegajo[0]&IL'> </td>";} else {echo "<td id='$regDetalleLegajo[0]&IL' style='text-align:center'><img name='xxxxxup' id='$regDetalleLegajo[6]&EL' src='./images/arriba.jpg' width='24' height='24'><img name='xxxxxdn' id='$regDetalleLegajo[6]&EL' src='./images/abajo.jpg' width='24' height='24'></td>";}				
    echo "</tr>";	
}  	
echo "</table>";	
//ahora la ultima fila en blanco para agregar item
if ($soyYo==0) {} else {
	echo "<img name='xxxxz' src='./images/Agregar.jpg' width='35' height='35'>";
	echo "<img name='xxxxy' id='$regDetalleLegajo[0]&$regDetalleLegajo[1]&imagenOk' src='./images/recarga.jpg' width='35' height='35'>";
}		
			
  
	
	

