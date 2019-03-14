addEventListener('load',inicializarEventos,false);

function inicializarEventos()
{
  document.getElementById('boton1').addEventListener('click',presionBoton,false);
}

function presionBoton(e)
{
	var nNombre=document.getElementById('name').value;
	var nApellido=document.getElementById('surname').value;
	var nHorarios=document.getElementById('horarios').value;
	//alert(document.getElementById('email').value);
	var nEmail=document.getElementById('email').value;
	var nUsername=document.getElementById('username').value;
	var nNumSes=document.getElementById('numerosesion').value;
	var conexion1;
	
	//alert ("ses :"+nNumSes);
	
  if ((nNombre=="")&&(nApellido=="")&&(nHorarios=="")&&(nUsername=="")&&(nEmail=="")){
	  alert ("Todos los campos estan vacíos!");
  };	 
  if ((nNombre!="")||(nApellido!="")||(nHorarios!="")||(nUsername!="")||(nEmail!="")){
	  cambiarDatos(nNombre,nApellido,nHorarios,nUsername,nNumSes,nEmail);
  };	
}


function cambiarDatos(nombre, apellido, horarios, usrname, nnumerosesion, nEmail) 
{
  conexion1=new XMLHttpRequest(); 
  conexion1.onreadystatechange = procesarEventos;
  var aleatorio=Math.random();
  conexion1.open('GET','./cambiodatos.php?nombre='+nombre+"&apellido="+apellido+"&horarios="+horarios+"&usrname="+usrname+"&idsesion="+nnumerosesion+"&eMail="+nEmail+"&rnadom="+aleatorio, true);
  conexion1.send();
}

function procesarEventos()
{
    if(conexion1.readyState == 4)
  {
	  if(conexion1.status == 200)
	  {
		  //var detalles = document.getElementById("comoEstoy");
		  //detalles.innerHTML=conexion1.responseText;
		  var datos=JSON.parse(conexion1.responseText);
		  var salida = datos.campo;
		  document.getElementById("nombreActualizado").innerHTML=datos.nombre;
		  document.getElementById("apellActualizado").innerHTML=datos.apellido;
		  document.getElementById("completoActualizado").innerHTML=datos.nombre+" "+datos.apellido;
		  document.getElementById("horariosActualizado").innerHTML=datos.horarios;
		  document.getElementById("userActualizado").innerHTML=datos.useername;
		  document.getElementById("eMailActualizado").innerHTML=datos.eMail;
		  document.getElementById("horaActualizacion").innerHTML=datos.fechaActualizacion;
	  }
  } 

}
