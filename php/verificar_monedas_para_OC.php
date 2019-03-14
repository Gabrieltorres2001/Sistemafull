	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$resultDetComprobante = mysqli_query($conexion_sp, "select Moneda, SubTotal, Destino from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."'")) die("Problemas con la consulta1");
   $moneda=0;
   $distintaMoneda=0;
   $SubTotal=0;
   $Destino=0;
	while ($row = mysqli_fetch_row($resultDetComprobante)){ 
		if ($moneda!=0){if ($moneda!=$row[0]){$distintaMoneda=1;}};
		$moneda=$row[0];
		$SubTotal=$SubTotal+$row[1];
		//Ahora tambien verifico que todos los items tengan destino
		if ($Destino==0){if (strlen($row[2])<1){$Destino=1;}};
	}
	
	echo "{
		\"moneda\":\"$moneda\",
		\"distintaMoneda\":\"$distintaMoneda\",
		\"SubTotal\":\"$SubTotal\",
		\"Destino\":\"$Destino\"
		}";
	
	