<?php
include_once './includes/psl-config.php';

function Buscar_Usuario($user_id) {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($stmt = $mysqli->prepare("SELECT Nombre, Apellido, Horarios, FechaActualizacion, Foto, email 
        FROM members
       WHERE id = ?
        LIMIT 1")){

        $stmt->bind_param('s', $user_id);  // Une “$user_id” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();

        // Obtiene las variables del resultado.
        $stmt->bind_result($Nombre, $Apellido, $Horarios, $FechaActualizacion, $Foto, $email);
        $stmt->fetch();
 		
		if ($stmt->num_rows == 1) {
			//es necesario guardarlos en $_SESSION?
			$_SESSION['Nombre'] = $Nombre;
			$_SESSION['Apellido'] = $Apellido;
			$_SESSION['Horarios'] = $Horarios;
			$_SESSION['FechaActualizacion'] = date("d/m/o H:i:s",$FechaActualizacion);
			$_SESSION['Foto'] = $Foto;	
			$_SESSION['email'] = $email;	
			} else {
				// El usuario no existe.

			}
  	
}
}

function Actualizar_Usuario($user_id) {
	sec_session_start();
	$conexion=mysqli_connect(HOST, USER, PASSWORD, DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion,"set names 'utf8'");

/*mysqli_query($conexion, "update members
                          set Nombre='protected_page3'") or
  die("Problemas en el select:".mysqli_error($conexion));*/
  header('Location: /protected_page3.php');
	//primero tengo que ver cuales campos voy a actualizar
	//si la longitud es cero, lo dejo con el que esta
	//no olvidar de actualizar tambien el campo $FechaActualizacion
	
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
	/* $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($stmt = $mysqli->prepare("SELECT Nombre, Apellido, Horarios, FechaActualizacion, Foto 
        FROM members
       WHERE id = ?
        LIMIT 1")){

        $stmt->bind_param('s', $user_id);  // Une “$user_id” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();

        // Obtiene las variables del resultado.
        $stmt->bind_result($Nombre, $Apellido, $Horarios, $FechaActualizacion, $Foto);
        $stmt->fetch();
 		
		if ($stmt->num_rows == 1) {
			//es necesario guardarlos en $_SESSION?
			$_SESSION['Nombre'] = $Nombre;
			$_SESSION['Apellido'] = $Apellido;
			$_SESSION['Horarios'] = $Horarios;
			$_SESSION['FechaActualizacion'] = $FechaActualizacion;
			$_SESSION['Foto'] = $Foto;		
			} else {
				// El usuario no existe.

			}
  	
}*/

}

function ultimo_inicio_sesion($user_id) {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($stmt = $mysqli->prepare("SELECT time 
        FROM login_exitosos
       WHERE user_id = ?
        order by time desc LIMIT 1,1")){

        $stmt->bind_param('s', $user_id);  // Une “$user_id” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();

        // Obtiene las variables del resultado.
        $stmt->bind_result($time);
        $stmt->fetch();
 		
		if ($stmt->num_rows == 1) {
			//es necesario guardarlos en $_SESSION?
			//$_SESSION['Nombre'] = $Nombre;
			echo date("d/m/o H:i:s",$time);
	
			} else {
				// El usuario no existe.

			}
  	
}
}


