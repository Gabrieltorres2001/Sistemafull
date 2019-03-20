addEventListener('load',inicializarEventos,false);

var nCom;
var idLista;

function inicializarEventos()
{
	llenarListadoListas();
	document.getElementById('cierraMovsAgPago').addEventListener('click',cerrarVentanaNuevoPago,false); 
	document.getElementById('cierraDeudores').addEventListener('click',cierraVentanaDeudores,false); 
	document.getElementById('cierraInfCliente').addEventListener('click',cierraVentanaInfClientes,false);	
	//document.getElementById('checkMostrarCanceladas').addEventListener('change',mostrarMovimientos,false); 
}

var conexion1;
function llenarListadoListas(){
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  conexion1.open('GET','./php/llenar_listado_listas.php?rnadom='+aleatorio, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('Listas').innerHTML=conexion1.responseText;
		  	$(document).ready(function() {
			  $("#listaNombre").select2();
			});		  
		  //acciones para el boton buscar
		  document.getElementById('seleccionaEmpresa').addEventListener('click',mostrarListaSeleccionadaNombre,false); 
		  document.getElementById('nuevaLista').addEventListener('click',nuevaListaContactos,false);	
		  document.getElementById('imprimirDeudores').addEventListener('click',informeDeudores,false);		  
	  }
  } 
}

function mostrarListaSeleccionadaNombre(){
		var lista=document.getElementById('listaNombre').value;
		buscarContactosLista(lista);
}

var conexion4;
var conexion3;
var conexion2;
function buscarContactosLista(lista){
	idLista=lista;
	//antes que nada borro los contenidos de los DIV
	document.getElementById('ContactosFueraLista').innerHTML="";
	datosc=document.getElementById('accionesContactos').innerHTML="";
	datosc=document.getElementById('ClientesEnLista').innerHTML="";
	
	//primero lleno las acciones (botones) del buscador de contactos
	conexion4=new XMLHttpRequest(); 
	conexion4.onreadystatechange = procesarEventos4;
	var aleatorio=Math.random();	
	conexion4.open('GET','./php/llenar_acciones_listas.php?rnadom='+aleatorio, true);
	conexion4.send();
	
	//Tambien llenar todos los contactos que HAY en la lista
	conexion3=new XMLHttpRequest(); 
	conexion3.onreadystatechange = procesarEventos3;
	aleatorio=Math.random();	
	conexion3.open('GET','./php/buscar_contactos_x_lista.php?rnadom='+aleatorio+'&lista='+idLista, true);
	conexion3.send();
	
	//Por ultimo llenar todos los contactos que NO HAY en la lista
	//Tomar la funcion llenar_listado_contactos() de funcContactos.php
	conexion2=new XMLHttpRequest(); 
	conexion2.onreadystatechange = procesarEventos2;
	aleatorio=Math.random();	
	conexion2.open('GET','./php/buscar_contactos_fuera_de_lista.php?rnadom='+aleatorio+'&lista='+idLista, true);
	conexion2.send();	
}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 	
		  document.getElementById('accionesContactos').innerHTML=conexion4.responseText;	
		  //Voy a tener que traer la funcion busco de funcionescontactos.js
		  document.getElementById('ordenPor').addEventListener('change',busco,false);
		  document.getElementById('botonBuscadorContacto').addEventListener('click',busco,false);
	  }
  } 
}


function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 	
		  document.getElementById('ClientesEnLista').innerHTML=conexion3.responseText;	
	  }
  } 
}


function procesarEventos2()
{
    if(conexion2.readyState == 4)
  { 
	  if(conexion2.status == 200)
	  { 	
		  document.getElementById('ContactosFueraLista').innerHTML=conexion2.responseText;	
	  }
  } 
}


var conexion10;
var clienteCCC;
function nuevaListaContactos(){
	var nuevoId=prompt("Nombre de la lista?");
	if (nuevoId.length>0){
		conexion10=new XMLHttpRequest(); 
		conexion10.onreadystatechange = procesarEventos10;
		var aleatorio=Math.random();
		//alert(nuevoId);
		conexion10.open('GET','./php/nuevo_listaContactos.php?&rnadom='+aleatorio+"&nombre="+nuevoId, true);
		conexion10.send();	
	} else {mostrarAvisos("Lista NO creada");}
}

