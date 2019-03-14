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
	listarPresupuestosMios();
	llenarInformePresupuestoJS();
	llenarInformeRemitoEnPresupuestoJS();
	llenarAccionesPresupuestoJS();
    document.getElementById('cierraMovs').addEventListener('click',cerrarVentanaMovs,false); 
	document.getElementById('cierraAgregarIt').addEventListener('click',cerrarVentanaAgregaIt,false); 
    document.getElementById('botonActualizaArticuloEnPresupuesto').addEventListener('click',actualizoArticulo,false);
	document.getElementById('itemABuscar').addEventListener('keypress',teclaEnter,false);
	document.getElementById('botonBuscarArticuloEnPresupuesto').addEventListener('click',busco,false);
	document.getElementById('cierraMovsAgArt').addEventListener('click',cerrarVentanaNuevoArt,false); 

}


var conexion1;
function llenarListadoPresupuestosJS(){
  document.getElementById('listaComprobantes').innerHTML="Cargando...";
  document.getElementById('portada').innerHTML="Seleccione un comprobante de la lista a la derecha";
  document.getElementById('detallesdecomprobante').innerHTML="";
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion1.open('GET','./php/llenar_listado_presupuestos.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('listaComprobantes').innerHTML=conexion1.responseText;
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
  //el encabezado del presupuesto
  document.getElementById('portada').innerHTML="";
  conexion4=new XMLHttpRequest(); 
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion4.open('GET','./php/llenar_encabezado_un_presupuesto.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion4.send();
  // el detalle del presupuesto
   document.getElementById('detallesdecomprobante').innerHTML="";
  conexion5=new XMLHttpRequest(); 
  conexion5.onreadystatechange = procesarEventos5;
  aleatorio=Math.random();
  conexion5.open('GET','./php/llenar_detalle_presupuesto.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion5.send();

}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 
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
			  	//document.getElementById('cambiaDatos').addEventListener('click',habilitarDetallesEncabezadoPresupuesto,false); 
				document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
				document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
				document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
				document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
				document.getElementById('PeticionOferta').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
				document.getElementById('Notas').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 								
			  } else {	  
					document.getElementById('asignarmePresup').addEventListener('click',asignarmePresupuesto,false); 	
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
						tags_td_actua[i].addEventListener('click',agregoArticuloAPresup,false);
				};				
			  //un click en el boton del + EN LA ULTIMA LINEA agrega un item POR CODIGO INTERNO
			  var tags_td_actuau = new Array();
  			  var tags_td_actuau = document.getElementsByName('xxxxuz');
			  for (i=0; i<tags_td_actuau.length; i++) {
						tags_td_actuau[i].addEventListener('click',agregoArticuloAPresupXCodigoInt,false);
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

function cambioUnArticuloPresup(celda)
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
				modificarCantidadTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);
				//leo el campo UNITARIO, lo multiplico por el que acabo de cambiar (celda.target.value) y lo guardo en SUBTOTAL
				var nuevaCant=(parseFloat(celda.target.value));
				var viejoUnitario=(parseFloat(document.getElementById(palabras[0]+'&'+palabras[1]+'&descontadoitem&E').value));
				//grabo el campo subtotal (en paralelo de lo que ya se guardo en la BD)
				var nuevoNum=nuevaCant*viejoUnitario;
				document.getElementById(palabras[0]+'&'+palabras[1]+'&subtotitem&E').value=nuevoNum.toFixed(2);
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
				if (monedaOriginal!=monedaUsuario){mostrarAvisos ("No se olvide de verificar la moneda del artículo");}				
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
				if (monedaOriginal!=monedaUsuario){mostrarAvisos ("No se olvide de verificar la moneda del artículo");}				
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
				if (monedaOriginal!=monedaUsuario){mostrarAvisos ("No se olvide de verificar la moneda del artículo");}
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
		  case "plazoitem":
				campoAEditar="Observaciones"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);						
				break;
		  case "obsitem":
				campoAEditar="Destino"
				//llamo a la funcion que graba en la BD solo este dato (no afecta a otros)
				//alert(celda.target.value);
				modificarCampoTablaDetalleComprobante(palabras[0],campoAEditar,celda.target.value);					
				break;
	  };
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
					  var aleatorio=Math.random();
					  //SEptiembre 2018. Me tengo que fijar para que empresa esta trabajando el sistema
					  //Esto tiene que estar grabado en la tabla controlPanel
					  var empresaActual=document.getElementById('estaEmpresa').value;
					  if (empresaActual=="Tecnoplus") {window.open('./informes/Tecnoplus_informe_presupuesto.php?idppto='+numPresup.value+"&descr="+descripExtendda+"&iva="+ivva+"&moneda="+monneda+"&cambioPesosAMoneda="+cambioPesosAMonedaExtr+"&plazo="+plazzo+"&rnadom="+aleatorio);}
					  if (empresaActual=="Cimse") {window.open('./informes/Cimse_informe_presupuesto.php?idppto='+numPresup.value+"&descr="+descripExtendda+"&iva="+ivva+"&moneda="+monneda+"&cambioPesosAMoneda="+cambioPesosAMonedaExtr+"&plazo="+plazzo+"&rnadom="+aleatorio);}
					}
			}
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
function llenarAccionesPresupuestoJS(){
  //var numeroComprobante=celda.target.id;
  //el encabezado del presupuesto
  conexion12=new XMLHttpRequest(); 
  conexion12.onreadystatechange = procesarEventos12;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion12.open('GET','./php/llenar_acciones_presupuestos.php?rnadom='+aleatorio+"&sesses="+obnn, true);
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
		document.getElementById('nuevoPresupuesto').addEventListener('click',mostrarDescolgableListadoEmpresas,false); 
	  }
  } 

}

