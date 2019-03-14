<?php
include_once '../includes/functions.php';

   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
echo "Contactos FUERA de esta Lista:";	
   if(!$result = mysqli_query($conexion_sp, "select contactos2.IdContacto, contactos2.NombreCompleto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id ORDER BY contactos2.IdContacto asc limit 100")) die("Problemas con la consulta contactos2");
echo "<table class='display' id='tablaDetalleFueraLista'>";  
echo "<tr>";   
echo "<th width='7'>Nombre</th>"; 
echo "<th width='8'>Empresa</th>";    
echo "</tr>";  
while ($row = mysqli_fetch_array($result)){   
	if(!$resultlista = mysqli_query($conexion_sp, "select contacto from listasYcontactos where lista='".$_REQUEST['lista']."' and contacto='".$row['IdContacto']."' limit 1")) die("Problemas con la consulta listasYcontactos");
	$regContacto = mysqli_fetch_array($resultlista);
	if (!($regContacto['contacto']==$row['IdContacto'])){
    echo "<tr id=".$row['IdContacto'].">";    
    echo "<td id=".$row['IdContacto'].">".$row['NombreCompleto']."</td>";
    echo "<td id=".$row['IdContacto'].">".$row['Organizacion']."</td>";   
    echo "</tr>";  }
};  
echo "</table>";
	
