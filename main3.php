<?php
session_start();
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
                    <a href="vistas_usuarios/clientes.php">
                        <span class="icon icon-3"><i class="ri-user-heart-line"></i></span>
                        <span class="sidebar--item">Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/contactoCliente.php">
                        <span class="icon icon-2"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Contacto Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/responsableCliente.php">
                        <span class="icon icon-4"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Responsable Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/sucursales.php">
                        <span class="icon icon-1"><i class="ri-store-2-fill"></i></span>
                        <span class="sidebar--item">Sucursales</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/referencias.php">
                        <span class="icon icon-5"><i class="ri-book-read-line"></i></span>
                        <span class="sidebar--item" style="white-space: nowrap;">Referencias</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/equipos.php">
                        <span class="icon icon-4"><i class="ri-truck-line"></i></span>
                        <span class="sidebar--item">Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/tiposMarca.php">
                        <span class="icon icon-5"><i class="ri-star-line"></i></span>
                        <span class="sidebar--item">Marcas Equipos</span>
                    </a>
                </li>

                <li>
                    <a href="vistas_usuarios/existencias.php">
                        <span class="icon icon-6"><i class="ri-arrow-right-circle-line"></i></span>
                        <span class="sidebar--item">Inventario - Existencias</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/ordenesCompra.php">
                        <span class="icon icon-3"><i class="ri-check-line"></i></span>
                        <span class="sidebar--item">Ordenes Compra</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/salidas.php">
                        <span class="icon icon-6"><i class="ri-arrow-left-circle-line"></i></span>
                        <span class="sidebar--item">Salidas</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/cotizaciones.php">
                        <span class="icon icon-4"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Cotizaciones</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/remisiones.php">
                        <span class="icon icon-3"><i class="ri-ball-pen-fill"></i></span>
                        <span class="sidebar--item">Remisiones</span>
                    </a>
                </li>
                <li>
                    <a href="vistas_usuarios/alquileres.php">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Alquileres</span>
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