$(document).ready(function () {
	
	initApp();

});

function buscar(clear = false) {
	sortNfilter("buscoempresa", clear);
}

function mostrarMovimientos() {
	if (document.getElementById('checkMostrarAFIP').checked) {
		document.getElementById('detallesdeempresas').style.height = '52vh';
		document.getElementById('empresaenafip').style.height = '25vh';
	} else {
		document.getElementById('detallesdeempresas').style.height = '77vh';
		document.getElementById('empresaenafip').style.height = '0vh';
	}
}

var conexion2;
var conexion6;
var conexion7;
var numeroEmp;

function mostrarDetalles($row) {

	getDetail($row, 'detallesempresa');

	var nCom = $row.id;
	//Abril 2019. Las acciones también se borran
	$('#accionesDetalle').html('');
	conexion7 = new XMLHttpRequest();
	conexion7.onreadystatechange = procesarEventos7;
	aleatorio = Math.random();
	var obnn = $('#numberses').val();
	conexion7.open('GET', './php/llenar_acciones_empresa.php?idsesion=' + obnn + "&rnadom=" + aleatorio, true);
	conexion7.send();
}


function procesarEventos7() {
	if (conexion7.readyState == 4) {
		if (conexion7.status == 200) {
			document.getElementById('accionesDetalle').innerHTML = conexion7.responseText;
			document.getElementById('botonActualizaEmpresa').addEventListener('click', actualizoEmpresa, false);
			document.getElementById('checkMostrarAFIP').addEventListener('change', mostrarMovimientos, false);
			document.getElementById('botonNuevaEmpresa').addEventListener('click', nuevaEmpresa, false);
		}
	}
}

function procesarEventos2() {
	if (conexion2.readyState == 4) {
		if (conexion2.status == 200) {
			$('#detallesdeempresas').html(conexion2.responseText);
			tags_cambios = [];
			//Busco el CUIT
			//AHORA LOS DATOS DE LA AFIP
			//ELIMINO LOS GUIONES PARA ENVIAR LOS DATOS A LA AFIP
			var cliente = document.getElementById('CUIT').value;
			//alert(cliente);
			var posicion = cliente.indexOf('-');
			while (posicion != -1) {
				cliente = cliente.substring(0, posicion) + cliente.substring(posicion + 1);
				posicion = cliente.indexOf('-');
			}
			conexion6 = new XMLHttpRequest();
			conexion6.onreadystatechange = procesarEventos6;
			conexion6.open('GET', 'https://soa.afip.gob.ar/sr-padron/v2/persona/' + cliente, true);
			conexion6.send();
		}
	}
}

function procesarEventos6() {
	if (conexion6.readyState == 4) {
		var datosc = document.getElementById('empresaenafip');
		datosc.innerHTML = 'INFORMACION REGISTRADA EN AFIP PARA EL CUIT DE REFERENCIA</BR></BR>';
		//datosc.innerHTML=datosc.innerHTML+conexion2.responseText;
		var empresaAK = JSON.parse(conexion6.responseText);
		if (empresaAK.success == true) {
			datosc.innerHTML = datosc.innerHTML + 'Nombre: ' + empresaAK.data.nombre + '</BR>';
			datosc.innerHTML = datosc.innerHTML + 'Tipo Persona: ' + empresaAK.data.tipoPersona + '</BR>';
			datosc.innerHTML = datosc.innerHTML + 'Estado: ' + empresaAK.data.estadoClave + '</BR>';
			if (empresaAK.data.tipoDocumento != undefined) {
				datosc.innerHTML = datosc.innerHTML + 'Tipo y Nro. de Documento: ' + empresaAK.data.tipoDocumento + ' ';
			} else {
				datosc.innerHTML = datosc.innerHTML + 'Tipo y Nro. de Documento: ND ';
			}
			if (empresaAK.data.numeroDocumento != undefined) {
				datosc.innerHTML = datosc.innerHTML + empresaAK.data.numeroDocumento + '</BR>';
			} else {
				datosc.innerHTML = datosc.innerHTML + 'ND</BR>';
			}
			datosc.innerHTML = datosc.innerHTML + 'Domicilio Fiscal: ' + empresaAK.data.domicilioFiscal.direccion + '</BR>';
			datosc.innerHTML = datosc.innerHTML + 'Localidad: (' + empresaAK.data.domicilioFiscal.codPostal + ') ';
			datosc.innerHTML = datosc.innerHTML + empresaAK.data.domicilioFiscal.localidad + '</BR>';
			datosc.innerHTML = datosc.innerHTML + '<input type="button" id="botonVerConstancia" value="Ver constancia de inscripción"/>' + '</BR>';
			document.getElementById('botonVerConstancia').addEventListener('click', mostrarConstancia, false);
		} else {
			if (empresaAK.success == false) {
				datosc.innerHTML = 'Error. Tipo: ' + empresaAK.error.tipoError + '</BR>';
				datosc.innerHTML = datosc.innerHTML + 'Mensaje: ' + empresaAK.error.mensaje + '</BR>';
				datosc.innerHTML = datosc.innerHTML + 'Datos: ' + empresaAK.data;
			}
		}
	}
}

