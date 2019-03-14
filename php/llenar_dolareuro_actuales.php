<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Dolar, Euro, Fecha from cotizacionesnew ORDER BY Id desc limit 1")) die("Problemas con la consulta");
	$reg = mysqli_fetch_array($result);  
	echo"<fieldset style='width:95%'>";
		echo"<legend>Cotizacion vigente desde: ". $reg['Fecha']."</legend>";
		echo"<fieldset style='width:47%'>";
			echo"<legend style='font-size:17px'>Dólar:</legend>";	
				echo "<P style='font-size:20px' align='center'> $ ". number_format($reg['Dolar'],2,',','.')."</P>";
		echo"</fieldset>";
		echo"<fieldset style='width:47%'>";
			echo"<legend style='font-size:17px'>Euro:</legend>";	
				echo "<P style='font-size:20px' align='center'> $ ". number_format($reg['Euro'],2,',','.')."</P>";
		echo"</fieldset>";
	echo"</fieldset>";

		
