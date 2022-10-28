<?php

$codigo_orden_trabajo = htmlspecialchars($_REQUEST['codigo_orden_trabajo']);
$tipo_orden_trabajo = htmlspecialchars($_REQUEST['tipo_orden_trabajo']);
$cliente= htmlspecialchars($_REQUEST['cliente']);
$sucursal = htmlspecialchars($_REQUEST['sucursal']);
$persona_encargada = htmlspecialchars($_REQUEST['persona_encargada']);
$tecnico = htmlspecialchars($_REQUEST['tecnico']);
$observaciones = htmlspecialchars($_REQUEST['observaciones']);
$fecha_orden_trabajo = htmlspecialchars($_REQUEST['fecha_orden_trabajo']);
$equipo = htmlspecialchars($_REQUEST['equipo']);
$marca = htmlspecialchars($_REQUEST['marca']);
$estado_equipo = htmlspecialchars($_REQUEST['estado_equipo']);
$hora_inicio = htmlspecialchars($_REQUEST['hora_inicio']);
$hora_finalizacion = htmlspecialchars($_REQUEST['hora_finalizacion']);
$voltaje = htmlspecialchars($_REQUEST['voltaje']);
$amperaje = htmlspecialchars($_REQUEST['amperaje']);
$clavija = htmlspecialchars($_REQUEST['clavija']);
$modelo = htmlspecialchars($_REQUEST['modelo']);
$serie = htmlspecialchars($_REQUEST['serie']);


include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into orden_trabajo (codigo_orden_trabajo,tipo_orden_trabajo,cliente,sucursal,persona_encargada,tecnico,observaciones,fecha_orden_trabajo,equipo,marca,estado_equipo,hora_inicio,hora_finalizacion,voltaje,amperaje,clavija,modelo,serie) values ('$codigo_orden_trabajo','$tipo_orden_trabajo','$cliente','$sucursal','$persona_encargada','$tecnico','$observaciones','$fecha_orden_trabajo','$equipo','$marca','$estado_equipo','$hora_inicio','$hora_finalizacion','$voltaje','$amperaje','$clavija','$modelo','$serie')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'codigo_orden_trabajo' => $codigo_orden_trabajo,
	'tipo_orden_trabajo' => $tipo_orden_trabajo,
	'cliente' => $cliente,
	'sucursal' => $sucursal,
	'persona_encargada' => $persona_encargada,
	'tecnico' => $tecnico,
	'observaciones' => $observaciones,
	'fecha_orden_trabajo' => $fecha_orden_trabajo,
	'equipo' => $equipo,
	'marca' => $marca,
	'estado_equipo' => $estado_equipo,
	'hora_inicio' => $hora_inicio,
	'hora_finalizacion' => $hora_finalizacion,
	'voltaje' => $voltaje,
	'amperaje' => $amperaje,
	'clavija' => $clavija,
	'modelo' => $modelo,
	'serie' => $serie

));
?>

