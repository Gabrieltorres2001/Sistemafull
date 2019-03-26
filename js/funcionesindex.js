addEventListener('load',inicializarEventos,false);


function inicializarEventos()
{
	  var str=(navigator.userAgent)
	  if (str.search("Firefox")!=-1){} else {
		//document.getElementById('avisoChrome').style.visibility='visible';  
		//habilitar solo el uso en firefox
		//document.getElementById('botonLogInicial').style.visibility='hidden';
	  };
	
}


var conexion01;
function recuperarClave(email)
{
    if (email == '') {
		mostrarAvisos('Deberá su dirección de email. Por favor, intente de nuevo');
        return false;
    }
	
    // Verifica el EMail. OJO QUE ESTO LO AGREGUE YO
    var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if(!emailRegex.test(email)) { 
        mostrarAvisos("El email no es válido. Por favor, inténtelo de nuevo"); 
        //form.email.focus();
        return false; 
		}
	//Consultar al server si la direccion ingresada tiene cuenta
	conexion01=new XMLHttpRequest(); 
	conexion01.onreadystatechange = procesarEventos01;
	var aleatorio=Math.random();
	conexion01.open('GET','./php/recupera.php?&rnadom='+aleatorio+"&email="+email, true);
	conexion01.send();
}

function procesarEventos01()
{
    if(conexion01.readyState == 4)
  { 
	  if(conexion01.status == 200)
	  { 	
			mostrarAvisos(conexion01.responseText); 	
	  }
  } 
}



function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}