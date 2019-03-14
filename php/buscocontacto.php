<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   $textoBusqueda=$_REQUEST['busqueda'];
   if ($textoBusqueda=="")
   {
   	if(!$result = mysqli_query($conexion_sp, "select contactos2.IdContacto, contactos2.NombreCompleto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id ORDER BY ".$_REQUEST['orden']." asc limit 500")) die("Problemas con la consulta");  
   }
   else
   {
	   if (substr_count($textoBusqueda, '*') > 0) $textoBusqueda=str_replace("*", "%", $textoBusqueda);
		   
	   if(!$result = mysqli_query($conexion_sp, "select contactos2.IdContacto, contactos2.NombreCompleto, organizaciones.Organizacion from contactos2 INNER JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id where ((contactos2.NombreCompleto like '%".$textoBusqueda."%') or (organizaciones.Organizacion like '%".$textoBusqueda."%') or (organizaciones.ActividEmpresa like '%".$textoBusqueda."%') or (contactos2.FuncionEnLaEmpresa like '%".$textoBusqueda."%') or (contactos2.PalabrasClave like '%".$textoBusqueda."%') or (organizaciones.CUIT like '%".$textoBusqueda."%')) ORDER BY ".$_REQUEST['orden']." asc limit 500")) die("Problemas con la consulta");     
   }
echo "<table class='display'>";
if (mysqli_num_rows($result) > 499){
	echo "<caption>Listado limitado a los primeros 500 resultados</caption>";
	}
	else {
			echo "<caption>Resultados encontrados: ".mysqli_num_rows($result)."</caption>";
	}
echo "<tr>";  
//echo "<th width='65'>IdContacto</th>";  
echo "<th width='150'>NombreCompleto</th>";  
echo "<th width='170'>Organización</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_row($result)){   
    echo "<tr id=$row[0]>";  
    //echo "<td id=$row[0]>$row[0]</td>";   
    echo "<td id=$row[0]>$row[1]</td>";   
    echo "<td id=$row[0]>$row[2]</td>";   
    echo "</tr>";  
};
echo "</table>";
