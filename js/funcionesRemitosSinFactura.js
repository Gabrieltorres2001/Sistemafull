addEventListener('load',inicializarEventos,false);
window.addEventListener('keydown', btnkeydown, false);

function inicializarEventos()
{
	listarRemitosMios();
	llenarAccionesRemitoJS();
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
  conexion1.open('GET','./php/llenar_listado_remitos_sin_facturar.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
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

function llenarAccionesRemitoJS(){
	document.getElementById('acciones').innerHTML="<label style='font-size:1em; font-weight:bold; color:red'>REMITOS SIN FACTURAR</label>";
	
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
  conexion301.open('GET','./php/llenar_listado_remitos_MIOS_sin_facturar.php?&rnadom='+aleatorio+"&sesses="+obnn, true);
  conexion301.send();
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
