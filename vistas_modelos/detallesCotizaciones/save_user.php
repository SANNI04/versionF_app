<?php

$codigocotizacion = htmlspecialchars($_REQUEST['codigocotizacion']);
$codigoproducto = htmlspecialchars($_REQUEST['codigoproducto']);
$descuento = htmlspecialchars($_REQUEST['descuento']);
$precio = htmlspecialchars($_REQUEST['precio']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);



include '../conexion/conn.php';

$conf= new Configuracion();
$conf->conectar();

$sql = "insert into detallecotizacion (codigocotizacion,codigoproducto,descuento,precio,cantidad) values ('$codigocotizacion','$codigoproducto','$descuento','$precio','$cantidad')";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'codigocotizacion' => $codigocotizacion,
	'codigoproducto' => $codigoproducto,
	'descuento' => $descuento,
	'precio' => $precio,
	'cantidad' => $cantidad
));
?>