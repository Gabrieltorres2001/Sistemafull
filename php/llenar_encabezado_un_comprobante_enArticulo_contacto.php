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
   if(!$resultComprobante = mysqli_query($conexion_sp, "select NumeroComprobante, FechaComprobante, NonmbreEmpresa, ApellidoContacto, CondicionesPago, Notas, Confecciono, Transporte, PlazoEntrega, NumeroComprobante01, Solicito, TipoComprobante, NumeroComprobante02, UsuarioModificacion, OCEnviada from comprobantes where IdComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta1");
	$regComprobante = mysqli_fetch_array($resultComprobante);  
	
	//Agrego un intermedio con el cambio de la tabla contactos a contactos2
	if(!$resultContEmp = mysqli_query($conexion_sp, "select idOrganizacion from contactos2 where IdContacto='".$regComprobante['NonmbreEmpresa']."' limit 1")) die("Problemas con la consulta2");
	$regContEmp = mysqli_fetch_array($resultContEmp);

	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion, Observaciones, CondDePago, CUIT, ActividEmpresa from organizaciones where id='".$regContEmp['idOrganizacion']."' limit 1")) die("Problemas con la consulta2");
	$regEmp = mysqli_fetch_array($resultEmp);
	
	if(!$resultEmpMail = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT='".$regComprobante['NonmbreEmpresa']."' and Direccion Like '%@%'")) die("Problemas con la consulta2");
	$regEmpMail = mysqli_fetch_array($resultEmpMail);
	
	if(!$confecc = mysqli_query($conexion_db, "select Nombre, Apellido from members where id='".$regComprobante['Confecciono']."' limit 1")) die("Problemas con la consulta members1");
	$rowConfecc = mysqli_fetch_array($confecc);	
	
	echo"<label for='NumeroComprobante'>Nº:</label>";
	echo"<input id='NumeroComprobante' class='input' name='NumeroComprobante' type='text' size='5' value=".$regComprobante['NumeroComprobante']."  Disabled>";
	echo"<label for='FechaComprobante'>Fecha del comprobante:</label>";
	echo"<input id='FechaComprobante' class='input' name='FechaComprobante' type='text' size='10' value=".substr($regComprobante['FechaComprobante'],8,2)."/".substr($regComprobante['FechaComprobante'],5,2)."/".substr($regComprobante['FechaComprobante'],0,4)." disabled>";
	echo"<label for='Confeccion'>Confeccionó:</label>";
	echo"<input id='Confeccion' class='input' name='Confeccion' type='text' size='18' value='".$rowConfecc['Nombre']." ".$rowConfecc['Apellido']."' disabled>";
	echo"<select id='Solicita' name='Solicita' disabled>";
		echo"<option value='0'> </option>";
		//Agrego el Where usuarioTrabajando=1, asi no listo a todos!
		if(!$solicitTodos = mysqli_query($conexion_db, "select id, Nombre, Apellido from members where usuarioTrabajando = 1")) die("Problemas con la consulta members5");
		while ($rowSolicitTodos = mysqli_fetch_array($solicitTodos)){
		  if ($rowSolicitTodos['id']==$regComprobante['Solicito']){
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
	//echo"<label for='Contacto'>Contacto:</label>";
	echo"<input id='Contacto' class='input' name='Contacto' type='text' size='35' value='".$regComprobante['ApellidoContacto']."'  disabled>";
	echo"<input id='DirecciondecorreoelectronicoP' class='input' name='Direcciondecorreoelectronico' type='hidden' size='43' value='".$regEmpMail['Direccion']."'>";
	if (strlen($regEmpMail['Direccion'])>0)
	{echo "<input type=image id='botonMailP' src='./images/botonemail.png' width='25' height='25'/> ";}
 	echo"<br>";
	//echo"<label for='NotasInternas'>Notas:</label>";
	echo"<textarea id='NotasInternas' class='input' overflow='scroll' name='NotasInternas' resize='none' cols='108' rows='1' disabled>".$regEmp['ActividEmpresa']." ".$regEmp['Observaciones']."</textarea>";
	echo"<br>";
	echo"<label for='CondicionesPago'>Condiciones de Pago:</label>";
	echo"<select id='CondicionesPago' name='CondicionesPago' disabled>";
		if(!$condicPago = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");	
		while ($rowCondicPago = mysqli_fetch_array($condicPago)){
		  $tmpFP = explode(',', $rowCondicPago['ContenidoValor']);
		  if ($rowCondicPago['Descripcion']==$regComprobante['CondicionesPago']){  
				echo"<option value='".$rowCondicPago['Descripcion']."' selected='selected'>".$tmpFP[0]."</option>";
		  } else {
		  echo"<option value='".$rowCondicPago['Descripcion']."'>".$tmpFP[0]."</option>";
		  }; 
		}  
	echo"</select>";
	echo"<br>";
	echo"<label for='PlazoEntrega'>Plazo de Entrega:</label>";
	echo"<select id='PlazoEntrega' name='PlazoEntrega' disabled>";
		echo"<option value='0'> </option>";
		if(!$plazoEnt = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='51' order by ContenidoValor")) die("Problemas con la consulta plazoentrega en controlpanel");
		while ($rowPlazoEnt = mysqli_fetch_array($plazoEnt)){
		  if ($rowPlazoEnt['Descripcion']==$regComprobante['PlazoEntrega']){
				echo"<option value='".$rowPlazoEnt['Descripcion']."' selected='selected'>".$rowPlazoEnt['ContenidoValor']."</option>";
		  } else {
		  echo"<option value='".$rowPlazoEnt['Descripcion']."'>".$rowPlazoEnt['ContenidoValor']."</option>";
		  }; 
		}  
	echo"</select>";
	echo"<br>";
	echo"<label for='Transporte'>Transporte:</label>";
	echo"<select id='Transporte' name='Transporte' disabled>";
		echo"<option value='0'> </option>";
		if(!$transport = mysqli_query($conexion_sp, "select idTransporte, Transporte from z_transportes order by Transporte")) die("Problemas con la consulta_z_transportes");
		while ($rowTransport = mysqli_fetch_array($transport)){
		  if ($rowTransport['Transporte']==$regComprobante['Transporte']){
				echo"<option value='".$rowTransport['idTransporte']."' selected='selected'>".$rowTransport['Transporte']."</option>";
		  } else {
		  echo"<option value='".$rowTransport['idTransporte']."'>".$rowTransport['Transporte']."</option>";
		  }; 
		}  
	echo"</select>";	
	echo"<br>";
	//Hasta aca es igual para todos. Ahora tengo que ver si es
	//Presupuesto, Remito o OC para completar el resto.
	//Presupuesto
	if($regComprobante['TipoComprobante']=="5") { 	
		echo"<label for='PeticionOferta'>Peticion de Oferta:</label>";
		echo"<input id='PeticionOferta' class='input' name='PeticionOferta' type='text' size='50' value='".$regComprobante['NumeroComprobante01']."' disabled>";
		echo"<br>";
		echo"<label for='Notas'>Notas:</label>";
		echo"<textarea id='Notas' class='input' overflow='scroll' name='Notas' resize='none' cols='100' rows='2' disabled>".$regComprobante['Notas']."</textarea>";
		echo"<br>";
		echo"<br>";}
	//Remito
	if($regComprobante['TipoComprobante']=="3") { 
		echo"<label for='PeticionOferta'>Nº OC cliente:</label>";
		echo"<input id='PeticionOferta' class='input' name='PeticionOferta' type='text' size='30' value='".$regComprobante['NumeroComprobante01']."' disabled>";
		echo"<label for='preimpreso'>Nº remito preimpreso:</label>";
		echo"<input id='preimpreso' class='input' name='preimpreso' type='text' size='15' value='".$regComprobante['NumeroComprobante02']."' disabled>";
		echo"<br>";
		echo"<label for='numfactura'>Nº factura:</label>";
		echo"<input id='numfactura' class='input' name='numfactura' type='text' size='25' value='".$regComprobante['UsuarioModificacion']."' disabled>";
		//echo"<br>";
		echo"<label for='Notas'>Notas:</label>";
		echo"<textarea id='Notas' class='input' overflow='scroll' name='Notas' resize='none' cols='60' rows='1' disabled>".$regComprobante['Notas']."</textarea>";
		echo"<br>";}
	//OC
	if($regComprobante['TipoComprobante']=="9") { 		
		echo"<label for='PeticionOferta'>Cotización:</label>";
		echo"<input id='PeticionOferta' class='input' name='PeticionOferta' type='text' size='50' value='".$regComprobante['NumeroComprobante01']."' disabled>";
		echo"<br>";
		echo"<label for='Notas'>Notas:</label>";
		echo"<textarea id='Notas' class='input' overflow='scroll' name='Notas' resize='none' cols='100' rows='2' disabled>".$regComprobante['Notas']."</textarea>";
		echo"<br>";
		if ($regComprobante['OCEnviada']==0){echo"<input id='ocEnviada' class='input' name='ocEnviada' type='text' size='20' style='width:140px;height:20px;background-color:red;color:yellow;font-size:10pt; font-family:Verdana;text-align:center;' value='OC NO GENERADA' readonly>";} else {echo"<input id='ocEnviada' class='input' name='ocEnviada' type='text' size='20' style='width:140px;height:20px;background-color:green;color:white;font-size:10pt; font-family:Verdana;text-align:center;' value='OC GENERADA' readonly>";}
		echo"<br>";}

	//Buscar si existe en algun legajo	
	if(!$legajo = mysqli_query($conexion_sp, "select idLegajo from detallelegajos where idComprobante='".$_REQUEST['idcomprobante']."' limit 1")) die("Problemas con la consulta detallelegajos");
	if ($rowLegajo = mysqli_fetch_array($legajo)) {echo "<p style='border: 1px solid green;border-radius: 5px;' align=center> Este presupuesto forma parte del legajo nº ".$rowLegajo['idLegajo']."</p>";}
	else
	{echo "<p style='border: 1px solid red;border-radius: 5px;' align=center> Este comprobante no forma parte de ningún legajo electrónico</p>";}

