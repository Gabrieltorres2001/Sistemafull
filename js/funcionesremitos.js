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
	listarRemitosMios();
	llenarAccionesRemitoJS();
	document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false); 
	document.getElementById('cierraAgregarIt').addEventListener('click',cerrarVentanaAgregaIt,false); 
	document.getElementById('cierralistaFacturas').addEventListener('click',cerrarVentanalistaFacturas,false); 
  document.getElementById('botonActualizaArticuloEnRemito').addEventListener('click',actualizoArticulo,false);
	document.getElementById('itemABuscar').addEventListener('keypress',teclaEnter,false);
	document.getElementById('botonBuscarArticuloEnRemito').addEventListener('click',busco,false);
	document.getElementById('cierraMovsAgArt').addEventListener('click',cerrarVentanaNuevoArt,false); 
	document.getElementById('botonSeleccionarComprobante').addEventListener('click',continuoConNC,false); 
}

var conexion1;
function llenarListadoRemitosJS(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1.open('GET','./php/llenar_listado_remitos.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('listaComprobantes').innerHTML=conexion1.responseText;
		  //listar todos los remitos MIOS
		  document.getElementById('listarMios').addEventListener('click',listarRemitosMios,false); 
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
function llenarDetalleRemitosJS(){
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  conexion3.open('GET','./php/llenar_encabezado_remitos.php?&rnadom='+aleatorio, true);
  conexion3.send();
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
		//mostrarAvisos(conexion3.responseText);
		document.getElementById('portada').innerHTML=conexion3.responseText;
	  }
  } 

}

var conexion4;
var conexion5;
function mostrarDetalles(celda){
	document.getElementById('informeRemito').innerHTML="";
	document.getElementById('informeFactura').innerHTML="";
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
  //el encabezado del remito
  document.getElementById('portada').innerHTML="";
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion4.open('GET','./php/llenar_encabezado_un_remito.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion4.send();
  // el detalle del remito
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  aleatorio=Math.random();
  conexion5.open('GET','./php/llenar_detalle_remito.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
	conexion5.send();
	llenarInformeRemitoJS();
	llenarInformeFacturaJS();
  mostrarFacturaProcesada();
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
		  	//$(document).ready(function() {
			//  $("#PlazoEntrega").select2();
			  //$("#PlazoEntrega").select2("open");
			//});
		  	//$(document).ready(function() {
			//  $("#Transporte").select2();
			  //$("#Transporte").select2("open");
			//});		  
			
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
		  esMio=document.getElementById('soyyoono').value;
		  if (datosce.value == '1') {
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PeticionOferta').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('numfactura').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	

			  } else {	  
					document.getElementById('asignarmeRemit').addEventListener('click',asignarmeRemito,false); 	
		  };}, 100);		  
		  document.getElementById('botonMailP').addEventListener('click',enviarMail,false);
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
		  setTimeout(function(){var datosce=document.getElementById('soyyoono');
		  //alert("no se refresca el valor si actualicé al articulo!");
		  //alert("le cambio la moneda y tampoco");
		  if (datosce.value == '1') {
			  //si soy yo, permito editar la tabla
			  //Lo hago solo para los xxxxt, ya que los xxxxtn no son editables.
			  var tags_td_camb = new Array();
  			  var tags_td_camb = document.getElementsByName('xxxxt');
			  for (i=0; i<tags_td_camb.length; i++) {
						tags_td_camb[i].addEventListener('change',cambioUnArticuloRemit,false);
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
						tags_td_elim[i].addEventListener('click',borrarArticuloRemit,false);
				};
			  //Nueva Diciembre 2018. Un click en el tilde de numero de serie lo agrega a la lista
			  var tags_td_OKNumSer = new Array();
  			  var tags_td_OKNumSer = document.getElementsByName('xxxNS');
			  for (i=0; i<tags_td_OKNumSer.length; i++) {
				tags_td_OKNumSer[i].addEventListener('click',agregarNumSerieArticuloRemit,false);
				};	
			  //Nueva Diciembre 2018. Un click en la cruz de numero de serie lo borra de la lista
			  var tags_td_XXNumSer = new Array();
  			  var tags_td_XXNumSer = document.getElementsByName('xxxBNS');
			  for (i=0; i<tags_td_XXNumSer.length; i++) {
				tags_td_XXNumSer[i].addEventListener('click',borrarNumSerieArticuloRemit,false);
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
						tags_td_actua[i].addEventListener('click',agregoArticuloARemit,false);			
				};				
			  //un click en el boton del + EN LA ULTIMA LINEA agrega un item POR CODIGO INTERNO
			  var tags_td_actuau = new Array();
  			  var tags_td_actuau = document.getElementsByName('xxxxuz');
			  for (i=0; i<tags_td_actuau.length; i++) {
						tags_td_actuau[i].addEventListener('click',agregoArticuloARemitXCodigoInt,false);
				};				
				};}, 100);
		  	//DOBLE CLICK EN LA LINEA GRIS TE LLEVA AL FORMULARIO DEL DETALLE DEL ARTICULO.
			//UN CLICK EN LA LINEA GRIS PERMITE EDITARLO (editablegrid).
		  	var tags_td_mov = new Array();
  			var tags_td_mov = document.getElementsByName('xxxx');
			  for (i=0; i<tags_td_mov.length; i++) {
						tags_td_mov[i].addEventListener('dblclick',mostrarDetallesArticulo,false);
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

function cambioUnArticuloRemit(celda)
{
	//Tengo que ver que eventos del viejo transfEnEditable me van a servir
	//alert(celda.target.id);
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[2];
	  switch(numeroartic){
		  case "ordenitem":
				//orden. Solo grabar el cambio de ese campo
				campoAEditar="Orden"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				break;
		  case "iditem":
				campoAEditar="IdProducto"
				//este no anda como quiero. pero por ahora me lo salteo para seguir avanzando.
				modificarArticuloTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				break;
		  case "cantitem":
				campoAEditar="Cantidad"
				//llamo a la funcion que graba en la BD el cambio de cantidad
				//Por ultimo tengo que actualizar el stock
				if (document.getElementById(palabras[0]+'&'+palabras[1]+'&chkcumplido').checked) {valor='1';} else {valor='0';}	
				modificarCantidadTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value,valor);
				//leo el campo UNITARIO, lo multiplico por el que acabo de cambiar (celda.target.value) y lo guardo en SUBTOTAL
				var nuevaCant=(parseFloat(celda.target.value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);	  
			  //Y eventualmente avisar si estoy vendiendo articulos sin stock. (o agregar un campo en stock en presupuestos/remitos/OC).
			  //Esto colocarlo en una funcion revisarStock para llamarlo desde aca y desde el campo cantidad. Y eventualmente desde presupuestos.
			  setTimeout(function(){revisarStock(palabras[0],palabras[1]);}, 100);
				break;
		  case "desc1item":
				campoAEditar="Descuento"
				modificarDescuentosTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				//primero verifico la moneda del campo UNITARIO
				//ESto es para ver cuantos digitos tengo que eliminar del precio unitario del articulo (4 ó 2)
				//4: "USD ", 2: "$ " ó "€ "
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(4);
				} else {
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(2);
				}
				//paso el string a numero decimal
				viejoUnitarioArticulo=parseFloat(viejoUnitarioArticuloTxt);
				//luego calculo el primer descuento
				var descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc1item&E').value);
				//Escribo el porcentaje que ingresó el usuario en formato porcentaje para que no se desoriente
				document.getElementById(palabras[0]+'&'+palabras[1]+'&desc1item&E').value=descuento.toFixed(2)+"%";
				//luego calculo el valor unitario con 1 descuento
				var descontado1=viejoUnitarioArticulo*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc2item&E').value);
				//luego calculo el valor unitario con 2 descuento
				var descontado2=parseFloat(descontado1)*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc3item&E').value);
				//luego calculo el valor unitario con 3 descuento
				var descontado3=parseFloat(descontado2)*(1-(parseFloat(descuento)/100))
				
				//luego grabo el nuevo unitario descontado
				if (descontado3<0.001){mostrarAvisos("El unitario queda en cero o negativo")};
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=descontado3.toFixed(2);
				//por ultimo recalculo el subtotal
				var nuevaCant=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cantitem&E').value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);			
				//POR ULTIMO. TENGO QUE REESTABLECER LA MONEDA DEL ARTICULO A LA ORIGINAL (si es que el usuario la habia cambiado)
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var monedaOriginal="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('€')!=-1){
						var monedaOriginal="€";
					} else {
						var monedaOriginal="$";
					}
				}
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('U')!=-1){
					//es en dolares
					var monedaUsuario="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('€')!=-1){
						var monedaUsuario="€";
					} else {
						var monedaUsuario="$";
					}
				}	
				if (monedaOriginal!=monedaUsuario){mostrarAvisos("No se olvide de verificar la moneda del artículo");}				
				break;
		  case "desc2item":
				campoAEditar="desc1"
				modificarDescuentosTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				//primero verifico la moneda del campo UNITARIO
				//ESto es para ver cuantos digitos tengo que eliminar del precio unitario del articulo (4 ó 2)
				//4: "USD ", 2: "$ " ó "€ "
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(4);
				} else {
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(2);
				}
				//paso el string a numero decimal
				viejoUnitarioArticulo=parseFloat(viejoUnitarioArticuloTxt);
				//luego calculo el primer descuento
				var descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc1item&E').value);
				//luego calculo el valor unitario con 1 descuento
				var descontado1=viejoUnitarioArticulo*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc2item&E').value);
				//Escribo el porcentaje que ingresó el usuario en formato porcentaje para que no se desoriente
				document.getElementById(palabras[0]+'&'+palabras[1]+'&desc2item&E').value=descuento.toFixed(2)+"%";
				//luego calculo el valor unitario con 2 descuento
				var descontado2=parseFloat(descontado1)*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc3item&E').value);
				//luego calculo el valor unitario con 3 descuento
				var descontado3=parseFloat(descontado2)*(1-(parseFloat(descuento)/100))
				
				//luego grabo el nuevo unitario descontado
				if (descontado3<0.001){mostrarAvisos("El unitario queda en cero o negativo")};
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=descontado3.toFixed(2);
				//por ultimo recalculo el subtotal
				var nuevaCant=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cantitem&E').value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);		
				//POR ULTIMO. TENGO QUE REESTABLECER LA MONEDA DEL ARTICULO A LA ORIGINAL (si es que el usuario la habia cambiado)
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var monedaOriginal="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('€')!=-1){
						var monedaOriginal="€";
					} else {
						var monedaOriginal="$";
					}
				}
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('U')!=-1){
					//es en dolares
					var monedaUsuario="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('€')!=-1){
						var monedaUsuario="€";
					} else {
						var monedaUsuario="$";
					}
				}	
				if (monedaOriginal!=monedaUsuario){mostrarAvisos("No se olvide de verificar la moneda del artículo");}				
				break;
		  case "desc3item":
				campoAEditar="desc2"
				modificarDescuentosTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				//primero verifico la moneda del campo UNITARIO
				//ESto es para ver cuantos digitos tengo que eliminar del precio unitario del articulo (4 ó 2)
				//4: "USD ", 2: "$ " ó "€ "
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(4);
				} else {
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(2);
				}
				//paso el string a numero decimal
				viejoUnitarioArticulo=parseFloat(viejoUnitarioArticuloTxt);
				//luego calculo el primer descuento
				var descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc1item&E').value);
				//luego calculo el valor unitario con 1 descuento
				var descontado1=viejoUnitarioArticulo*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc2item&E').value);
				//luego calculo el valor unitario con 2 descuento
				var descontado2=parseFloat(descontado1)*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc3item&E').value);
				//Escribo el porcentaje que ingresó el usuario en formato porcentaje para que no se desoriente
				document.getElementById(palabras[0]+'&'+palabras[1]+'&desc3item&E').value=descuento.toFixed(2)+"%";
				//luego calculo el valor unitario con 3 descuento
				var descontado3=parseFloat(descontado2)*(1-(parseFloat(descuento)/100))
				
				//luego grabo el nuevo unitario descontado
				if (descontado3<0.001){mostrarAvisos("El unitario queda en cero o negativo")};
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=descontado3.toFixed(2);
				//por ultimo recalculo el subtotal
				var nuevaCant=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cantitem&E').value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);		
				//POR ULTIMO. TENGO QUE REESTABLECER LA MONEDA DEL ARTICULO A LA ORIGINAL (si es que el usuario la habia cambiado)
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var monedaOriginal="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('€')!=-1){
						var monedaOriginal="€";
					} else {
						var monedaOriginal="$";
					}
				}
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('U')!=-1){
					//es en dolares
					var monedaUsuario="USD";
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&monedaitem&E').value).indexOf('€')!=-1){
						var monedaUsuario="€";
					} else {
						var monedaUsuario="$";
					}
				}	
				if (monedaOriginal!=monedaUsuario){mostrarAvisos("No se olvide de verificar la moneda del artículo");}
				break;
		  case "monedaitem":
				//Antes que nada tengo que saber la moneda del articulo y la moneda nueva seleccionada por el usuario
				//Busco la moneda del producto. Lo mismo que en Descuentos%
				//4: "USD ", 2: "$ " ó "€ "
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var monedaOriginal="USD";
					var cambioOriginal=parseFloat((document.getElementById('DolarHoy').innerHTML).replace(",","."));
				} else {
					if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('€')!=-1){
						var monedaOriginal="€";
						var cambioOriginal=parseFloat((document.getElementById('EuroHoy').innerHTML).replace(",","."));
					} else {
						var monedaOriginal="$";
						var cambioOriginal=parseFloat("1");
					}
				}
				//Ahora busco la moneda y el tipo de cambio nuevos
				if ((celda.target.value).indexOf('U')!=-1){
					//es en dolares
					var monedaNueva="USD";
					var monedaNuevaN="2";
					var cambioNueva=parseFloat((document.getElementById('DolarHoy').innerHTML).replace(",","."));
				} else {
					if ((celda.target.value).indexOf('€')!=-1){
						var monedaNueva="€";
						var monedaNuevaN="61";
						var cambioNueva=parseFloat((document.getElementById('EuroHoy').innerHTML).replace(",","."));
					} else {
						var monedaNueva="$";
						var monedaNuevaN="1";
						var cambioNueva="1";
					}
				}
				//alert (monedaUsuario);
				//Luego leo el precio original y los descuentos
				//NO SE SI ESTO ESTA BIEN (porque pierdo algun valor ingresado a mano por el usuario). PERO ME PARECE LA MEJOR OPCION
				//(porque sino cuando volvia a la moneda original no hacía nada y parecia un error)
