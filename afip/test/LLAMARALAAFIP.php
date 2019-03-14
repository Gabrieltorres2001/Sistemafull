
<?php

    $NumeroFactura = rand(100,999999);
	$idEnviado = $_REQUEST['monedaFactura'];
	$CAE = rand(1000000,9999999).rand(1000000,9999999);
	$VtoCAE = rand(2017,2020)."/".rand(01,12)."/".rand(01,31);
	$PtoVta=5;
	
	$pVtayFac=$_REQUEST['tipoComprobante'].$_REQUEST['tipoFactura'].str_pad($PtoVta, 4,"0", STR_PAD_LEFT)."-".str_pad($NumeroFactura, 8,"0", STR_PAD_LEFT);

	echo "{
		\"NumeroFactura\":\"$NumeroFactura\",
		\"idEnviado\":\"$idEnviado\",
		\"CAE\":\"$CAE\",
		\"VtoCAE\":\"$VtoCAE\",
        \"PtoVtayfac\":\"$pVtayFac\"
		}";
	
	