function mostrarConstancia() {
	//ELIMINO LOS GUIONES PARA ENVIAR LOS DATOS A LA AFIP
	var cliente = document.getElementById('CUIT').value;
	//alert(cliente);
	var posicion = cliente.indexOf('-');
	while (posicion != -1) {
		cliente = cliente.substring(0, posicion) + cliente.substring(posicion + 1);
		posicion = cliente.indexOf('-');
	}
	window.open('https://soa.afip.gob.ar/sr-padron/v1/constancia/' + cliente);
}

var conexion3;

function actualizoEmpresa() {
	if (document.getElementById('Organizacion').value.length > 0) {
		if (document.getElementById('CUIT').value.length < 7) {
			if (confirm("Seguro que desea dejarlo con un CUIT inválido?") == false) {
				return false;
			}
		}
	} else {
		mostrarAvisos("El nombre de la empresa está vacío");
		return false;
	}
	var numeroEmp = document.getElementById('idEmpresa').value;
	//alert (numeroEmp);
	//PRIMERO ACTUALIZO LA EMPRESA EN SU TABLA
	conexion3 = new XMLHttpRequest();
	conexion3.onreadystatechange = procesarEventos3;
	var aleatorio = Math.random();
	var cadena = "idemp=" + numeroEmp;
	cadena = cadena + "&CUIT=" + document.getElementById('CUIT').value;
	cadena = cadena + "&Organizacion=" + encodeURIComponent(document.getElementById('Organizacion').value);
	cadena = cadena + "&Informacion=" + encodeURIComponent(document.getElementById('Informacion').value);
	cadena = cadena + "&Observaciones=" + encodeURIComponent(document.getElementById('Observaciones').value);
	cadena = cadena + "&CondDePago=" + encodeURIComponent(document.getElementById('CondDePago').value);
	cadena = cadena + "&DiasDePago=" + encodeURIComponent(document.getElementById('DiasDePago').value);
	cadena = cadena + "&Horarios=" + encodeURIComponent(document.getElementById('Horarios').value);
	cadena = cadena + "&EntregaFactura=" + encodeURIComponent(document.getElementById('EntregaFactura').value);
	cadena = cadena + "&ActividEmpresa=" + encodeURIComponent(document.getElementById('ActividEmpresa').value);
	cadena = cadena + "&IdTipoContacto=" + document.getElementById('IdTipoContacto').value;
	cadena = cadena + "&CondicionIVA=" + encodeURIComponent(document.getElementById('CondicionIVA').value);
	cadena = cadena + "&tipocomprobantesafip=" + encodeURIComponent(document.getElementById('tipocomprobantesafip').value);
	cadena = cadena.replace("'", "`");
	cadena = './php/actualizo_detallesempresa.php?' + cadena + "&rnadom=" + aleatorio;
	//alert(cadena);
	conexion3.open('GET', cadena, true);
	conexion3.send();
}

var conexion101;

