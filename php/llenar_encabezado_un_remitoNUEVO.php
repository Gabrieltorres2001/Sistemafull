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
//echo"<ul class='nav navbar-nav'>";
//echo"<li>  Detalle:  </li>";
//echo"</ul>";
//echo"<br>";
//generamos la consulta
   if(!$resultComprobante = mysqli_query($conexion_sp, "select NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, Confecciono, Transporte, PlazoEntrega, NumeroComprobante01, Solicito from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$reg = mysqli_fetch_array($resultComprobante);  

	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$reg['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);
	
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion, Observaciones, CondDePago, CUIT, ActividEmpresa from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regEmp = mysqli_fetch_array($resultEmp);
	
	if(!$resultEmpMail = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT='".$reg['NonmbreEmpresa']."' and Direccion Like '%@%'")) die("Problemas con la consulta2");
	$regEmpMail = mysqli_fetch_array($resultEmpMail);
	
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$reg['Confecciono']."' limit 1")) die("Problemas con la consulta members1");
	$rowConfecc = mysqli_fetch_array($confecc);
	$soyYo=0;
	if($_REQUEST['sesses']==$reg['Confecciono'])$soyYo=1;
	
	//echo"<input type='button' id='cambiaDatos' value='Modificar' disabled>";
	//echo"<br>";	
	
	echo"<label for='NumeroComprobante'>Nº:</label>";
	echo"<input id='NumeroComprobante' class='input' name='NumeroComprobante' type='text' size='5' value=".$reg['NumeroComprobante']."  Disabled>";
	//echo"<label for='FechaComprobante'>Fecha del comprobante:</label>";
	//echo"<input id='FechaComprobante' class='input' name='FechaComprobante' type='text' size='10' value=".substr($reg['FechaComprobante'],8,2)."/".substr($reg['FechaComprobante'],5,2)."/".substr($reg['FechaComprobante'],0,4)." disabled>";
	echo"<label for='Confeccion'>Confeccionó:</label>";
	echo"<input id='Confeccion' class='input' name='Confeccion' type='text' size='18' value='".$rowConfecc['Nombre']." ".$rowConfecc['Apellido']."' disabled>";
	echo"<select id='Solicita' name='Solicita'>";
		echo"<option value='0'> </option>";
		//Agrego el Where usuarioTrabajando=1, asi no listo a todos!
		if(!$solicitTodos = mysqli_query($conexion_db, "select id, Nombre, Apellido from members where usuarioTrabajando = 1")) die("Problemas con la consulta members5");
		while ($rowSolicitTodos = mysqli_fetch_array($solicitTodos)){
		  if ($rowSolicitTodos['id']==$reg['Solicito']){
				echo"<option value='".$rowSolicitTodos['id']."' selected='selected'>".$rowSolicitTodos['Nombre']." ".$rowSolicitTodos['Apellido']."</option>";
		  } else {
		  echo"<option value='".$rowSolicitTodos['id']."'>".$rowSolicitTodos['Nombre']." ".$rowSolicitTodos['Apellido']."</option>";
		  }; 
		}  
	echo"</select>";
	echo"<br>";
	echo"<label for='Organizacion'>Organizacion:</label>";
	echo"<input id='Organizacion' class='input' name='Organizacion' type='text' size='50' value='".$regEmp['Organizacion']."'  disabled>";
	//echo"<br>";
	echo"<input id='Contacto' class='input' name='Contacto' type='text' size='35' value='".$reg['ApellidoContacto']."'  disabled>";
	echo"<input id='DirecciondecorreoelectronicoP' class='input' name='Direcciondecorreoelectronico' type='hidden' size='43' value='".$regEmpMail['Direccion']."'>";
	if (strlen($regEmpMail['Direccion'])>0)
	{echo "<input type=image id='botonMailP' src='./images/botonemail.png' width='25' height='25'/> ";}
 	echo"<br>";
	//echo"<label for='NotasInternas'>Notas:</label>";
	echo"<textarea id='NotasInternas' class='input' overflow='scroll' name='NotasInternas' resize='none' cols='108' rows='1' disabled>".$regEmp['ActividEmpresa']." ".$regEmp['Observaciones']."</textarea>";
	echo"<br>";
	
	echo"<label for='CondicionesPago'>Condiciones de Pago:</label>";
	echo"<select id='CondicionesPago' name='CondicionesPago'>";
		if(!$condicPago = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");	
		while ($rowCondicPago = mysqli_fetch_array($condicPago)){
		  $tmpFP = explode(',', $rowCondicPago['ContenidoValor']);
		  if ($rowCondicPago['Descripcion']==$reg['CondicionesPago']){  
				echo"<option value='".$rowCondicPago['Descripcion']."' selected='selected'>".$tmpFP[0]."</option>";
		  } else {
		  echo"<option value='".$rowCondicPago['Descripcion']."'>".$tmpFP[0]."</option>";
		  }; 
		} 
	echo"</select>";
	echo"<br>";
	echo"<label for='PlazoEntrega'>Plazo de Entrega:</label>";
	echo"<select id='PlazoEntrega' name='PlazoEntrega'>";
		echo"<option value='0'> </option>";
		if(!$plazoEnt = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='51' order by ContenidoValor")) die("Problemas con la consulta plazoentrega en controlpanel");
		while ($rowPlazoEnt = mysqli_fetch_array($plazoEnt)){
		  if ($rowPlazoEnt['Descripcion']==$reg['PlazoEntrega']){
				echo"<option value='".$rowPlazoEnt['Descripcion']."' selected='selected'>".$rowPlazoEnt['ContenidoValor']."</option>";
		  } else {
		  echo"<option value='".$rowPlazoEnt['Descripcion']."'>".$rowPlazoEnt['ContenidoValor']."</option>";
		  }; 
		}  
	echo"</select>";
	echo"<br>";
	echo"<label for='Transporte'>Transporte:</label>";
	echo"<select id='Transporte' name='Transporte'>";
		echo"<option value='0'> </option>";
		if(!$transport = mysqli_query($conexion_sp, "select idTransporte, Transporte from z_transportes order by Transporte")) die("Problemas con la consulta_z_transportes");
		while ($rowTransport = mysqli_fetch_array($transport)){
		  if ($rowTransport['Transporte']==$reg['Transporte']){
				echo"<option value='".$rowTransport['idTransporte']."' selected='selected'>".$rowTransport['Transporte']."</option>";
		  } else {
		  echo"<option value='".$rowTransport['idTransporte']."'>".$rowTransport['Transporte']."</option>";
		  }; 
		}  
	echo"</select>";	
	echo"<br>";
	echo"<label for='PeticionOferta'>Nº OC cliente:</label>";
	echo"<input id='PeticionOferta' class='input' name='PeticionOferta' type='text' size='30' value='".$reg['NumeroComprobante01']."'>";
	echo"<label for='preimpreso'>Nº remito preimpreso:</label>";
	echo"<input id='preimpreso' class='input' name='preimpreso' type='text' size='15' value=''>";
	echo"<br>";
	echo"<label for='numfactura'>Nº factura:</label>";
	echo"<input id='numfactura' class='input' name='numfactura' type='text' size='25' value=''>";
	//echo"<br>";
	echo"<label for='Notas'>Notas:</label>";
	echo"<textarea id='Notas' class='input' overflow='scroll' name='Notas' resize='none' cols='60' rows='1'>".$reg['Notas']."</textarea>";
	echo"<br>";
	//Siguen las direcciones. Hacer un descolgable.	
	//echo"<fieldset style='width:380px'>";				
	if(!$resultDirec = mysqli_query($conexion_sp, "select id, Direccion, Ciudad, Codigopostal, Provoestado, Pais from direcciones where CUIT = '".$regContEmp['idOrganizacion']."' and Direccion not Like '%@%' and ((Direccion is not null) and (Ciudad is not null) and (Codigopostal is not null) and (Provoestado is not null) and (Pais is not null)) order by id asc")) die("Problemas con la consulta Direcciones");
	echo"<label>Dirección a imprimir en el Comprobante:</label>";
	//echo"<br />";
	echo"<select id='direcRemito' name='direcRemito'>";
	while ($rowDir = mysqli_fetch_row($resultDirec)){ 
		echo"<option value='".$rowDir[0]."'>".$rowDir[1]." (".$rowDir[3].")".$rowDir[2]." ".$rowDir[4]."</option>";
	}
	echo"</select>";	
	//echo"</fieldset>";
	//echo"<br>";
	//echo"<input type='button' id='aceptarCambiaDatos' value='Aceptar'>";


