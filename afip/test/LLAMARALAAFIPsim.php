
<?php

    $NumeroFactura = "0000";
	$idEnviado = $_REQUEST['monedaFactura'];
	$CAE = "00000000000000";
	$VtoCAE = "2099/12/31";
	
	echo "{
		\"NumeroFactura\":\"$NumeroFactura\",
		\"idEnviado\":\"$idEnviado\",
		\"CAE\":\"$CAE\",
		\"VtoCAE\":\"$VtoCAE\"
		}";
	
	
