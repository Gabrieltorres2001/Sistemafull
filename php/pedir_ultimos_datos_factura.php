	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$resultDetComprobante = mysqli_query($conexion_sp, "select IdProducto, SubTotal from detallecomprobante where IdComprobante='".$_REQUEST['idcomprobante']."'")) die("Problemas con la consulta1");
   
   //Año 2018. Cambio totalmente este archivo para facturar en moneda extrajera
   //Si monedaFactura es '0' quiere decir que se factura en pesos (si los productos eran en USD o € se convierten)
   //Este codigo NO lo modifico, es exactamente el que se venia usando antes cuando solo se podia facturar en pesos
   //echo $_REQUEST['monedaFactura'];
   if ($_REQUEST['monedaFactura'] < 1) {
	//echo "entre";
   //totales sin diferenciar ivas
   $impTotal=0;
   $SubTotal=0;
   $ivaTotal=0;
   //iva4 es el 10,5%
   $iva4=0;
   $Iva4AlicuotaBase=0;
   $Iva4Alicuota=0;
   //iva5 es el 21%
   $iva5=0;
   $Iva5AlicuotaBase=0;
   $Iva5Alicuota=0;
   //hago los calculos
	while ($row = mysqli_fetch_row($resultDetComprobante)){ 
		//primero busco el IVA del producto en la tabla productos
		if(!$resultProducto = mysqli_query($conexion_sp, "select IVA from productos where IdProducto='".$row[0]."' limit 1")) die("Problemas con la consulta2");
		$rowresultProducto = mysqli_fetch_array($resultProducto);
		//luego veo a que iva equivale ese valor del producto
		if(!$iva = mysqli_query($conexion_sp, "select Valor from z_ivas where IdRegistro='".$rowresultProducto['IVA']."' limit 1")) die("Problemas con la consulta3");
		$rowIVA = mysqli_fetch_array($iva);
		//luego hago los calculos
		//primero los valores generales
		$SubTotal=$SubTotal+($row[1]*$_REQUEST['tipoCambio']);
		$ivaTotal=$ivaTotal+($row[1]*$rowIVA['Valor']*$_REQUEST['tipoCambio']);
		//luego veo si hay iva al 10,5% y los sumo
		if ($rowresultProducto['IVA']=='2')
			{$iva4=1;
			 $Iva4AlicuotaBase=$Iva4AlicuotaBase+($row[1]*$rowIVA['Valor']*$_REQUEST['tipoCambio']);
			 $Iva4Alicuota=$Iva4Alicuota+($row[1]*$_REQUEST['tipoCambio']);
			}
		//luego veo si hay iva al 21% y los sumo	
		if ($rowresultProducto['IVA']=='1')
			{$iva5=1;
			 $Iva5AlicuotaBase=$Iva5AlicuotaBase+($row[1]*$rowIVA['Valor']*$_REQUEST['tipoCambio']);
			 $Iva5Alicuota=$Iva5Alicuota+($row[1]*$_REQUEST['tipoCambio']);
			}		
	}
	$impTotal=$SubTotal+$ivaTotal;
	
	echo "{
		\"impTotal\":\"$impTotal\",
		\"SubTotal\":\"$SubTotal\",
		\"ivaTotal\":\"$ivaTotal\",
		\"iva4\":\"$iva4\",
		\"Iva4AlicuotaBase\":\"$Iva4AlicuotaBase\",
		\"Iva4Alicuota\":\"$Iva4Alicuota\",
		\"iva5\":\"$iva5\",
		\"Iva5AlicuotaBase\":\"$Iva5AlicuotaBase\",
		\"Iva5Alicuota\":\"$Iva5Alicuota\"
		}";
   } 
   
   //Fin del codigo viejo con facturacion en pesos
   //Ahora viene la parte nueva 2018 con facturacion en moneda extranjera
   //Lo bueno es que hago los calculos solo de numeros, por ahora no me interesa la moneda!
   if (($_REQUEST['monedaFactura'] > 0)) {
	// echo "No pude entrar";
   //totales sin diferenciar ivas
   $impTotal=0;
   $SubTotal=0;
   $ivaTotal=0;
   //iva4 es el 10,5%
   $iva4=0;
   $Iva4AlicuotaBase=0;
   $Iva4Alicuota=0;
   //iva5 es el 21%
   $iva5=0;
   $Iva5AlicuotaBase=0;
   $Iva5Alicuota=0;
   //hago los calculos
	while ($row = mysqli_fetch_row($resultDetComprobante)){ 
		//primero busco el IVA del producto en la tabla productos
		if(!$resultProducto = mysqli_query($conexion_sp, "select IVA from productos where IdProducto='".$row[0]."' limit 1")) die("Problemas con la consulta2");
		$rowresultProducto = mysqli_fetch_array($resultProducto);
		//luego veo a que iva equivale ese valor del producto
		if(!$iva = mysqli_query($conexion_sp, "select Valor from z_ivas where IdRegistro='".$rowresultProducto['IVA']."' limit 1")) die("Problemas con la consulta3");
		$rowIVA = mysqli_fetch_array($iva);
		//luego hago los calculos
		//primero los valores generales
		$SubTotal=$SubTotal+($row[1]);
		$ivaTotal=$ivaTotal+($row[1]*$rowIVA['Valor']);
		//luego veo si hay iva al 10,5% y los sumo
		if ($rowresultProducto['IVA']=='2')
			{$iva4=1;
			 $Iva4AlicuotaBase=$Iva4AlicuotaBase+($row[1]*$rowIVA['Valor']);
			 $Iva4Alicuota=$Iva4Alicuota+($row[1]);
			}
		//luego veo si hay iva al 21% y los sumo	
		if ($rowresultProducto['IVA']=='1')
			{$iva5=1;
			 $Iva5AlicuotaBase=$Iva5AlicuotaBase+($row[1]*$rowIVA['Valor']);
			 $Iva5Alicuota=$Iva5Alicuota+($row[1]);
			}		
	}
	$impTotal=$SubTotal+$ivaTotal;
	
	//Ahora si me interesa el tipo de cambio para mostrar al final la factura pesificada (como hace la AFIP)
	 $impTotalPesos=$impTotal*$_REQUEST['tipoCambio'];
			
	echo "{
		\"impTotal\":\"$impTotal\",
		\"SubTotal\":\"$SubTotal\",
		\"ivaTotal\":\"$ivaTotal\",
		\"iva4\":\"$iva4\",
		\"Iva4AlicuotaBase\":\"$Iva4AlicuotaBase\",
		\"Iva4Alicuota\":\"$Iva4Alicuota\",
		\"iva5\":\"$iva5\",
		\"Iva5AlicuotaBase\":\"$Iva5AlicuotaBase\",
		\"Iva5Alicuota\":\"$Iva5Alicuota\",
		\"impTotalPesos\":\"$impTotalPesos\"		
		}";
   }
   //Fin del codigo nuevo en moneda extranjera   
	