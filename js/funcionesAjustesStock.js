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

function inicializarEventos()
{
	listarArticulosAjustados();
	//listarPresupuestosMios();
	//llenarInformePresupuestoJS();
	//llenarInformeRemitoEnPresupuestoJS();
	llenarAccionesAjustesStock();
    document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false); 
	document.getElementById('cierraAgregarIt').addEventListener('click',cerrarVentanaAgregaIt,false); 
    document.getElementById('botonActualizaArticuloEnPresupuesto').addEventListener('click',actualizoArticulo,false);
	document.getElementById('itemABuscar').addEventListener('keypress',teclaEnter,false);
	document.getElementById('botonBuscarArticuloEnPresupuesto').addEventListener('click',busco,false);
	document.getElementById('cierraMovsAgArt').addEventListener('click',cerrarVentanaNuevoArt,false); 
	document.getElementById('cierraAjusteStock').addEventListener('click',cerrarVentanaAjusteStock,false); 
	document.getElementById('codIntNuevoAjusteStock').addEventListener('change',buscarDescripcionProducto,false);
}

function cerrarVentanaAjusteStock(){
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('cargarNuevoAjusteStockArticulo').style.visibility='hidden';
}

var conexion1;
function listarArticulosAjustados(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un artículo de la lista a la derecha";
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1.open('GET','./php/llenar_listado_Prod_ajustados_stk.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('listaComprobantes').innerHTML=conexion1.responseText;
		  //document.getElementById('articulosAjustados').focus();
		  	$(document).ready(function() {
			  //$("#articulosAjustados").select2();
			  $("#articulosAjustados").select2({ width: '80%' }); 
			  //$("#articulosAjustados").select2("open");
			});
		  //listar todos los presupuestos MIOS
		  //document.getElementById('listarMios').addEventListener('click',listarPresupuestosMios,false); 
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

var conexion3;
function llenarDetallePresupuestosJS(){
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  conexion3.open('GET','./php/llenar_encabezado_presupuestos.php?&rnadom='+aleatorio, true);
  conexion3.send();
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
		  document.getElementById('portada').innerHTML=conexion3.responseText;
	  }
  } 

}

var conexion4;
var conexion5;
function mostrarDetalles(celda){
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
  //alert(nCom);
  //El detalle de stock actual y ubicacion del articulo.
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion4.open('GET','./php/detallesarticulo_Ajustado_Stock.php?idart='+nCom+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion4.send();
  //El listado de todas las veces que actualice este articulo.
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  aleatorio=Math.random();
  conexion5.open('GET','./php/ajustes_stock_por_articulo.php?idart='+nCom+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion5.send();

}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 
		  document.getElementById('portada').innerHTML=conexion4.responseText;
	  }
  } 

}

function procesarEventos5()
{
    if(conexion5.readyState == 4)
  { 
	  if(conexion5.status == 200)
	  { 
		  document.getElementById('detallesdecomprobante').innerHTML=conexion5.responseText;				
	  }
  } 
}




var conexion7;
var conexion7a;
function imprimir() {
	//Antes de emitir el presupuesto voy a verificar que todos los items tengan la misma factura
	conexion7a=new XMLHttpRequest(); 
	conexion7a.onreadystatechange = procesarEventos7a;
	var aleatorio=Math.random();
	conexion7a.open('GET','./php/verificar_monedas_para_presupuesto.php?&rnadom='+aleatorio+"&idcomprobante="+nCom, true);
	conexion7a.send();	
}

function procesarEventos7a()
{
    if(conexion7a.readyState == 4)
  { 
	  if(conexion7a.status == 200)
	  {   
  //alert (conexion7a.responseText);
  		 var datosRecib=JSON.parse(conexion7a.responseText);
		 if (datosRecib.moneda < 1){mostrarAvisos("Verifique que los productos tengan moneda");}
			else {
				 if (datosRecib.distintaMoneda > 0){mostrarAvisos("Verifique que todos los productos tengan la misma moneda");}
					else {
						//document.getElementById('NumeroComprobante');
						var numPresup=document.getElementById('NumeroComprobante');
						if (document.getElementById('radio11').checked) {var descripExtendda='1'};
						if (document.getElementById('radio12').checked) {var descripExtendda='0'};
						
						if (document.getElementById('radio21').checked) {var ivva='1'};
						if (document.getElementById('radio22').checked) {var ivva='0'};
						
						if (document.getElementById('radio31').checked) {var monneda='1'};
						if (document.getElementById('radio32').checked) {var monneda='0'};
						
						if (document.getElementById('radio41').checked) {var plazzo='1'};
						if (document.getElementById('radio42').checked) {var plazzo='0'};
						
						var cambioPesosAMonedaExtr=document.getElementById('TipoDeCambio').value;
					  //conexion7=new XMLHttpRequest(); 
					  //conexion7.onreadystatechange = procesarEventos7;
					  var aleatorio=Math.random();
					  window.open('./informes/Tecnoplus_informe_presupuesto.php?idppto='+numPresup.value+"&descr="+descripExtendda+"&iva="+ivva+"&moneda="+monneda+"&cambioPesosAMoneda="+cambioPesosAMonedaExtr+"&plazo="+plazzo+"&rnadom="+aleatorio);

					  //conexion7.open('GET','./example_006.php?idppto='+numPresup.value+"&rnadom="+aleatorio, true);
					  //conexion7.send();
					}
			}
	  }
  }
}

