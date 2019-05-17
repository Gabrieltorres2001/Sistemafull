
$(document).ready(function () {
  $("#detallesdearticulo").on("change", "form", function () {
    $(".select2").select2();
  });

  $(".card-left").on("click", "#botonBuscador", function () {
    buscar();
  });

  $("table").on("click", "td", function () {
    mostrarDetalles(this);
  });

  $("#botonBorrar").on("click", function () {
    buscar(true);
  });

  $("#buscadorArticulos").on("keypress", function (e) {
    if (e.which == 13) {
      buscar();
    }
  });

  $(".container").on("change", "input, textarea, .select2", function (e) {
    $(this).parent().addClass('bg-warning');
  });

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

  $(".card-left .card-body").on("click", ".TableHeader", function () {
    sortChange(this);
    buscar();
  });

  $(".card [data-widget='collapse']").click(function () {
      if (!isExpanded(this)){
        refresh();
      }
  });

  $('#refresh').on('click',function(){
    if (isExpanded($(".card [data-widget='collapse']"))){
      refresh();
    }
  });

  $('#movimientosdearticulo').on('click','tr',function(){
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

function isExpanded(obj){
  var card = !$(obj).parents(".card").hasClass("collapsed-card");
  return card;
}

function buscar(clear = false) {
  var busqueda = "";
  if (!clear) {
    busqueda = $("#buscadorArticulos").val();
  }
  sortNfilter("buscoarticulo", busqueda);
  $("#detallesdearticulo").html("");

}

function mostrarDetalles(celda) { 
  var aleatorio = Math.random();
  $.ajax({
    type: "GET",
    url: "./php/detallesarticulo.php",
    data: {idart:celda.id, rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $("#detallesdearticulo").html(response);
      $(".select2").select2();
      if (!$('#detallesdemovimientos').hasClass('collapsed-card')){
        $('#refresh').trigger('click');
      }
    }
  }).fail(function(){
    console.log("error");
  });

  $(".card-left .card-body tr").removeClass('bg-primary');
  $("#" + celda.id).parent().addClass('bg-primary');
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
  //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
  if (conexion3.readyState == 4) {
    //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion3.status == 200) {
      //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      var datosc = document.getElementById("detallesdearticulo");
      datosc.innerHTML = conexion3.responseText;
      tags_cambios = [];
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