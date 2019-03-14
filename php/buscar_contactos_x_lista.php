<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//Primero busco todas las facturas registradas para el CUIT en la tabla FondosyFacturas
	if(!$resultlista = mysqli_query($conexion_sp, "select * from listasYcontactos where lista='".$_REQUEST['lista']."'")) die("Problemas con la consulta FondosyFacturas");
	//$regFondosyFacturas = mysqli_fetch_array($resultlista);

echo "Contactos de esta Lista:";
echo "<table class='display' id='tablaDetalleLista'>";  
echo "<tr>";   
echo "<th width='7'>Nombre</th>"; 
echo "<th width='8'>Empresa</th>";    
echo "</tr>";   
while ($rowLista = mysqli_fetch_array($resultlista)){  
	//generamos la consulta DE BUSCAR LAS FACTURAS EMITIDAS
	if(!$resultContacto = mysqli_query($conexion_sp, "select NombreCompleto, idOrganizacion from contactos2 where IdContacto='".$rowLista['contacto']."' limit 1")) die("Problemas con la consulta contactos2");
	$regContacto = mysqli_fetch_array($resultContacto);
	if(!$resultEmpresa = mysqli_query($conexion_sp, "select Organizacion from organizaciones where id='".$regContacto['idOrganizacion']."' limit 1")) die("Problemas con la consulta organizaciones");
	$regEmpresa = mysqli_fetch_array($resultEmpresa);
	echo "<tr id='".$rowLista['id']."'>";   
	echo "<td name='FilaContacto' id='".$rowLista['id']."'>".$regContacto['NombreCompleto']."</td>";
	echo "<td name='FilaContacto' id='".$rowLista['id']."'>".$regEmpresa['Organizacion']."</td>";	
	echo "</tr>";	
	} 
echo "</table>";
