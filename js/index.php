<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("location:  ../login/index.php");
    exit(0);
  }
?>