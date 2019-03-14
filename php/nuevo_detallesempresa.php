<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
include '../includes/funcEmpresas.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta de actualizacion
	
	if(!$resultcopia = mysqli_query($conexion_sp, "insert into organizaciones (CUIT, Organizacion, Informacion, Observaciones, CondDePago, DiasDePago, Horarios, EntregaFactura, ActividEmpresa, IdTipoContacto, CondicionIVA) values ('', '', '', '', '', '', '', '', '', '', '')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Empresa NO creada. Error en tabla organizaciones.</label>";
		 die("Problemas con la consulta de creacion");
	}
	else {
		$id=mysqli_insert_id($conexion_sp);
	};

	if(!$resultc = mysqli_query($conexion_sp, "select * from organizaciones where id = '".$id."' limit 1")) die("Problemas con la consulta de busqueda");  
	
	imprimir_detalle_empresas($resultc, $conexion_sp, '');
