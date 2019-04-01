addEventListener('load',inicializarEventos,false);

var tags_cambios = new Array();
var id_actual="";
var nCom;
function inicializarEventos()
{
  document.getElementById('ordenPor').addEventListener('change',busco,false);
  document.getElementById('botonBuscadorArticulo').addEventListener('click',busco,false);
  var tags_td = new Array();
  var tags_td=document.getElementsByTagName('td');
  for (i=0; i<tags_td.length; i++) {
            tags_td[i].addEventListener('click',mostrarDetalles,false);
  } 
  document.getElementById('buscadorArticulo').addEventListener('keypress',teclaEnter,false);
  var tags_input = new Array();
  var tags_input=document.getElementsByClassName("input");
  for (i=0; i<tags_input.length; i++) {
            tags_input[i].addEventListener('change',algoCambio,false);
  } 
  document.getElementById('botonBuscarPor').addEventListener('click',parametrosDeBusqueda,false);
  document.getElementById('botonAceptarBuscarPor').addEventListener('click',aceptarParametrosDeBusqueda,false);  
  document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false); 
  
}

function mostrarMovimientos()
{
	if(document.getElementById('checkMostrarMovimientos').checked)
	{
		document.getElementById('detallesdearticulo').style.height='30vh';
		document.getElementById('movimientosdearticulo').style.height='47vh';
	}
	else
	{
		document.getElementById('detallesdearticulo').style.height='77vh';	
		document.getElementById('movimientosdearticulo').style.height='0vh';	
	}
}


function parametrosDeBusqueda()
{
	document.getElementById('caja2').style.visibility='visible';
}

function aceptarParametrosDeBusqueda()
{
	document.getElementById('caja2').style.visibility='hidden';
}

function algoCambio(e)
{
	tags_cambios.push(e.target.id);
	  //for (i=0; i<tags_cambios.length; i++) {
      //      alert(tags_cambios[i]);
  //} 
}

function teclaEnter(e)
{
  var tecla=e.which;
  if(tecla==13)
  {
    e.preventDefault();
    busco();
  }  
}

var conexion2;
var conexion6;
var conexion9;
function mostrarDetalles(celda){
  //alert(celda.target.id);
  document.getElementById('detallesdearticulo').innerHTML="";
  if (isNaN(celda)){var numeroartic=celda.target.id;} else {var numeroartic=celda;}
  id_actual=numeroartic;
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  conexion2.open('GET','./php/detallesarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
  conexion2.send();
  //AHORA LOS MOVIMIENTOS DEL ARTICULO
  document.getElementById('movimientosdearticulo').innerHTML="";
  conexion6=new XMLHttpRequest(); 
  conexion6.onreadystatechange = procesarEventos6;
  aleatorio=Math.random();
  conexion6.open('GET','./php/movimientosarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
  conexion6.send();
  if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
  if (isNaN(celda)){document.getElementById(celda.target.id).style.backgroundColor="#809fff";} else {document.getElementById(celda).style.backgroundColor="#809fff";}
  //document.getElementById(celda.target.id).style.backgroundColor="#809fff";
  if (isNaN(celda)){nCom=celda.target.id;} else {nCom=celda;}
  //nCom=celda.target.id;
  //Solo para articulos publicos, acciones se borra y se recarga en cada atriculo
  document.getElementById('accionesDetalle').innerHTML="";
  conexion9=new XMLHttpRequest(); 
  conexion9.onreadystatechange = procesarEventos9;
  aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion9.open('GET','./php/accionesarticulopublico.php?idart='+numeroartic+"&rnadom="+aleatorio+"&estaSesion="+obnn, true);
  conexion9.send();
}

function procesarEventos9()
{
    if(conexion9.readyState == 4)
  { 
	  if(conexion9.status == 200)
	  { 
      document.getElementById('accionesDetalle').innerHTML=conexion9.responseText;
      document.getElementById('checkMostrarMovimientos').addEventListener('change',mostrarMovimientos,false); 
      document.getElementById('botonActualizaArticulo').addEventListener('click',actualizoArticulo,false);
      //acciones para botones de hacer publico o privado
      document.getElementById('botonHacerPublico').addEventListener('click',hacerPublicoArticulo,false);
      document.getElementById('botonHacerPrivado').addEventListener('click',hacerPrivadoArticulo,false);

    }
  }
}

var conexion10;
function hacerPublicoArticulo()
{
  conexion10=new XMLHttpRequest(); 
  conexion10.onreadystatechange = procesarEventos10;
  var aleatorio=Math.random();
  conexion10.open('GET','./php/hacerPublicoArticulo.php?idart='+nCom+"&rnadom="+aleatorio, true);
  conexion10.send();
}

function procesarEventos10()
{
    if(conexion10.readyState == 4)
  { 
	  if(conexion10.status == 200)
	  { 
      if(conexion10.responseText==1) {
        mostrarDetalles(nCom);
      }
    }
  }
}

var conexion11;
function hacerPrivadoArticulo()
{
  conexion11=new XMLHttpRequest(); 
  conexion11.onreadystatechange = procesarEventos11;
  var aleatorio=Math.random();
  conexion11.open('GET','./php/hacerPrivadoArticulo.php?idart='+nCom+"&rnadom="+aleatorio, true);
  conexion11.send();
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 
      if(conexion11.responseText==0) {
        mostrarDetalles(nCom);
      }
    }
  }
}