function procesarEventos7()
{
    if(conexion7.readyState == 4)
  { 
	  if(conexion7.status == 200)
	  {   
  
		var nVentana= window.open('"', '"', "width=595, height=841");
		nVentana.document.write(conexion7.responseText);
		//nVentana.document.close();
		nVentana.print();
		//nVentana.close();
	  }
  }
}

var conexion8;
var conexion9;
function mostrarDetallesArticulo(celda)
{
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if (numeroartic<=0){
		agregoArticuloAPresup(celda);
	} else {
		  lineaArtic=palabras[0];
		  //alert(lineaArtic);
		  document.getElementById('fondoClaro').style.visibility='visible';
		  document.getElementById('detallesdemovimientos').style.visibility='visible';
		  //var numeroartic=celda.target.name;
		  //el encabezado del presupuesto
		  conexion8=new XMLHttpRequest(); 
		  conexion8.onreadystatechange = procesarEventos8;
		  var aleatorio=Math.random();
		  conexion8.open('GET','./php/detallesarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
		  conexion8.send();
		  // el detalle del presupuesto
		  conexion9=new XMLHttpRequest(); 
		  conexion9.onreadystatechange = procesarEventos9;
		  aleatorio=Math.random();
		  conexion9.open('GET','./php/movimientosarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
		  conexion9.send();
	}
}

function procesarEventos8()
{
    if(conexion8.readyState == 4)
  { 
	  if(conexion8.status == 200)
	  { 
		  var datosc=document.getElementById('detallesdemovimientosFRMSup');
		  datosc.innerHTML=conexion8.responseText;
	  }
  } 
}

function procesarEventos9()
{
    if(conexion9.readyState == 4)
  { 
	  if(conexion9.status == 200)
	  { 
		  document.getElementById('detallesdemovimientosFRMInf').innerHTML=conexion9.responseText;
	  }
  } 
}

var conexion209;
function cerrarVentanaMovs()
{
	actualizoArticulo();
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('detallesdemovimientos').style.visibility='hidden';
	  //cambio el precio unitario y el subtotal de ese articulo
	  if (esMio=='1') {
		  conexion209=new XMLHttpRequest(); 
		  conexion209.onreadystatechange = procesarEventos209;
		  var aleatorio=Math.random();
		  conexion209.open('GET','./php/refrescaprecioartic.php?idart='+lineaArtic+"&rnadom="+aleatorio, true);
		  conexion209.send();}	
}

function procesarEventos209()
{
    if(conexion209.readyState == 4)
  { 
	  if(conexion209.status == 200)
	  { 
		  setTimeout(function(){mostrarDetalles(nCom);}, 100);
	  }
  } 
}

function cerrarVentanaNuevoArt()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
}

function cerrarVentanaAgregaIt()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('agregarItemAlComprobante').style.visibility='hidden';
	//setTimeout(function(){mostrarDetalles(nCom)}, 100);
}

