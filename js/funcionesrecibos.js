addEventListener('load',inicializarEventos,false);
window.addEventListener('keydown', btnkeydown, false);

var nCom;
var editableGrid;
var editableGridTemp;
var nFilaa;
var nombreCliente;
var nombreEmpresa;
var lineaArtic;
var esMio;
var palabras0;
var palabras1;

function inicializarEventos()
{
	listarRecibosMios();
	llenarAccionesReciboJS();
	document.getElementById('botonSeleccionarComprobante').addEventListener('click',agregaFacturaaRecibo,false); 
	document.getElementById('cierralistaFacturas').addEventListener('click',cerrarVentanalistaFacturas,false); 
	document.getElementById('cierrapreguntoDeudaOTipoCambio').addEventListener('click',cerrarVentanaDeudaOTipoCambio,false); 
	document.getElementById('cierraMovsAgPago').addEventListener('click',cerrarVentanaNuevoPago,false); 



	//exRemitos
	document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false); 
	document.getElementById('cierraAgregarIt').addEventListener('click',cerrarVentanaAgregaIt,false); 
	document.getElementById('itemABuscar').addEventListener('keypress',teclaEnter,false);
	document.getElementById('botonBuscarArticuloEnRemito').addEventListener('click',busco,false);

	
}

var conexion11;
function llenarInformeReciboJS(){
  conexion11=new XMLHttpRequest(); 
  conexion11.onreadystatechange = procesarEventos11;
  var aleatorio=Math.random();
  conexion11.open('GET','./php/llenar_informe_recibo.php?&rnadom='+aleatorio, true);
  conexion11.send();
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 
		  document.getElementById('informeRecibo').innerHTML=conexion11.responseText;
		  //habilito la funcion del boton "Informe"
		  document.getElementById('informe').addEventListener('click',imprimir,false);
	  }
  } 
}

var conexion7;
var conexion3_2019;
function imprimir() {
	document.getElementById('informe').disabled=true;
	//Primero tengo que ver si la suma de las facturas y la suma de los pagos dan igual. Sino no sigo
	var sumaFacturas=document.getElementById('totalFacturas').value;
	var sumaPagos=document.getElementById('totalValores').value;
	if (sumaFacturas!=sumaPagos)
		{//NO son iguales
			mostrarAvisos("TOTAL A CANCELAR y TOTAL PAGOS no coinciden. Deben ser iguales.");
			document.getElementById('informe').disabled=false;
		} else {
			//son iguales
			//document.getElementById('NumeroComprobante');
			var numRemit=document.getElementById('NumeroComprobante');
			//alert(numRemit.value);
			var aleatorio=Math.random();
			var direccionEmpresa=document.getElementById('direcRemito').value;
			esMio=document.getElementById('soyyoono').value;
			if (esMio == '0') {
				//Recibo YA generado, o el recibo NO es mio, en ambos casos, sólo puedo emitir el informe
				//Lo pongo fuera del IF porque de todas maneras lo voy a ejecutar
				} else {
				//Recibo NO generado, Y el recibo es mio, si se suman ambos casos, cargo los pagos a cada una de las facturas, y además emito el informe
					conexion3_2019=new XMLHttpRequest(); 
					conexion3_2019.onreadystatechange = procesarEventos3_2019;
					var aleatorio_2019=Math.random();
					conexion3_2019.open('GET','./php/agrego_pago_a_factura_por_recibo.php?idrecibo='+numRemit.value+'&rnadom='+aleatorio_2019, true);
					conexion3_2019.send();
				}
			window.open('./informes/Informe.php?idrecibo='+numRemit.value+"&rnadom="+aleatorio+"&direcc="+direccionEmpresa+"&tipoInforme=Recibo");
			document.getElementById('informe').disabled=false;
		}  
}

function procesarEventos3_2019()
{
    if(conexion3_2019.readyState == 4)
  { 
	  if(conexion3_2019.status == 200)
	  { 
			if (conexion3_2019.responseText=="Todos los pagos agregados correctamente"){actualizArticuloRemit();}
			alert(conexion3_2019.responseText);
			
		}
	}
}

var conexion301;
function listarRecibosMios(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion301=new XMLHttpRequest(); 
  conexion301.onreadystatechange = procesarEventos301;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion301.open('GET','./php/llenar_listado_recibos_MIOS.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion301.send();
}

function procesarEventos301()
{
    if(conexion301.readyState == 4)
  { 
	  if(conexion301.status == 200)
	  { 
		  var datosc=document.getElementById('listaComprobantes');
		  datosc.innerHTML=conexion301.responseText;
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('xxxxrt');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetalles,false);
				r=ii;
		  } 
	        //listar todos los remitos MIOS Y NO MIOS
			document.getElementById('listarTodos').addEventListener('click',llenarListadoRecibosJS,false); 
	  }
  } 

}

var conexion1;
function llenarListadoRecibosJS(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1.open('GET','./php/llenar_listado_recibos.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('listaComprobantes').innerHTML=conexion1.responseText;
		  //listar todos los Recibos MIOS
		  document.getElementById('listarMios').addEventListener('click',listarRecibosMios,false); 
		  var tags_td = new Array();
		  var tags_td=document.getElementsByName('xxxxrt');
		  var r=0;
		  for (i=0; i<tags_td.length; i++) {
				tags_td[i].addEventListener('click',mostrarDetalles,false);
				r=i;
		  } 
	  }
  } 

}

