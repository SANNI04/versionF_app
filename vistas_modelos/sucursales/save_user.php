<?php

$nombre_sucursal = htmlspecialchars($_REQUEST['nombre_sucursal']);
$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);
$direccion = htmlspecialchars($_REQUEST['direccion']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into sucursal_cliente (nombre_sucursal,identificacion_cliente,direccion) values ('$nombre_sucursal','$identificacion_cliente','$direccion')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'nombre_sucursal' => $nombre_sucursal,
	'identificacion_cliente' => $identificacion_cliente,
	'direccion' => $direccion

));
?>