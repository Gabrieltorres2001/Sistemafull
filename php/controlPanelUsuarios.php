<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

   //Creamos la conexión
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");
	
//generamos la consulta
//Primero busco mi nivel de usuario para determinar hasta que usuarios puedo mostrar
   if(!$resultYo = mysqli_query($conexion_db, "select nivelUsuario from members where id='".$_REQUEST['numeroSesion']."' limit 1")) die("Problemas con la consulta members1");
	$regYo = mysqli_fetch_array($resultYo);
//Luego busco a todos los miembros que puedo ver con mi usuario.
   if(!$resultMembers = mysqli_query($conexion_db, "select id, username, email, Nombre, Apellido, PuedeCotizar, PuedeModificarArticulos, PuedeModificarContactos, PuedeComprar, PuedeHacerLegajos, nivelUsuario, usuarioTrabajando from members where nivelUsuario > '".$regYo['nivelUsuario']."'")) die("Problemas con la consulta members2");

echo"<ul class='nav navbar-nav'>";
echo"</ul>";
echo "<table class='display' id='tablaDetalleMiembros'>";  
echo "<tr>";  
echo "<th width='1' style='text-align:center'>Id</th>";  
//echo "<th width='9' style='text-align:center'>username</th>"; 
//echo "<th width='5' style='text-align:center'>email</th>";  
echo "<th width='18' style='text-align:center'>Nombre y Apellido</th>"; 
echo "<th width='1' style='text-align:center'>Puede Cotizar</th>"; 
echo "<th width='1' style='text-align:center'>Puede Modificar Articulos</th>"; 
echo "<th width='1' style='text-align:center'>Puede Modificar Contactos</th>";
echo "<th width='1' style='text-align:center'>Puede Comprar</th>";
echo "<th width='1' style='text-align:center'>Puede Hacer Legajos</th>";
echo "<th width='1' style='text-align:center'>usuario Trabajando</th>";
echo "<th width='2' style='text-align:center' title='Tip: 1 admin, 2 dueño, 3 gerente, 4 jefe, 5 supervisor, 6 encargado, 7 confianza, 8 auxiliar, 9 nada'>nivel Usuario [".$regYo['nivelUsuario']."-9]*</th>"; 
echo "</tr>"; 
  
while ($regMembers = mysqli_fetch_array($resultMembers)){  
    echo "<tr id='".$regMembers['id']."'>";  
	//Tengo que dejar el formato: $row[0]&$row[2]&ordenitem&E para que luego funcione el doble click en toda la fila, sino anda en
	//algunos campos y no anda en otros, ya que el split lo tengo armado asi.
	echo "<td name='xxxxMemb' id='".$regMembers['id']."&idMiembro'  align='center'>".$regMembers['id']."</td>"; 
//	echo "<td name='xxxxMemb' id='".$regMembers['id']."&usernameMiembro'>".$regMembers['username']."</td>"; 
//	echo "<td name='xxxxMemb' id='".$regMembers['id']."&emailMiembro'>".$regMembers['email']."</td>";
	echo "<td name='xxxxMemb' id='".$regMembers['id']."&nombreApellidoMiembro'>".$regMembers['Nombre']." ".$regMembers['Apellido']."</td>";	
	//Los checks. PuedeCotizar
	if ($regMembers['PuedeCotizar']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&puedeCotizarMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeCotizar' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&puedeCotizarMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeCotizar' type='checkbox' checked></input></td>";
		}	 
	//Los checks. PuedeModificarArticulos
	if ($regMembers['PuedeModificarArticulos']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&PuedeModificarArticulosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeModificarArticulos' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&PuedeModificarArticulosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeModificarArticulos' type='checkbox' checked></input></td>";
		}	
	//Los checks. PuedeModificarContactos
	if ($regMembers['PuedeModificarContactos']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&PuedeModificarContactosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeModificarContactos' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&PuedeModificarContactosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeModificarContactos' type='checkbox' checked></input></td>";
		}	
	//Los checks. PuedeComprar
	if ($regMembers['PuedeComprar']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&PuedeComprarMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeComprar' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&PuedeComprarMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeComprar' type='checkbox' checked></input></td>";
		}	
	//Los checks. PuedeHacerLegajos
	if ($regMembers['PuedeHacerLegajos']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&PuedeHacerLegajosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeHacerLegajos' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&PuedeHacerLegajosMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&PuedeHacerLegajos' type='checkbox' checked></input></td>";
		}	
	//Los checks. usuarioTrabajando
	if ($regMembers['usuarioTrabajando']==0){
		//Sin checkear
		echo "<td id='".$regMembers['id']."&usuarioTrabajandoMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&usuarioTrabajando' type='checkbox' ></input></td>";
		} else {
		//Checkeado
		echo "<td id='".$regMembers['id']."&usuarioTrabajandoMiembro' align='center'><input name='xxxxMembCheck' id='".$regMembers['id']."&chk&usuarioTrabajando' type='checkbox' checked></input></td>";
		}	
	//El nivel de usuario
		echo "<td name='xxxxMemb' id='".$regMembers['id']."&nivelUsuarioMiembro' align='center'><input name='xxxxMembNivel' id='".$regMembers['id']."&valor&nivelUsuario' class='input' pattern='[".$regYo['nivelUsuario']."-9]' name='xxxxMembnivelUsuario' type='text' size='2' style='text-align:center' value=".$regMembers['nivelUsuario']."></td>";

echo "</tr>";	
}  	
echo "</table>";

//ahora la ultima fila en blanco para refrescar por las dudas.
	//echo "<img name='xxxxy' id='$row[0]&$row[2]&imagenOk' src='./images/recarga.jpg' width='35' height='35'>";
	//poner un boton para volver.


