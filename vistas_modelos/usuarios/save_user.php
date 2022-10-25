<?php

$nombre = htmlspecialchars($_REQUEST['nombre']);
$clave = htmlspecialchars($_REQUEST['clave']);
$identificacion_usuario = htmlspecialchars($_REQUEST['identificacion_usuario']);
$primer_nombre = htmlspecialchars($_REQUEST['primer_nombre']);
$segundo_nombre = htmlspecialchars($_REQUEST['segundo_nombre']);
$primer_apellido = htmlspecialchars($_REQUEST['primer_apellido']);
$segundo_apellido = htmlspecialchars($_REQUEST['segundo_apellido']);
$role_id = htmlspecialchars($_REQUEST['role_id']);

//encripar contraseña al ingresar nuevo usuario
$clave=password_hash($clave, PASSWORD_DEFAULT);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into usuarios (nombre,clave,identificacion_usuario,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,role_id) values ('$nombre','$clave','$identificacion_usuario','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$role_id')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'nombre' => $nombre,
	'clave' => $clave,
	'identificacion_usuario' => $identificacion_usuario,
	'primer_nombre' => $primer_nombre,
	'segundo_nombre' => $segundo_nombre,
	'primer_apellido' => $primer_apellido,
	'segundo_apellido' => $segundo_apellido,
	'role_id' => $role_id

));
?>