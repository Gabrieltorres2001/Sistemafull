<?php
//Archivo de conexión a la base de datos

require('../includes/sp_connect.php');
$conexion=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion,"set names 'utf8'");
	
//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");

	//Comprobamos que los inputs no estén vacíos, y si lo están, mandamos el mensaje correspondiente
	if($_FILES['imagen']['error'] === 4) {
		die ("{
		\"id\":\"0\"
		}");
		//die( 'Es necesario establecer un archivo' );
		//Si los inputs están seteados y el archivo no tiene errores, se procede
	} else if($_FILES['imagen']['error'] === 0 ) {
	
		 $archivo = $_FILES["imagen"]["tmp_name"]; 
		 $tamanio = $_FILES["imagen"]["size"];
		 $tipo    = $_FILES["imagen"]["type"];
		 $nombre  = $_FILES["imagen"]["name"];	
		$fp = fopen($archivo, "rb");
		$contenido = fread($fp, $tamanio);
		fclose($fp);
		//Convertimos la información de la imagen en binario para insertarla en la BBDD
		$imagenBinaria = addslashes($contenido);

		//Nombre del archivo
		$nombreArchivo = $_FILES['imagen']['name'];
		$tipoArchivo = $_FILES['imagen']['type'];
		//Extensiones permitidas
		$extensiones = array('pdf');

		//Obtenemos la extensión (en minúsculas) para poder comparar
		$tmp = explode('.', $nombreArchivo);
		$extension = strtolower(end($tmp));

		//Verificamos que sea una extensión permitida, si no lo es mostramos un mensaje de error
		if(!in_array($extension, $extensiones)) {
			//echo( 'Sólo se permiten archivos con las siguientes extensiones: '.implode(', ', $extensiones) );
			//echo "<BR>";
			echo "{
				\"id\":\"0\"
				}";
		} else {
			//Si la extensión es correcta, procedemos a comprobar el tamaño del archivo subido
			//Y definimos el máximo que se puede subir
			//Por defecto el máximo es de 2 MB, pero se puede aumentar desde el .htaccess o en la directiva 'upload_max_filesize' en el php.ini

			$tamañoArchivo = $_FILES['imagen']['size']; //Obtenemos el tamaño del archivo en Bytes
			$tamañoArchivoKB = round(intval(strval( $tamañoArchivo / 1024 ))); //Pasamos el tamaño del archivo a KB

			$tamañoMaximoKB = "16384"; //Tamaño máximo expresado en KB
			$tamañoMaximoBytes = $tamañoMaximoKB * 1024; // -> 16777216 Bytes -> 16 MB
			$tamañoMaximoMB = $tamañoMaximoKB / 1024;

			//Comprobamos el tamaño del archivo, y mostramos un mensaje si es mayor al tamaño expresado en Bytes
			if($tamañoArchivo > $tamañoMaximoBytes) {
				die ("{
						\"id\":\"0\"
						}");
				//die( "El archivo ".$nombreArchivo." es demasiado grande. El tamaño máximo del archivo es de ".$tamañoMaximoMB."Mb." );
			} else {
				//Si el tamaño es correcto, subimos los datos
				$consulta = "INSERT INTO pdflegajos (PDF, NombreArchivo, tipo) VALUES ('$imagenBinaria', '$nombre', '$tipo')";

				//Hacemos la inserción, y si es correcta, se procede
				if(mysqli_query($conexion, $consulta)) {
					//Mostramos un mensaje
					//echo( "El archivo con el nombre ".$nombreArchivo." fue subido. Su peso es de ".$tamañoArchivoKB." KB." );
					//echo "<BR>";
					$nuevoid=mysqli_insert_id($conexion);
					echo "{
						\"id\":\"$nuevoid\"
						}";		
				} else {
					//Si hay algún error con la inserción, se muestra un mensaje
					//echo( "Parece que ha habido un error. Recargue la página e inténtelo nuevamente." );
					echo "{
						\"id\":\"0\"
						}";
				};

			};//Fin condicional tamaño archivo

		};//Fin condicional extensiones

	};//Fin condicional para saber si todos los campos necesarios están completos
?>