function procesarEventos2()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion2.readyState == 4)
  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	  if(conexion2.status == 200)
	  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
		  document.getElementById('detallesdearticulo').innerHTML=conexion2.responseText;
		  var tags_input = new Array();
		  var tags_input=document.getElementsByClassName("input");
		  for (i=0; i<tags_input.length; i++) {
					tags_input[i].addEventListener('change',algoCambio,false);
		  } 
		  tags_cambios = []; 
		  $(document).ready(function() {$("#IdProveedor").select2();});	
		  $(document).ready(function() {$("#IdRubro").select2();});
		  $(document).ready(function() {$("#IdSubRubro").select2();});
	  }
  } 
}

function procesarEventos6()
{
    if(conexion6.readyState == 4)
  { 
	  if(conexion6.status == 200)
	  { 
		  document.getElementById('movimientosdearticulo').innerHTML=conexion6.responseText;
		  tags_cambios = []; 
		  id_actual="";
		  //AL HACER CLICK
		  //TE LLEVA AL FORMULARIO DEL MOVIMIENTO
		  	var tags_td_mov = new Array();
  			var tags_td_mov = document.getElementsByName('xxxx');
			  for (i=0; i<tags_td_mov.length; i++) {
						tags_td_mov[i].addEventListener('click',mostrarDetallesMovimientos,false);
			  } 
	  }
  } 
}


function busco()
{ 
  document.getElementById('detallesdearticulo').innerHTML="";
  document.getElementById('movimientosdearticulo').innerHTML="";
  document.getElementById('accionesDetalle').innerHTML="";
  var seleccion=document.getElementById('ordenPor');
  var criterio=document.getElementById('buscadorArticulo');
  //alert (criterio.value);
  //alert (seleccion.value);
  var tabla = document.getElementById('tablaArticulos');
  var rowCount = tabla.rows.length; 
  while(--rowCount) tabla.deleteRow(rowCount);
  cambiarDatos(seleccion.value, criterio.value);
}

var conexion1;
function cambiarDatos(orden, datoABuscar) 
{
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos;
  var aleatorio=Math.random();
  conexion1.open('GET','./php/buscoarticulo.php?orden='+orden+"&busqueda="+datoABuscar+"&rnadom="+aleatorio, true);
  conexion1.send();
}

function procesarEventos()
{
    if(conexion1.readyState == 4)
  {
	  if(conexion1.status == 200)
	  {
		  //var detalles = document.getElementById("comoEstoy");
		  //detalles.innerHTML=conexion1.responseText;
		  document.getElementById('tablaArticulos').innerHTML=conexion1.responseText;
		  inicializarEventos();
  		  //var tags_td = new Array();
  		  //var tags_td=document.getElementsByTagName('td');
		  //for (i=0; i<tags_td.length; i++) {
			//		tags_td[i].addEventListener('click',valor_celda,false);
		 // } 
		  tags_cambios = []; 
		  id_actual="";
	  }
  } 

}


