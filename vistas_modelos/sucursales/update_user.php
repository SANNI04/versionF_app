<?php

$index_id = intval($_REQUEST['index_id']);
$nombre_sucursal = htmlspecialchars($_REQUEST['nombre_sucursal']);
$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);
$direccion = htmlspecialchars($_REQUEST['direccion']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "update sucursal_cliente set nombre_sucursal='$nombre_sucursal',identificacion_cliente='$identificacion_cliente',direccion='$direccion' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'nombre_sucursal' => $nombre_sucursal,
	'identificacion_cliente' => $identificacion_cliente,
	'direccion' => $direccion

));
?>