function procesarEventos10()
{
    if(conexion10.readyState == 4)
  { 
	  if(conexion10.status == 200)
	  { 	
		llenarListadoListas();		
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
mostrarAvisos("cambiarDatos");	
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
		  document.getElementById('ContactosFueraLista').innerHTML=conexion1.responseText;
		  inicializarEventos();
  		  //var tags_td = new Array();
  		  //var tags_td=document.getElementsByTagName('td');
		  //for (i=0; i<tags_td.length; i++) {
		//			tags_td[i].addEventListener('click',valor_celda,false);
		 // } 
		  document.getElementById('detallesdecontacto').innerHTML="";
		  document.getElementById('movimientosdecontacto').innerHTML="";
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
	  }
  } 

}




/////////////////////////////7
//CReo que no van
/////////////////////////////7

var conexion5;
function mostrarDetalles(celda){
	//alert(celda);
	//alert(celda.target.id);
if (isNaN(celda))
  {
	if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
    var numeroComprobante=celda.target.id;
  }  else
  {
	var numeroComprobante=celda; 
  }
  nCom=numeroComprobante;
  // el detalle del presupuesto
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio=Math.random();
  //ESTE PHP LO VOY A TENER QUE CAMBIAR
  conexion5.open('GET','./php/llenar_detalle_pagos_factura.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
  conexion5.send();
}

function procesarEventos5()
{
    if(conexion5.readyState == 4)
  { 
	  if(conexion5.status == 200)
	  { 
		  document.getElementById('detallesdePagos').innerHTML=conexion5.responseText;
		  //un click en el boton del tilde EN LA ULTIMA LINEA agrega un item
		  var tags_td_actua = new Array();
		  var tags_td_actua = document.getElementsByName('xxxxz');
		  for (i=0; i<tags_td_actua.length; i++) {
					tags_td_actua[i].addEventListener('click',agregarPagoAFactura,false);
			};	
		//un click en el boton de la cruz borra la linea
		  var tags_td_elim = new Array();
		  var tags_td_elim = document.getElementsByName('xxxxx');
		  for (i=0; i<tags_td_elim.length; i++) {
					tags_td_elim[i].addEventListener('click',borrarPagoFactura,false);
		};
		var tags_td_actua = new Array();
		  var tags_td_actua = document.getElementsByName('xxxxy');
		  for (i=0; i<tags_td_actua.length; i++) {
					tags_td_actua[i].addEventListener('click',refrescarPagoAFactura,false);
		};	
	  }
  }
}

function refrescarPagoAFactura()
{
	mostrarDetalles(nCom);
}

function cerrarVentanaNuevoPago()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('nuevoItem').style.visibility='hidden';
}

function cierraVentanaDeudores()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('informeDeDeudores').style.visibility='hidden';
}

function cierraVentanaInfClientes()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('informeDeCliente').style.visibility='hidden';
}

var conexion6;
function agregarPagoAFactura()
{ 
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('nuevoItem').style.visibility='visible';
	transfEnEditableNueva();
	cargarFaltanteDePago();
	var tags_td_acept = new Array();
	  var tags_td_acept = document.getElementsByName('xxxxA');
	  for (i=0; i<tags_td_acept.length; i++) {
				tags_td_acept[i].addEventListener('click',agregaItemNuevo,false);
	};
	//conexion6=new XMLHttpRequest(); 
	//conexion6.onreadystatechange = procesarEventos6;
	//var aleatorio=Math.random();
	//var tipoTipo='4';
	//conexion6.open('GET','./php/leo_detalle_presupuesto_articulo.php?idart=15151&rnadom='+aleatorio, true);
	//conexion6.open('GET','./php/leer_tipos.php?tipo='+tipoTipo+"&rnadom="+aleatorio, true);
	//conexion6.send();
}

//var mArray;
//function procesarEventos6()
//{
 //   if(conexion6.readyState == 4)
