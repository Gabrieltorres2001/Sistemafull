<?php
include_once 'includes/psl-config.php';


    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
	$conexion=mysqli_connect(HOST,USER,PASSWORD,DATABASE) or
    die("Problemas con la conexión");
	mysqli_query($conexion,"set names 'utf8'");
	if ($_REQUEST['nombre']!="")
		{$nnnombre=$_REQUEST['nombre'];
		}
		else
		{$registros=mysqli_query($conexion, "select Nombre from members where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
		if ($reg=mysqli_fetch_array($registros))
			{$nnnombre=$reg['Nombre'];
			}
		};
	if ($_REQUEST['apellido']!="")
		{$nnapellido=$_REQUEST['apellido'];
		}
		else
		{$registros=mysqli_query($conexion, "select Apellido from members where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
		if ($reg=mysqli_fetch_array($registros))
			{$nnapellido=$reg['Apellido'];
			}
		};	
	if ($_REQUEST['horarios']!="")
		{$nnhorarios=$_REQUEST['horarios'];
		}
		else
		{$registros=mysqli_query($conexion, "select Horarios from members where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
		if ($reg=mysqli_fetch_array($registros))
			{$nnhorarios=$reg['Horarios'];
			}
		};	
	if ($_REQUEST['usrname']!="")
		{$nnusrname=$_REQUEST['usrname'];
		}
		else
		{$registros=mysqli_query($conexion, "select username from members where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
		if ($reg=mysqli_fetch_array($registros))
			{$nnusrname=$reg['username'];
			}
		};	
		if ($_REQUEST['eMail']!="")
		{$eMail=$_REQUEST['eMail'];
		}
		else
		{$registros=mysqli_query($conexion, "select eMail from members where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
		if ($reg=mysqli_fetch_array($registros))
			{$eMail=$reg['eMail'];
			}
		};	
		$FechaActualizacion=time();
  mysqli_query($conexion, "update members set Nombre='".$nnnombre."', Apellido='".$nnapellido."', Horarios='".$nnhorarios."', username='".$nnusrname."', eMail='".$eMail."', FechaActualizacion='".$FechaActualizacion."' where id='".$_REQUEST['idsesion']."'") 
		or die("Problemas en el select:".mysqli_error($conexion));
	echo "{
        \"nombre\":\"".$nnnombre."\",
        \"apellido\":\"".$nnapellido."\",
		\"horarios\":\"".$nnhorarios."\",
		\"useername\":\"".$nnusrname."\",
		\"eMail\":\"".$eMail."\",
		\"fechaActualizacion\":\"".date("d/m/o H:i:s",$FechaActualizacion)."\"
      }";
    
