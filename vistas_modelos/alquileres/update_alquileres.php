<?php

$index_id = intval($_REQUEST['index_id']);
$equipo = htmlspecialchars($_REQUEST['equipo']);
$cliente = htmlspecialchars($_REQUEST['cliente']);
$fecha_alquiler = htmlspecialchars($_REQUEST['fecha_alquiler']);
$fecha_devolucion = htmlspecialchars($_REQUEST['fecha_devolucion']);
$fecha_alerta = htmlspecialchars($_REQUEST['fecha_alerta']);

include '../conexion/conn.php';
$conf= new Configuracion();
$conf->conectar();

$sql = "update alquileres set equipo='$equipo',cliente='$cliente',fecha_alquiler='$fecha_alquiler',fecha_devolucion='$fecha_devolucion',fecha_alerta='$fecha_alerta' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'equipo' => $equipo,
	'cliente' => $cliente,
	'fecha_alquiler' => $fecha_alquiler,
	'fecha_devolucion' => $fecha_devolucion,
	'fecha_alerta' => $fecha_alerta
));
?>