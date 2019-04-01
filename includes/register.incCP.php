<?php
include_once 'db_connect.php';
include_once 'psl-config.php';


// Crear una sal aleatoria.
//$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

// Crea una contrase�a con sal. 
$password = hash('sha512', $_REQUEST['pass'] . $random_salt);

 
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
    mysqli_query($conexion_db,"set names 'utf8'");
//generamos la consulta de actualizacion
    if(!$resultact = mysqli_query($conexion_db, "update members set password = '".$password."', salt =  '".$random_salt."' where id = '".$_REQUEST['iduser']."'")){
        echo"../error.php?err=Registration failure: INSERT";
        die("Problemas con la consulta de actualizacion");
    } else { echo "./register_success.php";}