//  { 
//	  if(conexion6.status == 200)
//	  { 
		 //var datosRecib=JSON.parse(conexion6.responseText);
		 //alert(conexion6.responseText);
		 //mArray= new Array();
		 //for(var f=0;f<datosRecib.length;f++)
		 //{
		//	var segArray= new Array();
		//	segArray.push(datosRecib[f].ID);
		//	segArray.push(datosRecib[f].Descripcion);
		//	mArray.push(segArray);
		 //}
		 //alert(conexion6.responseText);
		 //transfEnEditableNueva();
	  //}
//  }
//}

var conexion7;
function agregaItemNuevo(celda){
	var datosc=document.getElementById('00&Importe');
	//alert(editableGridTemp.getValueAt(0, 0));
	//primero agrego un nuevo articulo al comprobante actual (de la variable global nCom)
	conexion7=new XMLHttpRequest(); 
	conexion7.onreadystatechange = procesarEventos7;
	var aleatorio=Math.random();
	//defino los campos a enviar
	var cadena="idcomprobante="+nCom;
	//alert(cadena);
	if ((isNaN(parseFloat(editableGridTemp.getValueAt(0, 3))))||(editableGridTemp.getValueAt(0, 0) == null)||(editableGridTemp.getValueAt(0, 1) == null)||(editableGridTemp.getValueAt(0, 2) == null)||(parseFloat(editableGridTemp.getValueAt(0, 3))<0.001)||(isNaN(parseFloat(editableGridTemp.getValueAt(0, 1))))||(isNaN(parseFloat(monedaAImputar)))){
		  mostrarAvisos("Faltan datos!")
	  } else {
			  //campo 0. Fecha
			  cadena=cadena+"&Fecha="+editableGridTemp.getValueAt(0,0);	
			  //campo 1. Forma de pago
			  cadena=cadena+"&TipoValor="+editableGridTemp.getValueAt(0, 1);
			  //campo 2. Moneda.
			  monedaAImputar=parseFloat(monedaAImputar)+1;
			  //alert (monedaAImputar);
			  //if ((isNaN(parseFloat(editableGridTemp.getValueAt(0, 2))))){cadena=cadena+"&MonedaPago=1"}
			  //else {cadena=cadena+"&MonedaPago="+editableGridTemp.getValueAt(0, 2);}
			  cadena=cadena+"&MonedaPago="+monedaAImputar;
			  //alert (cadena);
			  //campo 3. Importe.
			  cadena=cadena+"&Importe="+editableGridTemp.getValueAt(0, 3);
			  //campo 4. Descripcion.
			  cadena=cadena+"&Descripcion="+editableGridTemp.getValueAt(0, 4);
			  //ESTE PHP LO VOY A TENER QUE CAMBIAR
			  cadena='./php/agrego_pago_a_factura.php?'+cadena+"&rnadom="+aleatorio+"&cuit="+cuitCliente
			  //alert(cadena);
			  //alert(cadena);
			  conexion7.open('GET',cadena, true);
			  conexion7.send();
			  mostrarDetalles(nCom);
	  }
}

function cargarFaltanteDePago(){
	//primero agrego un nuevo articulo al comprobante actual (de la variable global nCom)
	conexion7=new XMLHttpRequest(); 
	conexion7.onreadystatechange = procesarEventos7;
	var aleatorio=Math.random();
	//defino los campos a enviar
	var cadena="idcomprobante="+nCom;
	//alert(cadena);
  cadena='./php/leo_faltantes_pago_a_factura.php?'+cadena+"&rnadom="+aleatorio;
  //alert(cadena);
  conexion7.open('GET',cadena, true);
  conexion7.send();
  //mostrarDetalles(nCom);
}

