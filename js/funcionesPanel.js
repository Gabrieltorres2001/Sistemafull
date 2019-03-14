addEventListener('load',inicializarEventos,false);

var tags_cambios = new Array();
var id_actual="";
var nCom;
function inicializarEventos()
{
  var tags_td = new Array();
  var tags_td=document.getElementsByTagName('td');
  for (i=0; i<tags_td.length; i++) {
            tags_td[i].addEventListener('click',mostrarDetalles,false);
  } 
}

var conexion2;
var numeroMenu;
function mostrarDetalles(celda){
  //alert(celda.target.id);
  numeroMenu=celda.target.id;
  id_actual=numeroMenu;
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion2.open('GET','./php/detallesmenupanelcontrol.php?idmenu='+numeroMenu+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion2.send();

  //Pinto el menu que esta seleccionado
	if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
	nCom=celda.target.id;
}

function procesarEventos2()
{
    if(conexion2.readyState == 4)
	{ 
	if(conexion2.status == 200)
		{ 
			document.getElementById('ControlPanelDetalles').innerHTML=conexion2.responseText; 	  
		}
  } 
}


var conexion1;
var conexion3;
var obnn;
function algoCambio(nombre,tipo,numerId)
{
	//alert(numerId);
	//alert(tipo.id);
	//alert(nombre);
	//alert(nombre.id);
	if (tipo.id=="SiNo") {
		conexion1=new XMLHttpRequest(); 
		conexion1.onreadystatechange = procesarEventos1;
		var aleatorio=Math.random();
		//var obnn=document.getElementById('numberses').value;
		conexion1.open('GET','./php/actualizo_registro_controlpanel.php?Descripcion='+nombre.id+"&rnadom="+aleatorio+"&nuevoValor="+nombre.value+"&numeroID="+numerId, true);
		conexion1.send();
	}
	if (tipo.id=="Boton") {
		//alert("Boton "+numerId);
		conexion3=new XMLHttpRequest(); 
		conexion3.onreadystatechange = procesarEventos3;
		var aleatorio=Math.random();
		obnn=document.getElementById(nombre.id).value;
		//alert(obnn);
		//Tengo que enviar mi nivel de usuario para saber hasta que nivel puede mostrar la pagina php que llama el boton.		
		//Mando mi usuario y el nivel lo saco por php.
		var usuarioActual=document.getElementById('numberses').value;
		//alert(usuarioActual);
		conexion3.open('GET',obnn+'?rnadom='+aleatorio+"&numeroID="+numerId+"&numeroSesion="+usuarioActual, true);
		conexion3.send();		
	}
	if (tipo.id=="Texto") {
		//alert("Texto "+nombre.id);
		conexion1=new XMLHttpRequest(); 
		conexion1.onreadystatechange = procesarEventos1;
		var aleatorio=Math.random();
		obnn=encodeURIComponent(document.getElementById(nombre.id).value);
		//alert(obnn);
		conexion1.open('GET','./php/actualizo_registro_controlpanel.php?Descripcion='+nombre.id+"&rnadom="+aleatorio+"&nuevoValor="+obnn+"&numeroID="+numerId, true);
		conexion1.send();		
	}

}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
	{ 
	if(conexion1.status == 200)
		{ 
			mostrarAvisos(conexion1.responseText); 	  
		}
  } 
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
	{ 
	if(conexion3.status == 200)
		{ 
		document.getElementById('ControlPanelDetalles').innerHTML=conexion3.responseText; 
		//Escuchar el evento de que cambió algún check.
		  var tags_td_camb = new Array();
		  var tags_td_camb = document.getElementsByName('xxxxMembCheck');
		  for (i=0; i<tags_td_camb.length; i++) {
					tags_td_camb[i].addEventListener('change',cambioUnCheckAUnMemb,false);
			};
		//Escuchar el evento de que cambió algún texto de nivel de usuario.
		  var tags_td_camb = new Array();
		  var tags_td_camb = document.getElementsByName('xxxxMembNivel');
		  for (i=0; i<tags_td_camb.length; i++) {
					tags_td_camb[i].addEventListener('change',cambioUnNivelAUnMemb,false);
			};
		}
		
		document.getElementById('consultarFacCAE').addEventListener('click',verCAE,false); 
  } 
}

var conexion444;
function verCAE()
{
	var cbteTipoo=(document.getElementById('CbteTipo').value);
	var ptoVtao=(document.getElementById('PtoVta').value);
	var cbteNroo=(document.getElementById('CbteNro').value);
	
	conexion444=new XMLHttpRequest(); 
	conexion444.onreadystatechange = procesarEventos4;
	var aleatorio=Math.random();
	conexion444.open('GET','./php/revisarWSFEEmitidas_resultado.php?rnadom='+aleatorio+"&cbteTipo="+cbteTipoo+"&ptoVta="+ptoVtao+"&cbteNro="+cbteNroo, true);

	conexion444.send();	
}

function procesarEventos4()
{
    if(conexion444.readyState == 4)
	{ 
	if(conexion444.status == 200)
		{ 
		document.getElementById('ControlPanelDetalles').innerHTML=conexion444.responseText; 
		}
	}
}

function cambioUnCheckAUnMemb(celda)
{
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var valor;
	if (celda.target.checked) {valor='1';} else {valor='0';}
	//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
	//alert(palabras[0]+" "+palabras[2]+" "+valor);
	modificarCampoTablaControlPanel(palabras[0],palabras[2],valor);
}

function cambioUnNivelAUnMemb(celda)
{
	//alert(celda.target.value);
	//Primero tengo que verificar que el numero que ingresè sea correcto (numero y ademas mayor o igual a mi nivel)
	 if ( ! celda.target.validity.valid ) {mostrarAvisos("Valor de nivel inválido! Cambio no guardado.");
	 } else {
		var ambosid=celda.target.id;
		var palabras = ambosid.split("&");
		//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
		//alert(palabras[0]+" "+palabras[2]+" "+valor);
		modificarCampoTablaControlPanel(palabras[0],palabras[2],celda.target.value);
	 }
}

var conexion17;
function modificarCampoTablaControlPanel(IdUsuario,campoAEditar,newValue){
	conexion17=new XMLHttpRequest(); 
	conexion17.onreadystatechange = procesarEventos17;
	var aleatorio=Math.random();
	var cadena=encodeURIComponent(newValue);
	conexion17.open('GET','./php/actualizo_detalle_control_panel.php?idUsuario='+IdUsuario+"&campo="+campoAEditar+"&valor="+cadena+"&rnadom="+aleatorio, true);
	conexion17.send();
	//ya esta. Se ve en la tabla y ademas (confio en que) se grabo en la BD
}

function procesarEventos17()
{
    if(conexion17.readyState == 4)
	{ 
	if(conexion17.status == 200)
		{ 
		mostrarAvisos(conexion17.responseText); 
		}
	}
}
//Siempre esta funcion al final (por orden mio nada mas)
function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}