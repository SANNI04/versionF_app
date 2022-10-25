<?php
$codigo_referencia = htmlspecialchars($_REQUEST['codigo_referencia']);;
$cantidad = htmlspecialchars($_REQUEST['cantidad']);
$fecha_ingreso = htmlspecialchars($_REQUEST['fecha_ingreso']);
$codigo_orden_compra = htmlspecialchars($_REQUEST['codigo_orden_compra']);

include '../conexion/conn.php';

$conf = new Configuracion();
$conf->conectar();

$i=0;
$d=1;
$x=0;


for($i;$i<intval($cantidad);$i++){
    $x++;
    $sql = "INSERT INTO existencias (codigo_referencia,cantidad,fecha_ingreso,codigo_orden_compra,consecutivo) VALUES ('$codigo_referencia','$d','$fecha_ingreso','$codigo_orden_compra','$x');";
    $query= mysqli_multi_query($conf->conectar(),$sql);
}

$sql = "INSERT INTO movimientos (codigo_referencia,cantidad,fecha_entrada) values ('$codigo_referencia','$cantidad','$fecha_ingreso')";

$query=mysqli_query($conf->conectar(),$sql);

echo json_encode(array(
    'codigo_referencia' => $codigo_referencia,
    'cantidad' => $d,
    'fecha_ingreso' => $fecha_ingreso

));
?>

