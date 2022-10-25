<?php
 session_start();
 if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
    header("location:  login/index.php");
     exit;
 }
?>