<?php

$codigo_orden = htmlspecialchars($_REQUEST['codigo_orden']);
$codigo_referencia = htmlspecialchars($_REQUEST['codigo_referencia']);
$cantidad= htmlspecialchars($_REQUEST['cantidad']);
$precio_unitario = htmlspecialchars($_REQUEST['precio_unitario']);
$precio_total = htmlspecialchars($_REQUEST['precio_total']);
$codigo_solicitante = htmlspecialchars($_REQUEST['codigo_solicitante']);
$concepto = htmlspecialchars($_REQUEST['concepto']);
$codigo_cliente_salida = htmlspecialchars($_REQUEST['codigo_cliente_salida']);
$fecha_ingreso = htmlspecialchars($_REQUEST['fecha_ingreso']);
$fecha_salida = htmlspecialchars($_REQUEST['fecha_salida']);
$estatus = htmlspecialchars($_REQUEST['estatus']);
$cod_cotizacion = htmlspecialchars($_REQUEST['cod_cotizacion']);
$cod_factura = htmlspecialchars($_REQUEST['cod_factura']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into ordenes_compra (codigo_orden,codigo_referencia,cantidad,precio_unitario,precio_total,codigo_solicitante,concepto,codigo_cliente_salida,fecha_ingreso,fecha_salida,estatus,cod_cotizacion,cod_factura) values ('$codigo_orden','$codigo_referencia','$cantidad','$precio_unitario','$precio_total','$codigo_solicitante','$concepto','$codigo_cliente_salida','$fecha_ingreso','$fecha_salida','$estatus','$cod_cotizacion','$cod_factura')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'codigo_orden' => $codigo_orden,
	'codigo_referencia' => $codigo_referencia,
	'cantidad' => $cantidad,
	'precio_unitario' => $precio_unitario,
	'precio_total' => $precio_total,
	'codigo_solicitante' => $codigo_solicitante,
	'concepto' => $concepto,
	'codigo_cliente_salida' => $codigo_cliente_salida,
	'fecha_ingreso' => $fecha_ingreso,
	'fecha_salida' => $fecha_salida,
	'estatus' => $estatus,
	'cod_cotizacion' => $cod_cotizacion,
	'cod_factura' => $cod_factura

));
?>

