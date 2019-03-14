<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';

$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta
if(!$resultMesFacturado = mysqli_query($conexion_sp, "SELECT caeafip.FechaFactura, caeafip.NumeroFactura, caeafip.TipoFactura, caeafip.CAE, caeafip.CUITCliente, caeafip.VtoCAE, organizaciones.Organizacion, caeafip.Provincia, caeafip.ImporteTotal, caeafip.ImporteNeto, caeafip.IVA21, caeafip.IVA10, datosauxfacturasemitidas.tipoCambio, caeafip.IdEnviado 
FROM ((caeafip LEFT JOIN datosauxfacturasemitidas ON caeafip.CAE = datosauxfacturasemitidas.CAE) LEFT JOIN contactos2 ON caeafip.NonmbreEmpresa = contactos2.IdContacto) LEFT JOIN organizaciones ON contactos2.idOrganizacion = organizaciones.id
WHERE year(caeafip.FechaFactura)='".$_REQUEST['aanno']."' and month(caeafip.FechaFactura)='".$_REQUEST['mmes']."'
ORDER BY caeafip.Id, caeafip.FechaFactura, caeafip.NumeroFactura;")) die("Problemas con la consulta Año");
echo "<table class='display' id='tablaComprobantes'>";  
echo "<tr>"; 
echo "<th style='text-align:center'>FechaFactura</th>";  
echo "<th style='text-align:center'>NumeroFactura</th>";  
echo "<th style='text-align:center'>TipoFactura</th>";  
echo "<th style='text-align:center'>CAE</th>";  
echo "<th style='text-align:center'>CUITCliente</th>";  
echo "<th style='text-align:center'>VtoCAE</th>";  
echo "<th style='text-align:center'>Organizacion</th>";  
echo "<th style='text-align:center'>Provincia</th>";  
echo "<th style='text-align:center'>ImporteTotal</th>";  
echo "<th style='text-align:center'>ImporteNeto</th>";  
echo "<th style='text-align:center'>IVA21</th>";  
echo "<th style='text-align:center'>IVA10</th>";  
echo "<th style='text-align:center'>tipoCambio</th>";  
echo "<th style='text-align:center'>MonedaFactura</th>";  
echo "</tr>";
while ($rowresultMesFacturado = mysqli_fetch_array($resultMesFacturado)){ 
    echo "<tr>";
    echo "<td style='text-align:center'>".$rowresultMesFacturado['FechaFactura']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['NumeroFactura']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['TipoFactura']."</td>"; 
    echo "<td style='text-align:center'>'".$rowresultMesFacturado['CAE']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['CUITCliente']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['VtoCAE']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['Organizacion']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['Provincia']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['ImporteTotal']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['ImporteNeto']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['IVA21']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['IVA10']."</td>"; 
    echo "<td style='text-align:center'>".$rowresultMesFacturado['tipoCambio']."</td>"; 
    if ($rowresultMesFacturado['IdEnviado']==60) 
        {echo "<td>Euros</td>"; }
        else {if ($rowresultMesFacturado['IdEnviado']==1) 
            {echo "<td>Dolares</td>"; }
                else {echo "<td>Pesos</td>"; }
        }
    
    echo "</tr>";
};
echo "</table>";



