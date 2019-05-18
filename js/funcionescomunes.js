var conexion14a;
function agregarUnNuevoComprobante(){
  var cliente=document.getElementById('empresa').value;
  conexion14a=new XMLHttpRequest(); 
  conexion14a.onreadystatechange = procesarEventos14a;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion14a.open('GET','./php/leo_empresaycontacto.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&sesses="+obnn, true);
  conexion14a.send();
}

var conexion14a;
function agregarUnNuevoComprobanteRecibo(){
	var cliente=document.getElementById('empresaNombre').value;
  conexion14a=new XMLHttpRequest(); 
  conexion14a.onreadystatechange = procesarEventos14a;
  var aleatorio=Math.random();
  var obnn=document.getElementById('numberses').value;
  conexion14a.open('GET','./php/leo_empresa.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&sesses="+obnn, true);
  conexion14a.send();
}

var tFEmpresa;
var datosRecib;
function procesarEventos14a(){
    if(conexion14a.readyState == 4)
  { 
	  if(conexion14a.status == 200)
	  { 
		  //Divido el json
		  datosRecib=JSON.parse(conexion14a.responseText);
		  //alert(conexion14a.responseText);
		  tFEmpresa=datosRecib.tipoComprobanteOrg;
		  //primero verificar que el contacto tenga una condicion de pago valida
		  if(isNaN(datosRecib.CondDePagoOrg) || datosRecib.CondDePagoOrg==0 || datosRecib.CondDePagoOrg > 23) {
			  noTengoFormaPago();
			  } else {
				  //segundo verificar que el contacto tenga un tipo de factura valido
					if(isNaN(tFEmpresa) || tFEmpresa==0) {
						noTengoTipoFactura();					  
					  } else {					  
						  //luego si puedo cargar el comprobante (presupuesto o remito)
						  cargarCompobante();
					}}
	  }
  } 
}

//El cliente no tiene Forma de pago.
function noTengoFormaPago(){
	document.getElementById('formaPagoHoy').innerHTML=datosRecib.CondDePagoOrg;
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('unificarFormaPagoCliente').style.visibility='visible';
	llenarcomboformaspagoJS();
	document.getElementById('botonActualizarCPContacto').addEventListener('click',actualizarCPContacto,false); 	
}
var conexion302;
function actualizarCPContacto(){
	var datosc=document.getElementById('CondPago');	
	if (datosc.value<1){mostrarAvisos("elegi uno!");
	} else {
		  var cliente=document.getElementById('empresa').value;
		  conexion302=new XMLHttpRequest(); 
		  conexion302.onreadystatechange = procesarEventos302;
		  var aleatorio=Math.random();
		  conexion302.open('GET','./php/grabo_cond_pago_cliente.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&condpago="+datosc.value, true);
		  conexion302.send();		
	}
}
function procesarEventos302(){
    if(conexion302.readyState == 4)
  { 
	  if(conexion302.status == 200)
	  {
		document.getElementById('fondoClaro').style.visibility='hidden';
		document.getElementById('unificarFormaPagoCliente').style.visibility='hidden';
		//Vuelvo al principio
		agregarUnNuevoComprobante();
	  }
  }
}//El cliente no tiene Forma de pago.

//El cliente no tiene tipo Factura
function noTengoTipoFactura(){
	document.getElementById('TipoFacturaHoy').innerHTML=tFEmpresa;
	document.getElementById('fondoClaro').style.visibility='visible';
	document.getElementById('unificarTipoFacturaCliente').style.visibility='visible';
	llenarcombotiposcomprobantesJS();
	document.getElementById('botonActualizarTFContacto').addEventListener('click',actualizarTFContacto,false); 		
}
var conexion302a;
function actualizarTFContacto(){
	var datosc=document.getElementById('tipocomprobantesafip');	
	if (datosc.value<1){mostrarAvisos("elegi uno!");
	} else {
		  var cliente=document.getElementById('empresa').value;
		  conexion302a=new XMLHttpRequest(); 
		  conexion302a.onreadystatechange = procesarEventos302a;
		  var aleatorio=Math.random();
		  conexion302a.open('GET','./php/grabo_tipo_comprob_cliente.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&tipoComprobante="+datosc.value, true);
		  conexion302a.send();		
	}
}
function procesarEventos302a(){
    if(conexion302a.readyState == 4)
  { 
	  if(conexion302a.status == 200)
	  {
		document.getElementById('fondoClaro').style.visibility='hidden';
		document.getElementById('unificarTipoFacturaCliente').style.visibility='hidden';
		//Vuelvo al principio
		agregarUnNuevoComprobante();
	  }
  }
}//El cliente no tiene tipo Factura

//El cliente tiene todo
var conexion14;
function cargarCompobante() {
	var cliente = "";
	conexion14=new XMLHttpRequest(); 
	conexion14.onreadystatechange = procesarEventos14;
	var aleatorio=Math.random();
	var obnn=document.getElementById('numberses').value;
	if(tipoComprobante=="Presupuesto") {
		//Para recibos el descolgable se llama diferente que para remitos y presupuestos.
		cliente=document.getElementById('empresa').value;
		conexion14.open('GET','./php/nuevo_presupuesto.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&sesses="+obnn, true);}
	if(tipoComprobante=="Remito") {
		//Para recibos el descolgable se llama diferente que para remitos y presupuestos.
		cliente=document.getElementById('empresa').value;
		conexion14.open('GET','./php/nuevo_remito.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&sesses="+obnn, true);}
	//Febrero 2019. Recibos.
	if(tipoComprobante=="Recibo") {
		//Para recibos el descolgable se llama diferente que para remitos y presupuestos.
		cliente=document.getElementById('empresaNombre').value;
		conexion14.open('GET','./php/nuevo_recibo.php?&rnadom='+aleatorio+"&numempresa="+cliente+"&sesses="+obnn, true);}
	conexion14.send();
}//El cliente tiene todo

function sortNfilter(url, clear = false) {
	if (!url) return;
	var busqueda = "";
  if (!clear) {
    busqueda = $("#buscador").val();
  }else{
		$("#buscador").val("");
	}
  $sortdir = $(".sortdir");
  $sortcol = $sortdir
    .parent()
    .parent()
    .attr("class");
  $sortdir = $sortdir.hasClass("fa-sort-amount-asc") ? "asc" : "desc";
  orden = $sortcol ? $sortcol + " " + $sortdir : "";

  $.ajax({
    type: "GET",
    url: "./php/" + url + ".php",
    data: {
      orden: orden,
      busqueda: busqueda
    },
    dataType: "html",
    success: function(response) {
      $(".card-left .card-body").html(response);
      $("." + $sortcol)
        .children()
        .append(' <i class="sortdir fa fa-sort-amount-' + $sortdir + '"></i>');
    }
  }).fail(function(err) {
    console.log("error en procesar busqueda y orden", err);
	});
	$(".card-right .card-body").html("");
}

function sortChange($obj){
	$this = $($obj);
	if (!$this.children().hasClass("fa-sort-amount-desc")) {
		$(".sortdir").remove();
		$($obj).append(' <i class="sortdir fa fa-sort-amount-desc"></i>');
	} else {
		$(".sortdir").remove();
		$($obj).append(' <i class="sortdir fa fa-sort-amount-asc"></i>');
	}
}

function getDetail($row, url =""){
	if (!url) return;
	var aleatorio = Math.random();
  $.ajax({
    type: "GET",
    url: "./php/" + url + ".php",
    data: {id:$row.id, rnadom:aleatorio},
    dataType: "html",
    success: function (response) {
      $(".card-right .card-body").html(response);
      $(".select2").select2();
      if (!$('.card-button').hasClass('collapsed-card')){
        $('#refresh').trigger('click');
      }
    }
  }).fail(function(){
    console.log("error");
  });

  $(".card-left .card-body tr").removeClass('bg-primary');
  $("#" + $row.id).addClass('bg-primary');
}

function isExpanded($obj){
  var result = !$($obj).parents(".card").hasClass("collapsed-card");
  return result;
}

function initApp(){

  $(".card-left .card-header").on("click", "#botonBuscador", function () {
    buscar();
  });
  
  $(".card-left .card-header").on("click","#botonBorrar", function () {
    buscar(true);
  });
  
  $(".card-left .card-header").on("keypress","#buscador", function (e) {
    if (e.which == 13) {
      buscar();
    }
  });
  
  $(".card-left .card-body").on("click", "table tbody tr", function () {
    mostrarDetalles(this);
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

  $(".card-right .card-body").on("change", "form", function () {
    $(".select2").select2();
  });

  $(".container").on("change", "input, textarea, .select2", function (e) {
    $(this).parent().addClass('bg-warning');
  });

}