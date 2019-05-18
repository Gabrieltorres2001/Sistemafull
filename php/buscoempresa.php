<?php
//Creamos la conexión
include_once '../includes/sp_connect.php';
include_once '../includes/funcEmpresas.php';
$conexion_sp = mysqli_connect(HOSTSP, USERSP, PASSWORDSP, DATABASESP) or
    die("Problemas con la conexión");
mysqli_query($conexion_sp, "set names 'utf8'");
//generamos la consulta

$textoBusqueda = $_REQUEST['busqueda'];
$ordenBusqueda = trim($_REQUEST['orden']) ? "ORDER BY ".$_REQUEST['orden'] : '';
$where ="";
if ($textoBusqueda == "") {
} else {
    if (substr_count($textoBusqueda, '*') > 0) $textoBusqueda = str_replace("*", "%", $textoBusqueda);
    $where = " AND ((Organizacion like '%" . $textoBusqueda . "%') or (ActividEmpresa like '%" . $textoBusqueda . "%') or (CUIT like '%" . $textoBusqueda . "%'))";
}

$sql = "SELECT id, Organizacion from organizaciones WHERE 1=1 {$where} {$ordenBusqueda} limit 500";
if (!$result = mysqli_query($conexion_sp, $sql)) die("Problemas con la consulta");

echo tablaEmpresas($result);
