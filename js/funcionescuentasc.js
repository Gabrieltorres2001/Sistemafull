addEventListener('load',inicializarEventos,false);

var nCom;
var cuitCliente;

function inicializarEventos()
{
	llenarListadoCuits();
	document.getElementById('cierraMovsAgPago').addEventListener('click',cerrarVentanaNuevoPago,false); 
	document.getElementById('cierraDeudores').addEventListener('click',cierraVentanaDeudores,false); 
	document.getElementById('cierraInfCliente').addEventListener('click',cierraVentanaInfClientes,false);	
	document.getElementById('checkMostrarCanceladas').addEventListener('change',mostrarMovimientos,false); 
}

var conexion1;
function llenarListadoCuits(){
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  conexion1.open('GET','./php/llenar_listado_empresas_cuit.php?rnadom='+aleatorio, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('CUITs').innerHTML=conexion1.responseText;
		  	$(document).ready(function() {
			  $("#empresaNombre").select2();
			});		  
		  //acciones para el boton buscar
		  document.getElementById('seleccionaEmpresa').addEventListener('click',mostrarEmpresaSeleccionadaNombre,false); 
		  document.getElementById('imprimirCuenta').addEventListener('click',informeCuentaCorriente,false);	
		  document.getElementById('imprimirDeudores').addEventListener('click',informeDeudores,false);		  
	  }
  } 
}

function mostrarEmpresaSeleccionadaNombre(){
		var cliente=document.getElementById('empresaNombre').value;
		buscarDatosEmpresa(cliente);
}

var conexion2;
var conexion3;	
var conexion4;
function buscarDatosEmpresa(cliente){
	cuitCliente=cliente;
	//antes que nada borro los contenidos de los DIV
	document.getElementById('datosAfip').innerHTML="";
	datosc=document.getElementById('empresaElegida').innerHTML="";
	datosc=document.getElementById('listaFacturas').innerHTML="";
		  
		//PRIMERO CONSULTO LOS DATOS EN MI BD. ANTES DE ELIMINAR LOS GUIONES PARA LA AFIP
		conexion3=new XMLHttpRequest(); 
		conexion3.onreadystatechange = procesarEventos3;
		var aleatorio=Math.random();
		conexion3.open('GET','./php/buscar_empresas_x_cuit.php?cuitemp='+cliente+'&rnadom='+aleatorio, true);
		conexion3.send();
		
		//TAMBIEN, EN PARALELO, BUSCO LAS FACTURAS DE ESE CLIENTE
		mostrarMovimientos();
		
		//ELIMINO LOS GUIONES PARA ENVIAR LOS DATOS A LA AFIP
		var posicion=cliente.indexOf('-');
		while (posicion!=-1){
			cliente=cliente.substring(0,posicion)+cliente.substring(posicion+1);
			posicion=cliente.indexOf('-');	
		}
		conexion2=new XMLHttpRequest(); 
		conexion2.onreadystatechange = procesarEventos2;
		conexion2.open('GET','https://soa.afip.gob.ar/sr-padron/v2/persona/'+cliente, true);
		conexion2.send();
}

function mostrarMovimientos(){
		conexion4=new XMLHttpRequest(); 
		conexion4.onreadystatechange = procesarEventos4;
		var aleatorio=Math.random();
		if(document.getElementById('checkMostrarCanceladas').checked){	
			conexion4.open('GET','./php/buscar_facturas_x_cuit.php?cuitemp='+cuitCliente+'&rnadom='+aleatorio, true);
		} else {
			conexion4.open('GET','./php/buscar_facturas_x_cuit_SINPAGAR.php?cuitemp='+cuitCliente+'&rnadom='+aleatorio, true);
		}
		conexion4.send();
}

