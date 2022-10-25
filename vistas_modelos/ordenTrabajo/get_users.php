<?php

session_start();
$nombre =  $_SESSION["nombre"]; 

if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
	header("location: index.php");
	exit;
}


	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include '../conexion/conn.php';

	$conf = new Configuracion();
	$conf->conectar();

	$sql = "SELECT count(*) FROM orden_trabajo where persona_encargada='".$nombre."'";
	//$query = mysqli_query($conn, $sql);

	$resultado= $conf->generarConsulta($sql);
	$result["total"] = $resultado;

	$sql="SELECT * FROM orden_trabajo where persona_encargada = '".$nombre."' limit $offset,$rows";

	$resultado= $conf->generarConsulta2($sql);
	$result["rows"] = $resultado;
	echo json_encode($result);
	
	$conf->desconectarDb();
?>