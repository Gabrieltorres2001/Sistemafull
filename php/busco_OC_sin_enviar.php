<?php
   //Creamos la conexión
	include_once '../includes/sp_connect.php';
	include_once '../includes/db_connect.php';
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	//Busco el nombre de la empresa del contacto que recibi
	if(!$resultLectEmpr = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto = '".$_REQUEST['numempresa']."' limit 1")){
		 die("Problemas con la primera consulta contactos2");
	}
	$rowresultLectEmpr = mysqli_fetch_array($resultLectEmpr);
	
	//Luego busco TODOS los empleados de esa empresa
	if(!$resultLectEmplEmpr = mysqli_query($conexion_sp, "select IdContacto from contactos2 where idOrganizacion = '".$rowresultLectEmpr['idOrganizacion']."'")){
		 die("Problemas con la segunda consulta contactos2");
	}
	//Contador de resultados encontrados
	$OCSinEnviar="Nones";
	while ($rowresultLectEmplEmpr = mysqli_fetch_array($resultLectEmplEmpr))
	{//Busco Ordenes de compra abiertas sin enviar de esta empresa en comprobantes (Tengo que buscar empleado por empleado)
		//IDEA: Puedo poner "que la fecha sea mayor al 04/07/2018 así no tengo que marcar como "Enviadas" a las OC anteriores y asi no perder historial
		//de las que realmente han sido enviadas o no
		if(!$resultContOC = mysqli_query($conexion_sp, "select IdComprobante, NumeroComprobante, FechaComprobante, Confecciono from comprobantes where NonmbreEmpresa='".$rowresultLectEmplEmpr['IdContacto']."' and TipoComprobante='9' and OCEnviada='0' limit 1")) die("Problemas con la comprobantes");
		if ($regContEmp = mysqli_fetch_array($resultContOC))
		{//Si entro al If es porque encontré un resultado
			//Busco el responsable
			if(!$resultResp = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$regContEmp['Confecciono']."' limit 1")) die("Problemas con la consulta members");
			$regResp = mysqli_fetch_array($resultResp);
			$OCSinEnviar='Existe una OC a este proveedor aún sin enviar, número: '.$regContEmp['NumeroComprobante'].', Fecha: '.$regContEmp['FechaComprobante'].', Confecciono: '.$regResp['Nombre'].' '.$regResp['Apellido'];
			break;
		}
	}
	echo $OCSinEnviar;
	
