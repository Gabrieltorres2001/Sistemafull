addEventListener('load',inicializarEventos,false);
window.addEventListener('keydown', btnkeydown, false);

var nCom;
var nComIL;
var editableGrid;
var editableGridTemp;
var nFilaa;
var nombreCliente;
var nombreEmpresa;
var lineaArtic;
var esMio;

function inicializarEventos()
{
	listarLegajosPorPresupuesto();
	llenarAccionesLegajo();
	
	
	//De Presupuestos
	document.getElementById('cierraAgregarIt').addEventListener('click',cerrarVentanaAgregaIt,false); 
    document.getElementById('botonActualizaArticuloEnPresupuesto').addEventListener('click',actualizoArticulo,false);
	document.getElementById('itemABuscar').addEventListener('keypress',teclaEnter,false);
	document.getElementById('botonBuscarArticuloEnPresupuesto').addEventListener('click',busco,false);
	document.getElementById('cierraMovsAgArt').addEventListener('click',cerrarVentanaNuevoArt,false); 
	
}
//listar Legajos Por Presupuesto
var conexion1a;
function listarLegajosPorPresupuesto(){
  document.getElementById('listaLegajos').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1a=new XMLHttpRequest(); 
  conexion1a.onreadystatechange = procesarEventos1a;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1a.open('GET','./php/llenar_LegajosPorPresupuesto.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1a.send();
}

function procesarEventos1a()
{
    if(conexion1a.readyState == 4)
  { 
	  if(conexion1a.status == 200)
	  { 
		  document.getElementById('listaLegajos').innerHTML=conexion1a.responseText;
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('xxxxrt');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetalles,false);
				r=ii;
		  } 
	        //listar los legajos filtrados por Remitos
			document.getElementById('listarRemitos').addEventListener('click',listarLegajosPorRemito,false); 
	        //listar los legajos filtrados por OCs
			document.getElementById('listarOCs').addEventListener('click',listarLegajosPorOC,false); 
	  }
  } 
}
//listar Legajos Por Remito
var conexion1b;
function listarLegajosPorRemito(){
  document.getElementById('listaLegajos').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1b=new XMLHttpRequest(); 
  conexion1b.onreadystatechange = procesarEventos1b;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1b.open('GET','./php/llenar_LegajosPorRemito.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1b.send();
}

function procesarEventos1b()
{
    if(conexion1b.readyState == 4)
  { 
	  if(conexion1b.status == 200)
	  { 
		  document.getElementById('listaLegajos').innerHTML=conexion1b.responseText;
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('xxxxrt');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetalles,false);
				r=ii;
		  } 
	        //listar los legajos filtrados por Presupuestos
			document.getElementById('listarPresupuestos').addEventListener('click',listarLegajosPorPresupuesto,false); 
	        //listar los legajos filtrados por OCs
			document.getElementById('listarOCs').addEventListener('click',listarLegajosPorOC,false); 
	  }
  } 
}
//listar Legajos Por OC
var conexion1c;
function listarLegajosPorOC(){
  document.getElementById('listaLegajos').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1c=new XMLHttpRequest(); 
  conexion1c.onreadystatechange = procesarEventos1c;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1c.open('GET','./php/llenar_LegajosPorOC.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1c.send();
}

function procesarEventos1c()
{
    if(conexion1c.readyState == 4)
  { 
	  if(conexion1c.status == 200)
	  { 
		  document.getElementById('listaLegajos').innerHTML=conexion1c.responseText;
		  var tags_tdm = new Array();
		  var tags_tdm=document.getElementsByName('xxxxrt');
		  var r=0;
		  for (ii=0; ii<tags_tdm.length; ii++) {
				tags_tdm[ii].addEventListener('click',mostrarDetalles,false);
				r=ii;
		  } 
	        //listar los legajos filtrados por Remitos
			document.getElementById('listarRemitos').addEventListener('click',listarLegajosPorRemito,false); 
	        //listar los legajos filtrados por Presupuestos
			document.getElementById('listarPresupuestos').addEventListener('click',listarLegajosPorPresupuesto,false); 
	  }
  } 
}
//Hacer un legajo nuevo
var conexion2;
function llenarAccionesLegajo(){
  //var numeroComprobante=celda.target.id;
  //el encabezado del presupuesto
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion2.open('GET','./php/llenar_acciones_legajos.php?rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion2.send();


}
function procesarEventos2()
{
    if(conexion2.readyState == 4)
  { 
	  if(conexion2.status == 200)
	  { 
		  var datosc=document.getElementById('acciones');
		  datosc.innerHTML=conexion2.responseText;
		  //acciones para el boton nuevo presupuesto
			document.getElementById('nuevoLegajo').addEventListener('click',mostrarDescolgableListadoPresupuestos,false); 
	  }
  } 

}

var conexion3;
function mostrarDescolgableListadoPresupuestos(){
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  conexion3.open('GET','./php/llenar_descolgable_listado_presupuestos.php?&rnadom='+aleatorio, true);
  conexion3.send();
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion3.responseText;
		  document.getElementById('Presupuestos').focus();
		  	$(document).ready(function() {
			  $("#Presupuestos").select2();
			  $("#Presupuestos").select2("open");
			});
		  //habilito la funcion del boton "Listo"
			document.getElementById('listoNuevoLeg').addEventListener('click',agregarUnNuevoLegajo,false); 

	  }
  } 

}

