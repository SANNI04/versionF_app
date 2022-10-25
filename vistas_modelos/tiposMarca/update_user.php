<?php

$index_id = intval($_REQUEST['index_id']);
$marca = htmlspecialchars($_REQUEST['marca']);
$codigo_marca = htmlspecialchars($_REQUEST['codigo_marca']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();


$sql = "update tipos_marca set marca='$marca',codigo_marca='$codigo_marca' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'marca' => $marca,
	'codigo_marca' => $codigo_marca

));
?>