var conexion13;
function mostrarDescolgableListadoEmpresas(){
  conexion13=new XMLHttpRequest(); 
  conexion13.onreadystatechange = procesarEventos13;
  var aleatorio=Math.random();
  conexion13.open('GET','./php/llenar_descolgable_listado_empresas.php?&rnadom='+aleatorio, true);
  conexion13.send();
}

var tipoComprobante="Presupuesto";
function procesarEventos13()
{
    if(conexion13.readyState == 4)
  { 
	  if(conexion13.status == 200)
	  { 
		  document.getElementById('acciones').innerHTML=conexion13.responseText;
		  document.getElementById('empresa').focus();
		  	$(document).ready(function() {
			  $("#empresa").select2();
			  $("#empresa").select2("open");
			});
			//document.getElementById('empresa').focus();
			//document.getElementById('empresa').click();
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
		  //acciones para el boton nuevo presupuesto
		  document.getElementById('nuevoPresupuesto').addEventListener('click',mostrarDescolgableListadoEmpresas,false); 
		  //actualizo los otros DIV
		  llenarListadoPresupuestosJS();
		  var obnprc=document.getElementById('NumeroPresupuestoRecienCreado').innerHTML;
		  mostrarDetalles(obnprc);
		  setTimeout(function(){mostrarDetallesPresupuestoNuevo(obnprc);
			if(!isNaN(nCom)){document.getElementById(nCom).style.backgroundColor="transparent";}
			document.getElementById(obnprc).style.backgroundColor="#809fff";}, 1000);
	  }
  } 

}

var conexion15;
function mostrarDetallesPresupuestoNuevo(celda){
  var numeroComprobante=celda;
  //el encabezado del presupuesto
  conexion15=new XMLHttpRequest(); 
  conexion15.onreadystatechange = procesarEventos15;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion15.open('GET','./php/llenar_encabezado_un_presupuestoNUEVO.php?idcomprobante='+numeroComprobante+"&rnadom="+aleatorio+"&sesses="+obnn, true);
  conexion15.send();
  // el detalle del presupuesto en este caso no va porque es un presupuesto nuevo y entonces esta en blanco


}
  
function procesarEventos15()
{
    if(conexion15.readyState == 4)
  { 
	  if(conexion15.status == 200)
	  { 
		document.getElementById('portada').innerHTML=conexion15.responseText;
		guardaCambiosEncabezadoPresupuesto(); 
		document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('PeticionOferta').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('Notas').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('botonMailP').addEventListener('click',enviarMail,false);
	  }
  } 
}
  