var conexion4;
var conexion14;
function agregarUnNuevoLegajo(){
  //Ojo que el Id que voy a tomar es el id de la tabla comprobantes.
  var Comprobante=document.getElementById('Presupuestos').value;
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  //Antes de agregar el presupuesto a un nuevo legajo deberia fijarme si ya pertenece a alguno y avisar que se quiere hacer.
  //Se busca en la tabla detalleLegajos
  conexion4.open('GET','./php/leo_presupuestos_en_legajos.php?&rnadom='+aleatorio+"&IdComprobante="+Comprobante, true);
  conexion4.send();
}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 
		//alert(conexion4.responseText);
		//Divido el json
		var datosRecib=JSON.parse(conexion4.responseText);
		var yaExiste=datosRecib.legajos;
		if (yaExiste>0) {if(!confirm("El presupuesto ya forma parte de un legajo, continuar?")){return false;}}
		//Agregar un nuevo legajo.
		var presupAAgregar=document.getElementById('Presupuestos').value;
		//return false;
		var obnn=document.getElementById('numberses').value;
		//alert (obnn);
		conexion14=new XMLHttpRequest(); 
		conexion14.onreadystatechange = procesarEventos14;
		var aleatorio=Math.random();
		//////HASTA ACA LLEGUE!
		conexion14.open('GET','./php/nuevo_legajo.php?&rnadom='+aleatorio+"&idComprob="+presupAAgregar+"&sesses="+obnn, true);
		conexion14.send();
		}
  }
}  
		
function procesarEventos14()
{
    if(conexion14.readyState == 4)
  { 
	  if(conexion14.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion14.responseText;
		  document.getElementById('nuevoLegajo').addEventListener('click',mostrarDescolgableListadoPresupuestos,false); 
		  listarLegajosPorPresupuesto();
		  //alert(document.getElementById('NumeroLegajoRecienCreado').innerHTML);
		  mostrarDetalles(document.getElementById('NumeroLegajoRecienCreado').innerHTML);
		  //Faltaría llenar encabezado un legajo nuevo
	  }
  } 

}

