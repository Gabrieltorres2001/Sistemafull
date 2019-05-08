<?php
//Creamos la conexión
$fileDir = __DIR__;
include ($fileDir.'/../includes/sp_connect.php');
include ($fileDir.'/../includes/db_connect.php');

function consultaMembers($id){
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tenerpermiso para modificar
		if(!$memberInfo = mysqli_query($conexion_db, "select * from members where id='$id' limit 1")) die("Problemas con consultaMembers");
		$res = mysqli_fetch_array($memberInfo);
    return $res;
}