function procesarEventos3() {
	//alert(conexion3.responseText);
	if (conexion3.readyState == 4) {
		if (conexion3.status == 200) {
			if (conexion3.responseText.substr(0, 5) == "OkOKo") {
				//LUEGO ACTUALIZO LAS DIRECCIONES DE LA EMPRESA
				conexion101 = new XMLHttpRequest();
				conexion101.onreadystatechange = procesarEventos101;
				var aleatorio = Math.random();
				var cadena = "idemp=" + document.getElementById('idEmpresa').value;
				cadena = cadena + "&cuitemp=" + document.getElementById('CUIT').value;
				//Primero tengo que ver cuantas direcciones hay en la pantalla
				var tags_inputm = [];
				tags_inputm = document.getElementsByName("DireccionEmpresa");
				//alert ("hay "+ tags_inputm.length +" direcciones");
				//return false;
				var contador = 0;
				//alert(contador);
				for (i = 0; i < tags_inputm.length; i++) {
					cadena = cadena + "&id" + i + "=" + encodeURIComponent(document.getElementById('id' + i).value);
					cadena = cadena + "&Direccion" + i + "=" + encodeURIComponent(document.getElementById('Direccion' + i).value);
					cadena = cadena + "&Ciudad" + i + "=" + encodeURIComponent(document.getElementById('Ciudad' + i).value);
					cadena = cadena + "&CP" + i + "=" + encodeURIComponent(document.getElementById('CP' + i).value);
					cadena = cadena + "&Provincia" + i + "=" + encodeURIComponent(document.getElementById('Provincia' + i).value);
					cadena = cadena + "&Pais" + i + "=" + encodeURIComponent(document.getElementById('pais' + i).value);
					if (((document.getElementById('Direccion' + i).value).length > 0) || ((document.getElementById('Ciudad' + i).value).length > 0) || ((document.getElementById('CP' + i).value).length > 0) || ((document.getElementById('Provincia' + i).value).length > 0) || ((document.getElementById('pais' + i).value).length > 0)) {

						//alert(contador);
						contador++;
					}
				}
				if (contador == 0) {
					mostrarAvisos("El contacto no puede quedar sin direcciones. Complete por lo menos UN campo de la tabla direcciones.");
					return false;
				}
				//alert(contador);
				cadena = cadena + "&cantidadDirecciones=" + tags_inputm.length;
				cadena = cadena.replace("'", "`");
				cadena = './php/actualizo_direcciones_empresa.php?' + cadena + "&rnadom=" + aleatorio;
				//alert(cadena);
				//return false;
				conexion101.open('GET', cadena, true);
				conexion101.send();
			}
		}
	}
}

function procesarEventos101() {
	//alert(conexion101.responseText); 
	if (conexion101.readyState == 4) {
		if (conexion101.status == 200) {

			document.getElementById('detallesdeempresas').innerHTML = conexion101.responseText;
			tags_cambios = [];
			//Busco el CUIT
			//AHORA LOS DATOS DE LA AFIP
			//ELIMINO LOS GUIONES PARA ENVIAR LOS DATOS A LA AFIP
			var cliente = document.getElementById('CUIT').value;
			//alert(cliente);
			var posicion = cliente.indexOf('-');
			while (posicion != -1) {
				cliente = cliente.substring(0, posicion) + cliente.substring(posicion + 1);
				posicion = cliente.indexOf('-');
			}
			conexion6 = new XMLHttpRequest();
			conexion6.onreadystatechange = procesarEventos6;
			conexion6.open('GET', 'https://soa.afip.gob.ar/sr-padron/v2/persona/' + cliente, true);
			conexion6.send();
		}
	}
}


function nuevaEmpresa() {
	conexion101 = new XMLHttpRequest();
	conexion101.onreadystatechange = procesarEventos101;
	var aleatorio = Math.random();
	cadena = './php/nuevo_detallesempresa.php?rnadom=' + aleatorio;
	conexion101.open('GET', cadena, true);
	conexion101.send();
}

function mostrarAvisos(aviso) {
	document.getElementById('mensajeAlertaAviso').innerHTML = aviso;
	document.getElementById('mensajeAlertaAviso').style.visibility = 'visible';
	setTimeout(function () {
		document.getElementById('mensajeAlertaAviso').style.visibility = 'hidden';
	}, 4000);

}