var conexion5;
function mostrarDetalles(celda){
	document.getElementById('informepresupuesto').innerHTML="";
if (isNaN(celda))
  {
	//alert(celda.target.id);
	if(!isNaN(nCom)){if(!(document.getElementById(nCom)==null)){document.getElementById(nCom).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
    var numeroComprobante=celda.target.id;
  }
  else
  {
	var numeroComprobante=celda; 
  }
  nCom=numeroComprobante;
  //el encabezado del presupuesto
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion5.open('GET','./php/llenar_encabezado_un_legajo.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
	conexion5.send();
	llenarInformeLegajoJS();
}

function procesarEventos5()
{
    if(conexion5.readyState == 4)
  { 
	  if(conexion5.status == 200)
	  { 
		  document.getElementById('portada').innerHTML=conexion5.responseText;
		  document.getElementById('detallesdecomprobante').innerHTML="";
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
		  esMio=document.getElementById('soyyoono').value;
		  if (datosce.value == '1') {
			  //si soy yo, permito editar la tabla
			  //Lo hago solo para los xxxxt, ya que los xxxxtn no son editables.
			  var tags_td_camb = new Array();
  			  var tags_td_camb = document.getElementsByName('xxxxt');
			  for (i=0; i<tags_td_camb.length; i++) {
						tags_td_camb[i].addEventListener('change',cambioUnArticuloPresup,false);
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
						tags_td_elim[i].addEventListener('click',borrarArticuloPresup,false);
				};
			  //un click en el boton del tilde refresca la tabla
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxy');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',actualizArticuloPresup,false);
				};
			  //un click en el boton de LA LUPA EN LA ULTIMA LINEA agrega un item BUSCANDO
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxz');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',agregoIemALegajo,false);
				};	
			  //Subir orden de item
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxxup');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',suboIemALegajo,false);
				};	
			  //Bajar orden de item
			  var tags_td_actua = new Array();
  			  var tags_td_actua = document.getElementsByName('xxxxxdn');
			  for (i=0; i<tags_td_actua.length; i++) {
						tags_td_actua[i].addEventListener('click',bajoIemALegajo,false);
				}; } else {	  
					document.getElementById('asignarmePresup').addEventListener('click',asignarmePresupuesto,false); 	
					  } 
			//Fuera del IF. No importa el responsable
			//mostrar los detalles de cada uno de los items del legajo
			  var tags_tdm = new Array();
			  var tags_tdm=document.getElementsByName('xxxxid');
			  var r=0;
			  for (ii=0; ii<tags_tdm.length; ii++) {
					tags_tdm[ii].addEventListener('click',mostrarDetallesItemLegajo,false);
					r=ii;
		  };}, 100);		  
	  }
  } 
}

var conexion7;
function agregoIemALegajo(){
  // el listado de comprobantes
  conexion7=new XMLHttpRequest(); 
  conexion7.onreadystatechange = procesarEventos7;
  aleatorio=Math.random();
  conexion7.open('GET','./php/llenar_comprobantesparaLegajo.php?rnadom='+aleatorio, true);
  conexion7.send();	
}

function procesarEventos7()
{
    if(conexion7.readyState == 4)
  { 
	  if(conexion7.status == 200)
	  { 
		document.getElementById('fondoClaro').style.visibility='visible';
		document.getElementById('agregarItemAlComprobanteFRMAcciones').innerHTML=conexion7.responseText;
		document.getElementById('agregarItemAlComprobanteFRMSup').innerHTML="";
		document.getElementById('agregarItemAlComprobanteFRMInf').innerHTML="";
		document.getElementById('agregarItemAlComprobante').style.visibility='visible';
		document.getElementById('botonBuscarTiposDeComprobantes').addEventListener('click',mostrarItemsParaLegajo,false);
		document.getElementById('itemsLegajo').addEventListener('change',limpiarInferior,false);
	  }
  }
}

function limpiarInferior()
{
	document.getElementById('agregarItemAlComprobanteFRMSup').innerHTML='';
}

function cerrarVentanaAgregaIt()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

var conexion8;
var tipoC;
function mostrarItemsParaLegajo(){
	tipoC=document.getElementById('itemsLegajo').value;
	//alert(tipoC);
  // el listado de comprobantes
  conexion8=new XMLHttpRequest(); 
  conexion8.onreadystatechange = procesarEventos8;
  aleatorio=Math.random();
  conexion8.open('GET','./php/llenar_listado_items_para_legajo.php?rnadom='+aleatorio+"&tipoComp="+tipoC, true);
  conexion8.send();	
}

function procesarEventos8()
{
    if(conexion8.readyState == 4)
  { 
	  if(conexion8.status == 200)
	  { 
		document.getElementById('agregarItemAlComprobanteFRMSup').innerHTML=conexion8.responseText;
		document.getElementById('listoNuevoLegVent').addEventListener('click',agregarAdjunto,false);
		$(document).ready(function() {
		  $("#itemsAAgregarALegajo").select2();
		  //$("#itemsAAgregarALegajo").select2("open");
		});
	  }
  }
}

