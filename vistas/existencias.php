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
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    
    <title>Existencias</title>
</head>

<body>
    <section class="header">
        <div class="logo">
        <a class="ri-menu-line icon icon-0 menu" href="../main.php" style="color:yellow"> Menu Principal</a>
        </div>
            <div class="notification--profile">
                <div class="picon profile">
                    <img src="../login/images/logo.png" alt="">
                </div>
            </div>
    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="usuarios.php" >
                        <span class="icon icon-4"><i class="ri-user-line"></i></span>
                        <span class="sidebar--item">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="clientes.php">
                        <span class="icon icon-3"><i class="ri-user-heart-line"></i></span>
                        <span class="sidebar--item">Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="contactoCliente.php">
                        <span class="icon icon-2"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Contacto Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="responsableCliente.php">
                        <span class="icon icon-2"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Responsable Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="sucursales.php">
                        <span class="icon icon-6"><i class="ri-store-2-fill"></i></span>
                        <span class="sidebar--item">Sucursales</span>
                    </a>
                </li>
                <li>
                    <a href="referencias.php">
                        <span class="icon icon-3"><i class="ri-book-read-line"></i></span>
                        <span class="sidebar--item" style="white-space: nowrap;">Referencias</span>
                    </a>
                </li>
                <li>
                    <a href="equipos.php">
                        <span class="icon icon-4"><i class="ri-truck-line"></i></span>
                        <span class="sidebar--item">Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="tiposMarca.php">
                        <span class="icon icon-5"><i class="ri-star-line"></i></span>
                        <span class="sidebar--item">Marcas Equipos</span>
                    </a>
                </li>

                <li>
                    <a href="#" id="active--link">
                        <span class="icon icon-6"><i class="ri-arrow-right-circle-line"></i></span>
                        <span class="sidebar--item">Inventario - Existencias</span>
                    </a>
                </li>
                <li>
                    <a href="movimientos.php">
                        <span class="icon icon-6"><i class="ri-archive-line"></i></span>
                        <span class="sidebar--item">Historico Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="ordenesCompra.php">
                        <span class="icon icon-6"><i class="ri-check-line"></i></span>
                        <span class="sidebar--item">Ordenes Compra</span>
                    </a>
                </li>
                <li>
                    <a href="salidas.php">
                        <span class="icon icon-6"><i class="ri-customer-service-line"></i></span>
                        <span class="sidebar--item">Salidas</span>
                    </a>
                </li>
                <li>
                    <a href="cotizaciones.php">
                        <span class="icon icon-4"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Cotizaciones</span>
                    </a>
                </li>
                <li>
                    <a href="detallescotizacion.php">
                        <span class="icon icon-4"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Detalles Cotizacion</span>
                    </a>
                </li>
                <li>
                    <a href="remisiones.php">
                        <span class="icon icon-3"><i class="ri-ball-pen-fill"></i></span>
                        <span class="sidebar--item">Remisiones</span>
                    </a>
                </li>
                <li>
                    <a href="alquileres.php">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Alquileres</span>
                    </a>
                </li>
                <li>
                    <a href="../ot/vista/ot.php" target="_blank">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">OT</span>
                    </a>
                </li>
            </ul>
            <ul class="sidebar--bottom-items">
                <li>
                        <a href="../login/logout.php">
                        <span class="icon icon-8"><i class="ri-logout-box-line"></i></span>
                        <span class="sidebar--item">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main--content">
            
        <br><br>
            <div class="recent--patients">
                <div class="title">
                    <h2 class="section--title">EXISTENCIAS</h2>
                </div>                   
                <br><br><br>                         
                    
                    <div id="contenedor--crud"></div>

                    <script>
                        $(document).ready(()=>{
                        $('#contenedor--crud').load('../vistas_modelos/existencias/index.php');
                        })
                    </script>
            </div>
        </div>
    </section>
    <script src="assets/js/main.js"></script>

</body>

</html>