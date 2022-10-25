<?php

$codigo_referencia =htmlspecialchars($_REQUEST['codigo_referencia']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);
$fecha_salida = htmlspecialchars($_REQUEST['fecha_salida']);
$codigo_orden_salida = htmlspecialchars($_REQUEST['codigo_orden_salida']);

include '../conexion/conn.php';

$conf = new Configuracion();
$conf -> conectar();

$i=0;
$d=1;


for($i;$i<intval($cantidad);$i++){
	$sql = "DELETE FROM existencias where codigo_referencia = '$codigo_referencia' and cantidad='$d' and consecutivo<='$cantidad'";
	$query=mysqli_query($conf->conectar(),$sql);
}

$sql1= "call actualizaExistencias('$codigo_referencia')";
$query=mysqli_query($conf->conectar(),$sql1);

$sql = "insert into salidas (codigo_referencia,cantidad,fecha_salida,codigo_orden_salida) values ('$codigo_referencia','$cantidad','$fecha_salida','$codigo_orden_salida')";
$query = mysqli_query($conf->conectar(),$sql);

$sql = "insert into movimientos (codigo_referencia,cantidad,fecha_salida) values ('$codigo_referencia','$cantidad','$fecha_salida')";
$query = mysqli_query($conf->conectar(),$sql);

echo json_encode(array(
	'codigo_referencia' => $codigo_referencia,
	'cantidad' => $cantidad,
	'fecha_salida' => $fecha_salida
));
?>