function procesarEventos2()
{
	if(conexion2.readyState == 4){
		  var datosc=document.getElementById('datosAfip');	 
		  datosc.innerHTML='INFORMACION REGISTRADA EN AFIP</BR></BR>';
		  //datosc.innerHTML=datosc.innerHTML+conexion2.responseText;
		  var empresaAK=JSON.parse(conexion2.responseText);
		  if (empresaAK.success==true){
		  datosc.innerHTML=datosc.innerHTML+'Nombre: '+empresaAK.data.nombre+'</BR>';			  
		  datosc.innerHTML=datosc.innerHTML+'Tipo Persona: '+empresaAK.data.tipoPersona+'</BR>';	
		  datosc.innerHTML=datosc.innerHTML+'Estado: '+empresaAK.data.estadoClave+'</BR>';	
			if (empresaAK.data.tipoDocumento!=undefined){
				datosc.innerHTML=datosc.innerHTML+'Tipo y Nro. de Documento: '+empresaAK.data.tipoDocumento+' ';
			} else {
				datosc.innerHTML=datosc.innerHTML+'Tipo y Nro. de Documento: ND ';
			}	
			if (empresaAK.data.numeroDocumento!=undefined){
				datosc.innerHTML=datosc.innerHTML+empresaAK.data.numeroDocumento+'</BR>';
			} else {
				datosc.innerHTML=datosc.innerHTML+'ND</BR>';
			}				
		  datosc.innerHTML=datosc.innerHTML+'Domicilio Fiscal: '+empresaAK.data.domicilioFiscal.direccion+'</BR>';	
		  datosc.innerHTML=datosc.innerHTML+'Localidad: ('+empresaAK.data.domicilioFiscal.codPostal+') ';	
		  datosc.innerHTML=datosc.innerHTML+empresaAK.data.domicilioFiscal.localidad+'</BR>';
		  }	else {
			if (empresaAK.success==false){	
				datosc.innerHTML='Error. Tipo: '+empresaAK.error.tipoError+'</BR>';	
				datosc.innerHTML=datosc.innerHTML+'Mensaje: '+empresaAK.error.mensaje+'</BR>';	
				datosc.innerHTML=datosc.innerHTML+'Datos: '+empresaAK.data;					
		  }	}		
	}
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
		  var datosc=document.getElementById('empresaElegida');
		  datosc.innerHTML=conexion3.responseText;	  
	  }
  } 
}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 	
		  var datosc=document.getElementById('listaFacturas');
		  datosc.innerHTML=conexion4.responseText;	
		  document.getElementById('detallesdePagos').innerHTML="";
		  //document.getElementById('xxxxB').addEventListener('click',buscarDatosEmpresa,false);			  
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('FilaFactura');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetalles,false);
				r=ii;
		  }
	  }
  } 
}

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
		  var datosc=document.getElementById('detallesdePagos');
		  datosc.innerHTML=conexion5.responseText;
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
				//alert(cadena);
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
					  	{ 8 : "Efectivo", 12 : "Cheque", 13 : "Tarjeta de débito", 14 : "Tarjeta de crédito", 15 : "Transferencia bancaria", 16 : "Nota de crédito", 17 : "Redondeo", 20 : "Otro", 25 : "A cuenta"}  },
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
		  var datosc=document.getElementById('verDeudores');
		  datosc.innerHTML=conexion9.responseText;	
		  document.getElementById('imprimirDeudoresPDF').addEventListener('click',informeDeudoresPDF,false);	
	  }
  } 
}


var conexion10;
var clienteCCC;
function informeCuentaCorriente(){
		clienteCCC=document.getElementById('empresaNombre').value;
		var datosc=document.getElementById('tituloCCC');
		datosc.innerHTML="Cuenta de cliente CUIT Nº: "+clienteCCC;	
		datosc=document.getElementById('verInfCliente');
		datosc.innerHTML="";
		document.getElementById('fondoClaro').style.visibility='visible';
		document.getElementById('informeDeCliente').style.visibility='visible';
		//alert("En un futuro se emitirá informe de: "+cliente);
		conexion10=new XMLHttpRequest(); 
		conexion10.onreadystatechange = procesarEventos10;
		var aleatorio=Math.random();
		conexion10.open('GET','./php/llenar_opciones_listado.php?&rnadom='+aleatorio, true);
		conexion10.send();	
}

function procesarEventos10()
{
    if(conexion10.readyState == 4)
  { 
	  if(conexion10.status == 200)
	  { 	
		  document.getElementById('verInfClienteOPCS').innerHTML=conexion10.responseText;	
		  $( function() {
			$( "#fchDesdeCCC" ).datepicker();
		  } );
		  $( function() {
			$( "#fchHastaCCC" ).datepicker();
		  } );	
		document.getElementById('seleccionaEmpresaCCC').addEventListener('click',mostrarMovimientosCCC,false); 		
		document.getElementById('informeEmpresaCCC').addEventListener('click',informeMovimientosCCC,false); 		
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
		window.open('./informes/informe_Cuenta_Cliente.php?&rnadom='+aleatorio+"&CUIT="+clienteCCC+"&desde="+desdeCCC+"&hasta="+hastaCCC+"&Canceladas="+cancCCC, true);
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

var conexion13;
function informeDeudoresPDF(){
		conexion13=new XMLHttpRequest(); 
		conexion13.onreadystatechange = procesarEventos13;
		var aleatorio=Math.random();
		window.open('./informes/informe_Deudores.php?&rnadom='+aleatorio, true);
		conexion13.send();	
}

function procesarEventos13()
{
    if(conexion13.readyState == 4)
  { 
	  if(conexion13.status == 200)
	  {   
  
		var nVentana= window.open('"', '"', "width=595, height=841");
		nVentana.document.write(conexion13.responseText);
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