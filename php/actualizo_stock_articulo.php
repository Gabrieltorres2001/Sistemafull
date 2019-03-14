<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//Primero leo el campo enStock del producto
	if(!$resultLect = mysqli_query($conexion_sp, "select EnStock from productos where IdProducto = '".$_REQUEST['idart']."' limit 1")){
		 die("Problemas con la consulta de lectura");
	}
	$rowresultLectStk = mysqli_fetch_array($resultLect);
	$stockViejo=$rowresultLectStk['EnStock'];
	
//actualizo EL stock EN LA TABLA DE PRODUCTO
	if(!$resultActStock = mysqli_query($conexion_sp, "update productos set EnStock ='".$_REQUEST['stock']."' where IdProducto = '".$_REQUEST['idart']."'")){
		 die("Problemas con la consulta de actualizar stock");
	}
//Cargo el nuevo movimiento de stock en la tabla ajustesstock
	if(!$resultActAjStock = mysqli_query($conexion_sp, "insert into ajustesstock (Fecha, IdProducto, stockAnterior, stockContado, Responsable) values ('".date('Y-m-d')."', '".$_REQUEST['idart']."', '".$stockViejo."', '".$_REQUEST['stock']."', '".$_REQUEST['sesses']."')")){
		 die("Problemas con la consulta de agregar resultActAjStock");
	}


//actualizo EL PRODUCTO(Deposito) EN LA TABLA DE stock (si es que está, sino lo cargo nuevo)
	if (strlen($_REQUEST['deposito'])>0) {
		//Primero busco si ya esxiste el registro para ese articulo
		if(!$resultLectDeposito = mysqli_query($conexion_sp, "select id, Deposito from stock where Producto = '".$_REQUEST['idart']."' limit 1")){
			 die("Problemas con la consulta de lectura Deposito");
		}
		if ($rowresultLectDep = mysqli_fetch_array($resultLectDeposito)) {
			//Ya estaba
			if(!$resultActDeposito = mysqli_query($conexion_sp, "update stock set Deposito ='".$_REQUEST['deposito']."' where id = '".$rowresultLectDep['id']."'")){
			 die("Problemas con la consulta de actualizar deposito");
	}} else {
		//No esta. Hay que cargar uno nuevo
		if(!$resultActDeposito = mysqli_query($conexion_sp, "insert into stock (id, Producto, Deposito, Estanteria, Estante) values (NULL, '".$_REQUEST['idart']."', '".$_REQUEST['deposito']."', NULL, NULL)")){ die("Problemas con la consulta de agregar deposito");}}
	}

//actualizo EL PRODUCTO(Estanteria) EN LA TABLA DE stock (si es que está, sino lo cargo nuevo)
	if (strlen($_REQUEST['deposito'])>0) {
		//Primero busco si ya esxiste el registro para ese articulo
		if(!$resultLectDeposito = mysqli_query($conexion_sp, "select id, Estanteria from stock where Producto = '".$_REQUEST['idart']."' limit 1")){
			 die("Problemas con la consulta de lectura Estanteria");
		}
		if ($rowresultLectDep = mysqli_fetch_array($resultLectDeposito)) {
			//Ya estaba
			if(!$resultActDeposito = mysqli_query($conexion_sp, "update stock set Estanteria ='".$_REQUEST['estanteria']."' where id = '".$rowresultLectDep['id']."'")){
			 die("Problemas con la consulta de actualizar Estanteria");
	}} else {
		//No esta. Hay que cargar uno nuevo
		if(!$resultActDeposito = mysqli_query($conexion_sp, "insert into stock (id, Producto, Deposito, Estanteria, Estante) values (NULL, '".$_REQUEST['idart']."', NULL, '".$_REQUEST['estanteria']."', NULL)")){ die("Problemas con la consulta de agregar Estanteria");}}
	}
	
//actualizo EL PRODUCTO(Estante) EN LA TABLA DE stock (si es que está, sino lo cargo nuevo)
	if (strlen($_REQUEST['deposito'])>0) {
		//Primero busco si ya esxiste el registro para ese articulo
		if(!$resultLectDeposito = mysqli_query($conexion_sp, "select id, Estante from stock where Producto = '".$_REQUEST['idart']."' limit 1")){
			 die("Problemas con la consulta de lectura Estante");
		}
		if ($rowresultLectDep = mysqli_fetch_array($resultLectDeposito)) {
			//Ya estaba
			if(!$resultActDeposito = mysqli_query($conexion_sp, "update stock set Estante ='".$_REQUEST['estante']."' where id = '".$rowresultLectDep['id']."'")){
			 die("Problemas con la consulta de actualizar Estante");
	}} else {
		//No esta. Hay que cargar uno nuevo
		if(!$resultActDeposito = mysqli_query($conexion_sp, "insert into stock (id, Producto, Deposito, Estanteria, Estante) values (NULL, '".$_REQUEST['idart']."', NULL, NULL, '".$_REQUEST['estante']."')")){ die("Problemas con la consulta de agregar Estante");}}
	}
	
echo "Registro cargado";