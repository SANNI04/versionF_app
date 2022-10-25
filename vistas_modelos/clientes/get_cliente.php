<?php

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include '../conexion/conn.php';
	$conf= new Configuracion();
	$conf->conectar();


	$sql = "SELECT count(*)  FROM clientes where activo=1";
	//$query = mysqli_query($conn, $sql);

	$resultado= $conf->generarConsulta($sql);
	$result["total"] = $resultado;


	$sql="SELECT * FROM clientes where activo=1 limit $offset,$rows";
	$resultado= $conf->generarConsulta2($sql);
	$result["rows"] = $resultado;
	echo json_encode($result);
	
	$conf->desconectarDb();

?>