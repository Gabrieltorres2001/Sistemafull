<?php
function llenar_listado_Panel() {
   //Creamos la conexión
include_once 'includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
//generamos la consulta contactos2
   if(!$result = mysqli_query($conexion_sp, "select id, Descripcion from controlpanel where padre=0")) die("Problemas con la consulta controlpanel");
echo "<table class='display' id='tablaContactos'>";  
echo "<tr>";  
echo "<th width='320'>Menu</th>";  
echo "</tr>";  
while ($row = mysqli_fetch_array($result)){   
    echo "<tr id=".$row['id'].">";  
    echo "<td id=".$row['id'].">".$row['Descripcion']."</td>"; 
    echo "</tr>";  
};  
echo "</table>";
}

function imprimir_detalle_menu_panel($resultc, $conexion_sp, $idEmpresaTemp, $usuarioSesion, $padre) {
include_once '../includes/db_connect.php';
$conexion_db=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or die("Problemas con la conexión");
mysqli_query($conexion_db,"set names 'utf8'");
if(!$sesionSistPlus = mysqli_query($conexion_db, "select nivelUsuario from members where id='".$usuarioSesion."' limit 1")) die("Problemas con la consulta3");
$rowSesionSistPlus = mysqli_fetch_array($sesionSistPlus);
	
	while ($reg = mysqli_fetch_array($resultc)){  
		//Uno a uno todos los registros pertenecientes a este menu
		//Primero tengo que preguntar si el usuario tiene permisos para ver esta opcion
		if ($reg['nivelUsuarioMinimo'] >= $rowSesionSistPlus['nivelUsuario'])
			{
			//Un switch (select Case), y en función del tipo de campo, la forma de presentar el dato
			switch ($reg['tipoCampo']) {
			case 'SiNo':
				echo"<br />";
				//El label con la descripcion del campo
				echo"<label for='".$reg['tipoCampo'].$reg['Descripcion']."'>".$reg['DescripcionExtendida'].":</label>";
				//un hidden con el tipo de campo y otr para el id
				echo"<input id='".$reg['tipoCampo']."' class='hidden' name='".$reg['tipoCampo']."' type='text' size='5' value=".$reg['tipoCampo']." >";
				echo"<input id='".$reg['id']."' class='hidden' name='".$reg['id']."' type='text' size='5' value=".$reg['id'].">";			
				echo"<select id='".$reg['tipoCampo'].$reg['Descripcion']."' class='input' name='".$reg['tipoCampo'].$reg['Descripcion']."' onChange='algoCambio(".$reg['tipoCampo'].$reg['Descripcion'].",".$reg['tipoCampo'].",".strval($reg['id']).");'>";
					if ($reg['ContenidoValor']=='No') {
						echo"<option selected value='No'>No</option>";
						echo"<option value='Si'>Si</option>";
					} else {
						echo"<option value='No'>No</option>";
						echo"<option selected value='Si'>Si</option>";
					}
				echo"</select>";	
				echo" (".$reg['nivelUsuarioMinimo'].")";
			break;		
			case 'Boton':
				echo"<br />";
				//un hidden con el tipo de campo y otro con el campo de texto 'ContenidoValor' que es el que luego necesito para el link.
				echo"<input id='".$reg['tipoCampo']."' class='hidden' name='".$reg['tipoCampo']."' type='text' size='5' value=".$reg['tipoCampo']." >";
				echo"<input id='".$reg['tipoCampo'].$reg['Descripcion']."' class='hidden' name='".$reg['id']."' type='text' size='5' value=".$reg['ContenidoValor'].">";
				echo"<input type='button' name='".$reg['tipoCampo'].$reg['Descripcion']."' value='".$reg['DescripcionExtendida']."'  onClick='algoCambio(".$reg['tipoCampo'].$reg['Descripcion'].",".$reg['tipoCampo'].",".strval($reg['id']).");'>";
				echo" (".$reg['nivelUsuarioMinimo'].")";
			break;	
			case 'Texto':
				echo"<br />";
				//El label con la descripcion del campo
				echo"<label for='".$reg['tipoCampo'].$reg['Descripcion']."'>".$reg['DescripcionExtendida'].":</label>";
				//un hidden con el tipo de campo y otr para el id
				echo"<input id='".$reg['tipoCampo']."' class='hidden' name='".$reg['tipoCampo']."' type='text' size='5' value=".$reg['tipoCampo']." >";
				echo"<input id='".$reg['id']."' class='hidden' name='".$reg['id']."' type='text' size='5' value=".$reg['id'].">";
				echo"<input type='text' class='input' size='65' id='".$reg['tipoCampo'].$reg['Descripcion']."' name='".$reg['tipoCampo'].$reg['Descripcion']."' value='".$reg['ContenidoValor']."' onChange='algoCambio(".$reg['tipoCampo'].$reg['Descripcion'].",".$reg['tipoCampo'].",".strval($reg['id']).");'>";
				echo" (".$reg['nivelUsuarioMinimo'].")";
			break;	
			case 'Nota':
				echo"<br />";
				//El label con la descripcion del campo
				echo"<label >".$reg['ContenidoValor']."</label>";
				echo" (".$reg['nivelUsuarioMinimo'].")";
			break;	
			case 'Check':
				echo"<br />";
				//El label con la descripcion del campo
				echo"<label for='".$reg['tipoCampo'].$reg['Descripcion']."'>".$reg['Descripcion'].": </label>";
				//un hidden con el tipo de campo y otr para el id
				//echo"<input id='".$reg['tipoCampo']."' class='hidden' name='".$reg['tipoCampo']."' type='text' size='5' value=".$reg['tipoCampo']." >";
				//echo"<input id='".$reg['id']."' class='hidden' name='".$reg['id']."' type='text' size='5' value=".$reg['id'].">";
				echo"<input type='text' class='input' size='35' value='".$reg['ContenidoValor']." '>";
				if ($reg['DescripcionExtendida']=='1') 
					{
					echo"<input id='".$reg['tipoCampo'].$reg['Descripcion']."' type='checkbox' onChange='algoCambio(".$reg['tipoCampo'].$reg['DescripcionExtendida'].",".$reg['tipoCampo'].",".strval($reg['id']).")' checked>";
					}
			  else {echo"<input id='".$reg['tipoCampo'].$reg['Descripcion']."' type='checkbox' onChange='algoCambio(".$reg['tipoCampo'].$reg['DescripcionExtendida'].",".$reg['tipoCampo'].",".strval($reg['id']).")'></input>";}
			  echo" (".$reg['nivelUsuarioMinimo'].")";
			break;				
			}
			//por ultimo un separador
			echo"<br />";
			}
	}	
	//por ultimo un separador
	echo"<br />";
}