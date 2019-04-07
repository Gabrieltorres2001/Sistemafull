<?php
 // Import PHPMailer classes into the global namespace
 // These must be at the top of your script, not inside a function
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Configura un nombre de sesión personalizado.
    $secure = SECURE;
    // Esto detiene que JavaScript sea capaz de acceder a la identificación de la sesión.
    $httponly = true;
    // Obliga a las sesiones a solo utilizar cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
		echo 'error';
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Obtiene los params de los cookies actuales.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Configura el nombre de sesión al configurado arriba.
    session_name($session_name);
    session_start();            // Inicia la sesión PHP.
    session_regenerate_id();    // Regenera la sesión, borra la previa. 
}


function login($email, $password, $mysqli) {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Une $email al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
 
        // Obtiene las variables del resultado.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // Hace el hash de la contraseña con una sal única.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Si el usuario existe, revisa si la cuenta está bloqueada
            // por muchos intentos de conexión.
 
            if (checkbrute($user_id, $mysqli) == true) {
                // La cuenta está bloqueada.
                // Envía un correo electrónico al usuario que le informa que su cuenta está bloqueada.
                return false;
            } else {
                // Revisa que la contraseña en la base de datos coincida 
                // con la contraseña que el usuario envió.
                if ($db_password == $password) {
                    // La contraseña es correcta!
                    // Obtén el agente de usuario del usuario.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //  Protección XSS ya que podríamos imprimir este valor.
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // Protección XSS ya que podríamos imprimir este valor.
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/","",$username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                    $password . $user_browser);
					$now = time();
					// Se graba este login en la base de datos.
					    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
       					$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    					} 
						elseif (isset($_SERVER['HTTP_VIA'])) { 
						   $ip = $_SERVER['HTTP_VIA']; 
						} 
						elseif (isset($_SERVER['REMOTE_ADDR'])) { 
						   $ip = $_SERVER['REMOTE_ADDR']; 
						} 
						else { 
						   $ip = "unknown"; 
						}  
                    $mysqli->query("INSERT INTO login_exitosos(user_id, time, IP)
                                    VALUES ('$user_id', '$now', '$ip')");
                    // Inicio de sesión exitoso
                    return true;
                } else {
                    // La contraseña no es correcta.
                    // Se graba este intento en la base de datos.
                    $now = time();
						if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
       					$ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    					} 
						elseif (isset($_SERVER['HTTP_VIA'])) { 
						   $ip = $_SERVER['HTTP_VIA']; 
						} 
						elseif (isset($_SERVER['REMOTE_ADDR'])) { 
						   $ip = $_SERVER['REMOTE_ADDR']; 
						} 
						else { 
						   $ip = "unknown"; 
						}
                    $mysqli->query("INSERT INTO login_attempts(user_id, time, IP)
                                    VALUES ('$user_id', '$now', '$ip')");
                    return false;
                }
            }
        } else {
            // El usuario no existe.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Obtiene el timestamp del tiempo actual.
    $now = time();
 
    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Ejecuta la consulta preparada.
        $stmt->execute();
        $stmt->store_result();
 
        // Si ha habido más de 5 intentos de inicio de sesión fallidos.
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($mysqli) {
    // Revisa si todas las variables de sesión están configuradas.
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];		
 
        // Obtiene la cadena de agente de usuario del usuario.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Une $user_id al parámetro.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Ejecuta la consulta preparada.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Si el usuario existe, obtiene las variables del resultado.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Conectado!! 
                    return true;
                } else {
                    // No conectado.
                    return false;
                }
            } else {
                // No conectado.
                return false;
            }
        } else {
            // No conectado.
            return false;
        }
    } else {
        // No conectado.
        return false;
    }
}

function formulario_habilitado($formulario) {
    include_once 'sp_connect.php';
    $conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or die("Problemas con la conexión");
    mysqli_query($conexion_sp,"set names 'utf8'");
    if(!$result = mysqli_query($conexion_sp, "select habilitacion, clave from formularios where formulario='".$formulario."' limit 1")) die("Problemas con la consulta formularios");
    $row = mysqli_fetch_array($result);
    $password = hash('sha512', $formulario . $row['clave']);
    if ($row['habilitacion']==$password) {return true;} else {return false;}
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Solo nos interesan los enlaces relativos de  $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function enviarEmail($email, $nombre, $asunto, $cuerpo){

    include_once 'sp_connect.php';
    $conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or die("Problemas con la conexión");
    mysqli_query($conexion_sp,"set names 'utf8'");
	if(!$resultSMTPAuth = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'SMTPAuth' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowSMTPAuth = mysqli_fetch_array($resultSMTPAuth);
	if(!$resultSMTPSecure = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'SMTPSecure' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
    $rowSMTPSecure = mysqli_fetch_array($resultSMTPSecure);
	if(!$resultHost = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'Host' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
    $rowHost = mysqli_fetch_array($resultHost);
	if(!$resultPort = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'Port' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
    $rowPort = mysqli_fetch_array($resultPort);
	if(!$resultUsername = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'Username' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
    $rowUsername = mysqli_fetch_array($resultUsername);
	if(!$resultPassword = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'Password' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
    $rowPassword = mysqli_fetch_array($resultPassword);
	if(!$resultsetFrom = mysqli_query($conexion_sp, "select ContenidoValor from controlpanel where Descripcion = 'setFrom' and padre = '104' limit 1")){die("Problemas con la consulta de CONTROLPANEL");}
	$rowsetFrom = mysqli_fetch_array($resultsetFrom);    

    /* Exception class. */
    require '../PHPMailer/src/Exception.php';
    
    /* The main PHPMailer class. */
    require '../PHPMailer/src/PHPMailer.php';
    
    /* SMTP class, needed if you want to use SMTP. */
    require '../PHPMailer/src/SMTP.php';
		
    //require_once '../PHPMailer/src/PHPMailerAutoload.php';
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = $rowSMTPAuth['ContenidoValor'];
    $mail->SMTPSecure = $rowSMTPSecure['ContenidoValor']; //Modificar
    $mail->Host = $rowHost['ContenidoValor']; //Modificar
    $mail->Port = $rowPort['ContenidoValor']; //Modificar
    //Tomado de: https://alexwebdevelop.com/phpmailer-tutorial/
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
     );
    
    $mail->Username = $rowUsername['ContenidoValor']; //Modificar
    $mail->Password = $rowPassword['ContenidoValor']; //Modificar
    
    $mail->setFrom($rowsetFrom['ContenidoValor'], 'Administrador - SistemaFull'); //Modificar
    $mail->addAddress($email, $nombre);
    
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->IsHTML(true);


    if($mail->send()) {
        echo $mail->ErrorInfo;
    return true;}
    else {
        echo $mail->ErrorInfo;
        return false;
    }


}