var conexion4;
var conexion5;
var conexion2019_5;
function mostrarDetalles(celda){
	document.getElementById('informeRecibo').innerHTML="";
if (isNaN(celda))
  {
	if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
    var numeroComprobante=celda.target.id;
  }
  else
  {
	var numeroComprobante=celda; 
  }
	nCom=numeroComprobante;
	//alert(numeroComprobante);
  //el encabezado del recibo
  document.getElementById('portada').innerHTML="";
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion4.open('GET','./php/llenar_encabezado_un_recibo.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion4.send();
  // el detalle defacturas del recibo (LIQUIDACION)
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  aleatorio=Math.random();
  conexion5.open('GET','./php/llenar_detalle_recibo.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
	conexion5.send();
  // el detalle de pagos del recibo (VALORES)
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion2019_5=new XMLHttpRequest(); 
  conexion2019_5.onreadystatechange = procesarEventos2019_5;
  aleatorio=Math.random();
  conexion2019_5.open('GET','./php/llenar_detalle_recibo_VALORES.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
	conexion2019_5.send();
	llenarInformeReciboJS();
}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 
		//mostrarAvisos(conexion4.responseText);
		document.getElementById('portada').innerHTML=conexion4.responseText;
		  	//$(document).ready(function() {
			//  $("#CondicionesPago").select2();
			  //$("#CondicionesPago").select2("open");
			//});

			
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
			esMio=document.getElementById('soyyoono').value;
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRecibo,false); 
		  if (datosce.value == '1') {
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRecibo,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRecibo,false);
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRecibo,false); 	
			  } else {	  
					document.getElementById('asignarmeRemit').addEventListener('click',asignarmeRemito,false); 	
		  };}, 100);		  
	  }
  } 

}




function procesarEventos2019_5()
{
    if(conexion2019_5.readyState == 4)
  { 
	  if(conexion2019_5.status == 200)
	  { 
		  document.getElementById('detallesdevalores').innerHTML=conexion2019_5.responseText;
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
		  //alert("no se refresca el valor si actualicé al articulo!");
		  //alert("le cambio la moneda y tampoco");
		  if (datosce.value == '1') {
			  //si soy yo, permito editar la tabla (P para Recibos)
			  //Lo hago solo para los xxxxt, ya que los xxxxtn no son editables.
			  var tags_td_camb = new Array();
  			  var tags_td_camb = document.getElementsByName('xxxxtp');
			  for (i=0; i<tags_td_camb.length; i++) {
						tags_td_camb[i].addEventListener('change',cambioUnPagoRecibo,false);
				};
			  var tags_td_cambE = new Array();
  			  var tags_td_cambE = document.getElementsByName('xxxxtp');
			  for (i=0; i<tags_td_cambE.length; i++) {
						tags_td_cambE[i].addEventListener('keypress',teclaEnterTab,false);
				};
			  //un click en el boton de la cruz borra la linea (P para Recibos)
			  var tags_td_elim = new Array();
  			  var tags_td_elim = document.getElementsByName('xxxxxp');
			  for (i=0; i<tags_td_elim.length; i++) {
						tags_td_elim[i].addEventListener('click',borrarPagoRecibo,false);
				};
			
				//un click en el boton del tilde refresca la tabla (P para Recibos)
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxyp');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',actualizArticuloRemit,false);
				};
			  //un click en el boton del tilde EN LA ULTIMA LINEA agrega un item (P para Recibos)
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxzp');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',agregoPagoARecibo,false);			
				};								
				};}, 100);
		}
	}
}

function cambioUnPagoRecibo(celda)
{
	//Tengo que ver que eventos del viejo transfEnEditable me van a servir
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[2];
	  switch(numeroartic){
			case "totalPago":
			  //El cliente modificó el importe a cancelar
				campoAEditar="Importe";
				modificarPagoTablaDetalleComprobante(palabras[0],campoAEditar,parseFloat(celda.target.value));
				break;

				//El cliente modificó el tipo de cambio, tengo que guardar ese y ademas el subtotal, el importe a cancelar queda sin tocar
			case "descripcionPago":
				campoAEditar="Descripcion";
				modificarPagoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				break;
	  };
}

