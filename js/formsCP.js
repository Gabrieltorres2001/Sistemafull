function formhash(form, password) {
    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash. 
    var p = document.createElement("input");
 
    // Agrega el elemento nuevo a nuestro formulario. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Asegúrate de que la contraseña en texto simple no se envíe. 
    password.value = "";
 
    // Finalmente envía el formulario. 
    form.submit();
}
 
var conexion;
function regformhash(form, uid, email, password, conf, iduser) {
     // Verifica que cada campo tenga un valor
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('Deberá brindar toda la información solicitada. Por favor, intente de nuevo');
        return false;
    }
 
    // Verifica el nombre de usuario
    var re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("El nombre de usuario deberá contener solo letras, números y guiones bajos. Por favor, inténtelo de nuevo"); 
        form.username.focus();
        return false; 
    }

    // Verifica el EMail. OJO QUE ESTO LO AGREGUE YO
    var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if(!emailRegex.test(form.email.value)) { 
        alert("El email no es válido. Por favor, inténtelo de nuevo"); 
        form.email.focus();
        return false; 
    }
 
    // Verifica que la contraseña tenga la extensión correcta (mín. 6 caracteres)
    // La verificación se duplica a continuación, pero se incluye para que el
    // usuario tenga una guía más específica.
    if (password.value.length < 6) {
        alert('La contraseña deberá tener al menos 6 caracteres. Por favor, inténtelo de nuevo');
        form.password.focus();
        return false;
    }
 
    // Por lo menos un número, una letra minúscula y una mayúscula 
    // Al menos 6 caracteres
 
    re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Las contraseñas deberán contener al menos un número, una letra minúscula y una mayúscula. Por favor, inténtelo de nuevo');
        return false;
    }
 
    // Verifica que la contraseña y la confirmación sean iguales
    if (password.value != conf.value) {
        alert('La contraseña y la confirmación no coinciden. Por favor, inténtelo de nuevo');
        form.password.focus();
        return false;
    }
 
    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash. 
    var p = document.createElement("input");
 
    // Agrega el elemento nuevo a nuestro formulario. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Asegúrate de que la contraseña en texto simple no se envíe. 
    password.value = "";
    conf.value = "";
 
    // Finalmente envía el formulario. 
    //form.submit();
    //return true;
    conexion=new XMLHttpRequest(); 
    conexion.onreadystatechange = procesarEventos;
    var aleatorio=Math.random();
    conexion.open('GET','./includes/register.incCP.php?iduser='+iduser.value+"&pass="+p.value+"&rnadom="+aleatorio, true);
    conexion.send();
}

function procesarEventos()
{
    if(conexion.readyState == 4)
  { 
	  if(conexion.status == 200)
	  {
        document.location.href=conexion.responseText;
      }
    }
}

