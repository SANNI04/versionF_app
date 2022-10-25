<?php

$nombre_referencia = htmlspecialchars($_REQUEST['nombre_referencia']);
$codigo_referencia = htmlspecialchars($_REQUEST['codigo_referencia']);
$alto = htmlspecialchars($_REQUEST['alto']);
$largo = htmlspecialchars($_REQUEST['largo']);
$ancho = htmlspecialchars($_REQUEST['ancho']);
$marca = htmlspecialchars($_REQUEST['marca']);
$descripcion = htmlspecialchars($_REQUEST['descripcion']);
$precio_inicial = htmlspecialchars($_REQUEST['precio_inicial']);
$ruta_foto = htmlspecialchars($_REQUEST['ruta_foto']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into referencias (nombre_referencia,codigo_referencia,alto,largo,ancho,marca,descripcion,precio_inicial,ruta_foto) values ('$nombre_referencia','$codigo_referencia','$alto','$largo','$ancho','$marca','$descripcion','$precio_inicial','$ruta_foto')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'nombre_referencia' => $nombre_referencia,
	'codigo_referencia' => $codigo_referencia,
	'alto' => $alto,
	'largo' => $largo,
	'ancho' => $ancho,
	'marca' => $marca,
	'descripcion' => $descripcion,
	'precio_inicial'  => $precio_inicial,
	'ruta_foto'  => $ruta_foto

));
?>