var monedaAImputar;
function procesarEventos7()
{
    if(conexion7.readyState == 4)
  { 
	  if(conexion7.status == 200)
	  { 
		var datosRecib=JSON.parse(conexion7.responseText);
		monedaAImputar=datosRecib.moneda;
		//por ultimo reseteo la grilla para cargar otro item
		editableGridTemp.setValueAt(0, 0, '','true');
		editableGridTemp.setValueAt(0, 1, '','true');
		if (datosRecib.moneda==0) {editableGridTemp.setValueAt(0, 2, '$','true');}
		if (datosRecib.moneda==1) {editableGridTemp.setValueAt(0, 2, 'USD','true');}
		if (datosRecib.moneda==60) {editableGridTemp.setValueAt(0, 2, '€','true');}
		editableGridTemp.setValueAt(0, 3, datosRecib.pendientePago,'true');
		editableGridTemp.setValueAt(0, 4, '','true');
	  }
  } 
}


function transfEnEditableNueva()
{
              editableGridTemp = new EditableGrid("DemoGridAttach",{// called when some value has been modified: actualizo la BD
			  modelChanged: function(rowIdx, colIdx, oldValue, newValue, row) { 
			  // todas las acciones a realizar al cambiar un campo
			  var campoAEditar="";
			  switch(colIdx){
				  case 0:
						campoAEditar="Fecha";
							//Por ahora nada.
						break;
				  case 1:
						campoAEditar="TipoValor";
						//Por ahora nada.
						break;
				  case 2:
						campoAEditar="MonedaPago";
						//Por ahora nada.
						break;
				  case 3:
						campoAEditar="Importe";
						//Por ahora nada.									
						break;
				  case 4:
						campoAEditar="Descripcion";
						//Por ahora nada.									
						break;
			  };
			  //alert(oldValue);
			  }, 			  
			  //otra funcion a redefir 
			  // ,rowSelected: function(oldRowIndex, newRowIndex) {
			//	 nuevarowindex=newRowIndex;
			  //}
			  }); 

				// we build and load the metadata in Javascript
				editableGridTemp.load({ metadata: [
					{ name: "Fecha", datatype: "date", editable: true },
					{ name: "TipoValor", datatype: "double", editable: true, values: 
					  	{ 8 : "Efectivo", 12 : "Cheque", 13 : "Tarjeta de débito", 14 : "Tarjeta de crédito", 15 : "Transferencia bancaria", 16 : "Nota de crédito", 17 : "Redondeo", 20 : "Otro"}  },
					{ name: "MonedaPago", datatype: "double", editable: false, values: 
					  	{ 1 : "$", 2 : "USD", 61 : "€"} },
					{ name: "Importe", datatype: "double(2)", editable: true },
					{ name: "Descripcion", datatype: "string", editable: true }
				]});
				// then we attach to the HTML table and render it
				editableGridTemp.attachToHTMLTable('tablaDetallePagoNuev');
				editableGridTemp.renderGrid();
			} 
			
var conexion8;
function borrarPagoFactura(celda){
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var idppago = palabras[0];
	var fechapago = palabras[1];
	if(confirm("Borrar el pago con fecha "+fechapago+"?")== true) {
		conexion8=new XMLHttpRequest(); 
		//conexion8.onreadystatechange = procesarEventos8;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		//ESTE PHP LO VOY A TENER QUE MODIFICAR
		conexion8.open('GET','./php/borro_pago_factura.php?idpago='+idppago+"&rnadom="+aleatorio, true);
		conexion8.send();
		//DEBO actualizar automaticamente
		setTimeout(function(){mostrarDetalles(nCom)}, 500);
	}
}

var conexion9;
function informeDeudores(){
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('informeDeDeudores').style.visibility='visible';
	conexion9=new XMLHttpRequest(); 
	conexion9.onreadystatechange = procesarEventos9;
	var aleatorio=Math.random();
	conexion9.open('GET','./php/llenar_listado_deudores.php?&rnadom='+aleatorio, true);
	conexion9.send();
}

function procesarEventos9()
{
    if(conexion9.readyState == 4)
  { 
	  if(conexion9.status == 200)
	  { 	
		  document.getElementById('verDeudores').innerHTML=conexion9.responseText;	
	  }
  } 
}

