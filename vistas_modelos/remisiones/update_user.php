<?php

$index_id = intval($_REQUEST['index_id']);
$numero_remision = htmlspecialchars($_REQUEST['numero_remision']);
$fecha = htmlspecialchars($_REQUEST['fecha']);
$cliente = htmlspecialchars($_REQUEST['cliente']);
$sucursal = htmlspecialchars($_REQUEST['sucursal']);
$tecnico = htmlspecialchars($_REQUEST['tecnico']);
$nombre_referencia = htmlspecialchars($_REQUEST['nombre_referencia']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);
$codigo_cotizacion = htmlspecialchars($_REQUEST['codigo_cotizacion']);
$codigo_ordenes_compra = htmlspecialchars($_REQUEST['codigo_ordenes_compra']);
$codigo_factura = htmlspecialchars($_REQUEST['codigo_factura']);
$fecha_caducado = htmlspecialchars($_REQUEST['fecha_caducado']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "UPDATE remisiones set numero_remision='$numero_remision',fecha='$fecha',cliente='$cliente',sucursal='$sucursal',tecnico='$tecnico',nombre_referencia='$nombre_referencia',cantidad='$cantidad',codigo_cotizacion='$codigo_cotizacion',codigo_ordenes_compra='$codigo_ordenes_compra',codigo_factura='$codigo_factura',fecha_caducado='$fecha_caducado' where index_id=$index_id";

$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'numero_remision' => $numero_remision,
	'fecha' => $fecha,
	'cliente' => $cliente,
	'sucursal' => $sucursal,
	'tecnico' => $tecnico,
	'nombre_referencia' => $nombre_referencia,
	'cantidad' => $cantidad,
	'codigo_cotizacion' => $codigo_cotizacion,
	'codigo_ordenes_compra' => $codigo_ordenes_compra,
	'codigo_factura' => $codigo_factura,
	'fecha_caducado' => $fecha_caducado
));
?>