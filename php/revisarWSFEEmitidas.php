<?php
include_once '../includes/functions.php';

//Creamos la conexión
	include_once '../includes/sp_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	
//Datos correspondiente a la empresa que emite la factura
	//BUSCO miPuntoVenta EN CONTROLPANEL.
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
	$PtoVta=$rowresultDatosAux['ContenidoValor'];
	
	echo "</br>";
//Le tengo que pedir al usuario el numero de comprobante a consultar
//    public function FECompConsultar($CbteTipo (1,2,6,etc),$CbteNro (5134 o 00005134),$PtoVta (5))
	echo"<label for='CbteTipo'>CbteTipo:</label>";
	echo"<select id='CbteTipo' name='CbteTipo'>";
		echo"<option value='1'>Factura A</option>";  
		echo"<option value='3'>Nota de crédito A</option>";  
		echo"<option value='2'>Nota de débito A</option>";  
		echo"<option value='6'>Factura B</option>";  
		echo"<option value='8'>Nota de crédito B</option>";  
		echo"<option value='7'>Nota de débito B</option>";   
	echo"</select>";
	echo"<label for='PtoVta'>PtoVta:</label>";
	echo"<input id='PtoVta' class='input' name='PtoVta' type='text' size='5' value=".$PtoVta." Disabled>";  
	echo"<label for='CbteNro'>CbteNro:</label>";
	echo"<input id='CbteNro' class='input' name='CbteNro' type='text' size='15' value=''>";  
	echo "</br>";
	echo"<input type='button' id='consultarFacCAE' value='Consultar'/>";
