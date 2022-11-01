<?php
function retornarConexion() {
    $server="localhost";
    $usuario="jv";
    $clave="Jason1234";
    $base="imaq_schema";
    $con=mysqli_connect($server,$usuario,$clave,$base) or die("problemas") ;
    mysqli_set_charset($con,'utf8'); 
    return $con;
}
?>