var conexion3;
function actualizoArticulo(){
  //alert(celda.target.id);
  //var numerocto=id_actual;
  var numeroart=document.getElementById('IdProducto').value;
  //alert (numerocto);
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  var cadena="idart="+numeroart;
  //alert(cadena);
  cadena=cadena+"&TipoProducto="+document.getElementById('TipoProducto').value;
  cadena=cadena+"&MonedaOrigen="+document.getElementById('MonedaOrigen').value;
  cadena=cadena+"&ValorVenta="+document.getElementById('ValorVenta').value;
  cadena=cadena+"&IVA="+document.getElementById('IVA').value;
  cadena=cadena+"&descricpcion="+encodeURIComponent(document.getElementById('descricpcion').value);  
  cadena=cadena+"&OfrecerAdemas="+encodeURIComponent(document.getElementById('OfrecerAdemas').value);
  cadena=cadena+"&Notas="+encodeURIComponent(document.getElementById('NotasArt').value);
  cadena=cadena+"&ComposicionyDescirpcion="+encodeURIComponent(document.getElementById('ComposicionyDescirpcion').value); 
  //alert (document.getElementById('IdProveedor').value);   
  cadena=cadena+"&IdProveedor="+document.getElementById('IdProveedor').value;
  cadena=cadena+"&CodigoProveedor="+encodeURIComponent(document.getElementById('CodigoProveedor').value);
  cadena=cadena+"&IdRubro="+document.getElementById('IdRubro').value;
  cadena=cadena+"&IdSubRubro="+document.getElementById('IdSubRubro').value;
  cadena=cadena+"&StockMinimo="+document.getElementById('StockMinimo').value;
  cadena=cadena+"&UnidadMedida="+document.getElementById('UnidadMedida').value;
  cadena=cadena+"&CodigoInterno="+document.getElementById('CodigoInterno').value;
  cadena=cadena+"&Numerodeserie="+document.getElementById('Numerodeserie').value;
  cadena=cadena+"&IdCostoProveedor="+document.getElementById('IdCostoProveedor').value;
  cadena=cadena+"&IdImagen="+document.getElementById('IdImagen').value;  
  if (document.getElementById('tangible').checked) {cadena=cadena+"&tangible=1";} else {cadena=cadena+"&tangible=0";}
  cadena=cadena+"&HojaFabricante="+document.getElementById('HojaFabricante').value;
  cadena=cadena+"&HojaOtra="+document.getElementById('HojaOtra').value;
  cadena=cadena+"&UsuarioCreacion="+document.getElementById('UsuarioCreacion').value;
  cadena=cadena+"&UsuarioModificacion="+document.getElementById('UsuarioModificacion').value;
  cadena=cadena+"&UsuarioFC="+document.getElementById('UsuarioFC').value;
  cadena=cadena+"&UsuarioFM="+document.getElementById('UsuarioFM').value;
  cadena=cadena+"&Imagen="+document.getElementById('Imagen').value;
  cadena=cadena+"&FechaActualizacion="+document.getElementById('FechaActualizacion').value; 
//Agrego ubicacion de Deposito
  cadena=cadena+"&Deposito="+encodeURIComponent(document.getElementById('numDeposito').value);
  cadena=cadena+"&Estanteria="+encodeURIComponent(document.getElementById('Estanteria').value);
  cadena=cadena+"&Estante="+encodeURIComponent(document.getElementById('Estante').value);
  cadena=cadena.replace("'","`");  
  //ACAAAAA---- SACAR EL COMETARIO A LA LINEA QUE SIGUE Y LLAMAR AL PHP CON LOS CAMPOS QUE HAYAN CAMBIADO
  //(PARA NO LLAMARLOS A TODOS). POR ESO USO EL ARRAY tags_cambios
  //for (i=0; i<tags_cambios.length; i++) {
	     //      tags_cambios[i]; VOY A TENER QUE ARMAR UN STRING EN FORMATO PARA ENVIAR LUEGO DEL ? DEL PHP
		 
  //}   
  //alert("voy a llamar al php. hasta aca todo bien"+conexion2.status);  
  cadena='./php/actualizo_detallesarticulo.php?'+cadena+"&rnadom="+aleatorio
  //alert(cadena);
  conexion3.open('GET',cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion3.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
}

function procesarEventos3()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion3.readyState == 4)
  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	  if(conexion3.status == 200)
	  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
		  //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
		  //busco();
		  var datosc=document.getElementById('detallesdearticulo');
		  datosc.innerHTML=conexion3.responseText;
		  tags_cambios = [];
		  $(document).ready(function() {$("#IdProveedor").select2();});	
		  $(document).ready(function() {$("#IdRubro").select2();});
		  $(document).ready(function() {$("#IdSubRubro").select2();});
	  }
  } 

}


var conexion4;
function copioArticulo(){
  //alert(celda.target.id);
  //var numerocto=id_actual;
  var numeroart=document.getElementById('IdProducto').value;
  //alert (numerocto);
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var cadena="idart="+numeroart;
  cadena='./php/copio_detallesarticulo.php?'+cadena+"&rnadom="+aleatorio
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
		  var datosc=document.getElementById('detallesdearticulo');
		  datosc.innerHTML=conexion4.responseText;
		  tags_cambios = [];
		  $(document).ready(function() {$("#IdProveedor").select2();});	
		  $(document).ready(function() {$("#IdRubro").select2();});
		  $(document).ready(function() {$("#IdSubRubro").select2();});
	  }
  } 

}


var conexion5;
function nuevoArticulo(){
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio=Math.random();
  cadena='./php/nuevo_detallesarticulo.php?rnadom='+aleatorio
  //alert(cadena);
  conexion5.open('GET',cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion5.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
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
		  document.getElementById('detallesdearticulo').innerHTML=conexion5.responseText;
		  document.getElementById('botonActualizaArticuloNuevo').addEventListener('click',actualizoArticulo,false);
		  tags_cambios = [];
		  $(document).ready(function() {$("#IdProveedor").select2();});	
		  $(document).ready(function() {$("#IdRubro").select2();});
		  $(document).ready(function() {$("#IdSubRubro").select2();});
	  }
  } 

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
  conexion7.open('GET','./php/llenar_encabezado_un_comprobante_enArticulo_contacto.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
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

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}