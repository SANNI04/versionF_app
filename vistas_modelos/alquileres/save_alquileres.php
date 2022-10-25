<?php

$equipo = htmlspecialchars($_REQUEST['equipo']);
$cliente = htmlspecialchars($_REQUEST['cliente']);
$fecha_alquiler = htmlspecialchars($_REQUEST['fecha_alquiler']);
$fecha_devolucion = htmlspecialchars($_REQUEST['fecha_devolucion']);
$fecha_alerta = htmlspecialchars($_REQUEST['fecha_alerta']);

include '../conexion/conn.php';
$conf= new Configuracion();
$conf->conectar();

$sql = "insert into alquileres (equipo,cliente,fecha_alquiler,fecha_devolucion,fecha_alerta) values ('$equipo','$cliente','$fecha_alquiler','$fecha_devolucion','$fecha_alerta')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'equipo' => $equipo,
	'cliente' => $cliente,
	'fecha_alquiler' => $fecha_alquiler,
	'fecha_devolucion' => $fecha_devolucion,
	'fecha_alerta' => $fecha_alerta
));
?>
