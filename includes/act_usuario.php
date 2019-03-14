<?php
include_once 'db_connect.php';
include_once 'functions.php';
include_once 'funcionesg.php';
 
sec_session_start();
Actualizar_Usuario($_SESSION['user_id']);
?>