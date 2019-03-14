addEventListener('load',inicializarEventos,false);

function inicializarEventos()
{
	llenar_dolar_euro_actuales();
	llenar_dolar_euro_historial();	
	llenar_fecha_hora_actual();
	llenar_fecha_hora_google();
	document.getElementById('nuevoCambio').addEventListener('click',guardarCambiosMonedas,false);
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
function llenar_dolar_euro_historial(){
  conexion2=new XMLHttpRequest(); 
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio=Math.random();
  conexion2.open('GET','./php/llenar_dolareuro_historial.php?rnadom='+aleatorio, true);
  conexion2.send();
}

function procesarEventos2()
{
    if(conexion2.readyState == 4)
  { 
	  if(conexion2.status == 200)
	  { 
		  document.getElementById('HistorialCambiosMoneda').innerHTML=conexion2.responseText;		  
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
		
		var current_time = dy+"/"+ms+"/"+an+" "+[h,m,s].join(':')+ " "+ampm;
		
		clock.innerHTML = current_time;
		
	};
	
	ticktock();
	
	// Calling ticktock() every 1 second
	setInterval(ticktock, 1000);
	
}

var conexion3;
function llenar_fecha_hora_google(){
  conexion3=new XMLHttpRequest(); 
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio=Math.random();
  conexion3.open('GET','./php/llenar_dolareuro_google.php?rnadom='+aleatorio, true);
  conexion3.send();
}

function procesarEventos3()
{
    if(conexion3.readyState == 4)
  { 
	  if(conexion3.status == 200)
	  { 
		  document.getElementById('datosAfip').innerHTML=conexion3.responseText;		
		  document.getElementById('NumeroDolar').value=document.getElementById('dolarescon').value;
		  document.getElementById('NumeroEuro').value=document.getElementById('euroescon').value;
		  document.getElementById('BNAWeb').addEventListener('click',abrirWebBNA,false);
	  }
  } 
}

var conexion4;
function guardarCambiosMonedas(){
  if ((!isNaN(document.getElementById('NumeroDolar').value))&&(document.getElementById('NumeroDolar').value>0)){
	  //Dolar Ok
	  if ((!isNaN(document.getElementById('NumeroEuro').value))&&(document.getElementById('NumeroEuro').value>0)){
		  //Euro Ok
		  conexion4=new XMLHttpRequest(); 
		  conexion4.onreadystatechange = procesarEventos4;
		  var aleatorio=Math.random();
		  var nDolar = document.getElementById('NumeroDolar').value;
		  var nEuro = document.getElementById('NumeroEuro').value;
		  var nFecha = document.getElementById('horaMonedaNuevo').innerHTML;
		  //alert (nFecha);
		  conexion4.open('GET','./php/grabar_dolareuro_actuales.php?rnadom='+aleatorio+"&dolar=" + nDolar +"&euro=" + nEuro +'&fecha='+ nFecha, true);
		  conexion4.send();
		  } else {
			  mostrarAvisos ("Verifique que el euro esté correcto"); 
		  }
	  } else {
		  mostrarAvisos ("Verifique que el dólar esté correcto");
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
		inicializarEventos();
		}
	  }
  } 
}

var conexion5;
function abrirWebBNA(){
		conexion5=new XMLHttpRequest(); 
		conexion5.onreadystatechange = procesarEventos5;
		var aleatorio=Math.random();
		window.open('http://www.bna.com.ar', true);
		conexion5.send();	
}

function procesarEventos5()
{
    if(conexion5.readyState == 4)
  { 
	  if(conexion5.status == 200)
	  {   
  
		var nVentana= window.open('"', '"', "width=595, height=841");
		nVentana.document.write(conexion5.responseText);
		//nVentana.document.close();
		//nVentana.print();
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