var conexion9;
var datosRecibAjax;
function agregarAdjunto()
{
	var formData = new FormData(document.getElementById("enviarimagenes"));
	$.ajax({
		url: "./php/subir.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		datosRecibAjax=JSON.parse(echo);
		//$("#aviso").html(datosRecib.id);
		grabarNuevoItemLegajo();
	});
}

function grabarNuevoItemLegajo()
{
	if ((tipoC=='3')||(tipoC=='5')||(tipoC=='9')){var idComprobante=document.getElementById('itemsAAgregarALegajo').value;} else {var idComprobante='0';}
	var txtComprobante=document.getElementById('NuevaDescripcionitem').value;
	  conexion9=new XMLHttpRequest(); 
	  conexion9.onreadystatechange = procesarEventos9;
	  aleatorio=Math.random();
	  //alert("idlegajo: "+nCom);
	  //alert("txtComprobante: "+txtComprobante);
	  //alert("datosRecibAjax.id: "+datosRecibAjax.id);
	  conexion9.open('GET','./php/nuevo_item_legajo.php?rnadom='+aleatorio+"&tipoComp="+tipoC+"&idComp="+idComprobante+'&idlegajo='+nCom+'&txtComp='+txtComprobante+'&pdfComp='+datosRecibAjax.id, true);
	  conexion9.send();			
}

function procesarEventos9()
{
    if(conexion9.readyState == 4)
  { 
	  if(conexion9.status == 200)
	  { 
  		//alert("despues");
		document.getElementById('agregarItemAlComprobanteFRMInf').innerHTML=conexion9.responseText;
		setTimeout(function(){document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
		document.getElementById('fondoClaro').style.visibility='hidden';
		mostrarDetalles(nCom);}, 1000);
	  }
  }
}

var conexion10;
function suboIemALegajo(celda){
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var ordenActual = palabras[0];
	  conexion10=new XMLHttpRequest(); 
	  conexion10.onreadystatechange = procesarEventos10;
	  aleatorio=Math.random();
	  conexion10.open('GET','./php/mover_item_legajo.php?rnadom='+aleatorio+'&idlegajo='+nCom+'&ordenItem='+ordenActual+'&accion=subir', true);
	conexion10.send();
}

function bajoIemALegajo(celda){
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var ordenActual = palabras[0];
	  conexion10=new XMLHttpRequest(); 
	  conexion10.onreadystatechange = procesarEventos10;
	  aleatorio=Math.random();
	  conexion10.open('GET','./php/mover_item_legajo.php?rnadom='+aleatorio+'&idlegajo='+nCom+'&ordenItem='+ordenActual+'&accion=bajar', true);
	conexion10.send();
}

function procesarEventos10()
{
    if(conexion10.readyState == 4)
  { 
	  if(conexion10.status == 200)
	  { 
		mostrarDetalles(nCom);
		//document.getElementById('acciones').innerHTML=conexion10.responseText;
	  }
  }
}

var conexion6;
var palabras;
var itemAnterior;
var itLegActual;
function mostrarDetallesItemLegajo(celda){
	palabras = celda.target.id.split("&");
	segundocodigo = palabras[1];
	if (segundocodigo=="IL"){
		if(!(document.getElementById(nComIL)==null)){document.getElementById(nComIL).style.backgroundColor="transparent";}
		document.getElementById(celda.target.id).style.backgroundColor="#809fff";
	}
	var numeroComprobante=palabras[0];
	itLegActual=numeroComprobante;
	nComIL=celda.target.id;

  // el detalle del item del legajo
  conexion6=new XMLHttpRequest(); 
  conexion6.onreadystatechange = procesarEventos6;
  aleatorio=Math.random();
  //alert('idcomprobante='+numeroComprobante);
  conexion6.open('GET','./php/llenar_detalle_item_legajo.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio, true);
  conexion6.send();
}

function procesarEventos6()
{
    if(conexion6.readyState == 4)
  { 
	  if(conexion6.status == 200)
	  { 
		  document.getElementById('detallesdecomprobante').innerHTML=conexion6.responseText;
		  document.getElementById('listoNuevoAdjuntoALeg').addEventListener('click',adjuntarAdjunto,false);
	  }
  } 
}


var conexion11;
var datosRecibAjax2;
function adjuntarAdjunto()
{
	var formData = new FormData(document.getElementById("enviarimagenesEnLeg"));
	$.ajax({
		url: "./php/subir.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		datosRecibAjax2=JSON.parse(echo);
		grabarNuevoImagenEnItemLegajo();
	});
}

function grabarNuevoImagenEnItemLegajo()
{
	  conexion11=new XMLHttpRequest(); 
	  conexion11.onreadystatechange = procesarEventos11;
	  aleatorio=Math.random();
	  conexion11.open('GET','./php/modificar_item_legajo.php?rnadom='+aleatorio+'&idcomprobante='+itLegActual+'&pdfComp='+datosRecibAjax2.id, true);
	  conexion11.send();			
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 
		document.getElementById('detallesdecomprobante').innerHTML=conexion11.responseText;
		setTimeout(function(){mostrarDetalles(nCom);}, 1000);
	  }
  }
}

