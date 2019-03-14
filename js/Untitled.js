function inicio()
  {
	document.getElementById('username').addEventListener('focus',escribirUsuario,false);
    document.getElementById('username').addEventListener('blur',ErrorUsuario,false);
	document.getElementById('email').addEventListener('focus',escribirEMail,false);
    document.getElementById('email').addEventListener('blur',ErrorEMail,false);
	document.getElementById('password').addEventListener('focus',escribirPassword,false);
    document.getElementById('password').addEventListener('blur',ErrorPassword,false);
	document.getElementById('confirmpwd').addEventListener('focus',escribirConfirmPwd,false);
    document.getElementById('confirmpwd').addEventListener('blur',ErrorConfirmPwd,false);
  }

function escribirUsuario() {
	var vista='block';
	document.getElementById('UsuarioAdvertencia').style.display = vista;
	document.getElementById('UsuarioAdvertencia').style.color='#0000ff';
	document.getElementById('username').style.color='#0000ff';
	document.getElementById('UsuarioAdvertencia').innerHTML='Escriba un nuevo nombre de usuario<br> El nombre de usuario deberá contener solo dígitos, letras mayúsculas, minúsculas y guiones bajos.<br>';
	
}

function ErrorUsuario() {
	var vista='none';
	document.getElementById('UsuarioAdvertencia').style.display = vista;
	document.getElementById('username').style.color='#000000';
	var re = /^\w+$/;
  	if ((document.getElementById('username').value=='') || (!re.test(document.getElementById('username').value))){
		vista='block';
		document.getElementById('UsuarioAdvertencia').style.display = vista;
		document.getElementById('UsuarioAdvertencia').style.color='#ff0000';
		document.getElementById('UsuarioAdvertencia').innerHTML='El nombre de usuario deberá contener solo dígitos, letras mayúsculas, minúsculas y guiones bajos.<br> Por favor, inténtelo de nuevo<br>';
		document.getElementById('username').style.color='#ff0000';
		
	}
}

function escribirEMail() {
	var vista='block';
	document.getElementById('eMailAdvertencia').style.display = vista;
	document.getElementById('eMailAdvertencia').style.color='#0000ff';
	document.getElementById('email').style.color='#0000ff';
	document.getElementById('eMailAdvertencia').innerHTML='Escriba su e-mail<br> Los correos electrónicos deberán tener un formato válido.<br>';
	
}

function ErrorEMail() {
	var vista='none';
	document.getElementById('eMailAdvertencia').style.display = vista;
	document.getElementById('email').style.color='#000000';
	var re = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
  	if (!re.test(document.getElementById('email').value)){
		vista='block';
		document.getElementById('eMailAdvertencia').style.display = vista;
		document.getElementById('eMailAdvertencia').style.color='#ff0000';
		document.getElementById('eMailAdvertencia').innerHTML='Los correos electrónicos deberán tener un formato válido.<br> Por favor, inténtelo de nuevo<br>';
		document.getElementById('email').style.color='#ff0000';
		
	}
}

function escribirPassword() {
	vista='block';
	document.getElementById('passwordAdvertencia').style.display = vista;
	document.getElementById('passwordAdvertencia').style.color='#0000ff';
	document.getElementById('password').style.color='#0000ff';
	document.getElementById('passwordAdvertencia').innerHTML='Escriba su contraseña<br> Las contraseñas deberán tener al menos 6 caracteres.<br> Las contraseñas deberán estar compuestas por: Por lo menos una letra mayúscula (A-Z), por lo menos una letra minúscula (a-z) y por lo menos un número (0-9)<br>';
	
}

function ErrorPassword() {
	vista='none';
	document.getElementById('passwordAdvertencia').style.display = vista;
	document.getElementById('password').style.color='#000000';
	re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
  	if ((document.getElementById('password').value=='') || (!re.test(document.getElementById('password').value))){
		vista='block';
		document.getElementById('passwordAdvertencia').style.display = vista;
		document.getElementById('passwordAdvertencia').style.color='#ff0000';
		document.getElementById('passwordAdvertencia').innerHTML='Las contraseñas deberán tener al menos 6 caracteres.<br> Las contraseñas deberán estar compuestas por: Por lo menos una letra mayúscula (A-Z), por lo menos una letra minúscula (a-z)y por lo menos un número (0-9)<br> Por favor, inténtelo de nuevo<br>';
		document.getElementById('password').style.color='#ff0000';
		
	}
}

function escribirConfirmPwd() {
	vista='block';
	document.getElementById('confirmpwdAdvertencia').style.display = vista;
	document.getElementById('confirmpwdAdvertencia').style.color='#0000ff';
	document.getElementById('confirmpwd').style.color='#0000ff';
	document.getElementById('confirmpwdAdvertencia').innerHTML='Confirme su contraseña<br> Las contraseñas deben coincidir<br>';
	
}

function ErrorConfirmPwd() {
	vista='none';
	document.getElementById('confirmpwdAdvertencia').style.display = vista;
	document.getElementById('confirmpwd').style.color='#000000';
	re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
  	if ((document.getElementById('confirmpwd').value=='') || (document.getElementById('confirmpwd').value!=document.getElementById('password').value)){
		vista='block';
		document.getElementById('confirmpwdAdvertencia').style.display = vista;
		document.getElementById('confirmpwdAdvertencia').style.color='#ff0000';
		document.getElementById('confirmpwdAdvertencia').innerHTML='Las contraseñas deben coincidir<br> Por favor, inténtelo de nuevo<br>';
		document.getElementById('confirmpwd').style.color='#ff0000';
		
	}
}




function cambiar(esto)
{
	vista=document.getElementById(esto).style.display;
	if (vista=='none')
		vista='block';
	else
		vista='none';

	document.getElementById(esto).style.display = vista;
}

function actualizaDatosUsuario(form, name, surname, horarios, email, username) {
	    // Envía el formulario. 
    form.submit();
    return true;
}