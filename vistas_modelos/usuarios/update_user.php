<?php

$index_id = intval($_REQUEST['index_id']);
$nombre = htmlspecialchars($_REQUEST['nombre']);
$clave = htmlspecialchars($_REQUEST['clave']);
$identificacion_usuario = htmlspecialchars($_REQUEST['identificacion_usuario']);
$primer_nombre = htmlspecialchars($_REQUEST['primer_nombre']);
$segundo_nombre = htmlspecialchars($_REQUEST['segundo_nombre']);
$primer_apellido = htmlspecialchars($_REQUEST['primer_apellido']);
$segundo_apellido = htmlspecialchars($_REQUEST['segundo_apellido']);
$role_id = htmlspecialchars($_REQUEST['role_id']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "update usuarios set nombre='$nombre',clave='$clave',identificacion_usuario='$identificacion_usuario',primer_nombre='$primer_nombre',segundo_nombre='$segundo_nombre',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',role_id='$role_id' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'nombre' => $nombre,
	'clave' => $clave,
	'identificacion_usuario' => $identificacion_usuario,
	'primer_nombre' => $primer_nombre,
	'segundo_nombre' => $segundo_nombre,
	'primer_apellido' => $primer_nombre,
	'segundo_apellido' => $segundo_apellido,
	'role_id' => $role_id

));
?>