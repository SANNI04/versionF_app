<?php

$index_id = intval($_REQUEST['index_id']);
$nombre_cliente = htmlspecialchars($_REQUEST['nombre_cliente']);
$identificacion = htmlspecialchars($_REQUEST['identificacion']);
$tipo_identificacion = htmlspecialchars($_REQUEST['tipo_identificacion']);
$email = htmlspecialchars($_REQUEST['email']);
$telefono = htmlspecialchars($_REQUEST['telefono']);
$direccion = htmlspecialchars($_REQUEST['direccion']);

include '../conexion/conn.php';
$conf= new Configuracion();
$conf->conectar();

$sql = "update clientes set nombre_cliente='$nombre_cliente',identificacion='$identificacion',tipo_identificacion='$tipo_identificacion',email='$email',telefono='$telefono',direccion='$direccion' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'nombre_cliente' => $nombre_cliente,
	'identificacion' => $identificacion,
	'tipo_identificacion' => $tipo_identificacion,
	'email' => $email,
	'telefono' => $telefono,
	'direccion' => $direccion

));
?>