var conexionR20;
function modificarPagoTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexionR20=new XMLHttpRequest(); 
	conexionR20.onreadystatechange = procesarEventosR20;
	var aleatorio=Math.random();
	conexionR20.open('GET','./php/actualizo_detalle_recibo_pago.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexionR20.send();
	//NOOOO DEBO actualizar automaticamente!! DEBO RECIBIR UN JSON Y GRABARLO EN EL CAMPO. VER FUNCION modificarArticuloDivAgregaArt
	setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function procesarEventosR20()
{
    if(conexionR20.readyState == 4)
  { 
	  if(conexionR20.status == 200)
	  { 
		//mostrarAvisos(conexionR20.responseText);
		document.getElementById('portada').innerHTML=datosc.innerHTML+conexionR20.responseText;
	  }
  } 
}



function agregoPagoARecibo(){
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('nuevoItem').style.visibility='visible';
	transfEnEditableNueva();
	cargarFaltanteDePago();
	var tags_td_acept = new Array();
	  var tags_td_acept = document.getElementsByName('xxxxA');
	  for (i=0; i<tags_td_acept.length; i++) {
				tags_td_acept[i].addEventListener('click',agregaItemNuevo,false);
	};
}


var conexionR7;
function agregaItemNuevo(celda){
	var datosc=document.getElementById('00&Importe');
	//alert(editableGridTemp.getValueAt(0, 0));
	//primero agrego un nuevo articulo al comprobante actual (de la variable global nCom)
	conexionR7=new XMLHttpRequest(); 
	conexionR7.onreadystatechange = procesarEventosR7;
	var aleatorio=Math.random();
	//defino los campos a enviar
	var cadena="idcomprobante="+nCom;
	//alert(cadena);
	if ((isNaN(parseFloat(editableGridTemp.getValueAt(0, 3))))||(editableGridTemp.getValueAt(0, 0) == null)||(editableGridTemp.getValueAt(0, 1) == null)||(editableGridTemp.getValueAt(0, 2) == null)||(parseFloat(editableGridTemp.getValueAt(0, 3))<0.001)||(isNaN(parseFloat(editableGridTemp.getValueAt(0, 1))))){
			mostrarAvisos("Faltan datos!")
	  } else {
				//campo 0. Fecha
			  cadena=cadena+"&Fecha="+editableGridTemp.getValueAt(0,0);	
			  //campo 1. Forma de pago
			  cadena=cadena+"&TipoValor="+editableGridTemp.getValueAt(0, 1);
			  //campo 2. Moneda.
			  cadena=cadena+"&MonedaPago=1";
			  //alert (cadena);
			  //campo 3. Importe.
			  cadena=cadena+"&Importe="+editableGridTemp.getValueAt(0, 3);
			  //campo 4. Descripcion.
			  cadena=cadena+"&Descripcion="+editableGridTemp.getValueAt(0, 4);
				//ESTE PHP LO VOY A TENER QUE CAMBIAR
				//alert(cadena);
			  cadena='./php/agrego_pago_a_recibo.php?'+cadena+"&rnadom="+aleatorio
				//alert(cadena);
				editableGridTemp.setValueAt(0, 0, '','true');
				editableGridTemp.setValueAt(0, 1, '','true');
				editableGridTemp.setValueAt(0, 2, '$','true');
				editableGridTemp.setValueAt(0, 3, '','true');
				editableGridTemp.setValueAt(0, 4, '','true');

			  conexionR7.open('GET',cadena, true);
			  conexionR7.send();
			  
	  }
}

function procesarEventosR7()
{
    if(conexionR7.readyState == 4)
  { 
	  if(conexionR7.status == 200)
	  {
			document.getElementById('fondoClaro').style.visibility='hidden';
			document.getElementById('nuevoItem').style.visibility='hidden';
			mostrarDetalles(nCom);
		}
	}
}

function cargarFaltanteDePago(){
	editableGridTemp.setValueAt(0, 2, '$','true');
}

function transfEnEditableNueva()
{
        editableGridTemp = new EditableGrid("DemoGridAttach",{// called when some value has been modified: actualizo la BD
			  modelChanged: function(rowIdx, colIdx, oldValue, newValue, row) { 
			  // todas las acciones a realizar al cambiar un campo
				var campoAEditar="";
				//editableGridTemp.setValueAt(0, 2, '$','true');
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
					  	{ 8 : "Efectivo", 12 : "Cheque", 13 : "Tarjeta de débito", 14 : "Tarjeta de crédito", 15 : "Transferencia bancaria", 16 : "Nota de crédito", 20 : "Otro"}  },
					{ name: "MonedaPago", datatype: "double", editable: false, values: 
					  	{ 1 : "$", 2 : "USD", 61 : "€"} },
					{ name: "Importe", datatype: "double(2)", editable: true },
					{ name: "Descripcion", datatype: "string", editable: true }
				]});
				// then we attach to the HTML table and render it
				editableGridTemp.attachToHTMLTable('tablaDetallePagoNuev');
				editableGridTemp.renderGrid();
			} 
			

function procesarEventos5()
{
    if(conexion5.readyState == 4)
  { 
	  if(conexion5.status == 200)
	  { 
		  document.getElementById('detallesdecomprobante').innerHTML=conexion5.responseText;
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
		  //alert("no se refresca el valor si actualicé al articulo!");
		  //alert("le cambio la moneda y tampoco");
		  if (datosce.value == '1') {
			  //si soy yo, permito editar la tabla
			  //Lo hago solo para los xxxxt, ya que los xxxxtn no son editables.
			  var tags_td_camb = new Array();
  			  var tags_td_camb = document.getElementsByName('xxxxt');
			  for (i=0; i<tags_td_camb.length; i++) {
						tags_td_camb[i].addEventListener('change',cambioUnComprobRecibo,false);
				};
			  var tags_td_cambE = new Array();
  			  var tags_td_cambE = document.getElementsByName('xxxxt');
			  for (i=0; i<tags_td_cambE.length; i++) {
						tags_td_cambE[i].addEventListener('keypress',teclaEnterTab,false);
				};
			  //un click en el boton de la cruz borra la linea
			  var tags_td_elim = new Array();
  			  var tags_td_elim = document.getElementsByName('xxxxx');
			  for (i=0; i<tags_td_elim.length; i++) {
						tags_td_elim[i].addEventListener('click',borrarComprobanteRecibo,false);
				};
			
			  //un click en el boton del tilde refresca la tabla
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxy');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',actualizArticuloRemit,false);
				};
			  //un click en el boton del tilde EN LA ULTIMA LINEA agrega un item
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxz');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',agregoComprobanteARecibo,false);			
				};								
				};}, 100);
	  }
  } 

}

