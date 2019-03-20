<?php 
//============================================================+
	   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	//generamos la consulta para el encabezado
	   if(!$resultComprobante = mysqli_query($conexion_sp, "select Id, NumeroFactura, TipoFactura, CAE, FechaFactura, ImporteTotal, VtoCAE, IdEnviado from caeafip where IdComprobante=".$_REQUEST['idcomprobante']."")) die("Problemas con la consulta1");
		//$reg = mysqli_fetch_array($resultComprobante);  
		
	//echo $_REQUEST['idcomprobante'];	
	//echo $reg['NumeroFactura'];
	
	while ($reg = mysqli_fetch_row($resultComprobante)){ 
	//if ((int)$reg['Id']>0){
		//Hay factura
		echo"<fieldset style='width:99%'>";
			echo"<legend>Detalles de comprobante ya emitido:</legend>";
				echo"<fieldset style='width:160px'>";
					echo"<legend>Número de factura:</legend>";	
					echo"<input id='TipFacEmitida' class='input' name='TipFacEmitida' type='text' size='1' style='text-align:center;' disabled value='".$reg[2]."'>";
					echo"<input id='numFacEmitida' class='input' name='numFacEmitida' type='text' size='14' style='text-align:right;' disabled value='".$reg[1]."'>";
				echo"</fieldset>";
				echo"<fieldset style='width:100px'>";
					echo"<legend>CAE:</legend>";	
					echo"<input id='numCaeEmitida' class='input' name='numCaeEmitida' type='text' size='14' style='text-align:right;' disabled value='".$reg[3]."'>";
				echo"</fieldset>";
				echo"<fieldset style='width:80px'>";
					echo"<legend>Fecha:</legend>";	
					echo"<input id='fechaFacEmitida' class='input' name='fechaFacEmitida' type='text' size='10' style='text-align:right;' disabled value='".$reg[4]."'>";
				echo"</fieldset>";
				echo"<fieldset style='width:80px'>";
					echo"<legend>Vto CAE:</legend>";	
					echo"<input id='vtoCaeFacEmitida' class='input' name='vtoCaeFacEmitida' type='text' size='10' style='text-align:right;' disabled value='".$reg[6]."'>";
				echo"</fieldset>";
				echo"<fieldset style='width:80px'>";
					echo"<legend>Importe:</legend>";
					if ($reg[7]==60) {					
					echo"<input id='importeFacEmitida' class='input' name='importeFacEmitida' type='text' size='10' style='text-align:right;' disabled value='€ ".number_format($reg[5],2,',','.')."'>"; } elseif ($reg[7]==1) {
							echo"<input id='importeFacEmitida' class='input' name='importeFacEmitida' type='text' size='10' style='text-align:right;' disabled value='USD ".number_format($reg[5],2,',','.')."'>"; } else {
								echo"<input id='importeFacEmitida' class='input' name='importeFacEmitida' type='text' size='10' style='text-align:right;' disabled value='$ ".number_format($reg[5],2,',','.')."'>"; }
				echo"</fieldset>";
				echo"<fieldset style='width:110px; border: 0px;'>";		
					if ($reg[7]==60) {					
					echo"<input type='button' name='informeReFacNme'  id='".$reg[3]."' value='Reimprimir'/>"; } elseif ($reg[7]==1) {
							echo"<input type='button' name='informeReFacNme'  id='".$reg[3]."' value='Reimprimir'/>"; } else {
								echo"<input type='button' name='informeReFacN'  id='".$reg[3]."' value='Reimprimir'/>"; }				
				echo"</fieldset>";
				//Marzo 2019. Recibo directo desde esta factura
				if (!($reg[2]=="NCA")){
					echo"<fieldset style='width:110px; border: 0px;'>";					
					echo"<input type='button' name='informeReciboDirecto' id='".$reg[3]."' value='Generar recibo'/>"; 
					echo"</fieldset>";}
		echo"</fieldset>";
		echo"<br>";
	//} else {
		//no hay factura
	//	echo "Error";
	}
