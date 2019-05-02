addEventListener('load', inicializarEventos, false);

var tags_cambios = [];
var id_actual = "";
var nCom;

function inicializarEventos() {

  $('#detallesdearticulo').on('change', 'form', function () {
    $('.select2').select2();
  });

  $('#ordenPor, #botonBuscadorArticulo').on('change', function () {
    var busqueda = $('#buscadorArticulo').val();
    sortNfilter('buscoarticulo', busqueda);
  });

  $('table').on('click', 'td', function () {
    mostrarDetalles(this);
  });

  $('#botonBuscadorborrar').on('click', function () {
    var busqueda = "";
    $('#buscadorArticulo').val("");
    sortNfilter('buscoarticulo', busqueda);
  });

  $('#buscadorArticulo').on('keypress', function (e) {
    if (e.which == 13) {
      var busqueda = $('#buscadorArticulo').val();
      sortNfilter('buscoarticulo', busqueda);
    }
  });

  $('input').on('change', function (e) {
    algoCambio(e);
  });

  $('#botonBuscarPor').on('click', function () {
    parametrosDeBusqueda();
  });
  $('#botonAceptarBuscarPor').on('click', function () {
    aceptarParametrosDeBusqueda();
  });
  $('#cierraMovs').on('click', function () {
    cerrarVentanaMovs();
  });

  $('#botonActualizaArticulo').on('click', function (event) {
    actualizoArticulo(event);
  });
  $('#botonCopiaArticulo').on('click', function () {
    copioArticulo();
  });
  $('#botonNuevoArticulo').on('click', function () {
    nuevoArticulo();
  });
  $('#checkMostrarMovimientos').on('change', function () {
    mostrarMovimientos();
  });

  $('.card-body').on('click', '.TableHeader', function () {
    $this = $(this);
    if (!$this.children().hasClass('fa-sort-amount-desc')) {
      $('.sortdir').remove();
      $(this).append(' <i class="sortdir fa fa-sort-amount-desc"></i>');
    } else {
      $('.sortdir').remove();
      $(this).append(' <i class="sortdir fa fa-sort-amount-asc"></i>');
    }
    var busqueda = $('#buscadorArticulo').val();
    sortNfilter('buscoarticulo', busqueda);
  });

  $(".card [data-widget='collapse']").click(function () {
    console.log('entrando');
    var card = $(this).parents(".card");
    if (!card.hasClass("collapsed-card")) {
      console.log("collapsing ");
    } else {
      console.log("expanding");
    }
  });

}

function sortNfilter(url, busqueda = "") {
  if (!url) return;
  $sortdir = $('.sortdir');
  $sortcol = $sortdir.parent().parent().attr('class');
  $sortdir = $sortdir.hasClass('fa-sort-amount-asc') ? 'asc' : 'desc';
  orden = $sortcol ? $sortcol + ' ' + $sortdir : '';

  $.ajax({
      type: "GET",
      url: "./php/" + url + ".php",
      data: {
        orden: orden,
        busqueda: busqueda
      },
      dataType: "html",
      success: function (response) {
        $('#tablaArticulos').html(response);
        $('.' + $sortcol).children().append(' <i class="sortdir fa fa-sort-amount-' + $sortdir + '"></i>');
      }
    })
    .fail(function (err) {
      console.log("error en procesar busqueda y orden", err);
    });

}

function algoCambio(e) {
  tags_cambios.push(e.target.id);
}

var conexion2;
var conexion6;

function mostrarDetalles(celda) {
  //$('#detallesdearticulo').html("");
  var numeroartic = celda.id;
  id_actual = numeroartic;
  conexion2 = new XMLHttpRequest();
  conexion2.onreadystatechange = procesarEventos2;
  var aleatorio = Math.random();
  conexion2.open('GET', './php/detallesarticulo.php?idart=' + numeroartic + "&rnadom=" + aleatorio, true);
  conexion2.send();
  //AHORA LOS MOVIMIENTOS DEL ARTICULO
  conexion6 = new XMLHttpRequest();
  conexion6.onreadystatechange = procesarEventos6;
  aleatorio = Math.random();
  conexion6.open('GET', './php/movimientosarticulo.php?idart=' + numeroartic + "&rnadom=" + aleatorio, true);
  conexion6.send();
  if ($("#" + nCom)) {
    $("#" + nCom).parent().css("backgroundColor", "");
  }
  $("#" + celda.id).parent().css("backgroundColor", "#809fff");
  nCom = celda.id;
}

function procesarEventos2() {
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  if (conexion2.readyState == 4) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion2.status == 200) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      $('#detallesdearticulo').html(conexion2.responseText);
      var tags_input = [];
      tags_input = document.getElementsByClassName("input");
      for (i = 0; i < tags_input.length; i++) {
        tags_input[i].addEventListener('change', algoCambio, false);
      }
      tags_cambios = [];
      $('.select2').select2();
    }
  }
}

function procesarEventos6() {
  if (conexion6.readyState == 4) {
    if (conexion6.status == 200) {
      $('#movimientosdearticulo').html(conexion6.responseText);
      tags_cambios = [];
      id_actual = "";
      //AL HACER CLICK
      //TE LLEVA AL FORMULARIO DEL MOVIMIENTO
      var tags_td_mov = [];
      tags_td_mov = document.getElementsByName('xxxx');
      for (i = 0; i < tags_td_mov.length; i++) {
        tags_td_mov[i].addEventListener('click', mostrarDetallesMovimientos, false);
      }
    }
  }
}

