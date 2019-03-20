<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Configura un nombre de sesi�n personalizado.
    $secure = SECURE;
    // Esto detiene que JavaScript sea capaz de acceder a la identificaci�n de la sesi�n.
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
    // Configura el nombre de sesi�n al configurado arriba.
    session_name($session_name);
    session_start();            // Inicia la sesi�n PHP.
    session_regenerate_id();    // Regenera la sesi�n, borra la previa. 
}


function login($email, $password, $mysqli) {
    // Usar declaraciones preparadas significa que la inyecci�n de SQL no ser� posible.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Une �$email� al par�metro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
 
        // Obtiene las variables del resultado.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // Hace el hash de la contrase�a con una sal �nica.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Si el usuario existe, revisa si la cuenta est� bloqueada
            // por muchos intentos de conexi�n.
 
            if (checkbrute($user_id, $mysqli) == true) {
                // La cuenta est� bloqueada.
                // Env�a un correo electr�nico al usuario que le informa que su cuenta est� bloqueada.
                return false;
            } else {
                // Revisa que la contrase�a en la base de datos coincida 
                // con la contrase�a que el usuario envi�.
                if ($db_password == $password) {
                    // �La contrase�a es correcta!
                    // Obt�n el agente de usuario del usuario.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //  Protecci�n XSS ya que podr�amos imprimir este valor.
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // Protecci�n XSS ya que podr�amos imprimir este valor.
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
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
                    // Inicio de sesi�n exitoso
                    return true;
                } else {
                    // La contrase�a no es correcta.
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
 
    // Todos los intentos de inicio de sesi�n se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Ejecuta la consulta preparada.
        $stmt->execute();
        $stmt->store_result();
 
        // Si ha habido m�s de 5 intentos de inicio de sesi�n fallidos.
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($mysqli) {
    // Revisa si todas las variables de sesi�n est�n configuradas.
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
            // Une �$user_id� al par�metro.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Ejecuta la consulta preparada.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Si el usuario existe, obtiene las variables del resultado.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // ��Conectado!! 
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