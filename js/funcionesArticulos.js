
$(document).ready(function () {
  initApp();
  $(".card-right .card-header").on("click", "button", function (event) {
    switch (this.id) {
      case "botonActualiza-Articulos":
        actualizoArticulo(event);
        break;
      case "botonCopia-Articulos":
        copioArticulo();
        break;
      case "botonNuevo-Articulos":
        nuevoArticulo();
        break;
      default:
        break;
    }
  });

  $('.card-button').on('click','tbody tr',function(){
    mostrarDetallesMovimientos(this.id);
  });

});


function refresh(){
  var id = $('#IdProducto').val();
  if (id){
    console.log('refreshing');
    movimientoArticulo(id);
  }
}

function buscar(clear = false) {
  sortNfilter("buscoarticulo", clear);

}

function mostrarDetalles($row) { 
  getDetail($row,'detallesarticulo');
}

function movimientoArticulo(id){
  aleatorio = Math.random();
  $.ajax({
    type: "GET",
    url: "./php/movimientosarticulo.php",
    data: {idart:id, rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $("#movimientosdearticulo").html(response);
    }
  });
}

var conexion3;

function actualizoArticulo(event) {
  event.preventDefault();
  conexion3 = new XMLHttpRequest();
  conexion3.onreadystatechange = procesarEventos3;
  var aleatorio = Math.random();
  cadena =
    "./php/actualizo_detallesarticulo.php?" +
    $("form").serialize() +
    "&rnadom=" +
    aleatorio;
  conexion3.open("GET", cadena, true);
  conexion3.send();
}

function procesarEventos3() {
  if (conexion3.readyState == 4) {
    if (conexion3.status == 200) {
      $("#detallesdearticulo").html(conexion3.responseText);
      $(".select2").select2();
    }
  }
}

var conexion4;

function copioArticulo() {
  var numeroart = document.getElementById("IdProducto").value;
  //alert (numerocto);
  conexion4 = new XMLHttpRequest();
  conexion4.onreadystatechange = procesarEventos4;
  var aleatorio = Math.random();
  var cadena = "idart=" + numeroart;
  cadena =
    "./php/copio_detallesarticulo.php?" + cadena + "&rnadom=" + aleatorio;
  conexion4.open("GET", cadena, true);
  conexion4.send();
}

function procesarEventos4() {
  if (conexion4.readyState == 4) {
    //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion4.status == 200) {
      //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      var datosc = document.getElementById("detallesdearticulo");
      datosc.innerHTML = conexion4.responseText;
      tags_cambios = [];
    }
  }
}

function nuevoArticulo() {
  var aleatorio = Math.random();
  $.ajax({
    type: "GET",
    url: "./php/nuevo_detallesarticulo.php",
    data: {rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $("#detallesdearticulo").html(response);
      $("#botonActualizaArticuloNuevo").on("click", function () {
        actualizoArticulo();
        $(".select2").select2();
      });
    }
  });
}

function mostrarDetallesMovimientos(id) {
  //el encabezado del presupuesto
  $.ajax({
    type: "GET",
    url: "./php/llenar_encabezado_un_comprobante_enArticulo_contacto.php",
    data: {idcomprobante:id,rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $('#detallesdemovimientosFRMSup').html(response);
    }
  });

  $.ajax({
    type: "GET",
    url: "./php/llenar_detalle_presupuesto.php",
    data: {idcomprobante:id,rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $('#detallesdemovimientosFRMInf').html(response);
    }
  });
  $('#movimientos-modal').modal('show');
}

function mostrarAvisos(aviso) {
  $("#mensajeAlertaAviso").html(aviso);
  $("#mensajeAlertaAviso").show();
  setTimeout(function () {
    $("#mensajeAlertaAviso").hide();
  }, 4000);
}