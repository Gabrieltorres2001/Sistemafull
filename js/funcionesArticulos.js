
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
//detalle del articulo
function mostrarDetalles($row) { 
  getDetail($row,'detallesarticulo');
}

function movimientoArticulo(id){
  var aleatorio = Math.random();
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


function actualizoArticulo(event) {
  var aleatorio = Math.random();
  $.ajax({
    type: "GET",
    url: "./php/actualizo_detallesarticulo.php",
    data:  $("form").serialize() + "&rnadom=" + aleatorio,
    dataType: "html",
    success: function (response) {
      $(".card-right .card-body").html(response);
        $(".select2").select2();
    }
  });

}

function copioArticulo() {
  var numeroart = document.getElementById("IdProducto").value;
  $.ajax({
    type: "GET",
    url: "./php/copio_detallesarticulo.php",
    data: {idart:numeroart,rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $('#detallesdearticulo').html(response);
    }
  });
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
  var aleatorio = Math.random();
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