var conexion121;
function asignarmeRemito(){
	if (confirm("Seguro que desea asignarse este recibo a su nombre?")== true){
		conexion121=new XMLHttpRequest(); 
		conexion121.onreadystatechange = procesarEventos121;
		var aleatorio=Math.random();
		var obnn=document.getElementById('numberses').value;
		//uso el de presupuesto porque es igual
		conexion121.open('GET','./php/cambiar_responsable_a_presupuesto.php?idpresup='+nCom+"&rnadom="+aleatorio+"&sesses="+obnn, true);
		conexion121.send();
	  } else {
		  mostrarAvisos("No asignado");
	  }
}

function procesarEventos121()
{
    if(conexion121.readyState == 4)
  { 
	  if(conexion121.status == 200)
	  { 
		setTimeout(function(){mostrarDetalles(nCom)}, 100);
	  }
  } 
}

var conexion25;
var conexion25a;
function borrarComprobanteRecibo(celda){
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if(confirm("Borrar el comprobante de este recibo?")== true) {
		conexion25=new XMLHttpRequest(); 
		conexion25.onreadystatechange = procesarEventos25;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		conexion25.open('GET','./php/borro_comprobante_detalle_recibo.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio, true);
		conexion25.send();	
		//DEBO actualizar automaticamente
		setTimeout(function(){mostrarDetalles(nCom)}, 500);
	}
}

function procesarEventos25()
{
    if(conexion25.readyState == 4)
  { 
	  if(conexion25.status == 200)
	  { 
		mostrarAvisos(conexion25.responseText);
	  }
  } 
}

var conexionR25;
function borrarPagoRecibo(celda){
	var ambosid=celda.target.id;
	//alert(ambosid);
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if(confirm("Borrar el pago de este recibo?")== true) {
		conexionR25=new XMLHttpRequest(); 
		conexionR25.onreadystatechange = procesarEventosR25;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		conexionR25.open('GET','./php/borro_pago_detalle_recibo.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio, true);
		conexionR25.send();	
		//DEBO actualizar automaticamente
		setTimeout(function(){mostrarDetalles(nCom)}, 500);
	}
}

function procesarEventosR25()
{
    if(conexionR25.readyState == 4)
  { 
	  if(conexionR25.status == 200)
	  { 
		mostrarAvisos(conexionR25.responseText);
		setTimeout(function(){mostrarDetalles(nCom)}, 500);
	  }
  } 
}


function ponerItemEncontradoEnVentanaAgregar(celda){
	if (!isNaN(celda)){
		//el numero en celda es el id del articulo que elegi
		//Agregar el item directamente a la tabla DETALLECOMPROBANTE
		agregaItemNuevoV2(celda);
	}
}

var conexion1101;
function agregaItemNuevoV2(celda){
	//alert("1196 "+celda);
	//return false;
	//primero agrego un nuevo articulo al comprobante actual (de la variable global nCom)
	conexion1101=new XMLHttpRequest(); 
	//conexion1101.onreadystatechange = procesarEventos1101;
	var aleatorio=Math.random();
	//defino los campos a enviar
	var cadena="idcomprobante="+nCom;
	  cadena='./php/agrego_detalle_remito_articulo.php?'+cadena+"&rnadom="+aleatorio
	  //alert(cadena);
	  //campo 0. Orden
	  cadena=cadena+"&Orden=999";			  
	  //campo 1. Codigo Articulo. El if esta arriba
	  cadena=cadena+"&IdProducto="+celda;
	  conexion1101.open('GET',cadena, true);
	  conexion1101.send();
	  mostrarDetalles(nCom);	
}

var conexion1_2019;
function agregoComprobanteARecibo(){
	conexion1_2019=new XMLHttpRequest(); 
	conexion1_2019.onreadystatechange = procesarEventos1_2019;
	var aleatorio=Math.random();
	document.getElementById('listaFacturasFRMSup').innerHTML="";
	document.getElementById('listaFacturasFRMInf').innerHTML="";
	document.getElementById('botonSeleccionarComprobante').disabled=true;
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('listaFacturas').style.visibility='visible';
	//Buscar los comprobantes "positivos" de esta empresa
	//alert(nCom);
	conexion1_2019.open('GET','./php/buscar_cuit_x_comprobante_idEmpresa.php?idcomp='+nCom+'&rnadom='+aleatorio, true);
	conexion1_2019.send();
}

var conexion2_2019;
function procesarEventos1_2019()
{
    if(conexion1_2019.readyState == 4)
  { 
	  if(conexion1_2019.status == 200)
	  {
			conexion2_2019=new XMLHttpRequest(); 
			conexion2_2019.onreadystatechange = procesarEventos2_2019;
			var aleatorio=Math.random();	
			conexion2_2019.open('GET','./php/buscar_facturas_x_cuit_Recibo.php?cuitemp='+conexion1_2019.responseText+'&rnadom='+aleatorio, true);
			conexion2_2019.send();
		}
	}
}


function procesarEventos2_2019()
{
    if(conexion2_2019.readyState == 4)
  { 
	  if(conexion2_2019.status == 200)
	  { 	
		  var datosc=document.getElementById('listaFacturasFRMSup');
		  datosc.innerHTML=conexion2_2019.responseText;	
		  document.getElementById('listaFacturasFRMInf').innerHTML="";
		  //document.getElementById('xxxxB').addEventListener('click',buscarDatosEmpresa,false);			  
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('FilaFactura');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetallesParaRecibo,false);
				r=ii;
		  }
	  }
  } 
}

