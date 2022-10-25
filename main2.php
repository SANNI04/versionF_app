<?php
session_start();
//echo session_id();

if(!isset($_SESSION["usuario"]) || $_SESSION["usuario"] !== true){
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    
    <title>Sistema de Gestion de Inventarios</title>
</head>

<body>
    <section class="header">
        <div class="logo">
            <i class="ri-menu-line icon icon-0 menu"></i>
        </div>
        <div class="notification--profile">   
            <div class="picon profile">
            <img src="login/images/logo.png" alt="">
        </div>
        </div>
    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="vistas_clientes/sucursales.php">
                        <span class="icon icon-1"><i class="ri-store-2-fill"></i></span>
                        <span class="sidebar--item">Sucursales</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_clientes/equipos.php">
                        <span class="icon icon-4"><i class="ri-truck-line"></i></span>
                        <span class="sidebar--item">Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_clientes/tiposMarca.php">
                        <span class="icon icon-5"><i class="ri-star-line"></i></span>
                        <span class="sidebar--item">Marcas Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_clientes/alquileres.php">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Alquileres</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_clientes/ordenTrabajo.php">
                        <span class="icon icon-3"><i class="ri-star-line"></i></span>
                        <span class="sidebar--item">Orden Trabajo</span>
                    </a>
                </li>

            </ul>
            <ul class="sidebar--bottom-items">
                <li>
                    <a href="login/logout.php">
                        <span class="icon icon-8"><i class="ri-logout-box-line"></i></span>
                        <span class="sidebar--item">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main--content">
            
            <div class="recent--patients">
                <div class="title">
                   <h2 class="section--title"> <?php echo "Bienvenido ". $_SESSION['nombre'] ?> </h2>
                </div>                        
                    
                    <div id="contenedor--crud"></div>
            </div>
        </div>
    </section>
    <script src="assets/js/main.js"></script>

</body>

</html>