var conexion1;

function cambiarDatos(orden, datoABuscar) {
  conexion1 = new XMLHttpRequest();
  conexion1.onreadystatechange = procesarEventos;
  var aleatorio = Math.random();
  conexion1.open('GET', './php/buscoarticulo.php?orden=' + orden + "&busqueda=" + datoABuscar + "&rnadom=" + aleatorio, true);
  conexion1.send();
}

function procesarEventos() {
  if (conexion1.readyState == 4) {
    if (conexion1.status == 200) {
      $('#tablaArticulos').html(conexion1.responseText);
      $('#detallesdearticulo').html("");
      $('#movimientosdearticulo').html("");
      //document.getElementById('accionesDetalle').innerHTML="";
      tags_cambios = [];
      id_actual = "";
    }
  }
}

var conexion3;

function actualizoArticulo(event) {
  event.preventDefault();
  //alert(celda.target.id);
  //var numerocto=id_actual;
  // var numeroart=document.getElementById('IdProducto').value;
  //alert (numerocto);
  conexion3 = new XMLHttpRequest();
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio = Math.random();
  cadena = './php/actualizo_detallesarticulo.php?' + $('form').serialize() + "&rnadom=" + aleatorio;
  //alert(cadena);
  conexion3.open('GET', cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion3.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
}

function procesarEventos3() {
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  if (conexion3.readyState == 4) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion3.status == 200) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      var datosc = document.getElementById('detallesdearticulo');
      datosc.innerHTML = conexion3.responseText;
      tags_cambios = [];
      $('.select2').select2();
    }
  }

}


var conexion4;

function copioArticulo() {
  //alert(celda.target.id);
  //var numerocto=id_actual;
  var numeroart = document.getElementById('IdProducto').value;
  //alert (numerocto);
  conexion4 = new XMLHttpRequest();
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio = Math.random();
  var cadena = "idart=" + numeroart;
  cadena = './php/copio_detallesarticulo.php?' + cadena + "&rnadom=" + aleatorio;
  //alert(cadena);
  conexion4.open('GET', cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion4.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
}

function procesarEventos4() {
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  if (conexion4.readyState == 4) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion4.status == 200) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      var datosc = document.getElementById('detallesdearticulo');
      datosc.innerHTML = conexion4.responseText;
      tags_cambios = [];
    }
  }
}

var conexion5;

function nuevoArticulo() {
  conexion5 = new XMLHttpRequest();
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio = Math.random();
  cadena = './php/nuevo_detallesarticulo.php?rnadom=' + aleatorio;
  //alert(cadena);
  conexion5.open('GET', cadena, true);
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  conexion5.send();
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
}

function procesarEventos5() {
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  if (conexion5.readyState == 4) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion5.status == 200) { //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      $('#detallesdearticulo').html(conexion5.responseText);
      $('#botonActualizaArticuloNuevo').on('click', function () {
        actualizoArticulo();
        $('.select2').select2();
      });
      // tags_cambios = [];
    }
  }

}

var conexion7;
var conexion8;

function mostrarDetallesMovimientos(celda) {
  //alert(celda.target.id);
  document.getElementById('detallesdemovimientos').style.visibility = 'visible';
  var numeroComprobante = celda.target.id;
  //el encabezado del presupuesto
  conexion7 = new XMLHttpRequest();
  conexion7.onreadystatechange = procesarEventos7;
  var aleatorio = Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con4"+conexion4.status);
  conexion7.open('GET', './php/llenar_encabezado_un_comprobante_enArticulo_contacto.php?idcomprobante=' + numeroComprobante + "&rnadom=" + aleatorio, true);
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  conexion7.send();
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  // el detalle del presupuesto
  conexion8 = new XMLHttpRequest();
  conexion8.onreadystatechange = procesarEventos8;
  aleatorio = Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con5"+conexion5.status);
  conexion8.open('GET', './php/llenar_detalle_presupuesto.php?idcomprobante=' + numeroComprobante + "&rnadom=" + aleatorio, true);
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
  conexion8.send();
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
}

function procesarEventos7() {
  if (conexion7.readyState == 4) {
    if (conexion7.status == 200) {
      document.getElementById('detallesdemovimientosFRMSup').innerHTML = conexion7.responseText;
    }
  }

}

function procesarEventos8() {
  if (conexion8.readyState == 4) {
    if (conexion8.status == 200) {
      document.getElementById('detallesdemovimientosFRMInf').innerHTML = conexion8.responseText;
    }
  }
}


function cerrarVentanaMovs() {
  document.getElementById('detallesdemovimientos').style.visibility = 'hidden';
}

function mostrarAvisos(aviso) {
  document.getElementById('mensajeAlertaAviso').innerHTML = aviso;
  document.getElementById('mensajeAlertaAviso').style.visibility = 'visible';
  setTimeout(function () {
    document.getElementById('mensajeAlertaAviso').style.visibility = 'hidden';
  }, 4000);

}