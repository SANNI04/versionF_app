<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'jv');
    define('DB_PASSWORD', 'Jason1234');
    define('DB_NAME', 'imaq_schema');

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($link === false){
        die("ERROR EN LA CONEXION" . mysqli_connect_error());
    }

?>


