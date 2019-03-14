<?php
include_once '../includes/sp_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select IdTipoComprobante, TipoComprobante FROM z_tipocomprobante WHERE ((IdTipoComprobante=1) OR (IdTipoComprobante=3) OR (IdTipoComprobante=9) OR (IdTipoComprobante=21) OR (IdTipoComprobante=14) OR (IdTipoComprobante=5) OR (IdTipoComprobante=15) OR (IdTipoComprobante=16) OR (IdTipoComprobante=17) OR (IdTipoComprobante=18) OR (IdTipoComprobante=19) OR (IdTipoComprobante=20))")) die("Problemas con la consulta z_tipocomprobante");
   echo '<label style="font-size:1.25em; font-weight:normal; color:#000">Tipo comprobante:</label>';
   echo"<select id='itemsLegajo' name='xxxxt'>";
	while ($row = mysqli_fetch_row($resultComprobante)){  
	  echo"<option value='".$row[0]."'>".$row[1]."</option>";
	}
	echo"</select>";
	echo "<input type='button' id='botonBuscarTiposDeComprobantes' value='Buscar'/>"; 