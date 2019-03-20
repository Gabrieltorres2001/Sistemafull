<?php
include_once '../includes/sp_connect.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//Primero busco el detallecomprobante, pero a difernecia de siempre no lo busco por el id de comprobante,
//sino por el id de detalle que viene por $_REQUEST
if(!$resultDetalle = mysqli_query($conexion_sp, "select * from detallecomprobante where IdDetalleComprobante='".$_REQUEST['iddetalle']."' order by Orden")) die("Problemas con la consulta2");
$row = mysqli_fetch_row($resultDetalle);

	//Tengo que buscar todos los numeros de serie de este idDetalleComprobante en la tabla NumerosSerie
	if(!$resultNumerosSerie = mysqli_query($conexion_sp, "select idNumeroSerie,numeroSerie from numerosserie where IdDetalleComprobante='".$row[0]."' order by numeroSerie")) die("Problemas con la consulta numerosserie");
	//Ahora tengo que mostrar los resultados
	//Primero hago el td, es igual sin importar si soy el propietario del remito o no
	echo "<td name='xxxx' id='$row[0]&$row[2]&serieitem'>";
	echo "<input id='$row[0]&$row[2]&serieitem&E' class='input' name='xxxxt 'type='text' size='10' value=''>
	<img name='xxxNS' id='$row[0]&$row[2]&imagenOKNS' src='./images/ok3.jpg' width='14' height='14'>
	</br>";
	//Luego cargo los datos de la tabla numeros serie
	while ($regNumerosSerie = mysqli_fetch_array($resultNumerosSerie)){
		echo "<input id='$row[0]&$row[2]&".$regNumerosSerie['idNumeroSerie']."&serieitem&E' class='input' name='xxxxt 'type='text' size='10' value='".$regNumerosSerie["numeroSerie"]."' readonly>
		<img name='xxxBNS' id='$row[0]&$row[2]&".$regNumerosSerie['idNumeroSerie']."&imagenBorraNS' src='./images/Borrar3.jpg' width='14' height='14'>
		</br>";

	}

	//Luego el numero de serie (si existe) en formato viejo
	echo $row[5];

	//Por ultimo cierro el td de numeros de serie
	echo "</td>";