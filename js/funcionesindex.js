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


function recuperarClave(email)
{
    if (email == '') {
		mostrarAvisos('Deberá brindar toda la información solicitada. Por favor, intente de nuevo');
        return false;
    }
	
    // Verifica el EMail. OJO QUE ESTO LO AGREGUE YO
    var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if(!emailRegex.test(email)) { 
        mostrarAvisos("El email no es válido. Por favor, inténtelo de nuevo"); 
        //form.email.focus();
        return false; 
    }
	mostrarAvisos("Enviando instrucciones al email ingresado"); 	
}



function mostrarAvisos(aviso)
{
	document.getElementById('mensajeAlertaAviso').innerHTML=aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility='visible';
	setTimeout(function(){document.getElementById('mensajeAlertaAviso').style.visibility='hidden';}, 4000);

}