var conexion5_2019;
var nComNC;
function mostrarDetallesParaRecibo(celda){
	//alert(celda);
	//alert(celda.target.id);
if (isNaN(celda))
  {
	if(!isNaN(nComNC)){if(!(document.getElementById(nComNC)==null)){document.getElementById(nComNC).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
		var numeroComprobante=celda.target.id;
		document.getElementById('botonSeleccionarComprobante').disabled=false;
		document.getElementById('botonSeleccionarComprobante').addEventListener('click',agregaFacturaaRecibo,false); 
  }  else
  {
	var numeroComprobante=celda; 
  }
	nComNC=numeroComprobante;
	//alert(nComNC);
  // el detalle del presupuesto
  conexion5_2019=new XMLHttpRequest(); 
  conexion5_2019.onreadystatechange = procesarEventos5_2019;
  var aleatorio=Math.random();
  //ESTE PHP LO VOY A TENER QUE CAMBIAR
  conexion5_2019.open('GET','./php/llenar_detalle_pagos_factura.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
  conexion5_2019.send();
}

var conexion408_2019;
function agregaFacturaaRecibo()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('listaFacturas').style.visibility='hidden';
	//ver que falta de la línea que no funciona. seguramente algo local.
	conexion408_2019=new XMLHttpRequest(); 
	conexion408_2019.onreadystatechange = procesarEventos408_2019;
	var aleatorio=Math.random();
	//alert(nComNC);
	//var dirRecibo=document.getElementsByName('xxxxrt');
	//alert(nCom);
	//Agregar la factura a la tabla DETALLEcomprobante
	//nCom es el id del comprobante
	//nComNC va en idProducto
	//Orden NO, los ordeno por fecha de la factura
	//Moneda (del comprobante, que en definitiva es la moneda en la que lo voy a cancelar) en Moneda
	//Pendiente en CostoUnitario (guardo el monto en moneda original, no en pesos)
	//Tipo de cambio en Descuento (por el tipo de campo, creo que es int)
	//Subtotal (en pesos) en Subtotal
	//Tengo que avisar que es una factura (ya que en la misma tabla van tambien los pagos)
	conexion408_2019.open('GET','./php/agrego_detalle_recibo_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nComNC+"&idRecibo="+nCom, true);
	conexion408_2019.send();
}

function procesarEventos408_2019()
{
    if(conexion408_2019.readyState == 4)
  { 
	  if(conexion408_2019.status == 200)
	  { 
			//mostrarAvisos(conexion408_2019.responseText);
			setTimeout(function(){mostrarDetalles(nCom);}, 100);
	  }
  }
}


function procesarEventos5_2019()
{
    if(conexion5_2019.readyState == 4)
  { 
	  if(conexion5_2019.status == 200)
	  { 
		  var datosc=document.getElementById('listaFacturasFRMInf');
		  datosc.innerHTML=conexion5_2019.responseText;
	  }
  }
}

function cerrarVentanalistaFacturas()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('listaFacturas').style.visibility='hidden';
}

function cerrarVentanaDeudaOTipoCambio()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('preguntoDeudaOTipoCambio').style.visibility='hidden';
	setTimeout(function(){mostrarDetalles(nCom);}, 100);
}


var conexion12;
function llenarAccionesReciboJS(){
  //var numeroComprobante=celda.target.id;
  //el encabezado del remito
  conexion12=new XMLHttpRequest(); 
  conexion12.onreadystatechange = procesarEventos12;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion12.open('GET','./php/llenar_acciones_recibos.php?rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion12.send();


}
function procesarEventos12()
{
    if(conexion12.readyState == 4)
  { 
	  if(conexion12.status == 200)
	  { 
		document.getElementById('acciones').innerHTML=conexion12.responseText;
		  //acciones para el boton nuevo remito
		document.getElementById('nuevoRecibo').addEventListener('click',mostrarDescolgableListadoEmpresas,false); 
	  }
  } 

}

var conexion13;
function mostrarDescolgableListadoEmpresas(){
  conexion13=new XMLHttpRequest(); 
  conexion13.onreadystatechange = procesarEventos13;
  var aleatorio=Math.random();
  conexion13.open('GET','./php/llenar_listado_empresas_cuit_recibos.php?&rnadom='+aleatorio, true);
  conexion13.send();
}

var conexion16;
function guardaCambiosEncabezadoRecibo()
{
	
	//AHORA SOLO ME FALTA GRABAR LOS CAMBIOS!!
	var numRemit=document.getElementById('NumeroComprobante').value;
	var numSolicit=document.getElementById('Solicita').value;
	var numCPago=document.getElementById('CondicionesPago').value;
	var txtNotas=encodeURIComponent(document.getElementById('Notas').value);
	var txtPreimpreso=encodeURIComponent(document.getElementById('preimpreso').value);	
	//Febrero2019
	var txtNumFac="";	
	
	conexion16=new XMLHttpRequest(); 
    conexion16.onreadystatechange = procesarEventos16;
    var aleatorio=Math.random();
		var obnn=document.getElementById('numberses').value;
	conexion16.open('GET','./php/actualizo_encabezado_recibo.php?numrecibo='+numRemit+"&rnadom="+aleatorio+"&sesses="+obnn+"&solicitaa="+numSolicit+"&numCcPago="+numCPago+"&textNotas="+txtNotas+"&textPreimpreso="+txtPreimpreso+"&textNumFac="+txtNumFac, true);
    conexion16.send();
}  
 
function procesarEventos16()
{
    if(conexion16.readyState == 4)
  { 
	  if(conexion16.status == 200)
	  { 
		//mostrarAvisos(conexion16.responseText);
		  //document.getElementById('portada').innerHTML=document.getElementById('portada').innerHTML + conexion16.responseText;
		  var obnpra=document.getElementById('NumeroRemitoRecienActualizado').innerHTML;
		  mostrarDetalles(obnpra);
		  //document.getElementById('cambiaDatos').addEventListener('click',habilitarDetallesEncabezadoRemito,false); 
		  //document.getElementById('aceptarCambiaDatos').addEventListener('click',guardaCambiosEncabezadoRecibo,false); 
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRecibo,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRecibo,false);
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRecibo,false); 	
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRecibo,false);   
	  }
  } 

} 


