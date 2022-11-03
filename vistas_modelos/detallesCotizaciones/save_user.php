<?php

$codigocotizacion = htmlspecialchars($_REQUEST['codigocotizacion']);
$codigoproducto = htmlspecialchars($_REQUEST['codigoproducto']);
$precio = htmlspecialchars($_REQUEST['precio']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);



include '../conexion/conn.php';

$conf= new Configuracion();
$conf->conectar();

$sql = "insert into detallefactura (codigocotizacion,codigoproducto,precio,cantidad) values ('$codigocotizacion','$codigoproducto','$precio','$cantidad')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'codigocotizacion' => $codigocotizacion,
	'codigoproducto' => $codigoproducto,
	'precio' => $precio,
	'cantidad' => $cantidad
));
?>