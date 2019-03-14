<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	if(!$resultDetalle = mysqli_query($conexion_sp, "select ImporteTotal, IdEnviado from caeafip where Id='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta2");
	$pagos=0;
	while ($row = mysqli_fetch_row($resultDetalle)){  
		if(!$resultPagosFondos = mysqli_query($conexion_sp, "select Importe from fondos where IdComprobante='".$_REQUEST['idcomprobante']."' and Tipo='1'")) die("Problemas con la consulta fondos");
		while ($rowresultPagosFondos = mysqli_fetch_row($resultPagosFondos)){  
			//falta ver que hago con pagos en otras monedas (por ahora no le doy bola)
			$pagos=$pagos+(number_format($rowresultPagosFondos[0],2,'.',''));
		}
		$pendiente=number_format(((number_format($row[0],2,'.',''))-$pagos),2,'.','');
		$moneda=$row[1];
	}
	//echo $pendiente;
	echo "{
		\"pendientePago\":\"$pendiente\",
		\"moneda\":\"$moneda\"
		}";