


  var tags_input = new Array();
  var tags_input=document.getElementsByClassName("input");
  for (i=0; i<tags_input.length; i++) {
            tags_input[i].addEventListener('change',algoCambio,false);
  }   
  //document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false);

  //document.getElementById('botonCopiaContacto').addEventListener('click',copioContacto,false);
  //document.getElementById('botonNuevoContacto')addEventListener('click',nuevoContacto,false);


function procesarEventos()
{
    if(conexion1.readyState == 4)
  {
	  if(conexion1.status == 200)
	  {
		  //var detalles = document.getElementById("comoEstoy");
		  //detalles.innerHTML=conexion1.responseText;
		  document.getElementById('empresas').innerHTML=conexion1.responseText;
  		  var tags_td = new Array();
  		  var tags_td=document.getElementsByTagName('td');
		  //for (i=0; i<tags_td.length; i++) {
			//		tags_td[i].addEventListener('click',valor_celda,false);
		  // } 
		  document.getElementById('detallesdeempresas').innerHTML="";
		  //document.getElementById('movimientosdecontacto').innerHTML="";
		  tags_cambios = []; 
		  id_actual="";
		  //document.getElementById('botonMail').addEventListener('click',enviarMail,false);
		  var tags_input = new Array();
		  var tags_input=document.getElementsByClassName("input");
		  for (i=0; i<tags_input.length; i++) {
					tags_input[i].addEventListener('change',algoCambio,false);
		  } 
		  tags_cambios = []; 
		  //document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);
		  inicializarEventos();
	  }
  } 

}

function algoCambio(e)
{
	tags_cambios.push(e.target.id);
	  //for (i=0; i<tags_cambios.length; i++) {
      //      alert(tags_cambios[i]);
  //} 
}

var conexion4;
function copioContacto(){
  //alert(celda.target.id);
  //var numerocto=id_actual;
  var numerocto=document.getElementById('IdContacto').value;
  //alert (numerocto);
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var cadena="idcto="+numerocto;
  cadena='./php/copio_detallescontacto.php?'+cadena+"&rnadom="+aleatorio
  //alert(cadena);
  conexion4.open('GET',cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion4.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
}

function procesarEventos4()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion4.readyState == 4)
  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	  if(conexion4.status == 200)
	  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
		  //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
		  //busco();
		  document.getElementById('detallesdecontacto').innerHTML=conexion4.responseText;
		  tags_cambios = [];
	  }
  } 

}




function procesarEventos5()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion5.readyState == 4)
  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	  if(conexion5.status == 200)
	  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
		  //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
		  //busco();
		  document.getElementById('detallesdecontacto').innerHTML=conexion5.responseText;
		  document.getElementById('botonActualizaContactoNuevo').addEventListener('click',actualizoContacto,false);
		  tags_cambios = [];
	  }
  } 

}


function enviarMail(botonmail)
{
	//alert(botonmail.target.id);
	window.location.href='mailto:'+document.getElementById('Direcciondecorreoelectronico'+botonmail.target.id).value;
	//document.write('<a href="mailto:juan@hotmail.com"></a>');

}

var conexion7;
var conexion8;
function mostrarDetallesMovimientos(celda)
{
	//alert(celda.target.id);
	document.getElementById('detallesdemovimientos').style.visibility='visible';
	var numeroComprobante=celda.target.id;
  //el encabezado del presupuesto
  conexion7=new XMLHttpRequest(); 
  conexion7.onreadystatechange = procesarEventos7;
  var aleatorio=Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con4"+conexion4.status);
  conexion7.open('GET','./php/llenar_encabezado_un_presupuesto.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  conexion7.send();
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  // el detalle del presupuesto
  conexion8=new XMLHttpRequest(); 
  conexion8.onreadystatechange = procesarEventos8;
  aleatorio=Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con5"+conexion5.status);
  conexion8.open('GET','./php/llenar_detalle_presupuesto.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
  conexion8.send();
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
}

function procesarEventos7()
{
    if(conexion7.readyState == 4)
  { 
	  if(conexion7.status == 200)
	  { 
		  document.getElementById('detallesdemovimientosFRMSup').innerHTML=conexion7.responseText;
	  }
  } 

}

function procesarEventos8()
{
    if(conexion8.readyState == 4)
  { 
	  if(conexion8.status == 200)
	  { 
		  document.getElementById('detallesdemovimientosFRMInf').innerHTML=conexion8.responseText;
	  }
  } 

}


function cerrarVentanaMovs()
{
	document.getElementById('detallesdemovimientos').style.visibility='hidden';
}

var conexion9;
function llenarAccionesContactosJS(){
  conexion9=new XMLHttpRequest(); 
  conexion9.onreadystatechange = procesarEventos9;
  var obnn=document.getElementById('numberses').value;
  //alert(obnn);
  var aleatorio=Math.random();
  conexion9.open('GET','./php/llenar_acciones_contactos.php?&sesses='+obnn+"&rnadom="+aleatorio, true);
  conexion9.send();
}

function procesarEventos9()
{
    if(conexion9.readyState == 4)
  { 
	  if(conexion9.status == 200)
	  { 
		  document.getElementById('accionesDetalle').innerHTML=conexion9.responseText;
		  alert("ee");

	  }
  } 

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