var tipoComprobante="Recibo";
function procesarEventos13()
{
    if(conexion13.readyState == 4)
  { 
	  if(conexion13.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion13.responseText;
		  	$(document).ready(function() {$("#empresaNombre").select2();
			  															$("#empresaNombre").select2("open");});
		  //habilito la funcion del boton "Listo"
		  //agregarUnNuevoComprobanteRecibo ahora esta en funcionescomunes.js
			document.getElementById('listoNuevoRe').addEventListener('click',agregarUnNuevoComprobanteRecibo,false); 
	  }
  } 

}
//agregarUnNuevoComprobanteRecibo ahora esta en funcionescomunes.js
function procesarEventos14()
{
    if(conexion14.readyState == 4)
  { 
	  if(conexion14.status == 200)
	  { 
			document.getElementById('acciones').innerHTML=conexion14.responseText;
		  //acciones para el boton nuevo remito
			document.getElementById('nuevoRecibo').addEventListener('click',mostrarDescolgableListadoEmpresas,false);
		  //actualizo los otros DIV
		  llenarListadoRecibosJS();
		  var obnprc=document.getElementById('NumeroRemitoRecienCreado').innerHTML;
		  mostrarDetalles(obnprc);
		  setTimeout(function(){mostrarDetallesReciboNuevo(obnprc);
			if(!isNaN(nCom)){document.getElementById(nCom).style.backgroundColor="transparent";}
			document.getElementById(obnprc).style.backgroundColor="#809fff";}, 1000);
	  }
  } 

}

var conexion15;
function mostrarDetallesReciboNuevo(celda){
  var numeroComprobante=celda;
  //el encabezado del remito
  conexion15=new XMLHttpRequest(); 
  conexion15.onreadystatechange = procesarEventos15;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion15.open('GET','./php/llenar_encabezado_un_reciboNUEVO.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion15.send();
  // el detalle del remito en este caso no va porque es un remito nuevo y entonces esta en blanco
}
  
function procesarEventos15()
{
    if(conexion15.readyState == 4)
  { 
	  if(conexion15.status == 200)
	  { 
			document.getElementById('portada').innerHTML=conexion15.responseText;
			guardaCambiosEncabezadoRecibo();
		  //document.getElementById('cambiaDatos').addEventListener('click',habilitarDetallesEncabezadoRemito,false); 
		  //document.getElementById('aceptarCambiaDatos').addEventListener('click',guardaCambiosEncabezadoRecibo,false); 
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRecibo,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRecibo,false);
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRecibo,false); 	
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRecibo,false); 	
	  }
  } 
}
	
