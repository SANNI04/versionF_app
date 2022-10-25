<?php

$index_id = intval($_REQUEST['index_id']);


include '../conexion/conn.php';

$conf= new Configuracion();
$conf->conectar();

$sql = "update equipos set activo=0 where index_id=$index_id";
$query = mysqli_query($conf->conectar(),$sql);
echo json_encode(array('success'=>true));
?>