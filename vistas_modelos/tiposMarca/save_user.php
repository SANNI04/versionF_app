<?php

$marca = htmlspecialchars($_REQUEST['marca']);
$codigo_marca = htmlspecialchars($_REQUEST['codigo_marca']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();


$sql = "insert into tipos_marca (marca,codigo_marca) values ('$marca','$codigo_marca')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'marca' => $marca,
	'codigo_marca' => $codigo_marca
	
));
?>