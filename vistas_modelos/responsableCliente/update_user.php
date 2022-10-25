<?php

$index_id = intval($_REQUEST['index_id']);
$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);
$identificacion_usuario = htmlspecialchars($_REQUEST['identificacion_usuario']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "update responsable_cliente set identificacion_cliente='$identificacion_cliente',identificacion_usuario='$identificacion_usuario' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'identificacion_cliente' => $identificacion_cliente,
	'identificacion_usuario' => $identificacion_usuario

));
?>