addEventListener('load',inicializarEventos,false);

function inicializarEventos()
{

	llenar_historial_novedades();	
	llenar_fecha_hora_actual();

	document.getElementById('nuevoCambio').addEventListener('click',guardarCambiosNovedades,false);
}

var conexion1;
function llenar_dolar_euro_actuales(){
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  conexion1.open('GET','./php/llenar_dolareuro_actuales.php?rnadom='+aleatorio, true);
  conexion1.send();
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		  document.getElementById('CambioMonedaActual').innerHTML=conexion1.responseText;		  
	  }
  } 
}

var conexion2;
function llenar_historial_novedades(){
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  conexion2.open('GET','./php/llenar_historial_novedades.php?rnadom='+aleatorio, true);
  conexion2.send();
}

function procesarEventos2()
{
    if(conexion2.readyState == 4)
  { 
	  if(conexion2.status == 200)
	  { 
		  document.getElementById('HistorialNovedades').innerHTML=conexion2.responseText;		  
	  }
  } 
}

function llenar_fecha_hora_actual() {

	var clock = document.getElementById('horaMonedaNuevo');
	
	// But there is a little problem
	// we need to pad 0-9 with an extra
	// 0 on the left for hours, seconds, minutes
	
	var pad = function(x) {
		return x < 10 ? '0'+x : x;
	};
	
	var ticktock = function() {
		var d = new Date();

		var dy = pad( d.getDate() );
		var ms = pad( d.getMonth()+1);
		var an = pad( d.getFullYear() );
		var hourss=d.getHours();
		var ampm = hourss >=12 ? 'p.m.' : 'a.m.';
		hourss = hourss % 12;
		var h = pad( hourss ? hourss : 12);
		var m = pad( d.getMinutes() );
		var s = pad( d.getSeconds() );
		
		var current_time = dy+"/"+ms+"/"+an;
		
		clock.innerHTML = current_time;
		
	};
	
	ticktock();
	
	// Calling ticktock() every 100 second
	setInterval(ticktock, 100000);
	
}

var conexion4;
function guardarCambiosNovedades(){
	//alert (document.getElementById('NuevaNovedad').value.length);
  if (document.getElementById('NuevaNovedad').value.length>0){
	  //Novedad Ok
		  conexion4=new XMLHttpRequest(); 
		  conexion4.onreadystatechange = procesarEventos4;
		  var aleatorio=Math.random();
		  var nNovedad = document.getElementById('NuevaNovedad').value;
		  var nFecha = document.getElementById('horaMonedaNuevo').innerHTML;
		  var nRespo = document.getElementById('numberses').value;
		  //alert (nRespo);
		  conexion4.open('GET','./php/grabar_novedad.php?rnadom='+aleatorio+"&novedad=" + nNovedad +'&fecha='+ nFecha +'&respo='+ nRespo, true);
		  conexion4.send();

	  } else {
		  mostrarAvisos ("No hay novedad!");
	  }		  

}

function procesarEventos4()
{
    if(conexion4.readyState == 4)
  { 
	  if(conexion4.status == 200)
	  { 
		//document.getElementById('datosAfip').innerHTML=conexion4.responseText;
		if (conexion4.responseText="OkOKo") 
		{
		//	alert ("inicializarEventos");
		document.getElementById('NuevaNovedad').value="";
		inicializarEventos();
		}
	  }
  } 
}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}