var conexion10;
function actualizoArticulo(){
  //var numerocto=id_actual;
  var numeroart=document.getElementById('IdProducto').value;
  conexion10=new XMLHttpRequest(); 
  conexion10.onreadystatechange = procesarEventos10;
  var aleatorio=Math.random();
  var cadena="idart="+numeroart;
  cadena=cadena+"&TipoProducto="+document.getElementById('TipoProducto').value;
  cadena=cadena+"&MonedaOrigen="+document.getElementById('MonedaOrigen').value;
  cadena=cadena+"&ValorVenta="+document.getElementById('ValorVenta').value;
  cadena=cadena+"&IVA="+document.getElementById('IVA').value;
  cadena=cadena+"&descricpcion="+encodeURIComponent(document.getElementById('descricpcion').value); 
  cadena=cadena+"&OfrecerAdemas="+encodeURIComponent(document.getElementById('OfrecerAdemas').value);
  cadena=cadena+"&Notas="+encodeURIComponent(document.getElementById('NotasArt').value);
  cadena=cadena+"&ComposicionyDescirpcion="+encodeURIComponent(document.getElementById('ComposicionyDescirpcion').value);   
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
  cadena='./php/actualizo_detallesarticulo.php?'+cadena+"&rnadom="+aleatorio
  conexion10.open('GET',cadena, true);
  conexion10.send();
}

function procesarEventos10()
{
    if(conexion10.readyState == 4)
  {	  if(conexion10.status == 200)
	  {   //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
		  //busco();
		  document.getElementById('detallesdemovimientosFRMSup').innerHTML=conexion10.responseText;
		  tags_cambios = [];
	  }
  } 

}

var conexion11;
function llenarInformePresupuestoJS(){
  conexion11=new XMLHttpRequest(); 
  conexion11.onreadystatechange = procesarEventos11;
  var aleatorio=Math.random();
  conexion11.open('GET','./php/llenar_informe_presupuesto.php?&rnadom='+aleatorio, true);
  conexion11.send();
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 
		  document.getElementById('informepresupuesto').innerHTML=conexion11.responseText;
		  //habilito la funcion del boton "Informe"
		  document.getElementById('informe').addEventListener('click',imprimir,false);
		  //muestro un cuadro de texto para escribir el Tipo de Cambio al habilitar el <input type='radio' id='radio32' name='moneda'>En Pesos</option>
		  document.getElementById('radio32').addEventListener('change',muestraTipoCambio,false); 
		  document.getElementById('radio31').addEventListener('change',ocultaTipoCambio,false); 
	  }
  } 

}

function muestraTipoCambio()
{
	if (document.getElementById('radio32').checked) {
		document.getElementById('lbltc').style.visibility='visible';
		document.getElementById('TipoDeCambio').style.visibility='visible';};
}

function ocultaTipoCambio()
{
	if (document.getElementById('radio31').checked) {
		document.getElementById('lbltc').style.visibility='hidden';
		document.getElementById('TipoDeCambio').style.visibility='hidden';
		document.getElementById('TipoDeCambio').value=1
		};
}


