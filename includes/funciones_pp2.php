<?php

function Llenar_articulos_pp2() {
   //Creamos la conexión
include_once '/includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select IdProducto,descricpcion,IdProveedor from productos ORDER BY IdProducto desc limit 3")) die("Problemas con la consulta");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Cod.</th>";  
echo "<th>Descripcion</th>";  
echo "<th>Proveedor</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td class='message'>$row[0]</td>";   
    echo "<td>$row[1]</td>";   
    echo "<td>$row[2]</td>";   
    echo "</tr>";  
}  
echo "</table>";
}


function Llenar_contactos_pp2() {
	//NO LO USO MAS
   //Creamos la conexión
include_once '/includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select IdContacto,NombreCompleto,Organizacion from contactos ORDER BY IdContacto desc limit 5")) die("Problemas con la consulta");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Id</th>";  
echo "<th>Nombre</th>";  
echo "<th>Organizacion</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td class='message'>$row[0]</td>";   
    echo "<td>$row[1]</td>";   
    echo "<td>$row[2]</td>";   
    echo "</tr>";  
}  
echo "</table>";
}

function Llenar_presupuestos_pp2() {
   //Creamos la conexión
include_once '/includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa from comprobantes where TipoComprobante=5 ORDER BY IdComprobante desc limit 5")) die("Problemas con la consulta1");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Nro.</th>";  
echo "<th>Fecha</th>";  
echo "<th>Empresa</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td class='message'>$row[0]</td>";   
    echo "<td>$row[1]</td>";   
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from contactos where IdContacto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
		while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td id=$row[0]>$rowEmp[0]</td>";  
		}
    echo "</tr>";  
}  
echo "</table>";
}

function Llenar_remitos_pp2() {
   //Creamos la conexión
include_once '/includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa from comprobantes where TipoComprobante=3 ORDER BY IdComprobante desc limit 5")) die("Problemas con la consulta1");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Nro.</th>";  
echo "<th>Fecha</th>";  
echo "<th>Empresa</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td class='message'>$row[0]</td>";   
    echo "<td>$row[1]</td>";   
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from contactos where IdContacto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
		while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td id=$row[0]>$rowEmp[0]</td>";  
		}
    echo "</tr>";  
}  
echo "</table>";
}

function Llenar_OC_pp2() {
   //Creamos la conexión
include_once '/includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select NumeroComprobante,FechaComprobante,NonmbreEmpresa from comprobantes where TipoComprobante=9 ORDER BY IdComprobante desc limit 5")) die("Problemas con la consulta1");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Nro.</th>";  
echo "<th>Fecha</th>";  
echo "<th>Empresa</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td class='message'>$row[0]</td>";   
    echo "<td>$row[1]</td>";   
	if(!$resultEmp = mysqli_query($conexion_sp, "select Organizacion from contactos where IdContacto='".$row[2]."' limit 1")) die("Problemas con la consulta2");
		while ($rowEmp = mysqli_fetch_row($resultEmp)){   
    	echo "<td id=$row[0]>$rowEmp[0]</td>";  
		}
    echo "</tr>";  
}  
echo "</table>";
}

function Llenar_novedades_pp2() {
//Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
   if(!$result = mysqli_query($conexion_sp, "select Fecha,Novedad from novedades ORDER BY IdNovedad desc limit 3")) die("Problemas con la consulta");
echo "<table border='1'>"; 
echo "<tr>";  
echo "<th>Fecha</th>";    
echo "<th>Novedad</th>";  
echo "</tr>";   
while ($row = mysqli_fetch_row($result)){   
    echo "<tr>";  
    echo "<td>".$row[0]."</td>"; 
    echo "<td>$row[1]</td>";     
    echo "</tr>";  
}  
echo "</table>";
}

function Llenar_novedades2_pp2() {
//Creamos la conexión
include_once 'includes/sp_connect.php';
include_once 'includes/db_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion_db,"set names 'utf8'");	

//generamos la consulta
echo "<div id='rotar' class='cycle-content' style='height:25px; width:98%; text-align:center;'> ";
if(!$result = mysqli_query($conexion_sp, "select Fecha,Novedad,responsable from novedades ORDER BY IdNovedad desc")) die("Problemas con la consulta");
while ($row = mysqli_fetch_row($result)){ 
	if(!$sesionSistPlus = mysqli_query($conexion_db, "select username from members where id='".$row[2]."' limit 1")) die("Problemas con la consulta3");
	$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
	echo "<div  style='height:25px; width:98%; text-align:center; display:none;'>".$row[0]." - $row[1] - ".$rowSesionSistPlus['username']."</div>";
} 
echo "</div>";
}