function cambioUnArticuloPresup(celda)
{
	//Tengo que ver que eventos del viejo transfEnEditable me van a servir
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[2];
	  switch(numeroartic){
		  case "Descripcionitem":
				campoAEditar="textoComprobante"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				//alert(celda.target.value);
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);					
				break;
	  };
}

var conexion17;
function modificarCampoTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion17=new XMLHttpRequest(); 
	//conexion17.onreadystatechange = procesarEventos17;
	var aleatorio=Math.random();
	var cadena=encodeURIComponent(newValue);
	conexion17.open('GET','./php/actualizo_detalle_legajo_orden.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+cadena+"&rnadom="+aleatorio, true);
	conexion17.send();
	//ya esta. Se ve en la tabla y ademas (confio en que) se grabo en la BD
}

var conexion25;
function borrarArticuloPresup(celda){
	var ambosid=celda.target.id;
	//alert (ambosid);
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if(confirm("Borrar este ítem del legajo?")== true) {
		conexion25=new XMLHttpRequest(); 
		conexion25.onreadystatechange = procesarEventos25;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		conexion25.open('GET','./php/borro_articulo_detalle_legajo.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio, true);
		conexion25.send();
		//DEBO actualizar automaticamente
		setTimeout(function(){mostrarDetalles(nCom)}, 500);
	}
}

var conexion18;
function llenarInformeLegajoJS(){
  conexion18=new XMLHttpRequest(); 
  conexion18.onreadystatechange = procesarEventos18;
  var aleatorio=Math.random();
  conexion18.open('GET','./php/llenar_informe_legajo.php?&rnadom='+aleatorio, true);
  conexion18.send();
}

function procesarEventos18()
{
    if(conexion18.readyState == 4)
  { 
	  if(conexion18.status == 200)
	  { 
		  document.getElementById('informepresupuesto').innerHTML=conexion18.responseText;
		  //habilito la funcion del boton "Informe"
		  document.getElementById('informe').addEventListener('click',imprimir,false);
	  }
  } 

}

function imprimir() {
	  var aleatorio=Math.random();
	  window.open('./informes/Informe.php?idlegajo='+nCom+"&rnadom="+aleatorio+"&tipoInforme=Legajo");
	  //Tengo que hacer andar este
	  //window.open('./PDFMerger-master/sample.php');
}









//////////////////////////////////////////////
/////////////DE presupuestos//////////////////
//////////////////////////////////////////////
var conexion1000;
function llenarListadoPresupuestosJS(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1000=new XMLHttpRequest(); 
  conexion1000.onreadystatechange = procesarEventos1000;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1000.open('GET','./php/llenar_listado_presupuestos.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1000.send();
}

function procesarEventos1000()
{
    if(conexion1000.readyState == 4)
  { 
	  if(conexion1000.status == 200)
	  { 
		  document.getElementById('listaComprobantes').innerHTML=conexion1000.responseText;
		  //listar todos los presupuestos MIOS
		  document.getElementById('listarMios').addEventListener('click',listarPresupuestosMios,false); 
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

function teclaEnter(e)
{
  var tecla=e.which;
  if(tecla==13)
  {
    e.preventDefault();
    busco();
  }  
}

function busco()
{ 
  //var seleccion=document.getElementById('ordenPor');
  var criterio=document.getElementById('itemABuscar');

  //var tabla = document.getElementById('tablaArticulos');
  //var rowCount = tabla.rows.length; 
  //while(--rowCount) tabla.deleteRow(rowCount);
  cambiarDatos("1", criterio.value);
  
}

var conexion31;
function cambiarDatos(orden, datoABuscar) 
{
  conexion31=new XMLHttpRequest(); 
  conexion31.onreadystatechange = procesarEventos31;
  var aleatorio=Math.random();
  conexion31.open('GET','./php/buscoarticulo.php?orden='+orden+"&busqueda="+datoABuscar+"&rnadom="+aleatorio, true);
  conexion31.send();
}

function procesarEventos31()
{
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
							mostrarDetallesItemEnPresup(i);
						}, 300);
					} else if (clickCount === 2) {
						clearTimeout(singleClickTimer);
						clickCount = 0;
						//alert(i.target.id);
						//aca deberia cargar el articulo en el div de nuevo articulo (nuevoItem)
						ponerItemEncontradoEnVentanaAgregar(i.target.id);
						//document.getElementById('fondoClaro').style.visibility='hidden';
						//document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
					}
				},false);
		  };		  		  
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
	  cadena='./php/agrego_detalle_presupuesto_articulo.php?'+cadena+"&rnadom="+aleatorio
	  //alert(cadena);
	  //campo 0. Orden
	  cadena=cadena+"&Orden=999";			  
	  //campo 1. Codigo Articulo. El if esta arriba
	  cadena=cadena+"&IdProducto="+celda;
	  conexion1101.open('GET',cadena, true);
	  conexion1101.send();
	  mostrarDetalles(nCom);	
}