var conexion11;
function mostrarMovimientosCCC(){
		var desdeCCC=document.getElementById('fchDesdeCCC');
		var hastaCCC=document.getElementById('fchHastaCCC');
		if (desdeCCC.value.length > 0) {
			//hay desde
			desdeCCC = desdeCCC.value.substr(6,4)+"-"+desdeCCC.value.substr(3,2)+"-"+desdeCCC.value.substr(0,2);
		} else {
			//NO hay desde
			//OJO PONGO LA FECHA DE INICIO DE SISTEMAPLUS PERO PODRIA USAR CUALQUIER OTRA. VA A SALIR EN LOS INFORMES
			desdeCCC = "2017-06-16";		
		}
		if (hastaCCC.value.length > 0) {
			//hay hasta
			hastaCCC = hastaCCC.value.substr(6,4)+"-"+hastaCCC.value.substr(3,2)+"-"+hastaCCC.value.substr(0,2);
		} else {
			//NO hay hasta
			var today = new Date();
			var dd=today.getDate();
			if (dd<10) { dd='0'+dd;}
			var mm=today.getMonth()+1;
			if (mm<10) { mm='0'+mm;}
			hastaCCC = today.getFullYear()+"-"+mm+"-"+dd;		
		}
		if(document.getElementById('checkMostrarCanceladasCCC').checked){var cancCCC=true;} else {var cancCCC=false;}
		//alert ("CUIT: "+clienteCCC+" desde: "+desdeCCC+" hasta: "+hastaCCC+" Canceladas: "+cancCCC);
		conexion11=new XMLHttpRequest(); 
		conexion11.onreadystatechange = procesarEventos11;
		var aleatorio=Math.random();
		conexion11.open('GET','./php/llenar_CCC_empresa.php?&rnadom='+aleatorio+"&CUIT="+clienteCCC+"&desde="+desdeCCC+"&hasta="+hastaCCC+"&Canceladas="+cancCCC, true);
		conexion11.send();	
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 	
		  document.getElementById('verInfCliente').innerHTML=conexion11.responseText;			  
	  }
  } 
}

var conexion12;
function informeMovimientosCCC(){
		var desdeCCC=document.getElementById('fchDesdeCCC');
		var hastaCCC=document.getElementById('fchHastaCCC');
		if (desdeCCC.value.length > 0) {
			//hay desde
			desdeCCC = desdeCCC.value.substr(6,4)+"-"+desdeCCC.value.substr(3,2)+"-"+desdeCCC.value.substr(0,2);
		} else {
			//NO hay desde
			//OJO PONGO LA FECHA DE INICIO DE SISTEMAPLUS PERO PODRIA USAR CUALQUIER OTRA. VA A SALIR EN LOS INFORMES
			desdeCCC = "2017-06-16";		
		}
		if (hastaCCC.value.length > 0) {
			//hay hasta
			hastaCCC = hastaCCC.value.substr(6,4)+"-"+hastaCCC.value.substr(3,2)+"-"+hastaCCC.value.substr(0,2);
		} else {
			//NO hay hasta
			var today = new Date();
			var dd=today.getDate();
			if (dd<10) { dd='0'+dd;}
			var mm=today.getMonth()+1;
			if (mm<10) { mm='0'+mm;}
			hastaCCC = today.getFullYear()+"-"+mm+"-"+dd;		
		}
		if(document.getElementById('checkMostrarCanceladasCCC').checked){var cancCCC=true;} else {var cancCCC=false;}
		//alert ("CUIT: "+clienteCCC+" desde: "+desdeCCC+" hasta: "+hastaCCC+" Canceladas: "+cancCCC);
		conexion12=new XMLHttpRequest(); 
		conexion12.onreadystatechange = procesarEventos12;
		var aleatorio=Math.random();
		window.open('./informes/Informe.php?&rnadom='+aleatorio+"&CUIT="+clienteCCC+"&desde="+desdeCCC+"&hasta="+hastaCCC+"&Canceladas="+cancCCC+"&tipoInforme=Cuenta_Cliente", true);
		conexion12.send();	
}

function procesarEventos12()
{
    if(conexion12.readyState == 4)
  { 
	  if(conexion12.status == 200)
	  {   
  
		var nVentana= window.open('"', '"', "width=595, height=841");
		nVentana.document.write(conexion12.responseText);
		//nVentana.document.close();
		nVentana.print();
		//nVentana.close();
	  }
  }
}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}