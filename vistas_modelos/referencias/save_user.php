<?php

$nombre_referencia = htmlspecialchars($_REQUEST['nombre_referencia']);
$codigo_referencia = htmlspecialchars($_REQUEST['codigo_referencia']);
$alto = htmlspecialchars($_REQUEST['alto']);
$largo = htmlspecialchars($_REQUEST['largo']);
$ancho = htmlspecialchars($_REQUEST['ancho']);
$marca = htmlspecialchars($_REQUEST['marca']);
$descripcion = htmlspecialchars($_REQUEST['descripcion']);
$precio_inicial = htmlspecialchars($_REQUEST['precio_inicial']);
$ruta_foto = $_FILES['ruta_foto']['name'];
//$ruta_foto = htmlspecialchars($_REQUEST['ruta_foto']);

	//Si el archivo contiene algo y es diferente de vacio
	if (isset($ruta_foto) && $ruta_foto != "") {
		//Obtenemos algunos datos necesarios sobre el archivo
		$name = $_FILES['ruta_foto']['name'];
		$tipo = $_FILES['ruta_foto']['type'];
		$tamano = $_FILES['ruta_foto']['size'];
		$temp = $_FILES['ruta_foto']['tmp_name'];

	   $carpeta_destino=$_SERVER['DOCUMENT_ROOT'] . '/versionF_app/vistas_modelos/referencias/images/';
	   //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
	  if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
	  
	}
	  else {

		if (move_uploaded_file($_FILES['ruta_foto']['tmp_name'],$carpeta_destino.$name)) {
			 //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
			 //chmod('images/'.$ruta_foto, 0777);
		 }
		 else {
			
		 }
	   }
	}
	
	$ruta = '/versionF_app/vistas_modelos/referencias/images/'.$_FILES['ruta_foto']['name'];
	$ruta_pintar = '<a href="'.$ruta.'" download>Descargar</a>';


include '../conexion/conn.php';
$conf = new Configuracion();
$conf->conectar();

$sql = "insert into referencias (nombre_referencia,codigo_referencia,alto,largo,ancho,marca,descripcion,precio_inicial,ruta_foto,ruta_server) values ('$nombre_referencia','$codigo_referencia','$alto','$largo','$ancho','$marca','$descripcion','$precio_inicial','$ruta_pintar','$ruta')";
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
	'ruta_foto' => $ruta_foto
));
?>