<?php 

echo"<fieldset style='width:99%'>";
	echo"<legend>Opciones de impresion de FACTURA:</legend>";
		echo"<fieldset style='width:130px'>";
			echo"<legend>Descripción extendida:</legend>";	
			echo"<input type='radio' id='radio211' name='descripEnFac'>Automática</option>";
			echo"<br>";
			echo"<input type='radio' id='radio212' name='descripEnFac' checked>Ninguna</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:110px'>";
			echo"<legend>Número de serie:</legend>";	
			echo"<input type='radio' id='radio221' name='serieFactura' checked>Automático</option>";
			echo"<br>";
			echo"<input type='radio' id='radio222' name='serieFactura'>Ninguno</option>";
		echo"</fieldset>";
		//Este dato ahora lo leo de la empresa. Ya no le dejo al usuario que lo seleccione
		//echo"<fieldset style='width:70px'>";
		//	echo"<legend>Tipo:</legend>";	
		//	echo"<input type='radio' id='radio231' name='tipoFactura' checked>A</option>";
		//	echo"<br>";
		//	echo"<input type='radio' id='radio232' name='tipoFactura'>B</option>";
		//echo"</fieldset>";
		echo"<fieldset style='width:100px'>";
		echo"<legend>Comprobante:</legend>";	
		echo"<input type='radio' id='radio241' name='tipoComprob' checked>Factura</option>";
		echo"<br>";
		echo"<input type='radio' id='radio242' name='tipoComprob'>N. Crédito</option>";
		echo"<br>";
		echo"<input type='radio' id='radio243' name='tipoComprob'>N. Débito</option>";
		echo"</fieldset>";
		//Nueva Septiembre 2018. Para cliente CIMSE , facturas con CAI en lugar de CAE
		//Primero pregunto si es CAI o CAE. Si es CAE ademas tengo que preguntar por el modo demo.
		//Si es CAI el cliente tendra que poner un numero de factura/NC/ND a mano. y tiene que ser numerico.
		include_once '../includes/sp_connect.php';
		$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
		die("Problemas con la conexión");
		mysqli_query($conexion_sp,"set names 'utf8'");
		if(!$resultcCAE = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'facturaCAE' and padre=1 limit 1")) die("Problemas con la consulta controlpanel");
		$regCAE = mysqli_fetch_array($resultcCAE);
		if ($regCAE['ContenidoValor'] == 'No'){
			echo"<fieldset style='width:110px; text-align:right;'>";
				echo"<legend>Número de comprobante:</legend>";	
				echo"<input pattern='[0-9]+' id='numCompCAI' name='numCompCAI' size='9' style='text-align:right;'>";
			echo"</fieldset>";			
		}
		echo"<fieldset style='width:100px'>";
			echo"<legend>Moneda:</legend>";	
			echo"<input type='radio' id='radio251' name='monedaFactura' checked>Del producto</option>";
			echo"<br>";
			echo"<input type='radio' id='radio252' name='monedaFactura'>En Pesos</option>";
		echo"</fieldset>";
		echo"<fieldset style='width:100px'>";
			echo"<legend>Cambio:</legend>";	
			echo"<input type='radio' id='radio261' name='cambioFactura' checked>Por sistema</option>";
			echo"<br>";
			echo"<input type='radio' id='radio262' name='cambioFactura'>otro</option>";
			echo"<label id='lbltcF' style='visibility: hidden;' for='TipoDeCambio'>:</label>";
			echo"<input id='TipoDeCambioF' class='input' name='TipoDeCambioF' type='text' size='4' style='text-align:right; visibility: hidden;' value=1>";
		echo"</fieldset>";
		echo"<fieldset style='width:250px; border: 0px;'>";		
		//Nueva Agosto 2018. Modo Demo. Que inhabilita el boton de factura.
		//Lo puedo hacer directamente aca, y no necesito sesion, porque no depende del usuario sino del panel de control.

		//Nueva Septiembre 2018. Para cliente CIMSE , facturas con CAI en lugar de CAE
		//Primero pregunto si es CAI o CAE. Si es CAE ademas tengo que preguntar por el modo demo.
		//Lo mejor para hacer esto va a ser que el boton sea diferente y que llame a otra funcion diferente en JS (javascript)
		if ($regCAE['ContenidoValor'] == 'Si'){
			//Factura con CAE. Sigue el metodo viejo, con modo demo y simulacion
			if(!$resultc = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'modoDemo' and padre=1 limit 1")) die("Problemas con la consulta controlpanel");
			$reg = mysqli_fetch_array($resultc);
			if ($reg['ContenidoValor'] == 'Si'){
				//Si estoy en modo demo.
				echo"<input type='button' id='informeFac' value='Emitir Comprobante' disabled/>";
			} else {
				echo"<input type='button' id='informeFac' value='Emitir Comprobante'/>";
			}
				echo"<br>";
				echo"<input type='button' id='previaFac' value='Simular'/>";
				//Los otros botones tienen que estar (ocultos) para que funciones javascript
				echo"<input type='button' id='informeFacCAI' value='CAI' style='visibility: hidden;'/>";
		} else {
			//Factura con CAI, boton diferente que llama a funcion JS diferente, y ademas sin boton demo (no hace falta porque no hay comunicacion con AFIP)
			echo"<input type='button' id='informeFacCAI' value='Emitir Comprobante CAI'/>";
			//Los otros botones tienen que estar (ocultos) para que funciones javascript
			echo"<input type='button' id='informeFac' value='Cae' style='visibility: hidden;'/>";
			echo"<input type='button' id='previaFac' value='Simular' style='visibility: hidden;'/>";
		}			
		echo"</fieldset>";
echo"</fieldset>";
echo"<br>";