var conexion32;
function mostrarDetallesItemEnPresup(celda){
  var numeroartic=celda.target.id;
  id_actual=numeroartic;
  conexion32=new XMLHttpRequest(); 
  conexion32.onreadystatechange = procesarEventos32;
  var aleatorio=Math.random();
  conexion32.open('GET','./php/detallesarticulo_nuevoenpresup.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
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





var conexion18181818;
function modificarCantidadTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion18181818=new XMLHttpRequest(); 
	conexion18181818.onreadystatechange = procesarEventos18181818;
	var aleatorio=Math.random();
	conexion18181818.open('GET','./php/actualizo_detalle_presupuesto_cantidad.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion18181818.send();
	//no DEBO actualizar automaticamente

}

function procesarEventos18181818()
{
    if(conexion18181818.readyState == 4)
  { 
	  if(conexion18181818.status == 200)
	  { 
		
	  }
  } 

}

var conexion19;
function modificarDescuentosTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion19=new XMLHttpRequest(); 
	conexion19.onreadystatechange = procesarEventos19;
	var aleatorio=Math.random();
	conexion19.open('GET','./php/actualizo_detalle_presupuesto_descuentos.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion19.send();
	//no DEBO actualizar automaticamente
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function procesarEventos19()
{
    if(conexion19.readyState == 4)
  { 
	  if(conexion19.status == 200)
	  { 
		  //document.getElementById('portada').innerHTML=datosc.innerHTML+conexion19.responseText;
	  }
  } 

}

var conexion20;
function modificarArticuloTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion20=new XMLHttpRequest(); 
	conexion20.onreadystatechange = procesarEventos20;
	var aleatorio=Math.random();
	conexion20.open('GET','./php/actualizo_detalle_presupuesto_articulo.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
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
		  document.getElementById('portada').innerHTML=datosc.innerHTML+conexion20.responseText;
	  }
  } 

}

var conexion21;
function modificarMonedaTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion21=new XMLHttpRequest(); 
	conexion21.onreadystatechange = procesarEventos21;
	var aleatorio=Math.random();
	conexion21.open('GET','./php/actualizo_detalle_presup_y_remito_moneda.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion21.send();
	//no DEBO actualizar automaticamente
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function procesarEventos21()
{
    if(conexion21.readyState == 4)
  { 
	  if(conexion21.status == 200)
	  { 
		  //document.getElementById('portada').innerHTML=datosc.innerHTML+conexion21.responseText;
	  }
  } 

}


var conexion22;
function modificarUnitarioTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion22=new XMLHttpRequest(); 
	conexion22.onreadystatechange = procesarEventos22;
	var aleatorio=Math.random();
	conexion22.open('GET','./php/actualizo_detalle_presupuesto_unitario.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion22.send();
	//no DEBO actualizar automaticamente
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

function procesarEventos22()
{
    if(conexion22.readyState == 4)
  { 
	  if(conexion22.status == 200)
	  { 
		  //document.getElementById('portada').innerHTML=datosc.innerHTML+conexion22.responseText;
	  }
  } 

}

function procesarEventos25()
{
    if(conexion25.readyState == 4)
  { 
	  if(conexion25.status == 200)
	  { 
		  document.getElementById('portada').innerHTML=datosc.innerHTML+conexion25.responseText;
	  }
  } 

}

function actualizArticuloPresup(celda){
	//antes deberia releer y regrabar todos los campos!! (sino hay datos que no se actualizan salvo que modifique 2 veces un descuento)
		mostrarDetalles(nCom);
}

function agregoArticuloAPresupXCodigoInt(){
	var nuevoId=prompt("Código de artículo?");
	//alert (nuevoId);
	if ((!isNaN(nuevoId))&&(nuevoId>0)){
		//el numero en celda es el id del articulo que elegi
		agregaItemNuevoV2(nuevoId);
	}
}

function enviarMail()
{
	//alert("Este botón enviará un mail al contacto próximamente");
	window.location.href='mailto:'+document.getElementById('DirecciondecorreoelectronicoP').value;
	//document.write('<a href="mailto:juan@hotmail.com"></a>');

}

var conexion21;
function asignarmePresupuesto(){
	if (confirm("Seguro que desea asignarse este legajo a su nombre?")== true){
		conexion21=new XMLHttpRequest(); 
		conexion21.onreadystatechange = procesarEventos121;
		var aleatorio=Math.random();
		var obnn=document.getElementById('numberses').value;
		conexion21.open('GET','./php/cambiar_responsable_a_legajo.php?idpresup='+nCom+"&rnadom="+aleatorio+"&sesses="+obnn, true);
		conexion21.send();
	  } else {
		  mostrarAvisos("No asignado");
	  }
}

function procesarEventos121()
{
    if(conexion21.readyState == 4)
  { 
	  if(conexion21.status == 200)
	  { 
		setTimeout(function(){mostrarDetalles(nCom)}, 100);
	  }
  } 
}

var conexion301;
function listarPresupuestosMios(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion301=new XMLHttpRequest(); 
  conexion301.onreadystatechange = procesarEventos301;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion301.open('GET','./php/llenar_listado_presupuestos_MIOS.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
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
	        //listar todos los presupuestos MIOS Y NO MIOS
			document.getElementById('listarTodos').addEventListener('click',llenarListadoPresupuestosJS,false); 
	  }
  } 
}

var conexion310;
function llenarcomboformaspagoJS(){
  conexion310=new XMLHttpRequest(); 
  conexion310.onreadystatechange = procesarEventos310;
  var aleatorio=Math.random();
  conexion310.open('GET','./php/llenar_combo_formas_pago.php?rnadom='+aleatorio, true);
  conexion310.send();
}

function procesarEventos310()
{
    if(conexion310.readyState == 4)
  { 
	  if(conexion310.status == 200)
	  { 
		 document.getElementById('CondPagodiv').innerHTML=conexion310.responseText;
	  }
  } 
}

var conexion310a;
function llenarcombotiposcomprobantesJS(){
  conexion310a=new XMLHttpRequest(); 
  conexion310a.onreadystatechange = procesarEventos310a;
  var aleatorio=Math.random();
  conexion310a.open('GET','./php/llenar_combo_tipos_comprobantes.php?rnadom='+aleatorio, true);
  conexion310a.send();
}

function procesarEventos310a()
{
    if(conexion310a.readyState == 4)
  { 
	  if(conexion310a.status == 200)
	  { 
		document.getElementById('TipoFacturadiv').innerHTML=conexion310a.responseText;
	  }
  } 
}

function btnkeydown(event)
{
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
			if (!isNaN(nCom)){agregoArticuloAPresupXCodigoInt()};
		}
		}
}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}