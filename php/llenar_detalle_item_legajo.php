<?php
include_once '../includes/sp_connect.php';

   //Creamos la conexión
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select PDF from detallelegajos where idDetalle='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante); 
	if ($reg['PDF']>0){
		
	   if(!$resultPDF = mysqli_query($conexion_sp, "select PDF, tipo from pdflegajos where id='".$reg[0]."' limit 1")) die("Problemas con la consulta2");
		if ($regPDF = mysqli_fetch_array($resultPDF)){
			$contenido = $regPDF['PDF'];
			echo'<object data="data:application/pdf;base64,'.base64_encode($contenido).'" type="application/pdf" style="height:700px;width:99%"></object>';
		}; 

	}else {
			echo'<form accept-charset="utf-8" method="POST" id="enviarimagenesEnLeg" enctype="multipart/form-data" >
			<br>
			<p>Este item no tiene adjunto. Presione Examinar para agregarle uno: <input type="file" id="files" name="imagen" accept=".pdf"/></p>
			</form>';
			echo"<input type='button' id='listoNuevoAdjuntoALeg' value='Agregar'>";
	}
	
