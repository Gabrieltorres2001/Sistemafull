
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
    // algoCambio(e);
    $(this).parent().addClass('bg-warning');
    // console.lo).css('bag(this);
    // var color = $('option:selected',this).css('background-color');
    //     $(thisckground-color','red');
  });

  $("#cierraMovs").on("click", function () {
    cerrarVentanaMovs();
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

  $("#checkMostrarMovimientos").on("change", function () {
    mostrarMovimientos();
  });

  $(".card-left .card-body").on("click", ".TableHeader", function () {
    sortChange(this);
    buscar();
  });

  $(".card [data-widget='collapse']").click(function () {
    console.log("entrando");
    var card = $(this).parents(".card");
    if (!card.hasClass("collapsed-card")) {
      console.log("collapsing ");
    } else {
      console.log("expanding");
      var id = $('#IdProducto').val();
      if (id){
        movimientoArticulo(id);
      }
    }
  });
});

function buscar(clear = false) {
  var busqueda = "";
  if (!clear) {
    busqueda = $("#buscadorArticulos").val();
  }
  sortNfilter("buscoarticulo", busqueda);
  $("#detallesdearticulo").html("");

}

function algoCambio(e) {
  tags_cambios.push(e.target.id);
}

var conexion6;

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
      //Nueva forma de cambiar los precios
      $("#ValorVenta").on("dblclick", function () {
        //Primero ver si el artículo tiene proveedor
        aleatorio = Math.random();
        $.ajax({
          type: "GET",
          url: "./php/buscarProveedorArticulo.php",
          data: {idart:celda.id, rnadom:aleatorio},
          dataType: "html",
          success: function (responseEmp) {
           if(responseEmp=='0'){
             mostrarAvisos('El artículo no tiene un provedor definido. Primero debe solucionar este problema.');
           } else {
              //Segundo ver si el proveedor tiene descuentos
              aleatorio = Math.random();
              $.ajax({
                type: "GET",
                url: "./php/buscarDescuentosProveedorArticulo.php",
                data: {idemp:responseEmp, rnadom:aleatorio},
                dataType: "html",
                success: function (responseDescEmp) {

                }

                }).fail();

              //Tercero mostrar la ventana de carga de precios
              document.getElementById("fondoClaro").style.visibility = "visible";
              document.getElementById("nuevoPrecio").style.visibility = "visible";
              $("#nuevoPrecio").html("3242343243");
           }
          }
        }).fail();

        });
    }
  }).fail();

  $(".card-left .card-body tr")
  .removeClass('bg-primary');
  $("#" + celda.id)
  .parent().addClass('bg-primary');
}

function movimientoArticulo(id){

  //AHORA LOS MOVIMIENTOS DEL ARTICULO
  conexion6 = new XMLHttpRequest();
  conexion6.onreadystatechange = procesarEventos6;
  aleatorio = Math.random();
  conexion6.open(
    "GET",
    "./php/movimientosarticulo.php?idart=" +
    id +
    "&rnadom=" +
    aleatorio,
    true
  );
  conexion6.send();

}

function procesarEventos6() {
  if (conexion6.readyState == 4) {
    if (conexion6.status == 200) {
      $("#movimientosdearticulo").html(conexion6.responseText);
      tags_cambios = [];
      id_actual = "";
      //AL HACER CLICK
      //TE LLEVA AL FORMULARIO DEL MOVIMIENTO
      var tags_td_mov = [];
      tags_td_mov = document.getElementsByName("xxxx");
      for (i = 0; i < tags_td_mov.length; i++) {
        tags_td_mov[i].addEventListener(
          "click",
          mostrarDetallesMovimientos,
          false
        );
      }
    }
  }
}

var conexion1;

function cambiarDatos(orden, datoABuscar) {
  conexion1 = new XMLHttpRequest();
  conexion1.onreadystatechange = procesarEventos;
  var aleatorio = Math.random();
  conexion1.open(
    "GET",
    "./php/buscoarticulo.php?orden=" +
    orden +
    "&busqueda=" +
    datoABuscar +
    "&rnadom=" +
    aleatorio,
    true
  );
  conexion1.send();
}

