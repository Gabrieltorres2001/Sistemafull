<?php

function llenar_listado_contactos() {
   //Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta contactos2
   if(!$result = mysqli_query($conexion_sp, "select contactos2.IdContacto, contactos2.NombreCompleto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id ORDER BY contactos2.IdContacto asc limit 100")) die("Problemas con la consulta contactos2");
echo "<table class='display' id='tablaContactos'>";  
echo "<tr>";  
//echo "<th width='65'>IdContacto</th>";  
echo "<th width='150'>NombreCompleto</th>";  
echo "<th  width='170'>Organización</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr id=$row[0]>";  
//    echo "<td id=$row[0]>$row[0]</td>";   
    echo "<td id=$row[0]>$row[1]</td>";
    echo "<td id=$row[0]>$row[2]</td>";   
    echo "</tr>";  
};  
echo "</table>";
}

function imprimir_detalle_contactos($resultc, $conexion_sp, $idEmpresaTemp) {
	$reg = mysqli_fetch_array($resultc);  
	//Primero datos del contacto
	echo"<label><u>Datos del contacto:</u></label>";
	echo"<br />";
	//echo"<label for='IdContacto'>Id del contacto:</label>";
	echo"<input id='IdContacto' class='hidden' name='IdContacto' type='text' size='5' value=".$reg['IdContacto']." >";
	
	echo"<label for='NombreCompleto'>Nombre completo:</label>";
	echo"<input id='NombreCompleto' class='input' name='NombreCompleto' type='text' size='88' value='".$reg['NombreCompleto']."'><br />";	
	
	//Aldo quiere ver la empresa en a parte superior de la ventana
if(!$resultUnaOrg = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$reg['idOrganizacion']."' limit 1")) die("Problemas con la consulta Todas organizaciones");
	$regUnaOrg = mysqli_fetch_array($resultUnaOrg); 
	echo"<label for='EmpresaRepetida'>Empresa:</label>";
	echo"<input id='EmpresaRepetida' class='input' name='EmpresaRepetida' type='text' size='88' readonly='readonly' value='".$regUnaOrg['Organizacion']."' disabled><br />";		
	
	echo"<label for='FuncionEnLaEmpresa'>Funcion en la empresa:</label>";
	echo"<input id='FuncionEnLaEmpresa' class='input' name='FuncionEnLaEmpresa' type='text' size='55' value='".$reg['FuncionEnLaEmpresa']."'> ";	
	
	echo"<label for='PoderDecision'>PoderDecision:</label>";
	echo"<select id='PoderDecision' class='input' name='PoderDecision'>";
		if ($reg['PoderDecision']==0) {
			echo"<option selected value=0>No</option>";
			echo"<option value=1>Si</option>";
		} else {
			echo"<option value=0>No</option>";
			echo"<option selected value=1>Si</option>";
		}
	echo"</select><br />";	
	
	echo"<label for='PalabrasClave'>PalabrasClave:</label>";
	echo"<textarea id='PalabrasClave' class='input' name='PalabrasClave' rows='3' cols='90'>".$reg['PalabrasClave']."</textarea><br />";
	
	//Luego los teléfonos. Hacer una tabla.
	if(!$resultTel = mysqli_query($conexion_sp, "select Telefono, Faxdeltrabajo, Telefonomovil, Telefonoprivado2, OtroTelefono from telefonos where IdContacto = '".$reg['IdContacto']."'")) die("Problemas con la consulta telefonos");
	while ($rowresultTel = mysqli_fetch_row($resultTel)){
		echo"<label for='IdTipoContacto'><u>Teléfonos del contacto:</u></label>";
		echo"<table>";
		echo"<tr>";
		echo"<th>Tipo</th>";
		echo"<th>Número</th>";
		echo"</tr>";
		//Principal
			echo"<tr>";
			echo"<th>Principal</th>";
			echo"<th><input id='Telefono' class='input' name='Telefono' type='text' size='55' value='".$rowresultTel[0]."'></th>";
			echo"</tr>";			
		//Fax del trabajo
			echo"<tr>";
			echo"<th>Fax del trabajo</th>";
			echo"<th><input id='Faxdeltrabajo' class='input' name='Faxdeltrabajo' type='text' size='55' value='".$rowresultTel[1]."'></th>";
			echo"</tr>";			
		//Celular
			echo"<tr>";
			echo"<th>Celular</th>";
			echo"<th><input id='Telefonomovil' class='input' name='Telefonomovil' type='text' size='55' value='".$rowresultTel[2]."'></th>";
			echo"</tr>";		
		//Privado
			echo"<tr>";
			echo"<th>Privado</th>";
			echo"<th><input id='Telefonoprivado2' class='input' name='Telefonoprivado2' type='text' size='55' value='".$rowresultTel[3]."'></th>";
			echo"</tr>";	
		//Otro
			echo"<tr>";
			echo"<th>Otro</th>";
			echo"<th><input id='OtroTelefono' class='input' name='OtroTelefono' type='text' size='55' value='".$rowresultTel[4]."'></th>";
			echo"</tr>";		
		echo"</table>";		
		//echo"<br />";	
	}
	//Luego los mails. Hacer una lista y permitir agregar mas campos.
	if(!$resultMail = mysqli_query($conexion_sp, "select Direccion from direcciones where CUIT = '".$reg['IdContacto']."' and Direccion Like '%@%'")) die("Problemas con la consulta eMail");
	echo"<label><u>e-Mail(s) del contacto:</u></label>";
	echo"<br />";
	$Contador=0;
	while ($row = mysqli_fetch_row($resultMail)){ 
		echo"<label for='Direcciondecorreoelectronico'>Correo electrónico:</label>";
		echo"<input id='Direcciondecorreoelectronico".$Contador."' class='input' name='Direcciondecorreoelectronico' type='text' size='55' value='".$row[0]."'>";	
		if (strlen($row[0])>0) {echo "<input type=image id='".$Contador."' name='botonMail' src='./images/botonemail.png' width='25' height='25'/> ";}
		echo "<br />";
		$Contador++;
	}
	echo"<label for='Direcciondecorreoelectronico'>Correo electrónico:</label>";
	echo"<input id='Direcciondecorreoelectronico".$Contador."' class='input' name='Direcciondecorreoelectronico' type='text' size='55' value=''><br />";		
	//Luego la empresa.
	if (strlen($idEmpresaTemp)>0) {
		if(!$resultOrg = mysqli_query($conexion_sp, "select CUIT, Organizacion, Informacion, Observaciones, CondDePago, DiasDePago, Horarios, EntregaFactura, ActividEmpresa, IdTipoContacto, CondicionIVA, id from organizaciones where id = '".$idEmpresaTemp."'")) die("Problemas con la consulta organizaciones");
	} else {
			if(!$resultOrg = mysqli_query($conexion_sp, "select CUIT, Organizacion, Informacion, Observaciones, CondDePago, DiasDePago, Horarios, EntregaFactura, ActividEmpresa, IdTipoContacto, CondicionIVA, id from organizaciones where id = '".$reg['idOrganizacion']."'")) die("Problemas con la consulta organizaciones");
		};
	$regOrg = mysqli_fetch_array($resultOrg);
	echo"<label><u>Empresa del contacto:</u></label>";
	echo"<br />";
	
	//if(!$resultTC = mysqli_query($conexion_sp, "select * from z_tipocontacto")) die("Problemas con la consulta z_tipocontacto");
	//echo"<label for='IdTipoContacto'>Tipo:</label>";
	//echo"<select id='IdTipoContacto' class='input' name='IdTipoContacto'>";
	//while ($row = mysqli_fetch_row($resultTC)){ 
	//	if ($regOrg['IdTipoContacto']==$row[0]){
	//		echo"<option selected value=".$row[0].">".$row[1]."</option>";
	//		}else{
	//			echo"<option value=".$row[0].">".$row[1]."</option>";
	//		}	
	//}
	//if ($regOrg['IdTipoContacto']=='' or $regOrg['IdTipoContacto']=='0'){
	//echo"<option selected value=''></option>";
	//}
    //echo"</select>";
	
	if(!$resultTodasOrg = mysqli_query($conexion_sp, "select distinct id, Organizacion from organizaciones order by Organizacion")) die("Problemas con la consulta Todas organizaciones");
	echo"<label for='Organizacion'>Organizacion:</label>";
	echo"<select id='Organizacion' class='input' name='Organizacion'>";
	while ($row = mysqli_fetch_row($resultTodasOrg)){ 
		if ($regOrg['Organizacion']==$row[1]){
			echo"<option selected value=".$row[0].">".substr($row[1],0,75)."</option>";
			}else{
				echo"<option value=".$row[0].">".substr($row[1],0,75)."</option>";
			}	
	}
	if ($regOrg['Organizacion']=='' or $regOrg['Organizacion']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	//echo"<input id='Organizacion' class='input' name='Organizacion' type='text' size='55' value='".$regOrg['Organizacion']."'><br />";
	
	if(!$resultTC = mysqli_query($conexion_sp, "select TipoContacto from z_tipocontacto where IdRegistroTipoContacto = '".$regOrg['IdTipoContacto']."'")) die("Problemas con la consulta z_tipocontacto");
	echo"<label for='IdTipoContacto'>Tipo:</label>";
	$regTC = mysqli_fetch_array($resultTC);
	echo"<input id='IdTipoContacto' class='input' name='IdTipoContacto' type='text' size='15' value='".$regTC['TipoContacto']."' disabled>";
	
	echo"<label for='ActividEmpresa'>Actividad de la empresa:</label>";
	echo"<input id='ActividEmpresa' class='input' name='ActividEmpresa' type='text' size='55' value='".$regOrg['ActividEmpresa']."' disabled><br />";
		
	echo"<label for='Observaciones'>Observaciones:</label>";
	echo"<textarea id='Observaciones' class='input' name='Observaciones' rows='6' cols='90' disabled>".$regOrg['Observaciones']."</textarea> <br />";
		
	echo"<label for='Informacion'>Rubro:</label>";
	echo"<input id='Informacion' class='input' name='Informacion' type='text' size='34' value='".$regOrg['Informacion']."' disabled>";
	
	echo"<label for='CUIT'>CUIT:</label>";
	echo"<input id='CUIT' class='input' name='CUIT' type='text' size='17' value='".$regOrg['CUIT']."' disabled><br />";
	
	echo"<label for='Horarios'>Horarios de trabajo:</label>";
	echo"<input id='Horarios' class='input' name='Horarios' type='text' size='89' value='".$regOrg['Horarios']."' disabled><br />";	
	
	echo"<label for='DiasDePago'>Dias y horarios de pago:</label>";
	echo"<input id='DiasDePago' class='input' name='DiasDePago' type='text' size='85' value='".$regOrg['DiasDePago']."' disabled><br />";	
	
	//cambio la condicion de pago. ahora voy a guardar el id, ya no guardo el texto
	//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
	//Padre 17 es la forma de pago. No lo puedo cambiar
	if(!$resultFP = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = '".$regOrg['CondDePago']."' and padre='17'")) die("Problemas con la consulta forma de pago en controlpanel");
	$regFP = mysqli_fetch_array($resultFP);
	//Separo el texto del plazo, vinculados con la coma
	$tmpFP = explode(',', $regFP['ContenidoValor']);
	echo"<label for='CondDePago'>Condición de pago:</label>";
	echo"<input id='CondDePago' class='input' name='CondDePago' type='text' size='35' value='".$tmpFP[0]."' disabled>";
	
	//if(!$resultCIVA = mysqli_query($conexion_sp, "select ConddeIva from z_conddeiva")) die("Problemas con la consulta z_conddeiva");
	//echo"<label for='CondicionIVA'>Condicion de IVA:</label>";
	//echo"<select id='CondicionIVA' class='input' name='CondicionIVA'>";
	//while ($row = mysqli_fetch_array($resultCIVA)){ 
	//	if ($reg['CondicionIVA']==$row['ConddeIva']){
	//		echo"<option selected value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
	//		}else{
	//			echo"<option value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
	//		}	
	//}
	//if ($reg['CondicionIVA']=='' or $reg['CondicionIVA']=='0'){
	//echo"<option selected value=''></option>";
	//}
    //echo"</select><br />";
	echo"<label for='CondicionIVA'>Condicion de IVA:</label>";
	echo"<input id='CondicionIVA' class='input' name='CondicionIVA' type='text' size='35' value='".$regOrg['CondicionIVA']."' disabled><br />";
	
	echo"<label for='EntregaFactura'>Entrega de facturas:</label>";
	echo"<input id='EntregaFactura' class='input' name='EntregaFactura' type='text' size='90' value='".$regOrg['EntregaFactura']."' disabled><br />";		
	
	
	
	//echo"<label for='Direccion'>Direccion:</label>";
	//echo"<input id='Direccion' class='input' name='Direccion' type='text' size='40' value='".$reg['Direccion']."'>";
	
	//echo"<label for='Ciudad'>Ciudad:</label>";
	//echo"<input id='Ciudad' class='input' name='Ciudad' type='text' size='40' value='".$reg['Ciudad']."'>";
	
	//echo"<label for='Codigopostal'>CP:</label>";
	//echo"<input id='Codigopostal' class='input' name='Codigopostal' type='text' size='6' value='".$reg['Codigopostal']."'><br />";
	
	//echo"<label for='Provoestado'>Provincia:</label>";
	//echo"<input id='Provoestado' class='input' name='Provoestado' type='text' size='40' value='".$reg['Provoestado']."'>";	
	
	//echo"<label for='Pais'>Pais:</label>";
	//echo"<input id='Pais' class='input' name='Pais' type='text' size='40' value='".$reg['Pais']."'><br />";	


	//Por ultimo las direcciones. Hacer una tabla.
	if(!$resultDirec = mysqli_query($conexion_sp, "select id, Direccion, Ciudad, Codigopostal, Provoestado, Pais from direcciones where CUIT = '".$regOrg['id']."' and Direccion not Like '%@%' order by id asc")) die("Problemas con la consulta Direcciones");
	echo"<label><u>Direccion(es) de la empresa:</u></label>";
	echo"<br />";
	echo"<table>";
	echo"<tr>";
	echo"<th>Direccion</th>";
	echo"<th>Ciudad</th>";
	echo"<th>CP</th>";
	echo"<th>Provincia</th>";
	echo"<th>País</th>";	
	echo"</tr>";
	while ($rowDir = mysqli_fetch_row($resultDirec)){ 
		echo"<tr>";
		echo"<td><input id='Direccion".$rowDir[0]."' class='input' name='Direccion".$rowDir[0]."' type='text' size='34' value='".$rowDir[1]."' disabled></td>";
		echo"<td><input id='Ciudad".$rowDir[0]."' class='input' name='Ciudad".$rowDir[0]."' type='text' size='10' value='".$rowDir[2]."' disabled></td>";
		echo"<td><input id='CP".$rowDir[0]."' class='input' name='CP".$rowDir[0]."' type='text' size='4' value='".$rowDir[3]."' disabled></td>";
		echo"<td><input id='Provincia".$rowDir[0]."' class='input' name='Provincia".$rowDir[0]."' type='text' size='14' value='".$rowDir[4]."' disabled></td>";
		echo"<td><input id='País".$rowDir[0]."' class='input' name='País".$rowDir[0]."' type='text' size='10' value='".$rowDir[5]."' disabled></td>";	
		echo"</tr>";
	}
	echo"</table>";			

	//echo"<label for='actualiz'>Ultima actualización:</label>";
	//echo"<input id='actualiz' class='input' name='actualiz' type='text' size='35' value='".$reg['actualiz']."' disabled><br />";	
	
	//echo"<br />";
	//echo"<br />";
	
	//echo"<label for='UsuarioCreacion'>UsuarioCreacion:</label>";
	//echo"<input id='UsuarioCreacion' class='input' name='UsuarioCreacion' type='text' size='35' value='".$reg['UsuarioCreacion']."'><br />";

	//	echo"<label for='UsuarioModificacion'>UsuarioModificacion:</label>";
	//echo"<input id='UsuarioModificacion' class='input' name='UsuarioModificacion' type='text' size='35' value='".$reg['UsuarioModificacion']."'><br />";
	
	//	echo"<label for='UsuarioFC'>UsuarioFC:</label>";
	//echo"<input id='UsuarioFC' class='input' name='UsuarioFC' type='text' size='35' value='".$reg['UsuarioFC']."'><br />";
	
	//	echo"<label for='UsuarioFM'>UsuarioFM:</label>";
	//echo"<input id='UsuarioFM' class='input' name='UsuarioFM' type='text' size='35' value='".$reg['UsuarioFM']."'><br />";
	
	//	echo"<label for='FechaActualizacion'>FechaActualizacion:</label>";
	//echo"<input id='FechaActualizacion' class='input' name='FechaActualizacion' type='text' size='35' value='".$reg['FechaActualizacion']."'><br />";
}

function imprimir_movimientos_contacto($resultc, $conexion_sp) {
	//$reg = mysqli_fetch_array($resultc); 
	$contador=0;
	if(!$resultcCont = mysqli_query($conexion_sp, "select IdComprobante,FechaComprobante,TipoComprobante from comprobantes where NonmbreEmpresa = '".$_REQUEST['idcto']."' order by TipoComprobante,FechaComprobante")) die("Problemas con la consulta comprobantes");
	while ($rowCont = mysqli_fetch_row($resultcCont)){ 
		if(!$resultDetComproCont = mysqli_query($conexion_sp, "select IdDetalleComprobante from detallecomprobante where IdComprobante='".$rowCont[0]."'")) die("Problemas con la consulta detallecomprobante"); 
		while ($rowDetComproCont = mysqli_fetch_row($resultDetComproCont)){ 
			$contador=$contador+1;
		}
	}
	
	echo "<table class='display' width='650' style='table-layout:fixed'>"; 
	//echo "<caption>Resultados encontrados: ".mysqli_num_rows($resultc)."</caption>";
	echo "<caption>Resultados encontrados: ".$contador."</caption>";

	echo "<tr>";  
	echo "<th width='80'>Comprobante</th>";  
	echo "<th width='50'>Número</th>";  
	echo "<th  width='60'>Fecha</th>";
	echo "<th  width='50'>Cod.</th>";   
	echo "<th  width='180'>Descripción</th>"; 
	echo "<th  width='50'>Cant</th>"; 
	echo "<th  width='50'>Valor venta</th>"; 
	echo "</tr>";  
	while ($row = mysqli_fetch_row($resultc)){   
		echo "<tr>";  
		if(!$resultDetCompro = mysqli_query($conexion_sp, "select IdDetalleComprobante,IdProducto,Cantidad,SubTotal,Moneda from detallecomprobante where IdComprobante='".$row[0]."'")) die("Problemas con la consulta detallecomprobante"); 
		if(!$resultTP = mysqli_query($conexion_sp, "select TipoComprobante from z_tipocomprobante where IdTipoComprobante='".$row[3]."'")) die("Problemas con la consulta z_tipocomprobante"); 
		$regTP = mysqli_fetch_array($resultTP);
		while ($rowDetCompro = mysqli_fetch_row($resultDetCompro)){   
			echo "<tr>"; 
		//$regDetCompro = mysqli_fetch_array($resultDetCompro);
			if(!$resultMon = mysqli_query($conexion_sp, "select Simbolo from monedaorigen where IdRegistroCambio='".$rowDetCompro[4]."'")) die("Problemas con la consulta monedaorigen"); 
			$regMon = mysqli_fetch_array($resultMon);
			if(!$resultDesc = mysqli_query($conexion_sp, "select descricpcion from productos where IdProducto='".$rowDetCompro[1]."'")) die("Problemas con la consulta productos"); 
			$regDesc = mysqli_fetch_array($resultDesc);
			echo "<td name='xxxx' id=$row[0]>".$regTP['TipoComprobante']."</td>";   
			echo "<td name='xxxx' id=$row[0]>$row[1]</td>";
			echo "<td name='xxxx' id=$row[0]>$row[2]</td>"; 
			echo "<td name='xxxx' id=$row[0]>$rowDetCompro[1]</td>";  
			echo "<td name='xxxx' id=$row[0]>".$regDesc['descricpcion']."</td>"; 
			echo "<td name='xxxx' id=$row[0]>$rowDetCompro[2]</td>"; 
			echo "<td name='xxxx' id=$row[0]>".$regMon['Simbolo']." $rowDetCompro[3]</td>"; 
			echo "</tr>"; 
		}
	};
	
	echo "</table>";

}
	
function llenar_acciones_contactos($estaSesion){
    //Creamos la conexión
	include_once 'includes/sp_connect.php';
	include_once 'includes/db_connect.php';
	
	$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
	$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
		die("Problemas con la conexión");
		mysqli_query($conexion_db,"set names 'utf8'");
		
		//tengo que tenerpermiso para modificar
		if(!$permisoModificar = mysqli_query($conexion_db, "select PuedeModificarContactos from members where id='".$estaSesion."' limit 1")) die("Problemas con la consultamembers");
		$rowPermisoModificar = mysqli_fetch_array($permisoModificar);
		$puedoModificar=0;
		if($rowPermisoModificar['PuedeModificarContactos']!=0)$puedoModificar=1;
		
		echo "<p>";
		if ($puedoModificar==0) {echo"<input type='button' id='botonActualizaContacto' value='Actualizar datos' disabled>";} else {echo"<input type='button' id='botonActualizaContacto' value='Actualizar datos'/>";}
		echo " ";
		if ($puedoModificar==0) {echo"<input type='button' id='botonCopiaContacto' value='Duplicar contacto' disabled>";} else {echo"<input type='button' id='botonCopiaContacto' value='Duplicar contacto'/>";}
		echo " ";
		if ($puedoModificar==0) {echo"<input type='button' id='botonNuevoContacto' value='Nuevo contacto' disabled>";} else {echo"<input type='button' id='botonNuevoContacto' value='Nuevo contacto'/>";}
		echo"</br>";
		echo"</br>";
		echo"<input type='checkbox' id='checkMostrarMovimientos' value='MostrarMovimientos'/>Mostrar movimientos del contacto";
		echo"</p>";
}
	
