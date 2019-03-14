<?php

   //Creamos la conexión
   //echo"<option value=0r>rrrrr</option>";
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
	if(!$resultFP = mysqli_query($conexion_sp, "select Codigo, Denominacion from tipocomprobantesafip where id = 1 or id = 6")) die("Problemas con la consulta tipocomprobantesafip");
	echo"<select id='tipocomprobantesafip' class='input'>";
	echo"<option value=0 selected></option>";
	while ($row = mysqli_fetch_row($resultFP)){ 
			echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
	echo"</select>";