//---------------------Copio el mismo codigo de Descuento %3
				//primero verifico la moneda del campo UNITARIO
				//ESto es para ver cuantos digitos tengo que eliminar del precio unitario del articulo (4 ó 2)
				//4: "USD ", 2: "$ " ó "€ "
				if ((document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).indexOf('U')!=-1){
					//es en dolares
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(4);
				} else {
					var viejoUnitarioArticuloTxt=(document.getElementById(palabras[0]+'&'+palabras[1]+'&unititem').innerHTML).substr(2);
				}
				//paso el string a numero decimal
				viejoUnitarioArticulo=parseFloat(viejoUnitarioArticuloTxt);
				//luego calculo el primer descuento
				var descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc1item&E').value);
				//luego calculo el valor unitario con 1 descuento
				var descontado1=viejoUnitarioArticulo*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc2item&E').value);
				//luego calculo el valor unitario con 2 descuento
				var descontado2=parseFloat(descontado1)*(1-(parseFloat(descuento)/100))
				//Leo el segundo descuento
				descuento=parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&desc3item&E').value);
				//luego calculo el valor unitario con 3 descuento
				var descontado3=parseFloat(descontado2)*(1-(parseFloat(descuento)/100))
				
				//luego grabo el nuevo unitario descontado
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=descontado3.toFixed(2);
//---------------------------------				
				//por ultimo recalculo el subtotal
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//paso el viejo unitario a pesos
				var viejoUnitarioAPesos=viejoUnitario*parseFloat(cambioOriginal);
				//Paso el viejo unitario en pesos al nuevo unitario en moneda elegida
				var nuevoUnitario=viejoUnitarioAPesos/parseFloat(cambioNueva);
				//grabo el nuevo unitario
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=nuevoUnitario.toFixed(2);
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevaCant=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cantitem&E').value));
				var nuevoNum=nuevaCant*nuevoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);						

				//luego guardo la moneda en la tabla
				campoAEditar="Moneda"
				//alert(celda.target.value);
				modificarMonedaTablaDetalleComprobante(palabras[0],campoAEditar,monedaNuevaN);	
				//Por ultimo guardo los nuevos valores de unitario y subtotal en la base de datos
				campoAEditar="CostoUnitario"
				modificarUnitarioTablaDetalleComprobante(palabras[0],campoAEditar,nuevoUnitario);
				break;
		  case "descontadoitem":
				campoAEditar="CostoUnitario"
				if (parseFloat(celda.target.value)<0.001){mostrarAvisos("El unitario queda en cero o negativo")};
				modificarUnitarioTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				//leo el campo CANTIDAD, lo multiplico por el que acabo de cambiar (newValue) y lo guardo en SUBTOTAL
				var nuevaCant=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&cantitem&E').value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value=viejoUnitario.toFixed(2);	
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);						
				break;
		  case "subtotitem":
				campoAEditar="SubTotal"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				var nuevoNum=parseFloat(celda.target.value);
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);	
				break;
		  case "serieitem":
				campoAEditar="NumeroSerie"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);						
				break;
		  case "obsitem":
				campoAEditar="Destino"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);					
				break;
		  case "chkcumplido":			
			  //Uno nuevo. Los chkcumplido que son los check de cumplido o no (mover stock).
			  campoAEditar="Cumplido";
			  if (celda.target.checked) {valor='1';} else {valor='0';}
			  modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,valor);	
			  //Aca no solo tengo que registrar el cambio de estado en detalle comprobante, sino que ademas
			  //tambien tengo que modificar el stock del articulo.
			  modificarStockArticulo(palabras[0],valor);		  
			  //Y eventualmente avisar si estoy vendiendo articulos sin stock. (o agregar un campo en stock en presupuestos/remitos/OC).
			  //Esto colocarlo en una funcion revisarStock para llamarlo desde aca y desde el campo cantidad. Y eventualmente desde presupuestos.
			  setTimeout(function(){revisarStock(palabras[0],palabras[1]);}, 100);
				break;
	  };
}


var conexion7;
function imprimir() {
	document.getElementById('informe').disabled=true;
	//document.getElementById('NumeroComprobante');
	var numRemit=document.getElementById('NumeroComprobante');
	if (document.getElementById('radio111').checked) {var descripExtendda='1'};
	if (document.getElementById('radio112').checked) {var descripExtendda='0'};
	
	if (document.getElementById('radio121').checked) {var serrie='1'};
	if (document.getElementById('radio122').checked) {var serrie='0'};
  var dirRemit=document.getElementById('direcRemito');
  //alert (dirRemit.value);
  var aleatorio=Math.random();
  //Nueva 2018. Remito con preimpreso
  if (document.getElementById('radio131').checked) {
		window.open('./informes/Informe.php?idrto='+numRemit.value+"&descr="+descripExtendda+"&serie="+serrie+"&rnadom="+aleatorio+"&diRemito="+dirRemit.value+"&tipoInforme=Remito");}
  //Nueva 2018. Remito con hoja en blanco
  if (document.getElementById('radio132').checked) {
	  //para esta opcion SI O SI tiene que existir numero de preimpreso
	  //alert(document.getElementById('preimpreso').value);
	  if((isNaN(document.getElementById('preimpreso').value))||(document.getElementById('preimpreso').value.length<1)){
		  mostrarAvisos("Tiene que existir un número de preimpreso válido");}
		  else {
				window.open('./informes/Informe.php?idrto='+numRemit.value+"&descr="+descripExtendda+"&serie="+serrie+"&rnadom="+aleatorio+"&diRemito="+dirRemit.value+"&numPreimpreso="+document.getElementById('preimpreso').value+"&tipoInforme=remito_hoja_limpia");			  
			}}
  
  document.getElementById('informe').disabled=false;
}

var conexion8;
var conexion9;
function mostrarDetallesArticulo(celda)
{
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if (numeroartic<=0){
		agregoArticuloARemit(celda);
	} else {
		  lineaArtic=palabras[0];
		  //alert(lineaArtic);
		  document.getElementById('fondoClaro').style.visibility='visible';
		  document.getElementById('detallesdemovimientos').style.visibility='visible';
		  //var numeroartic=celda.target.name;
		  //el encabezado del remito
		  conexion8=new XMLHttpRequest(); 
		  conexion8.onreadystatechange = procesarEventos8;
		  var aleatorio=Math.random();
		  conexion8.open('GET','./php/detallesarticulo.php?idart='+numeroartic+"&rnadom="+aleatorio, true);
		  conexion8.send();
		  // el detalle del remito
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
		  document.getElementById('detallesdemovimientosFRMSup').innerHTML=conexion8.responseText;
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
	//alert(lineaArtic);
	
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
function llenarInformeRemitoJS(){
  conexion11=new XMLHttpRequest(); 
  conexion11.onreadystatechange = procesarEventos11;
  var aleatorio=Math.random();
  conexion11.open('GET','./php/llenar_informe_remito.php?&rnadom='+aleatorio, true);
  conexion11.send();
}

function procesarEventos11()
{
    if(conexion11.readyState == 4)
  { 
	  if(conexion11.status == 200)
	  { 
		  document.getElementById('informeRemito').innerHTML=conexion11.responseText;
		  //habilito la funcion del boton "Informe"
		  document.getElementById('informe').addEventListener('click',imprimir,false);
		  //muestro un cuadro de texto para escribir el Tipo de Cambio al habilitar el <input type='radio' id='radio32' name='moneda'>En Pesos</option>
		  document.getElementById('radio32').addEventListener('change',muestraTipoCambio,false); 
		  document.getElementById('radio31').addEventListener('change',ocultaTipoCambio,false); 
	  }
  } 
}

var conexion12;
function llenarAccionesRemitoJS(){
  //var numeroComprobante=celda.target.id;
  //el encabezado del remito
  conexion12=new XMLHttpRequest(); 
  conexion12.onreadystatechange = procesarEventos12;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion12.open('GET','./php/llenar_acciones_remitos.php?rnadom='+aleatorio+"&sesses="+obnn, true);
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
		document.getElementById('nuevoRemito').addEventListener('click',mostrarDescolgableListadoEmpresas,false); 
	  }
  } 

}


var conexion13;
function mostrarDescolgableListadoEmpresas(){
  conexion13=new XMLHttpRequest(); 
  conexion13.onreadystatechange = procesarEventos13;
  var aleatorio=Math.random();
  conexion13.open('GET','./php/llenar_descolgable_listado_empresas_R.php?&rnadom='+aleatorio, true);
  conexion13.send();
}

var tipoComprobante="Remito";
function procesarEventos13()
{
    if(conexion13.readyState == 4)
  { 
	  if(conexion13.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion13.responseText;
		  	$(document).ready(function() {$("#empresa").select2();
			  															$("#empresa").select2("open");});
		  //habilito la funcion del boton "Listo"
		  //agregarUnNuevoComprobante ahora esta en funcionescomunes.js
			document.getElementById('listoNuevoPre').addEventListener('click',agregarUnNuevoComprobante,false); 
	  }
  } 

}
//agregarUnNuevoComprobante ahora esta en funcionescomunes.js
function procesarEventos14()
{
    if(conexion14.readyState == 4)
  { 
	  if(conexion14.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion14.responseText;
		  //acciones para el boton nuevo remito
		  document.getElementById('nuevoRemito').addEventListener('click',mostrarDescolgableListadoEmpresas,false); 
		  //actualizo los otros DIV
		  llenarListadoRemitosJS();
		  var obnprc=document.getElementById('NumeroRemitoRecienCreado').innerHTML;
		  mostrarDetalles(obnprc);
		  setTimeout(function(){mostrarDetallesRemitoNuevo(obnprc);
			if(!isNaN(nCom)){document.getElementById(nCom).style.backgroundColor="transparent";}
			document.getElementById(obnprc).style.backgroundColor="#809fff";}, 1000);
	  }
  } 

}

