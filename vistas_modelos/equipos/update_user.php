<?php

$index_id = intval($_REQUEST['index_id']);
$codigo_equipo = htmlspecialchars($_REQUEST['codigo_equipo']);
$nombre_modelo = htmlspecialchars($_REQUEST['nombre_modelo']);
$codigo_marca = htmlspecialchars($_REQUEST['codigo_marca']);
$cod_serial = htmlspecialchars($_REQUEST['cod_serial']);
$referencia = htmlspecialchars($_REQUEST['referencia']);
$estado_fisico = htmlspecialchars($_REQUEST['estado_fisico']);
$estado_alquiler = htmlspecialchars($_REQUEST['estado_alquiler']);


include '../conexion/conn.php';

$conf= new Configuracion();
$conf->conectar();

$sql = "update equipos set codigo_equipo='$codigo_equipo',nombre_modelo='$nombre_modelo',codigo_marca='$codigo_marca',cod_serial='$cod_serial',referencia='$referencia',estado_fisico='$estado_fisico',estado_alquiler='$estado_alquiler' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'codigo_equipo' => $codigo_equipo,
	'nombre_modelo' => $nombre_modelo,
	'codigo_marca' => $codigo_marca,
	'cod_serial' => $cod_serial,
	'referencia' => $referencia,
	'estado_fisico' => $estado_fisico,
	'estado_alquiler' => $estado_alquiler

));
?>