var nuevoAdescontarA;
var nuevoTipoCambioA;
var nuevoAdescontarB;
var nuevoTipoCambioB;
var nuevoSubTotal;
var elRecibo;
function cambioUnComprobRecibo(celda)
{
	//Tengo que ver que eventos del viejo transfEnEditable me van a servir
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[2];
	  switch(numeroartic){
			case "pendienteFacturaitem":
			  //El cliente modificó el importe a cancelar, tengo que guardar ese y ademas el subtotal, el tipo de cambio queda sin tocar
				campoAEditar="CostoUnitario";
				//este no anda como quiero. pero por ahora me lo salteo para seguir avanzando.
				//Se cambio el pendiente, lo que cambia son 2 cosas, el pendiente propiamente dicho y 
				//el subtotal en pesos (pendiente*tipocambio)
				//alert(celda.target.value);
				modificarArticuloTablaDetalleComprobante(palabras[0],campoAEditar,parseFloat(celda.target.value));
				//Ahora grabo el subtotal en pesos
				campoAEditar="Subtotal";
				//alert(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value);
				var nuevoSubotal=parseFloat(celda.target.value)*parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value);
				modificarArticuloTablaDetalleComprobante(palabras[0],campoAEditar,nuevoSubotal);
			break;

				//El cliente modificó el tipo de cambio, tengo que guardar ese y ademas el subtotal, el importe a cancelar queda sin tocar
			case "cambioitem":
				campoAEditar="Descuento";
				//este no anda como quiero. pero por ahora me lo salteo para seguir avanzando.
				//Se cambio el pendiente, lo que cambia son 2 cosas, el pendiente propiamente dicho y 
				//el subtotal en pesos (pendiente*tipocambio)
				//alert(celda.target.value);
				modificarArticuloTablaDetalleComprobante(palabras[0],campoAEditar,parseFloat(celda.target.value));
				//Ahora grabo el subtotal en pesos
				campoAEditar="Subtotal";
				//alert(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value);
				var nuevoSubotal=parseFloat(celda.target.value)*parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&pendienteFacturaitem&E').value);
				modificarArticuloTablaDetalleComprobante(palabras[0],campoAEditar,nuevoSubotal);
			break;

				//El cliente modificó el subtotal, aca tengo 2 opciones a preguntar al cliente: cambio el tipo de cambio o el importe a cancelar? Lo pregunto al usuario y luego grabo ambos (subtotal si o si, y lo que me diga el cliente).
				//PERO SIEMPRE Y CUANDO EL TIPO DE CAMBIO NO SEA 1!! SINO AL PEDO PREGUNTAR
			case "subtotitem":
				nuevoSubTotal=parseFloat(celda.target.value);
				elRecibo=palabras[0];
				if (document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value==1){
					//TC=1 o sea pesos
					nuevoAdescontarA=parseFloat(celda.target.value);
					nuevoTipoCambioA=1;
					cambioSubTotal();
				} else {
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML="<br>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<strong>Acaba de modificar el sub total en pesos a cancelar, debe seleccionar si este cambio afectará al importe a cancelar de la factura, o al tipo de cambio a utilizar.</strong>";
						
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<br>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<br>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<legend>Modificar el importe a cancelar de la factura:</legend>";
						
						nuevoAdescontarA=parseFloat(celda.target.value)/parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value);
						nuevoTipoCambioA=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value);
						
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<input type='radio' id='radio11111' name='chkModificaImporteOTipoCambio' checked> $ "+parseFloat(celda.target.value).toFixed(2)+" = (<strike>"+parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&pendienteFacturaitem&E').value).toFixed(2)+"</strike>) "+parseFloat(nuevoAdescontarA).toFixed(2)+" * "+parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value).toFixed(2)+"</option>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<br>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<br>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<legend>Modificar el tipo de cambio a utilizar:</legend>";
						
						nuevoTipoCambioB=parseFloat(celda.target.value)/parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&pendienteFacturaitem&E').value);
						nuevoAdescontarB=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&pendienteFacturaitem&E').value);
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<input type='radio' id='radio11112' name='chkModificaImporteOTipoCambio'> $ "+parseFloat(celda.target.value).toFixed(2)+" = "+parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&pendienteFacturaitem&E').value).toFixed(2)+" * (<strike>"+parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cambioitem&E').value).toFixed(2)+"</strike>) "+parseFloat(nuevoTipoCambioB).toFixed(2)+"</option>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"</fieldset>";
						document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML=document.getElementById("preguntoDeudaOTipoCambioFRMSup").innerHTML+"<br>";
						
						//Luego muestro la ventana de pregunta
						document.getElementById('fondoClaro').style.visibility='visible';
						document.getElementById('preguntoDeudaOTipoCambio').style.visibility='visible';
						//Si el usuario presiona el botn seleccionar sigo con el guardado de datos
						document.getElementById('botonDeudaOTipoCambio').addEventListener('click',cambioSubTotal,false); 
				}
				break;


	  };
}

function cambioSubTotal(){
				//Ahora si llamo a la funcion que graba en la base de datos. Grabo los 3 y listo.
				//Pregunto que opción vale
				//alert(nuevoAdescontarA);
				if ((nuevoTipoCambioA==1)||(document.getElementById('radio11111').checked)) {
						var nuevoAdescontar=nuevoAdescontarA;
						var nuevoTipoCambio=nuevoTipoCambioA;
				} else {
					var nuevoAdescontar=nuevoAdescontarB;
					var nuevoTipoCambio=nuevoTipoCambioB;			
				}
				//Empiezo por el que guardó el usuario
				campoAEditar="Subtotal";
				modificarArticuloTablaDetalleComprobante(elRecibo,campoAEditar,nuevoSubTotal);
				//sigo por el nuevo importe a cancelar
				campoAEditar="CostoUnitario";
				modificarArticuloTablaDetalleComprobante(elRecibo,campoAEditar,nuevoAdescontar);
				//por ultimo el tipo de cambio
				campoAEditar="Descuento";
				modificarArticuloTablaDetalleComprobante(elRecibo,campoAEditar,nuevoTipoCambio);
				//Oculto la ventana
				document.getElementById('fondoClaro').style.visibility='hidden';
				document.getElementById('preguntoDeudaOTipoCambio').style.visibility='hidden';
}