var conexion15;
function mostrarDetallesRemitoNuevo(celda){
  var numeroComprobante=celda;
  //el encabezado del remito
  conexion15=new XMLHttpRequest(); 
  conexion15.onreadystatechange = procesarEventos15;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion15.open('GET','./php/llenar_encabezado_un_remitoNUEVO.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
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
			guardaCambiosEncabezadoRemito();
		  //document.getElementById('cambiaDatos').addEventListener('click',habilitarDetallesEncabezadoRemito,false); 
		  //document.getElementById('aceptarCambiaDatos').addEventListener('click',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PeticionOferta').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('numfactura').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	
			document.getElementById('botonMailP').addEventListener('click',enviarMail,false);
	  }
  } 

}
  
var conexion16;
function guardaCambiosEncabezadoRemito()
{
	//PRIMERO HABILITO Y DESHABILITO LOS BOTONES Y TEXTBOXES
	//document.getElementById('cambiaDatos').disabled=false;

	//document.getElementById('Solicita').disabled=true;
	//document.getElementById('CondicionesPago').disabled=true;
	//document.getElementById('PlazoEntrega').disabled=true;
	//document.getElementById('Transporte').disabled=true;
	//document.getElementById('PeticionOferta').disabled=true;
	//document.getElementById('Notas').disabled=true;
	//document.getElementById('aceptarCambiaDatos').disabled=true;
	//document.getElementById('preimpreso').disabled=true;
	//document.getElementById('numfactura').disabled=true;
	
	//AHORA SOLO ME FALTA GRABAR LOS CAMBIOS!!
	var numRemit=document.getElementById('NumeroComprobante').value;
	var numSolicit=document.getElementById('Solicita').value;
	var numCPago=document.getElementById('CondicionesPago').value;
	var numPEntrega=document.getElementById('PlazoEntrega').value;
	var numTransp=document.getElementById('Transporte').value;
	var txtPetOfer=encodeURIComponent(document.getElementById('PeticionOferta').value);
	var txtNotas=encodeURIComponent(document.getElementById('Notas').value);
	var txtPreimpreso=encodeURIComponent(document.getElementById('preimpreso').value);	
	var txtNumFac=encodeURIComponent(document.getElementById('numfactura').value);	
	
	conexion16=new XMLHttpRequest(); 
    conexion16.onreadystatechange = procesarEventos16;
    var aleatorio=Math.random();
    var obnn=document.getElementById('numberses').value;
	conexion16.open('GET','./php/actualizo_encabezado_remito.php?numremito='+numRemit+"&rnadom="+aleatorio+"&sesses="+obnn+"&solicitaa="+numSolicit+"&numCcPago="+numCPago+"&numPpEntrega="+numPEntrega+"&numTtransp="+numTransp+"&textPetOfer="+txtPetOfer+"&textNotas="+txtNotas+"&textPreimpreso="+txtPreimpreso+"&textNumFac="+txtNumFac, true);
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
		  //document.getElementById('aceptarCambiaDatos').addEventListener('click',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('PeticionOferta').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('Notas').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	
			document.getElementById('preimpreso').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 
			document.getElementById('numfactura').addEventListener('blur',guardaCambiosEncabezadoRemito,false); 	
			document.getElementById('botonMailP').addEventListener('click',enviarMail,false);		  
	  }
  } 

} 

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



var conexion17;
function modificarCampoTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion17=new XMLHttpRequest(); 
	//conexion17.onreadystatechange = procesarEventos17;
	var aleatorio=Math.random();
	var cadena=encodeURIComponent(newValue);
	conexion17.open('GET','./php/actualizo_detalle_remito_orden.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+cadena+"&rnadom="+aleatorio, true);
	conexion17.send();
	//ya esta. Se ve en la tabla y ademas (confio en que) se grabo en la BD
}


var conexion18;
function modificarCantidadTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue,checkStock){
	conexion18=new XMLHttpRequest(); 
	//conexion18.onreadystatechange = procesarEventos18;
	var aleatorio=Math.random();
	conexion18.open('GET','./php/actualizo_detalle_remito_cantidad.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&chkstk="+checkStock+"&rnadom="+aleatorio, true);
	conexion18.send();
	//no DEBO actualizar automaticamente

}

function procesarEventos18()
{
    if(conexion18.readyState == 4)
  { 
	  if(conexion18.status == 200)
	  { 
		mostrarAvisos(conexion18.responseText);
	  }
  } 

}

var conexion19;
function modificarDescuentosTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion19=new XMLHttpRequest(); 
	conexion19.onreadystatechange = procesarEventos19;
	var aleatorio=Math.random();
	conexion19.open('GET','./php/actualizo_detalle_remito_descuentos.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
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
		  //var datosc=document.getElementById('portada');
		  //datosc.innerHTML=datosc.innerHTML+conexion19.responseText;
	  }
  } 

}

var conexion20;
function modificarArticuloTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion20=new XMLHttpRequest(); 
	conexion20.onreadystatechange = procesarEventos20;
	var aleatorio=Math.random();
	conexion20.open('GET','./php/actualizo_detalle_remito_articulo.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
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
		//mostrarAvisos(conexion21.responseText);
		  //var datosc=document.getElementById('portada');
		  //datosc.innerHTML=datosc.innerHTML+conexion21.responseText;
	  }
  } 

}


var conexion22;
function modificarUnitarioTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion22=new XMLHttpRequest(); 
	conexion22.onreadystatechange = procesarEventos22;
	var aleatorio=Math.random();
	conexion22.open('GET','./php/actualizo_detalle_remito_unitario.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+newValue+"&rnadom="+aleatorio, true);
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
		//mostrarAvisos(conexion22.responseText);
		  //var datosc=document.getElementById('portada');
		  //datosc.innerHTML=datosc.innerHTML+conexion22.responseText;
	  }
  } 

}

var conexion25;
var conexion25a;
function borrarArticuloRemit(celda){
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if(confirm("Borrar el artículo "+numeroartic+" de este remito?")== true) {
		conexion25=new XMLHttpRequest(); 
		conexion25.onreadystatechange = procesarEventos25;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		conexion25.open('GET','./php/borro_articulo_detalle_remito.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio, true);
		conexion25.send();
		//Tambien borro los numeros de serie asociados
		conexion25a=new XMLHttpRequest(); 
		conexion25a.onreadystatechange = procesarEventos29;
		var aleatorio=Math.random();
		conexion25a.open('GET','./php/borro_numeros_serie_todos.php?iddetalle='+numeroPosic+"&rnadom="+aleatorio, true);
		conexion25a.send();		
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
		//document.getElementById('portada').innerHTML=document.getElementById('portada').innerHTML+conexion25.responseText;
		//alert(conexion25.responseText);
	  }
  } 
}

