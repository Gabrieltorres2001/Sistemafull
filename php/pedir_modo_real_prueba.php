	<?php

   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
die("Problemas con la conexión");
mysqli_query($conexion_sp,"set names 'utf8'");

if(!$resultFormaPago = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'modoReal' and padre='1' limit 1")) die("{
	\"modoReal\":\"$Error. Problemas con la consulta forma de pago en controlpanel\"
	}");
$regFormaPago = mysqli_fetch_array($resultFormaPago);
//echo $regFormaPago['ContenidoValor'];	
$modoReal=$regFormaPago['ContenidoValor'];
echo "{
	\"modoReal\":\"$modoReal\"
	}";

