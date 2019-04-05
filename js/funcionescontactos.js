addEventListener('load',inicializarEventos,false);

var tags_cambios = new Array();
var id_actual="";
var nCom;
function inicializarEventos()
{
  document.getElementById('ordenPor').addEventListener('change',busco,false);
  document.getElementById('botonBuscadorContacto').addEventListener('click',busco,false);
  var tags_td = new Array();
  var tags_td=document.getElementsByTagName('td');
  for (i=0; i<tags_td.length; i++) {
            tags_td[i].addEventListener('click',mostrarDetalles,false);
  } 
  document.getElementById('buscadorContacto').addEventListener('keypress',teclaEnter,false);
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
		document.getElementById('detallesdecontacto').style.height='30vh';
		document.getElementById('movimientosdecontacto').style.height='47vh';
	}
	else
	{
		document.getElementById('detallesdecontacto').style.height='77vh';	
		document.getElementById('movimientosdecontacto').style.height='0vh';	
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
var numerocto;
function mostrarDetalles(celda){
	document.getElementById('detallesdecontacto').innerHTML="";
	document.getElementById('accionesDetalle').innerHTML="";
  numerocto=celda.target.id;
  id_actual=numerocto;
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  conexion2.open('GET','./php/detallescontacto.php?idcto='+numerocto+"&rnadom="+aleatorio, true);
  conexion2.send();
  //AHORA LOS MOVIMIENTOS DEL CONTACTO
  document.getElementById('movimientosdecontacto').innerHTML="";
  conexion6=new XMLHttpRequest(); 
  conexion6.onreadystatechange = procesarEventos6;
  var aleatorio=Math.random();
  //alert("voy a llamar al php. hasta aca todo bien"+conexion2.status);
  conexion6.open('GET','./php/movimientoscontacto.php?idcto='+numerocto+"&rnadom="+aleatorio, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion6.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
	nCom=celda.target.id;
	llenarAccionesContactosJS();
}

function procesarEventos2()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion2.readyState == 4)
	{ //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	if(conexion2.status == 200)
		{ //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
			document.getElementById('detallesdecontacto').innerHTML=conexion2.responseText;
			//No lo habilito porque despues no me anda el evento 'change'. 2018 ahora si (es con .on('change',))
			$(document).ready(function() {$("#Organizacion").select2();});	
			//on change para select2
			$('#Organizacion').on('change', cambiarEmpresa);
			//on change para select comun
			//document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);				
			var tags_inputm = new Array();
			var tags_inputm=document.getElementsByName("botonMail");
			for (i=0; i<tags_inputm.length; i++) {
				tags_inputm[i].addEventListener('click',enviarMail,false);
			} 
			//document.getElementById('botonMail').addEventListener('click',enviarMail,false);
			var tags_input = new Array();
			var tags_input=document.getElementsByClassName("input");
			for (i=0; i<tags_input.length; i++) {
				tags_input[i].addEventListener('change',algoCambio,false);
			} 
			tags_cambios = [];   	  
		}
  } 
}

function cambiarEmpresa()
{
  //alert(document.getElementById('Organizacion').value);
  //console.log(document.getElementById('Organizacion').value);
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  conexion2.open('GET','./php/detallescontactoprobarcambioempresa.php?idcto='+numerocto+"&rnadom="+aleatorio+"&empresatemp="+document.getElementById('Organizacion').value, true);
  conexion2.send();
}


