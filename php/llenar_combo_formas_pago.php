<?php

   //Creamos la conexión
   //echo"<option value=0r>rrrrr</option>";
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
	//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
	//Padre 17 es la forma de pago. No lo puedo cambiar
	if(!$resultFP = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");	
	echo"<select id='CondPago' class='input'>";
	echo"<option value=0 selected></option>";
	while ($row = mysqli_fetch_array($resultFP)){ 
			$tmpFP = explode(',', $row['ContenidoValor']);	
			echo"<option value=".$row['Descripcion'].">".$tmpFP[0]."</option>";
			}	
	echo"</select>";