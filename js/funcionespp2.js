addEventListener('load',inicializarEventos,false);



function inicializarEventos()
{
	document.getElementById('cp').addEventListener('click',mostrarClave,false);
	document.getElementById('fakepasswordremembered').addEventListener('keypress',presiontecla,false);
	document.getElementById('btnsbmt').addEventListener('click',ingresarClave,false);
}


function mostrarClave(event) {
	event.preventDefault();	
	document.getElementById('frmpanelfake').style.visibility='visible';
	document.getElementById('fakepasswordremembered').value='';
	document.getElementById('fakepasswordremembered').autocomplete='new-password';
	document.getElementById('fakepasswordremembered').focus();  
}

function presiontecla(event) {
	event.preventDefault();
	//Algunos navegadores usan which y otros charCode, asi que tengo que poner este if y usar KeyCode en lugar de event.charCode
	var KeyCode = event.KeyCode ? event.KeyCode : event.which ? event.which : event.charCode;

	//alert(KeyCode);
	if (KeyCode > 13) {
		document.getElementById('claveoculata').value=document.getElementById('claveoculata').value + event.key;
		document.getElementById('fakepasswordremembered').value=document.getElementById('fakepasswordremembered').value + '*';
	}
	
	if (KeyCode == 8) {
		document.getElementById('claveoculata').value=document.getElementById('claveoculata').value.substr(0,(document.getElementById('claveoculata').value.length)-1);
		document.getElementById('fakepasswordremembered').value=document.getElementById('fakepasswordremembered').value.substr(0,(document.getElementById('fakepasswordremembered').value.length)-1);
		
	}
	if (KeyCode == 13) {
		document.getElementById('fakepasswordremembered').value='';
		ingresarClave();} 
}

var conexion1;
function ingresarClave() {
	var clave=document.getElementById('claveoculata').value;
	document.getElementById('claveoculata').value='';
	//alert(hex_sha512(clave));
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos1;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  //alert ("clave: " + clave + " - hex: " + hex_sha512(clave));
  conexion1.open('GET','./php/preingreso_panel.php?&rnadom='+aleatorio+"&sesses="+obnn+"&clave="+hex_sha512(clave), true);
  conexion1.send();	  
}

function procesarEventos1()
{
    if(conexion1.readyState == 4)
  { 
	  if(conexion1.status == 200)
	  { 
		if(conexion1.responseText=="True") {window.open("ControlPanel.php","_self");} else {mostrarAvisos("Clave errónea");}

	  }
  } 

}

function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}