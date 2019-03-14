<?php
   //Creamos la conexión
    $moneda_origen="USD";
	$moneda_destino="ARS";
	$get1 = file_get_contents("https://www.google.com/finance/converter?a=1&from=$moneda_origen&to=$moneda_destino");
	$get1 = explode("<span class=bld>",$get1);
	$get1 = explode("</span>",$get1[1]);  
	//echo preg_replace("/[^0-9\.]/", null, $get1[0]);
	
    $moneda_origen="EUR";
	$moneda_destino="ARS";
	$get2 = file_get_contents("https://www.google.com/finance/converter?a=1&from=$moneda_origen&to=$moneda_destino");
	$get2 = explode("<span class=bld>",$get2);
	$get2 = explode("</span>",$get2[1]); 
	
	echo"<fieldset style='width:95%'>";
		echo"<legend>Cotizacion vigente en Google (QUE NO ES EL BNA): ". $reg['Fecha']."</legend>";
		echo"<fieldset style='width:47%'>";
			echo"<legend style='font-size:17px'>Dólar:</legend>";	
				echo "<P style='font-size:20px' align='center' id='nuevoDolarGoogle'> $ ". number_format(preg_replace("/[^0-9\.]/", null, $get1[0])*1.0152135,2,',','.')."</P>";
		echo"</fieldset>";
		echo"<fieldset style='width:47%'>";
			echo"<legend style='font-size:17px'>Euro:</legend>";	
				echo "<P style='font-size:20px' align='center' id='nuevoEuroGoogle'> $ ". number_format(preg_replace("/[^0-9\.]/", null, $get2[0])*1.056338,2,',','.')."</P>";
		echo"</fieldset>";
	echo"</fieldset>";
	echo"<input type='hidden' id='dolarescon' value='". number_format(preg_replace("/[^0-9\.]/", null, $get1[0])*1.0152135,2,'.','')."'>";
	echo"<input type='hidden' id='euroescon' value='". number_format(preg_replace("/[^0-9\.]/", null, $get2[0])*1.056338,2,'.','')."'>";
	echo"<P align='center'><input type='button' id='BNAWeb' value='Ir a la página del Banco Nación'/></P>";
