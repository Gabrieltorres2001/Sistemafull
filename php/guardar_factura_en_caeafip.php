<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//primero buscamos datos adicionales
		if(!$resultComp = mysqli_query($conexion_sp, "select NonmbreEmpresa from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
		$regComp = mysqli_fetch_array($resultComp);

		//Agrego un intermedio con el cambio de la tabla contactos a contactos2
		if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$regComp['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
		$regContEmp = mysqli_fetch_array($resultContEmp);
	
		if(!$resultEmp = mysqli_query($conexion_sp, "select CUIT from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
		$regEmp = mysqli_fetch_array($resultEmp);
		
		//Enero 2019. Multiples direcciones en la factura, al igual que en remitos
		//if(!$resultEmpDir = mysqli_query($conexion_sp, "select Provoestado from direcciones where CUIT='".$regContEmp['idOrganizacion']."' and Direccion Not Like '%@%' order by id asc limit 1")) die("Problemas con la consulta2");
		//$regEmpDir = mysqli_fetch_array($resultEmpDir);		
		if(!$resultEmpDir = mysqli_query($conexion_sp, "select Provoestado from direcciones where id='".$_REQUEST['diRemito']."' and Direccion Not Like '%@%' limit 1")) die("Problemas con la consulta diRemito");
		$regEmpDir = mysqli_fetch_array($resultEmpDir);			
		
	//BUSCO miPuntoVenta EN CONTROLPANEL.
	if(!$resultDatosAux = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'miPuntoVenta' and padre = '1' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowresultDatosAux = mysqli_fetch_array($resultDatosAux);	
		
//generamos la consulta de actualizacion
//2018 voy a cambiar el uso del registro IdEnviado, que en el sistema nuevo estaba al pedo (en el sistema Access se usaba pero luego ya no)
//ahora lo voy a usar para identificar la moneda de la factura realizada
//0 es pesos, 1 es dolares, 60 es Euro (como la AFIP)
	if(!$resultact = mysqli_query($conexion_sp, "insert into caeafip (IdEnviado, NumeroFactura, TipoFactura, CAE, CUITCliente, VtoCAE, FechaFactura, NonmbreEmpresa, ImporteTotal, ImporteNeto, Provincia, IVA21, IVA10, actualiz, IdComprobante) values ('".$_REQUEST['IdEnviado']."','".str_pad($rowresultDatosAux['ContenidoValor'], 4,"0", STR_PAD_LEFT).'-'.str_pad($_REQUEST['NumeroFactura'], 8,"0", STR_PAD_LEFT)."', '".$_REQUEST['TipoFactura']."', '".$_REQUEST['CAE']."', '".$regEmp['CUIT']."', '".$_REQUEST['VtoCAE']."', now(), '".$regComp['NonmbreEmpresa']."', '".$_REQUEST['ImporteTotal']."', '".$_REQUEST['ImporteNeto']."', '".$regEmpDir['Provoestado']."', '".$_REQUEST['IVA21']."', '".$_REQUEST['IVA10']."', now(), '".$_REQUEST['idcomprobante']."')")){
		//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
		 die("Problemas con la consulta de agregar item");
	}	else {
			$id=mysqli_insert_id($conexion_sp);
			if(!$resultfondosyfacturas = mysqli_query($conexion_sp, "insert into fondosyfacturas (idCaeAfip, CUIT) values ('".$id."', '".$regEmp['CUIT']."')")){
				//echo"<label style='font-size:1em; font-weight:bold; color:red'>No agregado</label>";
				 die("Problemas con la consulta de agregar fondosyfacturas");
			}	else {		
						echo"OkOko";
			}
	};