function procesarEventos6()
{
	//alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if(conexion6.readyState == 4)
  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
	  if(conexion6.status == 200)
	  { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
		  document.getElementById('movimientosdecontacto').innerHTML=conexion6.responseText;
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
  var seleccion=document.getElementById('ordenPor');
  var criterio=document.getElementById('buscadorContacto');
  //alert (criterio.value);
  //alert (seleccion.value);
  var tabla = document.getElementById('tablaContactos');
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
  conexion1.open('GET','./php/buscocontacto.php?orden='+orden+"&busqueda="+datoABuscar+"&rnadom="+aleatorio, true);
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
		  document.getElementById('tablaContactos').innerHTML=conexion1.responseText;
		  inicializarEventos();
  		  //var tags_td = new Array();
  		  //var tags_td=document.getElementsByTagName('td');
		  //for (i=0; i<tags_td.length; i++) {
			//		tags_td[i].addEventListener('click',valor_celda,false);
		 // } 
		  document.getElementById('detallesdecontacto').innerHTML="";
			document.getElementById('movimientosdecontacto').innerHTML="";
			document.getElementById('accionesDetalle').innerHTML="";
		  tags_cambios = []; 
		  id_actual="";
		  var tags_inputm = new Array();
		  var tags_inputm=document.getElementsByName("botonMail");
		  for (i=0; i<tags_inputm.length; i++) {
					tags_inputm[i].addEventListener('click',enviarMail,false);
		  } 
		  //document.getElementById('botonMail').addEventListener('click',enviarMail,false);
		  var tags_input = new Array();
		  var tags_input=document.getElementsByClassName("input");
		  for (i=0; i<tags_input.length; i++) {
					tags_input[i].addEventListener('change',algoCambio,false);
		  } 
		  tags_cambios = []; 
			document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);
			llenarAccionesContactosJS();
	  }
  } 

}


var conexion3;
function actualizoContacto(){
	//alert(document.getElementById('IdContacto').value);
  //alert(celda.target.id);
  //var numerocto=id_actual;
  numerocto=document.getElementById('IdContacto').value;
  //alert (numerocto);
  //PRIMERO ACTUALIZO EL CONTACTO EN SU TABLA
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  var cadena="idcto="+numerocto;
  cadena=cadena+"&NombreCompleto="+encodeURIComponent(document.getElementById('NombreCompleto').value);
  cadena=cadena+"&Organizacion="+encodeURIComponent(document.getElementById('Organizacion').value);
  if (document.getElementById('Organizacion').value.length < 1) {
	  mostrarAvisos ("El contacto no puede quedar sin empresa. No actualizado");
	  return false;
  }
  //alert (cadena);
  cadena=cadena+"&FuncionEnLaEmpresa="+encodeURIComponent(document.getElementById('FuncionEnLaEmpresa').value);
  cadena=cadena+"&PalabrasClave="+document.getElementById('PalabrasClave').value;
  cadena=cadena+"&PoderDecision="+document.getElementById('PoderDecision').value; 
  cadena=cadena.replace("'","`");
  cadena='./php/actualizo_detallescontacto.php?'+cadena+"&rnadom="+aleatorio
  //alert(cadena);
  conexion3.open('GET',cadena, true);
  conexion3.send();
}

var conexion101;
function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
			if (conexion3.responseText.substr(0,5)=="OkOKo") 
			{
			  //LUEGO ACTUALIZO LOS TELEFONOS DEL CONTACTO
			  conexion101=new XMLHttpRequest(); 
			  conexion101.onreadystatechange = procesarEventos101;
			  var aleatorio=Math.random();
			  var cadena="idcto="+numerocto;
			  cadena=cadena+"&Telefono="+encodeURIComponent(document.getElementById('Telefono').value);
			  cadena=cadena+"&Telefonomovil="+encodeURIComponent(document.getElementById('Telefonomovil').value);
			  cadena=cadena+"&Telefonoprivado2="+encodeURIComponent(document.getElementById('Telefonoprivado2').value);
			  cadena=cadena+"&Faxdeltrabajo="+encodeURIComponent(document.getElementById('Faxdeltrabajo').value); 
			  cadena=cadena+"&OtroTelefono="+encodeURIComponent(document.getElementById('OtroTelefono').value); 
			  cadena=cadena.replace("'","`");
			  cadena='./php/actualizo_telefonos_contacto.php?'+cadena+"&rnadom="+aleatorio
			  //alert(cadena);
			  conexion101.open('GET',cadena, true);
			  conexion101.send(); 				
			}
	  }
  } 

}

