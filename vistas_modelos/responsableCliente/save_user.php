<?php

$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);
$identificacion_usuario = htmlspecialchars($_REQUEST['identificacion_usuario']);

include "../conexion/conn.php";
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into responsable_cliente (identificacion_cliente,identificacion_usuario) values ('$identificacion_cliente','$identificacion_usuario')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'identificacion_cliente' => $identificacion_cliente,
	'identificacion_usuario' => $identificacion_usuario

));
?>