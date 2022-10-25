<?php

$cod_equipo = htmlspecialchars($_REQUEST['cod_equipo']);
$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);
$identificacion_comercial = htmlspecialchars($_REQUEST['identificacion_comercial']);
$fecha_alquiler = htmlspecialchars($_REQUEST['fecha_alquiler']);
$fecha_devolucion = htmlspecialchars($_REQUEST['fecha_devolucion']);
$fecha_mantenimiento = htmlspecialchars($_REQUEST['fecha_mantenimiento']);


include "../conexion/conn.php";
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into renta_equipos (cod_equipo,identificacion_cliente,identificacion_comercial,fecha_alquiler,fecha_devolucion,fecha_mantenimiento) values ('$cod_equipo','$identificacion_cliente','$identificacion_comercial','$fecha_alquiler','$fecha_devolucion','$fecha_mantenimiento')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'cod_equipo' => $cod_equipo,
	'identificacion_cliente' => $identificacion_cliente,
	'identificacion_comercial' => $identificacion_comercial,
	'fecha_alquiler' => $fecha_alquiler,
	'fecha_devolucion' => $fecha_devolucion,
	'fecha_mantenimiento' => $fecha_mantenimiento

));
?>