var conexion102;
function procesarEventos101()
{
    if(conexion101.readyState == 4)
  { 
	  if(conexion101.status == 200)
	  {
			if (conexion101.responseText.substr(0,5)=="OkOKo")   
			{
			  //POR ULTIMO ACTUALIZO LOS EMAILS DEL CONTACTO
			  conexion102=new XMLHttpRequest(); 
			  conexion102.onreadystatechange = procesarEventos102;
			  var aleatorio=Math.random();
			  var cadena="idcto="+numerocto;
			  //Primero tengo que ver cuantos mails hay en la pantalla
			  var tags_inputm = new Array();
			  var tags_inputm=document.getElementsByName("Direcciondecorreoelectronico");
			  var contador=0;
			  for (i=0; i<tags_inputm.length; i++) {
				  if ((document.getElementById('Direcciondecorreoelectronico'+i).value).length > 0) {
					  cadena=cadena+"&email"+i+"="+encodeURIComponent(document.getElementById('Direcciondecorreoelectronico'+i).value); 
					  contador++;
					  }
			  } 	
			  cadena=cadena+"&cantidadMails="+contador;
			  cadena=cadena.replace("'","`");
			  cadena='./php/actualizo_emails_contacto.php?'+cadena+"&rnadom="+aleatorio
			  //alert(cadena);
			  conexion102.open('GET',cadena, true);
			  conexion102.send(); 			  
			}
	  }
  } 
}

function procesarEventos102()
{
    if(conexion102.readyState == 4)
  { 
	  if(conexion102.status == 200)
	  { 
		  document.getElementById('detallesdecontacto').innerHTML=conexion102.responseText;
			//No lo habilito porque despues no me anda el evento 'change'. 2018 ahora si (es con .on('change',))
			$(document).ready(function() {$("#Organizacion").select2();});	
			//on change para select2
			$('#Organizacion').on('change', cambiarEmpresa);
			//on change para select comun
			//document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);				  
		  tags_cambios = [];
		  var tags_inputm = new Array();
		  var tags_inputm=document.getElementsByName("botonMail");
		  for (i=0; i<tags_inputm.length; i++) {
					tags_inputm[i].addEventListener('click',enviarMail,false);
		  } 
		  //document.getElementById('botonMail').addEventListener('click',enviarMail,false);
		  var tags_input = new Array();
		  var tags_input=document.getElementsByClassName("input");
		  for (i=0; i<tags_input.length; i++) {
					tags_input[i].addEventListener('change',algoCambio,false);
		  } 
		  tags_cambios = []; 
		  document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);
	  }
  } 
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
		  	//No lo habilito porque despues no me anda el evento 'change'. 2018 ahora si (es con .on('change',))
			$(document).ready(function() {$("#Organizacion").select2();});	
			//on change para select2
			$('#Organizacion').on('change', cambiarEmpresa);
			//on change para select comun
			//document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);		
		  tags_cambios = [];
	  }
  } 

}


var conexion5;
function nuevoContacto(){
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio=Math.random();
  cadena='./php/nuevo_detallescontacto.php?rnadom='+aleatorio
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
		  document.getElementById('detallesdecontacto').innerHTML=conexion5.responseText;
		  	//No lo habilito porque despues no me anda el evento 'change'. 2018 ahora si (es con .on('change',))
			$(document).ready(function() {$("#Organizacion").select2();});	
			//on change para select2
			//$('#Organizacion').on('change', cambiarEmpresa);
			//on change para select comun
			//document.getElementById('Organizacion').addEventListener('change',cambiarEmpresa,false);		
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
		  var datosc=document.getElementById('detallesdemovimientosFRMSup');
		  datosc.innerHTML=conexion7.responseText;
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
			document.getElementById('botonActualizaContacto').addEventListener('click',actualizoContacto,false);
			document.getElementById('botonCopiaContacto').addEventListener('click',copioContacto,false);
			document.getElementById('botonNuevoContacto').addEventListener('click',nuevoContacto,false);
			document.getElementById('checkMostrarMovimientos').addEventListener('change',mostrarMovimientos,false);
	  }
  } 

}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}