//Nueva Diciembre 2018.Agregar numeros de serie uno por uno a la tabla
var conexion28;
var conexion28a;
function agregarNumSerieArticuloRemit(celda){
	var ambosid=celda.target.id;
	//alert(ambosid);
	var palabras = ambosid.split("&");
	if(document.getElementById(palabras[0]+'&'+palabras[1]+'&serieitem&E').value.length==0) {mostrarAvisos("No hay número de serie para agregar!");} else {
		var numeroartic = palabras[1];
		conexion28=new XMLHttpRequest(); 
		conexion28.onreadystatechange = procesarEventos28;
		var numeroPosic = palabras[0];
		var serieAagregar = document.getElementById(palabras[0]+'&'+palabras[1]+'&serieitem&E').value;
		var aleatorio=Math.random();
		conexion28.open('GET','./php/agrego_numero_serie.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio+"&numeroSerie="+serieAagregar, true);
		conexion28.send();
		document.getElementById(palabras[0]+'&'+palabras[1]+'&serieitem&E').value="";
		//Actualizar (solo este detallecomprobante)
		conexion28a=new XMLHttpRequest(); 
		conexion28a.onreadystatechange = procesarEventos28a;
		aleatorio=Math.random();
		document.getElementById(palabras[0]+'&'+palabras[1]+'&serieitem').innerHTML="";
		conexion28a.open('GET','./php/actualizar_detalle_numero_serie.php?iddetalle='+palabras[0]+"&rnadom="+aleatorio, true);
		conexion28a.send();
		palabras0=palabras[0];
		palabras1=palabras[1];
	}
}

function procesarEventos28()
{
    if(conexion28.readyState == 4)
  { 
	  if(conexion28.status == 200)
	  { 
		if (conexion28.responseText.length==0) {} else {mostrarAvisos(conexion28.responseText);}
	  }
  } 

}


function procesarEventos28a()
{
    if(conexion28a.readyState == 4)
  { 
	  if(conexion28a.status == 200)
	  { 
		document.getElementById(palabras0+'&'+palabras1+'&serieitem').innerHTML=conexion28a.responseText;
		//Nueva Diciembre 2018. Un click en el tilde de numero de serie lo agrega a la lista
		var tags_td_OKNumSer = new Array();
		var tags_td_OKNumSer = document.getElementsByName('xxxNS');
		for (i=0; i<tags_td_OKNumSer.length; i++) {
		tags_td_OKNumSer[i].addEventListener('click',agregarNumSerieArticuloRemit,false);
		};	
		//Nueva Diciembre 2018. Un click en la cruz de numero de serie lo borra de la lista
		var tags_td_XXNumSer = new Array();
		var tags_td_XXNumSer = document.getElementsByName('xxxBNS');
		for (i=0; i<tags_td_XXNumSer.length; i++) {
		tags_td_XXNumSer[i].addEventListener('click',borrarNumSerieArticuloRemit,false);
		};
	  }
  } 

}

//Nueva Diciembre 2018.Borrar numeros de serie uno por uno de la tabla
var conexion29;
var conexion29a;
function borrarNumSerieArticuloRemit(celda){
	var ambosid=celda.target.id;
	//alert(ambosid);
	var palabras = ambosid.split("&");
	if(confirm("Borrar el numero de serie "+document.getElementById(palabras[0]+'&'+palabras[1]+'&'+palabras[2]+'&serieitem&E').value+" de este comprobante?")== true) {
		var numeroartic = palabras[1];
		conexion29=new XMLHttpRequest(); 
		conexion29.onreadystatechange = procesarEventos29;
		var numeroPosic = palabras[2];
		var aleatorio=Math.random();
		conexion29.open('GET','./php/borro_numero_serie.php?idserie='+numeroPosic+"&rnadom="+aleatorio, true);
		conexion29.send();
		//Actualizar (solo este detallecomprobante)
		conexion29a=new XMLHttpRequest(); 
		conexion29a.onreadystatechange = procesarEventos29a;
		aleatorio=Math.random();
		document.getElementById(palabras[0]+'&'+palabras[1]+'&serieitem').innerHTML="";
		conexion29a.open('GET','./php/actualizar_detalle_numero_serie.php?iddetalle='+palabras[0]+"&rnadom="+aleatorio, true);
		conexion29a.send();
		palabras0=palabras[0];
		palabras1=palabras[1];
	}
}

function procesarEventos29()
{
    if(conexion29.readyState == 4)
  { 
	  if(conexion29.status == 200)
	  { 
		mostrarAvisos(conexion29.responseText);
	  }
  } 

}


function procesarEventos29a()
{
    if(conexion29a.readyState == 4)
  { 
	  if(conexion29a.status == 200)
	  { 
		document.getElementById(palabras0+'&'+palabras1+'&serieitem').innerHTML=conexion29a.responseText;
		//Nueva Diciembre 2018. Un click en el tilde de numero de serie lo agrega a la lista
		var tags_td_OKNumSer = new Array();
		var tags_td_OKNumSer = document.getElementsByName('xxxNS');
		for (i=0; i<tags_td_OKNumSer.length; i++) {
		tags_td_OKNumSer[i].addEventListener('click',agregarNumSerieArticuloRemit,false);
		};	
		//Nueva Diciembre 2018. Un click en la cruz de numero de serie lo borra de la lista
		var tags_td_XXNumSer = new Array();
		var tags_td_XXNumSer = document.getElementsByName('xxxBNS');
		for (i=0; i<tags_td_XXNumSer.length; i++) {
		tags_td_XXNumSer[i].addEventListener('click',borrarNumSerieArticuloRemit,false);
		};
	  }
  } 

}

function actualizArticuloRemit(celda){
	//antes deberia releer y regrabar todos los campos!! (sino hay datos que no se actualizan salvo que modifique 2 veces un descuento)
		mostrarDetalles(nCom);
}

function agregoArticuloARemitXCodigoInt(){
	var nuevoId=prompt("Código de artículo?");
	//alert (nuevoId);
	if ((!isNaN(nuevoId))&&(nuevoId>0)){
		//el numero en celda es el id del articulo que elegi
		agregaItemNuevoV2(nuevoId);
	}
}

function agregoArticuloARemit(){
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('agregarItemAlComprobante').style.visibility='visible';
}

function enviarMail()
{
	//alert("Este botón enviará un mail al contacto próximamente");
	window.location.href='mailto:'+document.getElementById('DirecciondecorreoelectronicoP').value;
	//document.write('<a href="mailto:juan@hotmail.com"></a>');

}

var conexion121;
function asignarmeRemito(){
	if (confirm("Seguro que desea asignarse este remito a su nombre?")== true){
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

var conexion301;
function listarRemitosMios(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion301=new XMLHttpRequest(); 
  conexion301.onreadystatechange = procesarEventos301;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion301.open('GET','./php/llenar_listado_remitos_MIOS.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
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
			document.getElementById('listarTodos').addEventListener('click',llenarListadoRemitosJS,false); 
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

var conexion401;
function llenarInformeFacturaJS(){
  conexion401=new XMLHttpRequest(); 
  conexion401.onreadystatechange = procesarEventos401;
  var aleatorio=Math.random();
  conexion401.open('GET','./php/llenar_informe_factura.php?&rnadom='+aleatorio, true);
  conexion401.send();
}

function procesarEventos401()
{
    if(conexion401.readyState == 4)
  { 
	  if(conexion401.status == 200)
	  { 
		  document.getElementById('informeFactura').innerHTML=conexion401.responseText;
		  //habilito la funcion del boton "InformeFac"
		  document.getElementById('informeFac').addEventListener('click',imprimirFactura,false);
		  document.getElementById('previaFac').addEventListener('click',simularFactura,false);
		  document.getElementById('informeFacCAI').addEventListener('click',imprimirFacturaCAI,false);
		  //muestro un cuadro de texto para escribir el Tipo de Cambio al habilitar el <input type='radio' id='radio32' name='moneda'>En Pesos</option>
		  document.getElementById('radio262').addEventListener('change',muestraTipoCambioFac,false); 
		  document.getElementById('radio261').addEventListener('change',ocultaTipoCambioFac,false); 		  
	  }
  } 
}

//FacturaCAE
var conexion407;
function imprimirFactura() {
	document.getElementById('informeFac').disabled=true;
	if (confirm("Emitir comprobante fiscal?")== true){
	  conexion407=new XMLHttpRequest(); 
	  conexion407.onreadystatechange = procesarEventos407;
	  var aleatorio=Math.random();
	  conexion407.open('GET','./afip/test/TestWSAA.php?&rnadom='+aleatorio, true);
	  conexion407.send();
	} else {
			  mostrarAvisos("Comprobante no generado");
			  document.getElementById('informeFac').disabled=false;
	}	  
}

var tipoFactura;
var conexion408;
function procesarEventos407()
{
    if(conexion407.readyState == 4)
  { 
	  if(conexion407.status == 200)
	  {   
		//alert(conexion407.responseText);
		
		 var datosc=document.getElementById('informeFactura'); 
		  if (conexion407.responseText.substr(0,5)=="OkOko") 
		  {
			  //return;
			  //primero tengo que verificar:
			  //Si el usuario quiere una Factura o NC/ND
			  if (document.getElementById('radio241').checked){
				  //Factura
				  //YA TIENE NUMERO DE FACTURA
				  if ((document.getElementById('numfactura').value.length > 0)){mostrarAvisos("El campo número de factura no se encuentra vacío. Se asume que ya existe una factura para este comprobante y no se puede continuar");}
				  else {//campo factura vacío. continúo con la factura.
					  conexion408=new XMLHttpRequest(); 
					  conexion408.onreadystatechange = procesarEventos408;
					  var aleatorio=Math.random();
					  var dirRemit=document.getElementById('direcRemito');
					  conexion408.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
					  conexion408.send();
			  };}
			  if ((document.getElementById('radio242').checked)||(document.getElementById('radio243').checked)){
				  //NC o ND
				  //NO TIENE NUMERO DE FACTURA
				  if ((document.getElementById('numfactura').value.length < 1)){mostrarAvisos("El campo número de factura se encuentra vacío. Se asume que no existe una factura para este comprobante y no se puede continuar");}
				  else {//campo factura NO vacío. continúo con la NC o ND.
					//Enero 2019. Nuevo cambio. Antes que nada debo avisar a que comprobante tengo que asociar la NC
					if (document.getElementById('radio242').checked){
						//NC
						//Luego de terminar la función que voy a llamar, tengo que copiar el mismo códgo de la ND
						seleccionarComprobanteACancelar();
					} else {
						//ND
					  conexion408=new XMLHttpRequest(); 
					  conexion408.onreadystatechange = procesarEventos408;
					  var aleatorio=Math.random();
					  var dirRemit=document.getElementById('direcRemito');
					  conexion408.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
						conexion408.send();
					}
			  };}
		  } 
		  else {
			  //aviso del error de generacion de token y sign de AFIP WSAA
			  mostrarAvisos(conexion407.responseText)};
			  document.getElementById('informeFac').disabled=false;
	  }
  }
}

//Febrero 2019. Si hago una NC tengo que cancelar una FC o ND
//Lo hago con esta función
var conexion1_2019;
function seleccionarComprobanteACancelar(){
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
	conexion1_2019.open('GET','./php/buscar_cuit_x_comprobante.php?idcomp='+nCom+'&rnadom='+aleatorio, true);
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
			conexion2_2019.open('GET','./php/buscar_facturas_x_cuit_paraNC.php?cuitemp='+conexion1_2019.responseText+'&rnadom='+aleatorio, true);
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
				tags_tdm[ii].addEventListener('click',mostrarDetallesParaNC,false);
				r=ii;
		  }
	  }
  } 
}

var conexion5_2019;
var nComNC;
function mostrarDetallesParaNC(celda){
	//alert(celda);
	//alert(celda.target.id);
if (isNaN(celda))
  {
	if(!isNaN(nComNC)){if(!(document.getElementById(nComNC)==null)){document.getElementById(nComNC).style.backgroundColor="transparent";}}
	document.getElementById(celda.target.id).style.backgroundColor="#809fff";
		var numeroComprobante=celda.target.id;
		document.getElementById('botonSeleccionarComprobante').disabled=false;
		document.getElementById('botonSeleccionarComprobante').addEventListener('click',continuoConNC,false); 
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

function continuoConNC()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('listaFacturas').style.visibility='hidden';
	//ver que falta de la línea que no funciona. seguramente algo local.
	conexion408=new XMLHttpRequest(); 
	conexion408.onreadystatechange = procesarEventos408;
	var aleatorio=Math.random();
	var dirRemit=document.getElementById('direcRemito');
	conexion408.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
	conexion408.send();
}
//2019-02. Aca termina el nuevo codigo para seleccionar FC o ND a cancelar con NC.
//Falta luego, una vez que se hizo la ND con AFIP, descontarla del listado de cuentas corrientes.
//y no olvidar vaciar la variable nComNC una vez terminado.

function cerrarVentanalistaFacturas()
{
	document.getElementById('fondoClaro').style.visibility='hidden';
	document.getElementById('listaFacturas').style.visibility='hidden';
	mostrarAvisos("Nota de crédito no emitida porque no se seleccionó comprobante a cancelar");
	document.getElementById('informeFac').disabled=false;
}


var conexion409;
function procesarEventos408()
{
    if(conexion408.readyState == 4)
  { 
	  if(conexion408.status == 200)
	  {   
  		 var datosRecib=JSON.parse(conexion408.responseText);
		 //alert(conexion408.responseText);
		 if (datosRecib.CondicionesPago.length < 1){mostrarAvisos("Verifique la condición de pago"); document.getElementById('informeFac').disabled=false;}
			else {
				 if (datosRecib.Provoestado.length < 1){mostrarAvisos("Verifique la provincia de la Empresa"); document.getElementById('informeFac').disabled=false;}
					else {
						if ((datosRecib.CUIT.length < 7)||(datosRecib.CUIT.length > 13)){mostrarAvisos("Verifique el CUIT de la Empresa"); document.getElementById('informeFac').disabled=false;}
							else {
								cuitCliente=datosRecib.CUIT;
								if (datosRecib.CondicionIVA.length < 1){mostrarAvisos("Verifique la condición de IVA de la Empresa"); document.getElementById('informeFac').disabled=false;}
									else {
										//alert ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'));
										if ((datosRecib.tipoComprobante.length < 1)||(isNaN(datosRecib.tipoComprobante)) || (datosRecib.tipoComprobante==0)|| ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'))){mostrarAvisos("Verifique el tipo de comprobante de la Empresa"); document.getElementById('informeFac').disabled=false;}
										else {
											//Pasó las PRIMERAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
											//ver las monedas de cada item. verificar que sean todas iguales. Sino no puedo seguir.
											//ver que la factura no de cero o negativo
											if (datosRecib.tipoComprobante=='1') {tipoFactura='A'};
											if (datosRecib.tipoComprobante=='6') {tipoFactura='B'};
											//alert (tipoFactura);
											conexion409=new XMLHttpRequest(); 
											conexion409.onreadystatechange = procesarEventos409;
											var aleatorio=Math.random();
											//alert (nCom);
											conexion409.open('GET','./php/verificar_monedas_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom, true);
											conexion409.send();
										}
									}
							}
					}
			}
	  }
  }
}

var conexion410;
var monedaItemsFact;
function procesarEventos409()
{
    if(conexion409.readyState == 4)
  { 
	  if(conexion409.status == 200)
	  {   
	//alert(conexion409.responseText);
  		 var datosRecib=JSON.parse(conexion409.responseText);
		 
		 if (datosRecib.moneda < 1){mostrarAvisos("Verifique que los productos tengan moneda"); document.getElementById('informeFac').disabled=false;}
			else {
				 monedaItemsFact=datosRecib.moneda;
				 if (datosRecib.distintaMoneda > 0){mostrarAvisos("Verifique que todos los productos tengan la misma moneda"); document.getElementById('informeFac').disabled=false;}
					else {
						if (datosRecib.SubTotal < 0.01){mostrarAvisos("Verifique que el monto de la factura sea mayor de cero"); document.getElementById('informeFac').disabled=false;}
							else {
								//Pasó las SEGUNDAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
								//Aunque sea un desperdicio tengo que leer el TC del Dolar y del Euro antes que nada.
								//(desperdicio porque tal vez todos los items sean en pesos)
								conexion410=new XMLHttpRequest(); 
								conexion410.onreadystatechange = procesarEventos410;
								var aleatorio=Math.random();
								conexion410.open('GET','./php/leer_Cambio_Moneda.php?&rnadom='+aleatorio, true);
								conexion410.send();									
							}
					}
			}
	  }
  }
}

var tipoComprobante;
var cambioPesosAMonedaExtr;
var monedaFactura;
var conexion411;
function procesarEventos410()
{
    if(conexion410.readyState == 4)
  { 
	  if(conexion410.status == 200)
	  {   
  		//alert("aca");
  		var datosRecib=JSON.parse(conexion410.responseText);
		//alert(conexion410.responseText);	
		//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
		//MONEDA DE LA FACTURA (por ahora es solo en pesos)
		if (document.getElementById('radio251').checked) {monedaFactura='1'};
		if (document.getElementById('radio252').checked) {monedaFactura='0'};
		//TIPO DE CAMBIO A USAR. EN REALIDAD EL DATO QUE VOY A ENVIAR ES EL CAMBIO (cambioPesosAMonedaExtr)
		if (document.getElementById('radio261').checked) {var cambioMonnedaFac='1'};
		if (document.getElementById('radio262').checked) {var cambioMonnedaFac='0'};
		
		//definir el tipo de cambio (el que escribio el cliente o el del sistema. la moneda DEL ARTICULO la se por datosRecib.moneda
		if (cambioMonnedaFac=='1'){
			//por sistema
			//ahora leo la moneda de los items a facturar
			if (monedaItemsFact==1){
				//Pesos
				cambioPesosAMonedaExtr='1';
			} else 
			{//No es pesos
				if (monedaItemsFact==2){
				//Dolares. Tengo que leer el TC del dolar en la BD
				cambioPesosAMonedaExtr=datosRecib.Dolar;
				} else 
					{//No es Dolares, es Euros. Tengo que leer el TC del Euro en la BD
						cambioPesosAMonedaExtr=datosRecib.euro;
					}
				}
		} else {//cambioMonnedaFac=='0'
			//definido por el usuario
			cambioPesosAMonedaExtr=document.getElementById('TipoDeCambioF').value;
		}
		//alert(cambioPesosAMonedaExtr);
		//ver los ivas de cada item. Definir si es uno o dos y los importes (neto, ivas, bruto).
		conexion411=new XMLHttpRequest(); 
		conexion411.onreadystatechange = procesarEventos411;
		var aleatorio=Math.random();
		//alert (monedaFactura);
		conexion411.open('GET','./php/pedir_ultimos_datos_factura.php?rnadom='+aleatorio+"&idcomprobante="+nCom+"&monedaFactura="+monedaFactura+"&tipoCambio="+cambioPesosAMonedaExtr, true);
		conexion411.send();	
	  }
  }
}

var impTotal;
var subTotal;
var ivaTotal;
var iva4;
var iva4AlicuotaBase;
var iva4Alicuota;
var iva5;
var iva5AlicuotaBase;
var iva5Alicuota;
var conexion412;
var conexion412b;
function procesarEventos411()
{
	if(conexion411.readyState == 4)
  { 
	  if(conexion411.status == 200)
	  {  
 		//AHORA QUE TENGO TODOS LOS DATOS ME TENGO QUE COMUNICAR CON LA AFIP ANTES DE HACER LA FACTURA
		//alert(conexion411.responseText);
  		var datosRecib=JSON.parse(conexion411.responseText);
		impTotal=datosRecib.impTotal;
		subTotal=datosRecib.SubTotal;
		ivaTotal=datosRecib.ivaTotal;
		iva4=datosRecib.iva4;
		iva4AlicuotaBase=datosRecib.Iva4AlicuotaBase;
		iva4Alicuota=datosRecib.Iva4Alicuota;
		iva5=datosRecib.iva5;
		iva5AlicuotaBase=datosRecib.Iva5AlicuotaBase;
		iva5Alicuota=datosRecib.Iva5Alicuota;		
		//AHORA VER EL TIPO DE FACTURA (A o B)
		//Voy a sacar esto. Lo voy a leer de la Empresa
		//if (document.getElementById('radio231').checked) {tipoFactura='A'};
		//if (document.getElementById('radio232').checked) {tipoFactura='B'};
		//AHORA VER EL TIPO DE COMPROBANTE (Factura, nota de crédito o nota de débito)
		if (document.getElementById('radio241').checked) {tipoComprobante='FC'};
		if (document.getElementById('radio242').checked) {tipoComprobante='NC'};
		if (document.getElementById('radio243').checked) {tipoComprobante='ND'};	
		//Leo la moneda en la que se tendra que hacer la factura
		if (document.getElementById('radio251').checked) {
		if (monedaItemsFact==1){monedaFactura='0'} else {if (monedaItemsFact==2){monedaFactura='1'} else {monedaFactura='60'}}};
		if (document.getElementById('radio252').checked) {monedaFactura='0'};	
		//alert (cambioPesosAMonedaExtr); Es el tipo de cambio. Lo envio siempre, haga facturas en pesos o moneda extranjera
		//alert (monedaFactura); Es la moneda a facturar. 0 pesos, 1 dolares, 60 euros. Se envia en funcion de factura en pesos o me
		//Nuevo Octubre 2018. Voy a leer a la base de datos, si estoy en modo REAL (Afip) o PRUEBA
		conexion412b=new XMLHttpRequest(); 
		conexion412b.onreadystatechange = procesarEventos412b;
		var aleatorio=Math.random();
		//alert (monedaFactura);
		conexion412b.open('GET','./php/pedir_modo_real_prueba.php?rnadom='+aleatorio, true);
		conexion412b.send();
	  }
	}
}	

function procesarEventos412b()
{
	if(conexion412b.readyState == 4)
  { 
	  if(conexion412b.status == 200)
	  { 
		//AHORA ME CONECTO A LA AFIP CON LOS DATOS QUE RECIBÍ MAS LOS QUE TENGO ACA (RADIO)
		conexion412=new XMLHttpRequest(); 
		conexion412.onreadystatechange = procesarEventos412;
		var aleatorio=Math.random();
		//mostrarAvisos(conexion412b.responseText);
		var datosRecib=JSON.parse(conexion412b.responseText);
		var modoReal;
		modoReal=datosRecib.modoReal;
		if(modoReal == 'Si'){
		//============================================================+
			// MODO REAL (Se conecta a la AFIP)
			conexion412.open('GET','./afip/test/RegistrarFeSistemaPlus.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr+ "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante + "&impTotal="+impTotal + "&subTotal="+subTotal + "&ivaTotal="+ivaTotal + "&iva4="+iva4 + "&iva4AlicuotaBase="+iva4AlicuotaBase + "&iva4Alicuota="+iva4Alicuota + "&iva5="+iva5 + "&iva5AlicuotaBase="+iva5AlicuotaBase + "&iva5Alicuota="+iva5Alicuota, true);
			//============================================================+
		} else {
		if (modoReal == "No"){
			//============================================================+
			// MODO PRUEBA (simula los datos que deberia devolver)
			conexion412.open('GET','./afip/test/LLAMARALAAFIP.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr+ "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante, true);
			//============================================================+
		} else {mostrarAvisos(conexion412b.responseText);}}
		conexion412.send();
		//LUEGO, SI LA AFIP ME DEVUELVE EL OK HAGO EL INFORME
	  }
  }
}

var ultCAE;
var tipoComprobyFac;
var conexion413;
var facturaGenerada;
function procesarEventos412()
{
    if(conexion412.readyState == 4)
  { 
	  if(conexion412.status == 200)
	  {
		//alert(conexion412.responseText);
		if (conexion412.responseText.substr(0,5)=="Error") {
			mostrarAvisos("Se produjo un error. No se generó el CAE. Vea el log de errores. "+conexion412.responseText);
			document.getElementById('informeFac').disabled=false;
		}
		else {	
			var datosRecib=JSON.parse(conexion412.responseText);
			conexion413=new XMLHttpRequest(); 
			conexion413.onreadystatechange = procesarEventos413;
			var aleatorio=Math.random();
			var dirRemit=document.getElementById('direcRemito');	
			ultCAE=datosRecib.CAE;
			//Febrero2019. Sera aca que grabo el numero de factura??
			document.getElementById('numfactura').value = datosRecib.PtoVtayfac;

			if (tipoComprobante!='FC') {tipoComprobyFac=tipoComprobante+tipoFactura} else {tipoComprobyFac=tipoFactura};
			facturaGenerada=datosRecib.PtoVtayfac;
			conexion413.open('GET','./php/guardar_factura_en_caeafip.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&IdEnviado="+datosRecib.idEnviado + "&NumeroFactura="+datosRecib.NumeroFactura + "&TipoFactura="+tipoComprobyFac + "&CAE="+ultCAE + "&VtoCAE="+datosRecib.VtoCAE + "&ImporteTotal="+impTotal + "&ImporteNeto="+subTotal + "&IVA21="+iva5AlicuotaBase + "&IVA10="+iva4AlicuotaBase+"&diRemito="+dirRemit.value, true);
			conexion413.send();		
		}
		//LOS DATOS QUE RECIBI DE AFIP (NUMERO FACTURA, CAE Y VTO CAE SE LOS TENGO QUE MOSTRAR AL USUARIO!
		//EN OTRO DIV CON ESOS DATOS JUNTO CON UN BOTON "REIMPRIMIR FACTURA"
		//procesarEventos413();
	  }
  }
}  

var conexion414_2019;
function procesarEventos413()
{
    if(conexion413.readyState == 4)
  { 
	  if(conexion413.status == 200)
	  {   
		//alert (conexion413.responseText);
		  if (conexion413.responseText.substr(0,5)=="OkOko") 
		  {
			mostrarFacturaProcesada();
			conexion414_2019=new XMLHttpRequest(); 
			//Enero 2019. Nueva tabla detalle comprobante facturas EMITIDAS. Es igual que la anterior
			//pero solo guarda los detalles de facturas emitidas que no se pueden modificar, es para
			//hacer la reimpresion y que salga igual que la emitida, sin leer los datos que se puedan
			//haber modificado luego. Ver que hago con: Numeros de serie.
			//Los encabezados si se pueden modificar asi que no los toco (se seguiran leyendo desde la tabla original).
			conexion414_2019.onreadystatechange = procesarEventos414_2019;
			//conexion414.onreadystatechange = procesarEventos414;
			var aleatorio=Math.random();
			conexion414_2019.open('GET','./php/guardar_factura_en_tabla_comprobante.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&numCAE="+ultCAE, true);
			conexion414_2019.send();	
		  } else {//error
				mostrarAvisos("Se produjo un error al emitir el comprobante. "+ conexion413.responseText);
				document.getElementById('informeFac').disabled=false;
		  }
	  }
  }
}

var conexion414;
var conexion414_2019_2;
function procesarEventos414_2019()
{
    if(conexion414_2019.readyState == 4)
  { 
	  if(conexion414_2019.status == 200)
	  {   
		  //alert (conexion414_2019.responseText);
		  if (conexion414_2019.responseText.substr(0,5)=="OkOko") 
		  {	
			conexion414_2019_2=new XMLHttpRequest(); 
			conexion414_2019_2.onreadystatechange = procesarEventos414_2019_2;
			var aleatorio=Math.random();
			conexion414_2019_2.open('GET','./php/guardar_copia_detalle_comprobante.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&numCAE="+ultCAE, true);
			conexion414_2019_2.send();
		  }
		 else {//error
			mostrarAvisos("Se produjo un error al emitir el comprobante. "+ conexion414_2019.responseText);
			document.getElementById('informeFac').disabled=false;
	  		}
		}
	}
}

function procesarEventos414_2019_2()
{
    if(conexion414_2019_2.readyState == 4)
  { 
	  if(conexion414_2019_2.status == 200)
	  { 
			if (conexion414_2019_2.responseText.substr(0,5)=="OkOko") 
		  {	
				//Febrero 2019. Si es NC anulo un comprobante
				conexion414=new XMLHttpRequest(); 
				conexion414.onreadystatechange = procesarEventos414;
				var aleatorio=Math.random();
				var cadena="idcomprobante="+nComNC;
				cadena=cadena+"&Fecha=20/02/2019&TipoValor=16";
				monedaAImputar=parseFloat(monedaFactura)+1;
				cadena=cadena+"&MonedaPago="+monedaAImputar;
				cadena=cadena+"&Importe="+impTotal;
				cadena=cadena+"&Descripcion=Anulada con "+facturaGenerada;
				cadena=cadena+"&tipoComprob="+tipoComprobante;
				//alert(cadena);
								
				conexion414.open('GET','./php/agrego_pago_a_factura_por_NC.php?'+cadena+"&rnadom="+aleatorio+"&cuit="+cuitCliente, true);
				conexion414.send();				
			} else {//error
				mostrarAvisos("Se produjo un error al mostrar el comprobante. "+conexion414_2019_2.responseText);
				document.getElementById('informeFac').disabled=false;
			}
		}
	}
}

function procesarEventos414()
{
    if(conexion414.readyState == 4)
  { 
	  if(conexion414.status == 200)
	  {   
		  //alert (conexion414.responseText);
		  if (conexion414.responseText.substr(0,5)=="OkOko") 
		  {	
			//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
			//DESCRIPCION EXTENDIDA
			if (document.getElementById('radio211').checked) {var descripExtenddaFac='1'};
			if (document.getElementById('radio212').checked) {var descripExtenddaFac='0'};
			//NUMERO DE SERIE
			if (document.getElementById('radio221').checked) {var serrieFac='1'};
			if (document.getElementById('radio222').checked) {var serrieFac='0'};

			var aleatorio=Math.random();
			document.getElementById('informeFac').disabled=false;
			//Dependiendo la moneda que va a tener la factura veo a que formulario tengo que llamar
		  var dirRemit=document.getElementById('direcRemito');
			if (monedaFactura=='0') {
				window.open('./informes/Informe.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr + "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante + "&numCAE="+ultCAE + "&monedaOriginal="+monedaItemsFact+ "&TipoCompFactura="+tipoComprobyFac+"&diRemito="+dirRemit.value+"&tipoInforme=factura");
			} else {
				window.open('./informes/Informe.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr + "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante + "&numCAE="+ultCAE + "&monedaOriginal="+monedaItemsFact+ "&TipoCompFactura="+tipoComprobyFac+"&diRemito="+dirRemit.value+"&tipoInforme=Factura_Extranjera");}	
		  } else {//error
				mostrarAvisos("Se produjo un error al mostrar el comprobante. "+conexion414.responseText);
				document.getElementById('informeFac').disabled=false;
		  }
	  }
  }
}


function muestraTipoCambioFac()
{
	if (document.getElementById('radio262').checked) {
		document.getElementById('lbltcF').style.visibility='visible';
		document.getElementById('TipoDeCambioF').style.visibility='visible';};
}

function ocultaTipoCambioFac()
{
	if (document.getElementById('radio261').checked) {
		document.getElementById('lbltcF').style.visibility='hidden';
		document.getElementById('TipoDeCambioF').style.visibility='hidden';
		document.getElementById('TipoDeCambioF').value=1
		};
}

var conexion430;
function mostrarFacturaProcesada(){
		conexion430=new XMLHttpRequest(); 
		conexion430.onreadystatechange = procesarEventos430;
		var aleatorio=Math.random();
		conexion430.open('GET','./php/llenar_informe_factura_emitida.php?rnadom=' + aleatorio + "&idcomprobante=" + nCom, true);
		conexion430.send();
}

function procesarEventos430()
{
    if(conexion430.readyState == 4)
  { 
	  if(conexion430.status == 200)
	  {   
		//alert (conexion430.responseText);
		  if (conexion430.responseText.length < 1)
		  {document.getElementById('resultadoFacturaEmitida').style.visibility='hidden';}
	  else {
		  document.getElementById('resultadoFacturaEmitida').style.visibility='visible';
		  document.getElementById('resultadoFacturaEmitida').innerHTML=conexion430.responseText;
		  //accion del boton REIMPRIMIR FACTURA
		  var tags_td = new Array();
		  var tags_td=document.getElementsByName('informeReFacN');
		  var r=0;
		  for (i=0; i<tags_td.length; i++) {
				tags_td[i].addEventListener('click',mostrarBotonPResionado,false);
				r=i;
		  } 
		  //NUEVA accion del boton REIMPRIMIR FACTURA PERO EN MONEDA EXTRANJERA!! (ME, no es Windows ME)
		  var tags_td = new Array();
		  var tags_td=document.getElementsByName('informeReFacNme');
		  var r=0;
		  for (i=0; i<tags_td.length; i++) {
				tags_td[i].addEventListener('click',mostrarBotonPResionadoME,false);
				r=i;
			} 
		  //Marzo 2019. Genera un recibo directamente desde la factura emitida
		  var tags_td = new Array();
		  var tags_td=document.getElementsByName('informeReciboDirecto');
		  var r=0;
		  for (i=0; i<tags_td.length; i++) {
				tags_td[i].addEventListener('click',generarReciboDirecto,false);
				r=i;
		  } 			
	  }
	  }
  }
}

var conexion312;
var CaeParaAgregar;
function generarReciboDirecto(celda){
	//Los mismos pasos que cuando hago un remito desde un presupuesto. Primero el recibo, luego el item de factura, y por ultimo envío al usuario a la venta recibos
	conexion312=new XMLHttpRequest(); 
	conexion312.onreadystatechange = procesarEventos312;
	var aleatorio=Math.random();
	var obnn=document.getElementById('numberses').value;
	CaeParaAgregar=celda.target.id;
	conexion312.open('GET','./php/nuevo_recibo_desde_factura_emitida.php?&rnadom='+aleatorio+"&numCAE="+CaeParaAgregar+"&sesses="+obnn, true);
	conexion312.send();
}

conexion313;
var reciboNuevo;
function procesarEventos312()
{
    if(conexion312.readyState == 4)
  { 
	  if(conexion312.status == 200)
	  {   
			if (conexion312.responseText.substr(0,16)=="Recibo NO creado") 
				{mostrarAvisos("Ocurrió un error al generar el recibo");}
				else {
						reciboNuevo=conexion312.responseText;
						//busco el número de factura a agregar, sólo tengo el CAE
						conexion313=new XMLHttpRequest(); 
						conexion313.onreadystatechange = procesarEventos313;
						var aleatorio=Math.random();
						conexion313.open('GET','./php/buscar_factura_x_cae.php?&rnadom='+aleatorio+"&numCAE="+CaeParaAgregar, true);
						conexion313.send();

				}
		}
	}
}

conexion314;
function procesarEventos313()
{
    if(conexion313.readyState == 4)
  { 
	  if(conexion313.status == 200)
	  {   
			conexion314=new XMLHttpRequest(); 
			conexion314.onreadystatechange = procesarEventos314;
			var aleatorio=Math.random();
			conexion314.open('GET','./php/agrego_detalle_recibo_factura.php?&rnadom='+aleatorio+"&idcomprobante="+conexion313.responseText+"&idRecibo="+reciboNuevo, true);
			conexion314.send();
		}
	}
}

function procesarEventos314()
{
    if(conexion314.readyState == 4)
  { 
	  if(conexion314.status == 200)
	  {
			window.open('Recibos.php',"_self");			
	  }
  }
}

function mostrarBotonPResionado(celda){
			//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
			//DESCRIPCION EXTENDIDA
			if (document.getElementById('radio211').checked) {var descripExtenddaFac='1'};
			if (document.getElementById('radio212').checked) {var descripExtenddaFac='0'};
			//NUMERO DE SERIE
			if (document.getElementById('radio221').checked) {var serrieFac='1'};
			if (document.getElementById('radio222').checked) {var serrieFac='0'};
			var aleatorio=Math.random();	
			var dirRemit=document.getElementById('direcRemito');
			window.open('./informes/Informe.php?rnadom='+aleatorio + "&numCAE="+celda.target.id + "&descr="+descripExtenddaFac + "&serie="+serrieFac+"&diRemito="+dirRemit.value+"&tipoInforme=reimprimir_Factura");}

  function mostrarBotonPResionadoME(celda){
			//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
			//DESCRIPCION EXTENDIDA
			if (document.getElementById('radio211').checked) {var descripExtenddaFac='1'};
			if (document.getElementById('radio212').checked) {var descripExtenddaFac='0'};
			//NUMERO DE SERIE
			if (document.getElementById('radio221').checked) {var serrieFac='1'};
			if (document.getElementById('radio222').checked) {var serrieFac='0'};
			var aleatorio=Math.random();
			var dirRemit=document.getElementById('direcRemito');
			window.open('./informes/Informe.php?rnadom='+aleatorio + "&numCAE="+celda.target.id + "&descr="+descripExtenddaFac + "&serie="+serrieFac+"&diRemito="+dirRemit.value+"&tipoInforme=reimprimir_Factura_Extranjera");		
  }
  


//============================================================+  
//----------factura simulada o previa
//============================================================+
var tipoFacturasim;
var conexion408sim;
function simularFactura()
{
			  //alert("primero tengo que verificar:");
			  //Si el usuario quiere una Factura o NC/ND
			  if (document.getElementById('radio241').checked){
				  //Factura
				  //YA TIENE NUMERO DE FACTURA
				  if ((document.getElementById('numfactura').value.length > 0)){mostrarAvisos("El campo número de factura no se encuentra vacío. Se asume que ya existe una factura para este comprobante y no se puede continuar");}
				  else {//campo factura vacío. continúo con la factura.
					  conexion408sim=new XMLHttpRequest(); 
					  conexion408sim.onreadystatechange = procesarEventos408sim;
					  var aleatorio=Math.random();
					  var dirRemit=document.getElementById('direcRemito');
					  conexion408sim.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
					  conexion408sim.send();
			  };}
			  if ((document.getElementById('radio242').checked)||(document.getElementById('radio243').checked)){
				  //NC o ND
				  //NO TIENE NUMERO DE FACTURA
				  if ((document.getElementById('numfactura').value.length < 1)){mostrarAvisos("El campo número de factura se encuentra vacío. Se asume que no existe una factura para este comprobante y no se puede continuar");}
				  else {//campo factura NO vacío. continúo con la NC o ND.
					  conexion408sim=new XMLHttpRequest(); 
					  conexion408sim.onreadystatechange = procesarEventos408sim;
					  var aleatorio=Math.random();
					  var dirRemit=document.getElementById('direcRemito');
					  conexion408sim.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
					  conexion408sim.send();
			  };}
}

var conexion409sim;
function procesarEventos408sim()
{
    if(conexion408sim.readyState == 4)
  { 
	  if(conexion408sim.status == 200)
	  {   
  		 var datosRecib=JSON.parse(conexion408sim.responseText);
		 //alert(conexion408sim.responseText);
		 if (datosRecib.CondicionesPago.length < 1){mostrarAvisos("Verifique la condición de pago");}
			else {
				 if (datosRecib.Provoestado.length < 1){mostrarAvisos("Verifique la provincia de la Empresa");}
					else {
						if ((datosRecib.CUIT.length < 7)||(datosRecib.CUIT.length > 13)){mostrarAvisos("Verifique el CUIT de la Empresa");}
							else {
								if (datosRecib.CondicionIVA.length < 1){mostrarAvisos("Verifique la condición de IVA de la Empresa");}
									else {
										//alert ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'));
										if ((datosRecib.tipoComprobante.length < 1)||(isNaN(datosRecib.tipoComprobante)) || (datosRecib.tipoComprobante==0)|| ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'))){mostrarAvisos("Verifique el tipo de comprobante de la Empresa");}
										else {
											//Pasó las PRIMERAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
											//ver las monedas de cada item. verificar que sean todas iguales. Sino no puedo seguir.
											//ver que la factura no de cero o negativo
											if (datosRecib.tipoComprobante=='1') {tipoFacturasim='A'};
											if (datosRecib.tipoComprobante=='6') {tipoFacturasim='B'};
											//alert (tipoFacturasim);
											conexion409sim=new XMLHttpRequest(); 
											conexion409sim.onreadystatechange = procesarEventos409sim;
											var aleatorio=Math.random();
											//alert (nCom);
											conexion409sim.open('GET','./php/verificar_monedas_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom, true);
											conexion409sim.send();
										}
									}
							}
					}
			}
	  }
  }
}

var conexion410sim;
var monedaItemsFactsim;
function procesarEventos409sim()
{
    if(conexion409sim.readyState == 4)
  { 
	  if(conexion409sim.status == 200)
	  {   
		//alert(conexion409sim.responseText);
  		 var datosRecib=JSON.parse(conexion409sim.responseText);
		 
		 if (datosRecib.moneda < 1){mostrarAvisos("Verifique que los productos tengan moneda");}
			else {
				 monedaItemsFactsim=datosRecib.moneda;
				 if (datosRecib.distintaMoneda > 0){mostrarAvisos("Verifique que todos los productos tengan la misma moneda");}
					else {
						if (datosRecib.SubTotal < 0.01){mostrarAvisos("Verifique que el monto de la factura sea mayor de cero");}
							else {
								//Pasó las SEGUNDAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
								//Aunque sea un desperdicio tengo que leer el TC del Dolar y del Euro antes que nada.
								//(desperdicio porque tal vez todos los items sean en pesos)
								conexion410sim=new XMLHttpRequest(); 
								conexion410sim.onreadystatechange = procesarEventos410sim;
								var aleatorio=Math.random();
								conexion410sim.open('GET','./php/leer_Cambio_Moneda.php?&rnadom='+aleatorio, true);
								conexion410sim.send();									
							}
					}
			}
	  }
  }
}

var tipoComprobanteSim;
var cambioPesosAMonedaExtrsim;
var monedaFacturasim;
var conexion411sim;
function procesarEventos410sim()
{
    if(conexion410sim.readyState == 4)
  { 
	  if(conexion410sim.status == 200)
	  {   
  		//alert("aca");
  		var datosRecib=JSON.parse(conexion410sim.responseText);
		//alert(conexion410sim.responseText);	
		//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
		//MONEDA DE LA FACTURA (por ahora es solo en pesos)
		if (document.getElementById('radio251').checked) {monedaFacturasim='1'};
		if (document.getElementById('radio252').checked) {monedaFacturasim='0'};
		//TIPO DE CAMBIO A USAR. EN REALIDAD EL DATO QUE VOY A ENVIAR ES EL CAMBIO (cambioPesosAMonedaExtrsim)
		if (document.getElementById('radio261').checked) {var cambioMonnedaFac='1'};
		if (document.getElementById('radio262').checked) {var cambioMonnedaFac='0'};
		
		//definir el tipo de cambio (el que escribio el cliente o el del sistema. la moneda DEL ARTICULO la se por datosRecib.moneda
		if (cambioMonnedaFac=='1'){
			//por sistema
			//ahora leo la moneda de los items a facturar
			if (monedaItemsFactsim==1){
				//Pesos
				cambioPesosAMonedaExtrsim='1';
			} else 
			{//No es pesos
				if (monedaItemsFactsim==2){
				//Dolares. Tengo que leer el TC del dolar en la BD
				cambioPesosAMonedaExtrsim=datosRecib.Dolar;
				} else 
					{//No es Dolares, es Euros. Tengo que leer el TC del Euro en la BD
						cambioPesosAMonedaExtrsim=datosRecib.euro;
					}
				}
		} else {//cambioMonnedaFac=='0'
			//definido por el usuario
			cambioPesosAMonedaExtrsim=document.getElementById('TipoDeCambioF').value;
		}
		//alert(cambioPesosAMonedaExtrsim);
		//ver los ivas de cada item. Definir si es uno o dos y los importes (neto, ivas, bruto).
		conexion411sim=new XMLHttpRequest(); 
		conexion411sim.onreadystatechange = procesarEventos411sim;
		var aleatorio=Math.random();
		//alert (monedaFacturasim);
		conexion411sim.open('GET','./php/pedir_ultimos_datos_factura.php?rnadom='+aleatorio+"&idcomprobante="+nCom+"&monedaFactura="+monedaFacturasim+"&tipoCambio="+cambioPesosAMonedaExtrsim, true);
		conexion411sim.send();	
	  }
  }
}

var impTotalsim;
var subTotalsim;
var ivaTotalsim;
var iva4sim;
var iva4AlicuotaBaseSim;
var iva4AlicuotaSim;
var iva5sim;
var iva5AlicuotaBaseSim;
var iva5AlicuotaSim;
var conexion412sim;
function procesarEventos411sim()
{
	if(conexion411sim.readyState == 4)
  { 
	  if(conexion411sim.status == 200)
	  {  
 		//AHORA QUE TENGO TODOS LOS DATOS ME TENGO QUE COMUNICAR CON LA AFIP ANTES DE HACER LA FACTURA
		//alert(conexion411sim.responseText);
  		var datosRecib=JSON.parse(conexion411sim.responseText);
		impTotalsim=datosRecib.impTotal;
		subTotalsim=datosRecib.SubTotal;
		ivaTotalsim=datosRecib.ivaTotal;
		iva4sim=datosRecib.iva4;
		iva4AlicuotaBaseSim=datosRecib.Iva4AlicuotaBase;
		iva4AlicuotaSim=datosRecib.Iva4Alicuota;
		iva5sim=datosRecib.iva5;
		iva5AlicuotaBaseSim=datosRecib.Iva5AlicuotaBase;
		iva5AlicuotaSim=datosRecib.Iva5Alicuota;		
		//AHORA VER EL TIPO DE FACTURA (A o B)
		//Voy a sacar esto. Lo voy a leer de la Empresa
		//if (document.getElementById('radio231').checked) {tipoFacturasim='A'};
		//if (document.getElementById('radio232').checked) {tipoFacturasim='B'};
		//AHORA VER EL TIPO DE COMPROBANTE (Factura, nota de crédito o nota de débito)
		if (document.getElementById('radio241').checked) {tipoComprobanteSim='FC'};
		if (document.getElementById('radio242').checked) {tipoComprobanteSim='NC'};
		if (document.getElementById('radio243').checked) {tipoComprobanteSim='ND'};	
		//AHORA ME CONECTO A LA AFIP CON LOS DATOS QUE RECIBÍ MAS LOS QUE TENGO ACA (RADIO)
		conexion412sim=new XMLHttpRequest(); 
		conexion412sim.onreadystatechange = procesarEventos412sim;
		var aleatorio=Math.random();
		//Leo la moneda en la que se tendra que hacer la factura
		if (document.getElementById('radio251').checked) {
		if (monedaItemsFactsim==1){monedaFacturasim='0'} else {if (monedaItemsFactsim==2){monedaFacturasim='1'} else {monedaFacturasim='60'}}};
		if (document.getElementById('radio252').checked) {monedaFacturasim='0'};	
		//alert (cambioPesosAMonedaExtrsim); Es el tipo de cambio. Lo envio siempre, haga facturas en pesos o moneda extranjera
		//alert (monedaFacturasim); Es la moneda a facturar. 0 pesos, 1 dolares, 60 euros. Se envia en funcion de factura en pesos o me
		
		//2018 ACA VOY A TENER QUE MODIFICAR PARA FACTURAR EN DOLARES Y EUROS!!
		
		//============================================================+
		// MODO REAL (Se conecta a la AFIP)
		//Jamas usar en simulacion!!!!!
		//conexion412sim.open('GET','./afip/test/RegistarFeSistemaPlus.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&monedaFactura="+monedaFacturasim + "&tipoCambio="+cambioPesosAMonedaExtrsim+ "&tipoFactura="+tipoFacturasim + "&tipoComprobante="+tipoComprobanteSim + "&impTotal="+impTotalsim + "&subTotal="+subTotalsim + "&ivaTotal="+ivaTotalsim + "&iva4="+iva4sim + "&iva4AlicuotaBase="+iva4AlicuotaBaseSim + "&iva4Alicuota="+iva4AlicuotaSim + "&iva5="+iva5sim + "&iva5AlicuotaBase="+iva5AlicuotaBaseSim + "&iva5Alicuota="+iva5AlicuotaSim, true);
		//============================================================+
		
		//============================================================+
		// MODO PRUEBA (simula los datos que deberia devolver)
		conexion412sim.open('GET','./afip/test/LLAMARALAAFIPsim.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&monedaFactura="+monedaFacturasim + "&tipoCambio="+cambioPesosAMonedaExtrsim, true);
		//============================================================+
		conexion412sim.send();
		//LUEGO, SI LA AFIP ME DEVUELVE EL OK HAGO EL INFORME		
	  }
  }
}

var ultCAEsim;
var tipoComprobyFacSim;
function procesarEventos412sim()
{
    if(conexion412sim.readyState == 4)
  { 
	  if(conexion412sim.status == 200)
	  {
		//alert(conexion412sim.responseText);	
		var datosRecib=JSON.parse(conexion412sim.responseText);
		
		var aleatorio=Math.random();
		ultCAEsim=datosRecib.CAE;
		if (tipoComprobanteSim!='FC') {tipoComprobyFacSim=tipoComprobanteSim+tipoFacturasim} else {tipoComprobyFacSim=tipoFacturasim};
		//ACA! en lugar de guardar en tablaCaeAfip, y en el paso siguiente en tabla comprobantes, tengo que enviar estos datos (que son
		//Descartables, ya que esto es una simulacion) al formulario de informe_factura
		//conexion413sim.open('GET','./php/guardar_factura_en_caeafip.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&IdEnviado="+datosRecib.idEnviado + "&NumeroFactura="+datosRecib.NumeroFactura + "&TipoFactura="+tipoComprobyFacSim + "&CAE="+ultCAEsim + "&VtoCAE="+datosRecib.VtoCAE + "&ImporteTotal="+impTotalsim + "&ImporteNeto="+subTotalsim + "&IVA21="+iva5AlicuotaBaseSim + "&IVA10="+iva4AlicuotaBaseSim, true);
		//conexion414.open('GET','./php/guardar_factura_en_tabla_comprobante.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&numCAE="+ultCAEsim, true);
		
		//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
		//DESCRIPCION EXTENDIDA
		if (document.getElementById('radio211').checked) {var descripExtenddaFac='1'};
		if (document.getElementById('radio212').checked) {var descripExtenddaFac='0'};
		//NUMERO DE SERIE
		if (document.getElementById('radio221').checked) {var serrieFac='1'};
		if (document.getElementById('radio222').checked) {var serrieFac='0'};
		//mostrarDetalles(nCom);
		var aleatorio=Math.random();
		var dirRemit=document.getElementById('direcRemito');
		//alert (dirRemit.value);
		//Dependiendo la moneda que va a tener la factura veo a que formulario tengo que llamar
		if (monedaFacturasim=='0') {
					window.open('./informes/Informe.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFacturasim + "&tipoCambio="+cambioPesosAMonedaExtrsim + "&tipoFactura="+tipoFacturasim + "&tipoComprobante="+tipoComprobanteSim + "&numCAE="+ultCAEsim + "&monedaOriginal="+monedaItemsFactsim+ "&TipoCompFactura="+tipoComprobyFacSim + "&NumeroFactura="+datosRecib.NumeroFactura + "&VtoCAE="+datosRecib.VtoCAE+"&diRemito="+dirRemit.value+"&tipoInforme=simulacion_factura");}
					else {
		  		window.open('./informes/Informe.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFacturasim + "&tipoCambio="+cambioPesosAMonedaExtrsim + "&tipoFactura="+tipoFacturasim + "&tipoComprobante="+tipoComprobanteSim + "&numCAE="+ultCAEsim + "&monedaOriginal="+monedaItemsFactsim+ "&TipoCompFactura="+tipoComprobyFacSim + "&NumeroFactura="+datosRecib.NumeroFactura + "&VtoCAE="+datosRecib.VtoCAE+"&diRemito="+dirRemit.value+"&tipoInforme=simulacion_Factura_Extranjera");}	
	  }
  }
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
			if (!isNaN(nCom)){agregoArticuloARemitXCodigoInt()};
		}
		}
}

var conexion26;
function modificarStockArticulo(IdDetalleComprobante,newValue){
	conexion26=new XMLHttpRequest(); 
	//conexion26.onreadystatechange = procesarEventos26;
	var aleatorio=Math.random();
	var cadena=encodeURIComponent(newValue);
	conexion26.open('GET','./php/actualizo_detalle_remito_stock.php?idcomprobante='+IdDetalleComprobante+"&valor="+cadena+"&rnadom="+aleatorio, true);
	conexion26.send();
	//alert("actualizado");
	//ya esta. Se ve en la tabla y ademas (confio en que) se grabo en la BD
}

function procesarEventos26()
{
    if(conexion26.readyState == 4)
  { 
	  if(conexion26.status == 200)
	  {
		  mostrarAvisos(conexion26.responseText);
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
	conexion27.open('GET','./php/reviso_detalle_remito_stock.php?idcomprobante='+IdDetalleComprobante+"&rnadom="+aleatorio, true);
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

//FacturaCAI
var conexionCAI01;
function imprimirFacturaCAI() {
	document.getElementById('informeFacCAI').disabled=true;	
	//Primero verifico que haya un numero de factura para que salga en el comprobante.
	//NONONO. distinto!!
	if ((document.getElementById('numCompCAI').value.length < 1)){
		mostrarAvisos("El campo número de factura se encuentra vacío. No se puede continuar");
		document.getElementById('informeFacCAI').disabled=false;}
		  else {if (isNaN(document.getElementById('numCompCAI').value)){
			  mostrarAvisos("El campo número de factura no es numérico. No se puede continuar");
			  document.getElementById('informeFacCAI').disabled=false;}
			else {
				//Paso la prueba de numero de comprobante.
				 //mostrarAvisos("Se puede continuar");
				  conexionCAI01=new XMLHttpRequest(); 
				  conexionCAI01.onreadystatechange = procesarEventosCAI01;
				  var aleatorio=Math.random();
				  //alert(nCom);
				  var dirRemit=document.getElementById('direcRemito');
				  conexionCAI01.open('GET','./php/verificar_basicos_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom+"&diRemito="+dirRemit.value, true);
				  conexionCAI01.send();				 
				 //document.getElementById('informeFacCAI').disabled=false;
			}
		  }
}

var conexionCAI02;
function procesarEventosCAI01()
{
    if(conexionCAI01.readyState == 4)
  { 
	  if(conexionCAI01.status == 200)
	  {   
  		 var datosRecib=JSON.parse(conexionCAI01.responseText);
		 //alert(conexionCAI01.responseText);
		 if (datosRecib.CondicionesPago.length < 1){mostrarAvisos("Verifique la condición de pago"); document.getElementById('informeFacCAI').disabled=false;}
			else {
				 if (datosRecib.Provoestado.length < 1){mostrarAvisos("Verifique la provincia de la Empresa"); document.getElementById('informeFacCAI').disabled=false;}
					else {
						if ((datosRecib.CUIT.length < 7)||(datosRecib.CUIT.length > 13)){mostrarAvisos("Verifique el CUIT de la Empresa"); document.getElementById('informeFac').disabled=false;}
							else {
								if (datosRecib.CondicionIVA.length < 1){mostrarAvisos("Verifique la condición de IVA de la Empresa"); document.getElementById('informeFac').disabled=false;}
									else {
										//alert ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'));
										if ((datosRecib.tipoComprobante.length < 1)||(isNaN(datosRecib.tipoComprobante)) || (datosRecib.tipoComprobante==0)|| ((datosRecib.tipoComprobante!='1')&& (datosRecib.tipoComprobante!='6'))){mostrarAvisos("Verifique el tipo de comprobante de la Empresa"); document.getElementById('informeFac').disabled=false;}
										else {
											//Pasó las PRIMERAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
											//ver las monedas de cada item. verificar que sean todas iguales. Sino no puedo seguir.
											//ver que la factura no de cero o negativo
											if (datosRecib.tipoComprobante=='1') {tipoFactura='A'};
											if (datosRecib.tipoComprobante=='6') {tipoFactura='B'};
											//alert (tipoFactura);
											conexionCAI02=new XMLHttpRequest(); 
											conexionCAI02.onreadystatechange = procesarEventosCAI02;
											var aleatorio=Math.random();
											//alert (nCom);
											conexionCAI02.open('GET','./php/verificar_monedas_para_factura.php?&rnadom='+aleatorio+"&idcomprobante="+nCom, true);
											conexionCAI02.send();
										}
									}
							}
					}
			}
	  }
  }
}

var conexionCAI03;
function procesarEventosCAI02()
{
    if(conexionCAI02.readyState == 4)
  { 
	  if(conexionCAI02.status == 200)
	  {   
	//alert(conexionCAI02.responseText);
  		 var datosRecib=JSON.parse(conexionCAI02.responseText);
		 
		 if (datosRecib.moneda < 1){mostrarAvisos("Verifique que los productos tengan moneda"); document.getElementById('informeFacCAI').disabled=false;}
			else {
				 monedaItemsFact=datosRecib.moneda;
				 if (datosRecib.distintaMoneda > 0){mostrarAvisos("Verifique que todos los productos tengan la misma moneda"); document.getElementById('informeFacCAI').disabled=false;}
					else {
						if (datosRecib.SubTotal < 0.01){mostrarAvisos("Verifique que el monto de la factura sea mayor de cero"); document.getElementById('informeFacCAI').disabled=false;}
							else {
								//Pasó las SEGUNDAS verificaciones basicas internas mias (eran motivo de no hacer la factura). Ahora:
								//Aunque sea un desperdicio tengo que leer el TC del Dolar y del Euro antes que nada.
								//(desperdicio porque tal vez todos los items sean en pesos)
								conexionCAI03=new XMLHttpRequest(); 
								conexionCAI03.onreadystatechange = procesarEventosCAI03;
								var aleatorio=Math.random();
								conexionCAI03.open('GET','./php/leer_Cambio_Moneda.php?&rnadom='+aleatorio, true);
								conexionCAI03.send();									
							}
					}
			}
	  }
  }
}

var conexionCAI04;
function procesarEventosCAI03()
{
    if(conexionCAI03.readyState == 4)
  { 
	  if(conexionCAI03.status == 200)
	  {   
  		//alert("aca");
  		var datosRecib=JSON.parse(conexionCAI03.responseText);
		//alert(conexionCAI03.responseText);	
		//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
		//MONEDA DE LA FACTURA (por ahora es solo en pesos)
		if (document.getElementById('radio251').checked) {monedaFactura='1'};
		if (document.getElementById('radio252').checked) {monedaFactura='0'};
		//TIPO DE CAMBIO A USAR. EN REALIDAD EL DATO QUE VOY A ENVIAR ES EL CAMBIO (cambioPesosAMonedaExtr)
		if (document.getElementById('radio261').checked) {var cambioMonnedaFac='1'};
		if (document.getElementById('radio262').checked) {var cambioMonnedaFac='0'};
		
		//definir el tipo de cambio (el que escribio el cliente o el del sistema. la moneda DEL ARTICULO la se por datosRecib.moneda
		if (cambioMonnedaFac=='1'){
			//por sistema
			//ahora leo la moneda de los items a facturar
			if (monedaItemsFact==1){
				//Pesos
				cambioPesosAMonedaExtr='1';
			} else 
			{//No es pesos
				if (monedaItemsFact==2){
				//Dolares. Tengo que leer el TC del dolar en la BD
				cambioPesosAMonedaExtr=datosRecib.Dolar;
				} else 
					{//No es Dolares, es Euros. Tengo que leer el TC del Euro en la BD
						cambioPesosAMonedaExtr=datosRecib.euro;
					}
				}
		} else {//cambioMonnedaFac=='0'
			//definido por el usuario
			cambioPesosAMonedaExtr=document.getElementById('TipoDeCambioF').value;
		}
		//alert(cambioPesosAMonedaExtr);
		//ver los ivas de cada item. Definir si es uno o dos y los importes (neto, ivas, bruto).
		conexionCAI04=new XMLHttpRequest(); 
		conexionCAI04.onreadystatechange = procesarEventosCAI04;
		var aleatorio=Math.random();
		//alert (monedaFactura);
		conexionCAI04.open('GET','./php/pedir_ultimos_datos_factura.php?rnadom='+aleatorio+"&idcomprobante="+nCom+"&monedaFactura="+monedaFactura+"&tipoCambio="+cambioPesosAMonedaExtr, true);
		conexionCAI04.send();	
	  }
  }
}

var conexionCAI05;
function procesarEventosCAI04()
{
	if(conexionCAI04.readyState == 4)
  { 
	  if(conexionCAI04.status == 200)
	  {  
 		//AHORA QUE TENGO TODOS LOS DATOS ME TENGO QUE COMUNICAR CON LA AFIP ANTES DE HACER LA FACTURA
		//alert(conexionCAI04.responseText);
  		var datosRecib=JSON.parse(conexionCAI04.responseText);
		impTotal=datosRecib.impTotal;
		subTotal=datosRecib.SubTotal;
		ivaTotal=datosRecib.ivaTotal;
		iva4=datosRecib.iva4;
		iva4AlicuotaBase=datosRecib.Iva4AlicuotaBase;
		iva4Alicuota=datosRecib.Iva4Alicuota;
		iva5=datosRecib.iva5;
		iva5AlicuotaBase=datosRecib.Iva5AlicuotaBase;
		iva5Alicuota=datosRecib.Iva5Alicuota;		
		//AHORA VER EL TIPO DE FACTURA (A o B)
		//Voy a sacar esto. Lo voy a leer de la Empresa
		//if (document.getElementById('radio231').checked) {tipoFactura='A'};
		//if (document.getElementById('radio232').checked) {tipoFactura='B'};
		//AHORA VER EL TIPO DE COMPROBANTE (Factura, nota de crédito o nota de débito)
		if (document.getElementById('radio241').checked) {tipoComprobante='FC'};
		if (document.getElementById('radio242').checked) {tipoComprobante='NC'};
		if (document.getElementById('radio243').checked) {tipoComprobante='ND'};	
		//AHORA ME CONECTO A LA AFIP CON LOS DATOS QUE RECIBÍ MAS LOS QUE TENGO ACA (RADIO)
		conexionCAI05=new XMLHttpRequest(); 
		conexionCAI05.onreadystatechange = procesarEventosCAI05;
		var aleatorio=Math.random();
		//Leo la moneda en la que se tendra que hacer la factura
		if (document.getElementById('radio251').checked) {
		if (monedaItemsFact==1){monedaFactura='0'} else {if (monedaItemsFact==2){monedaFactura='1'} else {monedaFactura='60'}}};
		if (document.getElementById('radio252').checked) {monedaFactura='0'};	
		
		//Enviar los datos para guardar la factura generada, va a faltar el punto de venta que hay que tomarlo de la base de datos.

		conexionCAI05.open('GET','./php/guardar_factura_en_tabla_comprobanteCAI.php?rnadom='+aleatorio + "&idcomprobante="+nCom + "&numFactura="+document.getElementById('numCompCAI').value + "&tipoComprobante="+tipoComprobante + "&tipoFactura="+tipoFactura, true);
		conexionCAI05.send();	

		//alert('LUEGO HAGO EL INFORME');		
	  }
  }
}

var conexionCAI06;
function procesarEventosCAI05()
{
	if(conexionCAI05.readyState == 4)
  { 
	  if(conexionCAI05.status == 200)
	  { 		  
		if (conexionCAI05.responseText.substr(0,5)=="OkOko") 
		  {
			 document.getElementById('numfactura').value = conexionCAI05.responseText.substr(5);
			//leer los radio options (en primera medida solo moneda y cambio ya que los otros no afectan al resultado final)
			//DESCRIPCION EXTENDIDA
			if (document.getElementById('radio211').checked) {var descripExtenddaFac='1'};
			if (document.getElementById('radio212').checked) {var descripExtenddaFac='0'};
			//NUMERO DE SERIE
			if (document.getElementById('radio221').checked) {var serrieFac='1'};
			if (document.getElementById('radio222').checked) {var serrieFac='0'};
			//mostrarDetalles(nCom);
			var aleatorio=Math.random();
			//Dependiendo la moneda que va a tener la factura veo a que formulario tengo que llamar
			if (monedaFactura=='0') {
				window.open('./informes/CAI_informe_Factura.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr + "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante + "&monedaOriginal="+monedaItemsFact+ "&TipoCompFactura="+tipoComprobyFac+ "&tiponumfac="+conexionCAI05.responseText.substr(5));	
			} else {
				window.open('./informes/CAI_informe_Factura_Extranjera.php?idcomprobante='+nCom + "&descr="+descripExtenddaFac + "&serie="+serrieFac + "&rnadom="+aleatorio + "&monedaFactura="+monedaFactura + "&tipoCambio="+cambioPesosAMonedaExtr + "&tipoFactura="+tipoFactura + "&tipoComprobante="+tipoComprobante + "&numCAE="+ultCAE + "&monedaOriginal="+monedaItemsFact+ "&TipoCompFactura="+tipoComprobyFac+ "&tiponumfac="+conexionCAI05.responseText.substr(5));	
			}		 
			document.getElementById('informeFacCAI').disabled=false;
		  } else {//error
				mostrarAvisos("Se produjo un error al emitir el comprobante. "+ conexionCAI05.responseText);
				document.getElementById('informeFacCAI').disabled=false;
		  }
	  }
  }
}