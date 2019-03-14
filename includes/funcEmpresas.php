<?php

function llenar_listado_empresas() {
   //Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta contactos2
   if(!$result = mysqli_query($conexion_sp, "select id, Organizacion from organizaciones ORDER BY Organizacion asc limit 100")) die("Problemas con la consulta organizaciones");
echo "<table class='display' id='tablaOrganizaciones'>";  
echo "<tr>";  
//echo "<th width='65'>IdContacto</th>";   
echo "<th  width='170'>Organización</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr id=$row[0]>";  
//    echo "<td id=$row[0]>$row[0]</td>";   
    echo "<td id=$row[0]>$row[1]</td>";  
    echo "</tr>";  
};  
echo "</table>";
}

function imprimir_detalle_empresas($resultc, $conexion_sp, $idEmpresaTemp) {
	$reg = mysqli_fetch_array($resultc);  
	//Primero datos del contacto
	echo"<label><u>Datos de la Empresa:</u></label>";
	echo"<br />";
	//echo"<label for='idEmpresa'>Id del contacto:</label>";
	echo"<input id='idEmpresa' class='hidden' name='idEmpresa' type='text' size='5' value=".$reg['id']." >";
	
	echo"<label for='CUIT'>CUIT:</label>";
	echo"<input id='CUIT' class='input' name='CUIT' type='text' size='12' value='".$reg['CUIT']."'>";	
	
	echo"<label for='Organizacion'>Razón social:</label>";
	echo"<input id='Organizacion' class='input' name='Organizacion' type='text' size='72' value='".$reg['Organizacion']."'> <br />";	
	
	if(!$resultTC = mysqli_query($conexion_sp, "select * from z_tipocontacto")) die("Problemas con la consulta z_tipocontacto");
	echo"<label for='IdTipoContacto'>Tipo:</label>";
	echo"<select id='IdTipoContacto' class='input' name='IdTipoContacto'>";
	while ($row = mysqli_fetch_row($resultTC)){ 
		if ($reg['IdTipoContacto']==$row[0]){
			echo"<option selected value=".$row[0].">".$row[1]."</option>";
			}else{
				echo"<option value=".$row[0].">".$row[1]."</option>";
			}	
	}
	if ($reg['IdTipoContacto']=='' or $reg['IdTipoContacto']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select>";
	
	echo"<label for='ActividEmpresa'>Actividad de la empresa:</label>";
	echo"<input id='ActividEmpresa' class='input' name='ActividEmpresa' type='text' size='55' value='".$reg['ActividEmpresa']."'><br />";
		
	echo"<label for='Observaciones'>Observaciones:</label>";
	echo"<textarea id='Observaciones' class='input' name='Observaciones' rows='6' cols='90'>".$reg['Observaciones']."</textarea> <br />";
		
	echo"<label for='Informacion'>Rubro:</label>";
	echo"<input id='Informacion' class='input' name='Informacion' type='text' size='34' value='".$reg['Informacion']."'><br />";
	
	echo"<label for='Horarios'>Horarios de trabajo:</label>";
	echo"<input id='Horarios' class='input' name='Horarios' type='text' size='89' value='".$reg['Horarios']."'><br />";	
	
	echo"<label for='DiasDePago'>Dias y horarios de pago:</label>";
	echo"<input id='DiasDePago' class='input' name='DiasDePago' type='text' size='85' value='".$reg['DiasDePago']."'><br />";	
	
	echo"<label for='EntregaFactura'>Entrega de facturas:</label>";
	echo"<input id='EntregaFactura' class='input' name='EntregaFactura' type='text' size='88' value='".$reg['EntregaFactura']."'><br />";
	
	//cambio la condicion de pago. ahora voy a guardar el id, ya no guardo el texto
	//Vuelvo a cambiar, ahora la voy a leer del panel de control (y la tengo que separar de la coma).
	//Padre 17 es la forma de pago. No lo puedo cambiar
	if(!$resultCpago = mysqli_query($conexion_sp, "select Descripcion, ContenidoValor from controlpanel where padre='17' order by ContenidoValor")) die("Problemas con la consulta forma de pago en controlpanel");
	echo"<label for='CondDePago'>Condición de pago:</label>";
	echo"<select id='CondDePago' class='input' name='CondDePago'>";
	echo"<option selected value=''></option>";
	while ($rowresultCpago = mysqli_fetch_array($resultCpago)){ 
		$tmpCpago = explode(',', $rowresultCpago['ContenidoValor']);
		if ($reg['CondDePago']==$rowresultCpago['Descripcion']){
			echo"<option selected value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}else{
				echo"<option value='".$rowresultCpago['Descripcion']."'>".$tmpCpago[0]."</option>";
			}	
	}
    echo"</select><br />";
	
	if(!$resultCIVA = mysqli_query($conexion_sp, "select ConddeIva from z_conddeiva")) die("Problemas con la consulta z_conddeiva");
	echo"<label for='CondicionIVA'>Condicion de IVA:</label>";
	echo"<select id='CondicionIVA' class='input' name='CondicionIVA'>";
	while ($row = mysqli_fetch_array($resultCIVA)){ 
		if ($reg['CondicionIVA']==$row['ConddeIva']){
			echo"<option selected value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
			}else{
				echo"<option value='".$row['ConddeIva']."'>".$row['ConddeIva']."</option>";
			}	
	}
	if ($reg['CondicionIVA']=='' or $reg['CondicionIVA']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";		

	//Nueva 2018. Tipo de factura (A o B), para que el sistema lo seleccione solo a la hora de facturar
	if(!$tipocomprobantesafip = mysqli_query($conexion_sp, "select Codigo, Denominacion from tipocomprobantesafip where id = 1 or id = 6")) die("Problemas con la consulta tipocomprobantesafip");
	echo"<label for='tipocomprobantesafip'>Tipo de comprobantes:</label>";
	echo"<select id='tipocomprobantesafip' class='input' name='tipocomprobantesafip'>";
	while ($row = mysqli_fetch_array($tipocomprobantesafip)){ 
		if ($reg['tipoComprobante']==$row['Codigo']){
			echo"<option selected value='".$row['Codigo']."'>".$row['Denominacion']."</option>";
			}else{
				echo"<option value='".$row['Codigo']."'>".$row['Denominacion']."</option>";
			}	
	}
	if ($reg['tipoComprobante']=='' or $reg['tipoComprobante']=='0'){
	echo"<option selected value=''></option>";
	}
    echo"</select><br />";
	
	//Siguen las direcciones. Hacer una tabla.
	if(!$resultDirec = mysqli_query($conexion_sp, "select id, Direccion, Ciudad, Codigopostal, Provoestado, Pais from direcciones where CUIT = '".$reg['id']."' and Direccion not Like '%@%' and ((Direccion is not null) and (Ciudad is not null) and (Codigopostal is not null) and (Provoestado is not null) and (Pais is not null)) order by id asc")) die("Problemas con la consulta Direcciones");
	echo"<label><u>Direccion(es) de la empresa:</u></label>";
	echo"<br />";
	echo"<table>";
	echo"<tr>";
	echo"<th>Direccion</th>";
	echo"<th>Ciudad</th>";
	echo"<th>CP</th>";
	echo"<th>Provincia</th>";
	echo"<th>pais</th>";	
	echo"</tr>";
	$contadortd=0;
	while ($rowDir = mysqli_fetch_row($resultDirec)){ 
		echo"<tr name='DireccionEmpresa' id='".$rowDir[0]."'>";
		echo"<td><input id='Direccion".$contadortd."' class='input' type='text' size='34' value='".$rowDir[1]."'></td>";
		echo"<td><input id='Ciudad".$contadortd."' class='input' type='text' size='10' value='".$rowDir[2]."'></td>";
		echo"<td><input id='CP".$contadortd."' class='input' type='text' size='4' value='".$rowDir[3]."'></td>";
		echo"<td><input id='Provincia".$contadortd."' class='input' type='text' size='14' value='".$rowDir[4]."'></td>";
		echo"<td><input id='pais".$contadortd."' class='input' type='text' size='10' value='".$rowDir[5]."'></td>";		
		if ($contadortd==0) {echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='".$rowDir[0]."'>Facturación</td>";} else {echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='".$rowDir[0]."'></td>";}
		echo"</tr>";
		$contadortd++;
	}
		echo"<tr name='DireccionEmpresa' id='0'>";
		echo"<td><input id='Direccion".$contadortd."' class='input' type='text' size='34' value=''></td>";
		echo"<td><input id='Ciudad".$contadortd."' class='input' type='text' size='10' value=''></td>";
		echo"<td><input id='CP".$contadortd."' class='input' type='text' size='4' value=''></td>";
		echo"<td><input id='Provincia".$contadortd."' class='input' type='text' size='14' value=''></td>";
		echo"<td><input id='pais".$contadortd."' class='input' type='text' size='10' value=''></td>";
		echo"<td><input id='id".$contadortd."' class='input' type='hidden' size='34' value='0'></td>";		
		echo"</tr>";
	echo"</table>";			
	//Por ultimo los empleados de la empresa
	if(!$resultEmpleados = mysqli_query($conexion_sp, "select NombreCompleto, FuncionEnLaEmpresa, PalabrasClave, PoderDecision from contactos2 where idOrganizacion = '".$reg['id']."' order by NombreCompleto")) die("Problemas con la consulta contactos2");
	echo"<label><u>Empleados de la Empresa:</u></label>";
	echo"<br />";
	echo"<table>";
	echo"<tr>";
	echo"<th>Nombre</th>";
	echo"<th>Funcion</th>";
	echo"<th>Palabras clave</th>";
	echo"<th>Decide</th>";	
	echo"</tr>";
	while ($rowDir = mysqli_fetch_row($resultEmpleados)){ 
		echo"<tr>";
		echo"<td><input class='input' type='text' size='34' value='".$rowDir[0]."' disabled></td>";
		echo"<td><input class='input' type='text' size='30' value='".$rowDir[1]."' disabled></td>";
		echo"<td><input class='input' type='text' size='30' value='".$rowDir[2]."' disabled></td>";
		if ($rowDir[3]=='1') {echo"<td><input class='input' type='text' size='2' value='Si' disabled></td>";} else {echo"<td><input class='input' type='text' size='2' value='No' disabled></td>";}
		echo"</tr>";
	}
	echo"</table>";	
}
	
function llenar_acciones_empresas($estaSesion){
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
		if ($puedoModificar==0) {echo"<input type='button' id='botonActualizaEmpresa' value='Actualizar datos' disabled>";} else {echo"<input type='button' id='botonActualizaEmpresa' value='Actualizar datos'/>";}
		echo " ";
		if ($puedoModificar==0) {echo"<input type='button' id='botonNuevaEmpresa' value='Nueva empresa' disabled>";} else {echo"<input type='button' id='botonNuevaEmpresa' value='Nueva empresa'/>";}
		echo"</br>";
		echo"</br>";
		echo"<input type='checkbox' id='checkMostrarAFIP' value='MostrarAFIP'/>Mostrar datos en AFIP";
		echo"</p>";
}
	