var conexion12;
function llenarAccionesAjustesStock(){
  //var numeroComprobante=celda.target.id;
  //el encabezado del presupuesto
  conexion12=new XMLHttpRequest(); 
  conexion12.onreadystatechange = procesarEventos12;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion12.open('GET','./php/llenar_acciones_ajustes_stock.php?rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion12.send();


}
function procesarEventos12()
{
    if(conexion12.readyState == 4)
  { 
	  if(conexion12.status == 200)
	  { 
		document.getElementById('acciones').innerHTML=conexion12.responseText;
		  //acciones para el boton nuevo presupuesto
		document.getElementById('nuevoAjusteStock').addEventListener('click',mostrarVentanaNuevoAjuste,false); 
	  }
  } 

}

function mostrarVentanaNuevoAjuste(){
	document.getElementById('codIntNuevoAjusteStock').value="";
	document.getElementById('nuevoAjusteDescripcion').innerHTML="";
	document.getElementById('stockNuevoAjusteStock').value="";
	document.getElementById('depositoNuevoAjusteStock').value="";
	document.getElementById('estanteriaNuevoAjusteStock').value="";
	document.getElementById('estanteNuevoAjusteStock').value="";
	
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('cargarNuevoAjusteStockArticulo').style.visibility='visible';
	document.getElementById('cierraAjusteStock').addEventListener('click',cerrarVentanaAjusteStock,false);
	document.getElementById('codIntNuevoAjusteStock').addEventListener('change',buscarDescripcionProducto,false);
	//Controlar que la cantidad sea un numero
	document.getElementById('stockNuevoAjusteStock').addEventListener('change',controlarNumero,false);
	document.getElementById('botonActualizarAjusteStock').addEventListener('click',cargarAjusteStock,false);
	document.getElementById('codIntNuevoAjusteStock').focus();
}

var conexion14;
function cargarAjusteStock(){
	var codInt=document.getElementById('codIntNuevoAjusteStock').value;
	if ((isNaN(codInt)) || (codInt.length<1)){mostrarAvisos("Falta el codigo interno");}
		else {
			var nuevoStock=document.getElementById('stockNuevoAjusteStock').value;
			if ((isNaN(nuevoStock)) || (nuevoStock.length<1)){mostrarAvisos("Falta el stock");}
				else {
					var nuevoDeposito=document.getElementById('depositoNuevoAjusteStock').value;
					var nuevaEstanteria=document.getElementById('estanteriaNuevoAjusteStock').value;
					var nuevoEstante=document.getElementById('estanteNuevoAjusteStock').value;
					//Actualizar los datos en las tablas articulos, ajustesStock y stock
					conexion14=new XMLHttpRequest(); 
					conexion14.onreadystatechange = procesarEventos14;
					var aleatorio=Math.random();
					var obnn=document.getElementById('numberses').value;
					conexion14.open('GET','./php/actualizo_stock_articulo.php?idart='+codInt+"&stock="+nuevoStock+"&deposito="+nuevoDeposito+"&estanteria="+nuevaEstanteria+"&estante="+nuevoEstante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
					conexion14.send();
					
					setTimeout(function(){listarArticulosAjustados()}, 100);
				}
		}
}

function procesarEventos14()
{
    if(conexion14.readyState == 4)
  { 
	  if(conexion14.status == 200)
	  { 
		document.getElementById('accionesInforme').innerHTML=conexion14.responseText;
		document.getElementById('fondoClaro').style.visibility='hidden';
		document.getElementById('cargarNuevoAjusteStockArticulo').style.visibility='hidden';
	  }
  } 

}
	
function controlarNumero(){
	if (isNaN(document.getElementById('stockNuevoAjusteStock').value)) {
		document.getElementById('stockNuevoAjusteStock').focus();
		mostrarAvisos("No es un número!");
		document.getElementById('stockNuevoAjusteStock').focus();
	};
}

var conexion13;
function buscarDescripcionProducto(){
	var codInt=document.getElementById('codIntNuevoAjusteStock').value;
	//alert(codInt);
	conexion13=new XMLHttpRequest(); 
	conexion13.onreadystatechange = procesarEventos13;
	var aleatorio=Math.random();
	conexion13.open('GET','./php/busco_descripcion_articulo.php?idart='+codInt+"&rnadom="+aleatorio, true);
	conexion13.send();
}

function procesarEventos13()
{
    if(conexion13.readyState == 4)
  { 
	  if(conexion13.status == 200)
	  { 
		  document.getElementById('nuevoAjusteDescripcion').innerHTML=conexion13.responseText;
		  document.getElementById('stockNuevoAjusteStock').focus();
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

var conexion18;
function modificarCantidadTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion18=new XMLHttpRequest(); 
	conexion18.onreadystatechange = procesarEventos18;
	var aleatorio=Math.random();
	conexion18.open('GET','./php/actualizo_detalle_presupuesto_cantidad.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
	conexion18.send();
	//no DEBO actualizar automaticamente

}

function procesarEventos18()
{
    if(conexion18.readyState == 4)
  { 
	  if(conexion18.status == 200)
	  { 
		
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

function agregoArticuloAPresup(){
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('agregarItemAlComprobante').style.visibility='visible';
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

var conexion311;
function llenarInformeRemitoEnPresupuestoJS(){
  conexion311=new XMLHttpRequest(); 
  conexion311.onreadystatechange = procesarEventos311;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion311.open('GET','./php/llenar_informe_remito_desde_presupuesto.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion311.send();
}

function procesarEventos311()
{
    if(conexion311.readyState == 4)
  { 
	  if(conexion311.status == 200)
	  { 
		  document.getElementById('informeRemito').innerHTML=conexion311.responseText;
		  //habilito la funcion del boton "Informe"
		  document.getElementById('informeRemitoEnPresupuesto').addEventListener('click',imprimirRemitoDesdePresupuesto,false);
		  //muestro un cuadro de texto para escribir el Tipo de Cambio al habilitar el <input type='radio' id='radio32' name='moneda'>En Pesos</option>
		  document.getElementById('radio32').addEventListener('change',muestraTipoCambio,false); 
		  document.getElementById('radio31').addEventListener('change',ocultaTipoCambio,false); 
	  }
  } 
}

var conexion312;
function imprimirRemitoDesdePresupuesto() {
	var ob=document.getElementById('preimpreso1');
	if ((isNaN(ob.value))||(ob.value=='')||(ob.value==null)){mostrarAvisos("El numero de preimpreso esta mal. No se generó el remito.")}
		else {
			//primero cargar el remito. Me tiene que devolver el numero de comprobante para poder hacer el informe.
			var empobb=document.getElementById('Organizacion').value;
			var nomobb=document.getElementById('Contacto').value;
			 //if (confirm("Agregar remito a nombre de: "+empobb+", "+nomobb+"?")== true){
				var obb=document.getElementById('NumeroComprobante').value;
				var occ=encodeURIComponent(document.getElementById('ocRemito').value);
				conexion312=new XMLHttpRequest(); 
				conexion312.onreadystatechange = procesarEventos312;
				var aleatorio=Math.random();
				var obnn=document.getElementById('numberses').value;
				conexion312.open('GET','./php/hacer_remito_desde_presupuesto.php?&rnadom='+aleatorio+"&presup="+obb+"&sesses="+obnn+"&preimpres="+ob.value+"&occlien="+occ, true);
				conexion312.send();
				document.getElementById('preimpreso1').value='';
				document.getElementById('ocRemito').value='';
				//} else {
			  //alert("Remito no agregado");
		  //}
		};
}

var nuevoRtoDePres;
function procesarEventos312()
{
    if(conexion312.readyState == 4)
  { 
	  if(conexion312.status == 200)
	  {   
		var nuevoID=conexion312.responseText;
		if (!isNaN(nuevoID)){
			nuevoRtoDePres=nuevoID;
			//ahora que cree el remito, le cargo los items
			  conexion313=new XMLHttpRequest(); 
			  conexion313.onreadystatechange = procesarEventos313;
			  var aleatorio=Math.random();
			  var obb=document.getElementById('NumeroComprobante').value;
			  //alert(nuevoID);
			  conexion313.open('GET','./php/llenar_remito_desde_presupuesto.php?&rnadom='+aleatorio+"&presup="+obb+"&idremit="+nuevoID, true);
			  conexion313.send();				  
		} else {
			mostrarAvisos("no se cargó el remito");
		}
	  }
  }
}

function procesarEventos313()
{
    if(conexion313.readyState == 4)
  { 
	  if(conexion313.status == 200)
	  {
		if (!isNaN(nuevoRtoDePres)){
			//var datosc=document.getElementById('informeRemito');
		  //datosc.innerHTML=conexion313.responseText;
		  //alert(nuevoRtoDePres);
			//ahora que le cargue los items,, imprimo el informe
			//if (document.getElementById('radio111').checked) {var descripExtendda='1'};
			//if (document.getElementById('radio112').checked) {var descripExtendda='0'};
			
			//if (document.getElementById('radio121').checked) {var serrie='1'};
			//if (document.getElementById('radio122').checked) {var serrie='0'};

			//var aleatorio=Math.random();
			window.open('Remitos.php',"_self");
			//window.open('./informes/informe_remito_desde_presup.php?idrto='+nuevoRtoDePres+"&descr="+descripExtendda+"&serie="+serrie+"&rnadom="+aleatorio);
		}			
	  }
  }
}

function procesarEventos314()
{
    if(conexion314.readyState == 4)
  { 
	  if(conexion314.status == 200)
	  {   
  
		var nVentana= window.open('"', '"', "width=595, height=841");
		nVentana.document.write(conexion314.responseText);
		//nVentana.document.close();
		nVentana.print();
		//nVentana.close();
	  }
  }
}

function btnkeydown(event)
{
	var KeyCode = event.KeyCode ? event.KeyCode : event.which ? event.which : event.charCode;
	if (event.ctrlKey) {	
	
		if (KeyCode==65)
		{
			event.preventDefault();
			if (!isNaN(nCom)){agregoArticuloAPresupXCodigoInt()};
		}
		}
}


var conexion27;
var idc;
var idp;
function revisarStock(IdDetalleComprobante,IdProducto) {
	idc=IdDetalleComprobante;
	idp=IdProducto;
	//alert(idc+' '+idp);
	conexion27=new XMLHttpRequest(); 
	conexion27.onreadystatechange = procesarEventos27;
	var aleatorio=Math.random();
	conexion27.open('GET','./php/reviso_detalle_presupuesto_stock.php?idcomprobante='+IdDetalleComprobante+"&rnadom="+aleatorio, true);
	conexion27.send();		
}

function procesarEventos27()
{
    if(conexion27.readyState == 4)
  { 
	  if(conexion27.status == 200)
	  {
		  //alert(conexion27.responseText);
		  document.getElementById(idc+'&'+idp+'&cantitem&E').style.backgroundColor = conexion27.responseText;
	  }
  }
}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}