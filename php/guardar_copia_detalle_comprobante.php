<?php
   //Creamos la conexión
include_once '../includes/sp_connect.php';
$conexion_sp=mysqli_connect(HOSTSP,USERSP,PASSWORDSP,DATABASESP) or
    die("Problemas con la conexión");
	mysqli_query($conexion_sp,"set names 'utf8'");
	
//generamos la consulta para buscar los detalles a copiar
if(!$result = mysqli_query($conexion_sp, "select * from detallecomprobante where IdComprobante = '".$_REQUEST['idcomprobante']."'")) die("Problemas con la consulta de lectura");

//Grabamos todos los registros encontrados (ojo que algunos campos cambian de lugar, por lo menos uno el iddetallecomprobante, y se agrega el cae)
while ($regCopio = mysqli_fetch_array($result)){

	if(!$resultcopia = mysqli_query($conexion_sp, "insert into detallecomprobantecae (IdDCompCAE, IdComprobante, IdProducto, Cantidad, CostoUnitario, NumeroSerie, SubTotal, Orden, Destino, DestinoSalida, DestinoEntrada, Descuento, IVA, Moneda, desc1, desc2, Cumplido, Observaciones, Inversion, Previsto, Anulado, Imprimir, PlazoEntrega, FSolicitud, Fcotizacion, FConfirmacion, FEntrega, actualiz, CAE, IdDetalleComprobante) values ('', '".$regCopio['IdComprobante']."', '".$regCopio['IdProducto']."', '".$regCopio['Cantidad']."', '".$regCopio['CostoUnitario']."', '".$regCopio['NumeroSerie']."', '".$regCopio['SubTotal']."', '".$regCopio['Orden']."', '".$regCopio['Destino']."', '".$regCopio['DestinoSalida']."', '".$regCopio['DestinoEntrada']."', '".$regCopio['Descuento']."', '".$regCopio['IVA']."', '".$regCopio['Moneda']."', '".$regCopio['desc1']."', '".$regCopio['desc2']."', '".$regCopio['Cumplido']."', '".$regCopio['Observaciones']."', '".$regCopio['Inversion']."', '".$regCopio['Previsto']."', '".$regCopio['Anulado']."', '".$regCopio['Imprimir']."', '".$regCopio['PlazoEntrega']."', '".$regCopio['FSolicitud']."', '".$regCopio['Fcotizacion']."', '".$regCopio['FConfirmacion']."', '".$regCopio['FEntrega']."', now(), '".$_REQUEST['numCAE']."', '".$regCopio['IdDetalleComprobante']."')")){
		echo"<label style='font-size:1em; font-weight:bold; color:red'>Articulo NO copiado</label>";
		 die("Problemas con la consulta de copia");
	}
}
	
//si llegue hasta aca es porque no hubo DIE, asi que todo ok
echo"OkOko";
	
