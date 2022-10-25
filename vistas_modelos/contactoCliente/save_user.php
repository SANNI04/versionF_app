<?php

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

$sql = "insert into contacto_cliente (identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,telefono,email,identificacion_cliente) values ('$identificacion','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$telefono','$email','$identificacion_cliente')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
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