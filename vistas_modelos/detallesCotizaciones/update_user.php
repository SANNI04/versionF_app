<?php

$index_id = intval($_REQUEST['index_id']);
$codigocotizacion = htmlspecialchars($_REQUEST['codigocotizacion']);
$codigoproducto = htmlspecialchars($_REQUEST['codigoproducto']);
$precio = htmlspecialchars($_REQUEST['precio']);
$cantidad = htmlspecialchars($_REQUEST['cantidad']);

include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();


$sql = "update detallefactura set codigocotizacion='$codigocotizacion',codigoproducto='$codigoproducto',precio='$precio',cantidad='$cantidad' where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array(
	'index_id' => $index_id,
	'codigocotizacion' => $codigocotizacion,
	'codigoproducto' => $codigoproducto,
    'precio' => $precio,
    'cantidad' => $cantidad
));
?>