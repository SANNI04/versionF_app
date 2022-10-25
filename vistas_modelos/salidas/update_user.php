<?php

$index_id = intval($_REQUEST['index_id']);
$codigo_referencia = htmlspecialchars($_REQUEST['codigo_referencia']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);
$fecha_salida = htmlspecialchars($_REQUEST['fecha_salida']);
$codigo_orden_salida = htmlspecialchars($_REQUEST['codigo_orden_salida']);


include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "update salidas set codigo_referencia='$codigo_referencia',cantidad='$cantidad',fecha_salida='$fecha_salida',codigo_orden_salida='$codigo_orden_salida' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'codigo_referencia' => $codigo_referencia,
	'cantidad' => $cantidad,
	'fecha_salida' => $fecha_salida,
	'codigo_orden_salida' => $codigo_orden_salida

));
?>