function procesarEventos() {
  if (conexion1.readyState == 4) {
    if (conexion1.status == 200) {
      $("#tablaArticulos").html(conexion1.responseText);
      $("#detallesdearticulo").html("");
      $("#movimientosdearticulo").html("");
      //document.getElementById('accionesDetalle').innerHTML="";
      tags_cambios = [];
      id_actual = "";
    }
  }
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
      document.getElementById("detallesdearticulo").innerHTML = conexion3.responseText;
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
      document.getElementById("detallesdearticulo").innerHTML = conexion4.responseText;
      tags_cambios = [];
    }
  }
}

var conexion5;

function nuevoArticulo() {
  conexion5 = new XMLHttpRequest();
  conexion5.onreadystatechange = procesarEventos5;
  var aleatorio = Math.random();
  cadena = "./php/nuevo_detallesarticulo.php?rnadom=" + aleatorio;
  conexion5.open("GET", cadena, true);
  conexion5.send();
}

function procesarEventos5() {
  if (conexion5.readyState == 4) {
    //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
    if (conexion5.status == 200) {
      //alert ("readyState: "+conexion2.readyState+"status: "+conexion2.status);
      //SI BUSCO LA CAGOOOO. TENGO QUE VER COMO HACER PARA ACTUALIZAR EL LISTADO SIN PERDER EL DETALLE
      $("#detallesdearticulo").html(conexion5.responseText);
      $("#botonActualizaArticuloNuevo").on("click", function () {
        actualizoArticulo();
        $(".select2").select2();
      });
      // tags_cambios = [];
    }
  }
}

var conexion7;
var conexion8;

function mostrarDetallesMovimientos(celda) {
  //alert(celda.target.id);
  document.getElementById("detallesdemovimientos").style.visibility = "visible";
  var numeroComprobante = celda.target.id;
  //el encabezado del presupuesto
  conexion7 = new XMLHttpRequest();
  conexion7.onreadystatechange = procesarEventos7;
  var aleatorio = Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con4"+conexion4.status);
  conexion7.open(
    "GET",
    "./php/llenar_encabezado_un_comprobante_enArticulo_contacto.php?idcomprobante=" +
    numeroComprobante +
    "&rnadom=" +
    aleatorio,
    true
  );
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  conexion7.send();
  //alert ("readyState: "+conexion4.readyState+"status: "+conexion4.status);
  // el detalle del presupuesto
  conexion8 = new XMLHttpRequest();
  conexion8.onreadystatechange = procesarEventos8;
  aleatorio = Math.random();
  //alert("voy a llamar al php. hasta aca todo bien. con5"+conexion5.status);
  conexion8.open(
    "GET",
    "./php/llenar_detalle_presupuesto.php?idcomprobante=" +
    numeroComprobante +
    "&rnadom=" +
    aleatorio,
    true
  );
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
  conexion8.send();
  //alert ("readyState: "+conexion5.readyState+"status: "+conexion5.status);
}

function procesarEventos7() {
  if (conexion7.readyState == 4) {
    if (conexion7.status == 200) {
      document.getElementById("detallesdemovimientosFRMSup").innerHTML =
        conexion7.responseText;
    }
  }
}

function procesarEventos8() {
  if (conexion8.readyState == 4) {
    if (conexion8.status == 200) {
      document.getElementById("detallesdemovimientosFRMInf").innerHTML =
        conexion8.responseText;
    }
  }
}

function cerrarVentanaMovs() {
  document.getElementById("detallesdemovimientos").style.visibility = "hidden";
}

function mostrarAvisos(aviso) {
  document.getElementById("mensajeAlertaAviso").innerHTML = aviso;
  document.getElementById("mensajeAlertaAviso").style.visibility = "visible";
  setTimeout(function () {
    document.getElementById("mensajeAlertaAviso").style.visibility = "hidden";
  }, 4000);
}