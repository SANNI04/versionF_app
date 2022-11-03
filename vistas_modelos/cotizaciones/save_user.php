<?php

$cod_cotizacion = htmlspecialchars($_REQUEST['cod_cotizacion']);
$fecha_cotizacion = htmlspecialchars($_REQUEST['fecha_cotizacion']);
$hoja_trabajo = htmlspecialchars($_REQUEST['hoja_trabajo']);
$nombre_creador = htmlspecialchars($_REQUEST['nombre_creador']);
$cliente = htmlspecialchars($_REQUEST['cliente']);
$sucursal = htmlspecialchars($_REQUEST['sucursal']);
$marca = htmlspecialchars($_REQUEST['marca']);
$modelo = htmlspecialchars($_REQUEST['modelo']);
$serie = htmlspecialchars($_REQUEST['serie']);
$repuestos = htmlspecialchars($_REQUEST['repuestos']);
$valor = htmlspecialchars($_REQUEST['valor']);
$ejecucion = htmlspecialchars($_REQUEST['ejecucion']);
$cod_orden_compra = htmlspecialchars($_REQUEST['cod_orden_compra']);
$cod_factura = htmlspecialchars($_REQUEST['cod_factura']);
$codigocliente = htmlspecialchars($_REQUEST['codigocliente']);
$vigencia = htmlspecialchars($_REQUEST['vigencia']);
$ciudad = htmlspecialchars($_REQUEST['ciudad']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into cotizaciones (cod_cotizacion,fecha_cotizacion,hoja_trabajo,nombre_creador,cliente,sucursal,marca,modelo,serie,repuestos,valor,ejecucion,cod_orden_compra,cod_factura,codigocliente,vigencia,ciudad) values('$cod_cotizacion','$fecha_cotizacion','$hoja_trabajo','$nombre_creador','$cliente','$sucursal','$marca','$modelo','$serie','$repuestos','$valor','$ejecucion','$cod_orden_compra','$cod_factura','$codigocliente','$vigencia','$ciudad')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'cod_cotizacion' => $cod_cotizacion,
	'fecha_cotizacion' => $fecha_cotizacion,
	'hoja_trabajo' => $hoja_trabajo,
	'nombre_creador' => $nombre_creador,
	'cliente' => $cliente,
	'sucursal' => $sucursal,
	'marca' => $marca,
	'modelo' => $modelo,
	'serie' => $serie,
	'repuestos' => $repuestos,
	'valor' => $valor,
	'ejecucion' => $ejecucion,
	'cod_orden_compra' => $cod_orden_compra,
	'cod_factura' => $cod_factura,
	'codigocliente' => $codigocliente,
	'vigencia' => $vigencia,
	'ciudad' => $ciudad
));
?>