var conexion16;
function guardaCambiosEncabezadoPresupuesto()
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
	//AHORA SOLO ME FALTA GRABAR LOS CAMBIOS
	var numPresup=document.getElementById('NumeroComprobante').value;
	var numSolicit=document.getElementById('Solicita').value;
	var numCPago=document.getElementById('CondicionesPago').value;
	var numPEntrega=document.getElementById('PlazoEntrega').value;
	var numTransp=document.getElementById('Transporte').value;
	var txtPetOfer=encodeURIComponent(document.getElementById('PeticionOferta').value);
	var txtNotas=encodeURIComponent(document.getElementById('Notas').value);	
	
	conexion16=new XMLHttpRequest(); 
    conexion16.onreadystatechange = procesarEventos16;
    var aleatorio=Math.random();
    var obnn=document.getElementById('numberses').value;
	conexion16.open('GET','./php/actualizo_encabezado_presupuesto.php?numpresupuesto='+numPresup+"&rnadom="+aleatorio+"&sesses="+obnn+"&solicitaa="+numSolicit+"&numCcPago="+numCPago+"&numPpEntrega="+numPEntrega+"&numTtransp="+numTransp+"&textPetOfer="+txtPetOfer+"&textNotas="+txtNotas, true);
    conexion16.send();
}  
 
function procesarEventos16()
{
    if(conexion16.readyState == 4)
  { 
	  if(conexion16.status == 200)
	  { 
		  //var datosc=document.getElementById('portada');
		  //datosc.innerHTML=datosc.innerHTML + conexion16.responseText;
		var obnpra=document.getElementById('NumeroPresupuestoRecienActualizado').innerHTML;
		mostrarDetalles(obnpra);
		  //document.getElementById('cambiaDatos').addEventListener('click',habilitarDetallesEncabezadoPresupuesto,false); 
		document.getElementById('Solicita').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('CondicionesPago').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('PlazoEntrega').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('Transporte').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('PeticionOferta').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('Notas').addEventListener('change',guardaCambiosEncabezadoPresupuesto,false); 
		document.getElementById('botonMailP').addEventListener('click',enviarMail,false);
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



var conexion17;
function modificarCampoTablaDetalleComprobante(IdDetalleComprobante,campoAEditar,newValue){
	conexion17=new XMLHttpRequest(); 
	//conexion17.onreadystatechange = procesarEventos17;
	var aleatorio=Math.random();
	var cadena=encodeURIComponent(newValue);
	conexion17.open('GET','./php/actualizo_detalle_presupuesto_orden.php?idcomprobante='+IdDetalleComprobante+"&campo="+campoAEditar+"&valor="+cadena+"&rnadom="+aleatorio, true);
	conexion17.send();
	//ya esta. Se ve en la tabla y ademas (confio en que) se grabo en la BD
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

var conexion25;
function borrarArticuloPresup(celda){
	var ambosid=celda.target.id;
	var palabras = ambosid.split("&");
	var numeroartic = palabras[1];
	if(confirm("Borrar el artículo "+numeroartic+" de este presupuesto?")== true) {
		conexion25=new XMLHttpRequest(); 
		conexion25.onreadystatechange = procesarEventos25;
		var numeroPosic = palabras[0];
		var aleatorio=Math.random();
		conexion25.open('GET','./php/borro_articulo_detalle_presupuesto.php?idcomprobante='+numeroPosic+"&rnadom="+aleatorio, true);
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

function agregoArticuloAPresup(){
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
function asignarmePresupuesto(){
	if (confirm("Seguro que desea asignarse este presupuesto a su nombre?")== true){
		conexion121=new XMLHttpRequest(); 
		conexion121.onreadystatechange = procesarEventos121;
		var aleatorio=Math.random();
		var obnn=document.getElementById('numberses').value;
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
		  document.getElementById('listaComprobantes').innerHTML=conexion301.responseText;
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