var conexion20;
function modificarArticuloTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion20=new XMLHttpRequest(); 
	conexion20.onreadystatechange = procesarEventos20;
	var aleatorio=Math.random();
	conexion20.open('GET','./php/actualizo_detalle_recibo_factura.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion20.send();
	//NOOOO DEBO actualizar automaticamente!! DEBO RECIBIR UN JSON Y GRABARLO EN EL CAMPO. VER FUNCION modificarArticuloDivAgregaArt
	setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function procesarEventos20()
{
    if(conexion20.readyState == 4)
  { 
	  if(conexion20.status == 200)
	  { 
		//mostrarAvisos(conexion20.responseText);
		document.getElementById('portada').innerHTML=datosc.innerHTML+conexion20.responseText;
	  }
  } 
}

function cerrarVentanaNuevoPago()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('nuevoItem').style.visibility='hidden';
}


function teclaEnterTab(e)
{//ESte todavia no anda. No logro leer los tabindex de los items. tendre que asignarselos yo?
       if (e.keyCode == 13) {
		   	
           cb = parseInt($(this).attr('tabindex'));
    //alert(cb);
           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
               $(':input[tabindex=\'' + (cb + 1) + '\']').focus();
               $(':input[tabindex=\'' + (cb + 1) + '\']').select();
               e.preventDefault();
    
               return false;
           }
       }
}


function cerrarVentanaAgregaIt()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function actualizArticuloRemit(celda){
	//antes deberia releer y regrabar todos los campos!! (sino hay datos que no se actualizan salvo que modifique 2 veces un descuento)
		mostrarDetalles(nCom);
}

function btnkeydown(event)
{
	//Algunos navegadores usan which y otros charCode, asi que tengo que poner este if y usar KeyCode en lugar de event.charCode
	var KeyCode = event.KeyCode ? event.KeyCode : event.which ? event.which : event.charCode;

	if (KeyCode==13)
	{
		if (document.activeElement.name=="xxxxt")
		{
			var tags_td = new Array();
		  var tags_td=document.getElementsByName('xxxxt');
			var r=0;
			var ae=document.activeElement.id;
			for (i=0; i<tags_td.length; i++) {
				if (ae==tags_td[i].id){
					r=i;
					r++;
					tags_td[r].focus(); }
		  } 			
		}
	}

	if (event.ctrlKey) {	
	
		if (KeyCode==65)
		{
			event.preventDefault();
			if (!isNaN(nCom)){agregoComprobanteARecibo()};
		}
		}
}


function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);
}























//exRemitos
function teclaEnter(e){
  var tecla=e.which;
  if(tecla==13)
  {
    e.preventDefault();
    busco();
  }  
}

function busco(){ 
  //var seleccion=document.getElementById('ordenPor');
  var criterio=document.getElementById('itemABuscar');

  //var tabla = document.getElementById('tablaArticulos');
  //var rowCount = tabla.rows.length; 
  //while(--rowCount) tabla.deleteRow(rowCount);
  cambiarDatos("1", criterio.value);
}

var conexion31;
function cambiarDatos(orden, datoABuscar){
  conexion31=new XMLHttpRequest(); 
  conexion31.onreadystatechange = procesarEventos31;
  var aleatorio=Math.random();
  conexion31.open('GET','./php/buscoarticulo.php?orden='+orden+"&busqueda="+datoABuscar+"&rnadom="+aleatorio, true);
  conexion31.send();
}

function procesarEventos31(){
    if(conexion31.readyState == 4)
  {
	  if(conexion31.status == 200)
	  {
		  document.getElementById('agregarItemAlComprobanteFRMSup').innerHTML=conexion31.responseText;
		  var tags_td = new Array();
		  var tags_td=document.getElementsByName('xxxxb');
		  var clickCount = 0;
		  for (i=0; i<tags_td.length; i++) {
					tags_td[i].addEventListener('click',function(i) {
					clickCount++;
					if (clickCount === 1) {
						singleClickTimer = setTimeout(function() {
							clickCount = 0;
							mostrarDetallesItemEnRemit(i);
						}, 300);
					} else if (clickCount === 2) {
						clearTimeout(singleClickTimer);
						clickCount = 0;
						//alert(i.target.id);
						//aca deberia cargar el articulo en el div de nuevo articulo (nuevoItem)
						ponerItemEncontradoEnVentanaAgregar(i.target.id);
						//document.getElementById('nuevoItem').style.visibility='hidden';
						//document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
					}
				},false);
		  };		  		  
	  }
  } 
}


var conexion32;
function mostrarDetallesItemEnRemit(celda){
  var numeroartic=celda.target.id;
  id_actual=numeroartic;
  conexion32=new XMLHttpRequest(); 
  conexion32.onreadystatechange = procesarEventos32;
  var aleatorio=Math.random();
  conexion32.open('GET','./php/detallesarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
  conexion32.send();
}

function procesarEventos32()
{
    if(conexion32.readyState == 4)
  { 
	  if(conexion32.status == 200)
	  { 
		  document.getElementById('agregarItemAlComprobanteFRMInf').innerHTML=conexion32.responseText;
	  }
  } 

}



