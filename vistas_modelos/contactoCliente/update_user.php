<?php

$index_id = intval($_REQUEST['index_id']);
$identificacion = htmlspecialchars($_REQUEST['identificacion']);
$primer_nombre = htmlspecialchars($_REQUEST['primer_nombre']);
$segundo_nombre = htmlspecialchars($_REQUEST['segundo_nombre']);
$primer_apellido = htmlspecialchars($_REQUEST['primer_apellido']);
$segundo_apellido = htmlspecialchars($_REQUEST['segundo_apellido']);
$telefono = htmlspecialchars($_REQUEST['telefono']);
$email = htmlspecialchars($_REQUEST['email']);
$identificacion_cliente = htmlspecialchars($_REQUEST['identificacion_cliente']);

include '../conexion/conn.php';

$conf= new Configuracion();
$conf->conectar();

$sql = "update contacto_cliente set identificacion='$identificacion',primer_nombre='$primer_nombre',segundo_nombre='$segundo_nombre',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',telefono='$telefono',email='$email',identificacion_cliente='$identificacion_cliente' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'identificacion' => $identificacion,
	'primer_nombre' => $primer_nombre,
	'segundo_nombre' => $segundo_nombre,
	'primer_apellido' => $primer_apellido,
	'segundo_apellido' => $segundo_apellido,
	'telefono' => $telefono,
	'email' => $email,
	'identificacion_cliente' => $identificacion_cliente

));
?>