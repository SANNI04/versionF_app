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
    <!--<link rel="stylesheet" href="login/bootstrap-4.3.1/css/bootstrap.min.css">-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../js/datagrid-filter.js"></script>
    
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
                 <!--<li>
                    <a href="login/logout.php">
                        <span class="icon icon-8" style="position: absolute;right: 20px"><i class="ri-logout-box-line">Cerrar sesión</i></span>
                        
                    </a>
                </li>-->
        </div>
    </section>
    <section class="main">
        <div class="sidebar">
            <ul class="sidebar--items">
                <li>
                    <a href="vistas/usuarios.php">
                        <span class="icon icon-1"><i class="ri-user-line"></i></span>
                        <span class="sidebar--item">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/clientes.php">
                        <span class="icon icon-3"><i class="ri-user-heart-line"></i></span>
                        <span class="sidebar--item">Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/contactoCliente.php">
                        <span class="icon icon-2"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Contacto Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/responsableCliente.php">
                        <span class="icon icon-4"><i class="ri-user-2-line"></i></span>
                        <span class="sidebar--item">Responsable Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/sucursales.php">
                        <span class="icon icon-1"><i class="ri-store-2-fill"></i></span>
                        <span class="sidebar--item">Sucursales</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/referencias.php">
                        <span class="icon icon-5"><i class="ri-book-read-line"></i></span>
                        <span class="sidebar--item" style="white-space: nowrap;">Referencias</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/equipos.php">
                        <span class="icon icon-4"><i class="ri-truck-line"></i></span>
                        <span class="sidebar--item">Equipos</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/tiposMarca.php">
                        <span class="icon icon-5"><i class="ri-star-line"></i></span>
                        <span class="sidebar--item">Marcas Equipos</span>
                    </a>
                </li>

                <li>
                    <a href="vistas/existencias.php">
                        <span class="icon icon-6"><i class="ri-arrow-right-circle-line"></i></span>
                        <span class="sidebar--item">Inventario - Existencias</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/movimientos.php">
                        <span class="icon icon-2"><i class="ri-archive-line"></i></span>
                        <span class="sidebar--item">Historico Inventario</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/ordenesCompra.php">
                        <span class="icon icon-3"><i class="ri-check-line"></i></span>
                        <span class="sidebar--item">Ordenes Compra</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/salidas.php">
                        <span class="icon icon-6"><i class="ri-arrow-left-circle-line"></i></span>
                        <span class="sidebar--item">Salidas</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/cotizaciones.php">
                        <span class="icon icon-4"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Cotizaciones</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/detallescotizacion.php">
                        <span class="icon icon-4"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Detalles Cotizacion</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/remisiones.php">
                        <span class="icon icon-3"><i class="ri-ball-pen-fill"></i></span>
                        <span class="sidebar--item">Remisiones</span>
                    </a>
                </li>
                <li>
                    <a href="vistas/alquileres.php">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">Alquileres</span>
                    </a>
                </li>
                <li>
                    <a href="http://localhost/versionF_app/ot/vista/ot.php"  target="_blank">
                        <span class="icon icon-5"><i class="ri-article-line"></i></span>
                        <span class="sidebar--item">OT</span>
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
                <br>
                <!--<button type="button" class="btn btn-warning btn-lg btn-block"><a href="http://localhost/versionF_app/ot/vista/ot.php"  target="_blank" style="color: black">Acceso directo OT</a></button>-->
                <a class="btn" href="http://localhost/versionF_app/ot/vista/ot.php"  target="_blank">Acceso directo OT</a>

                <style type="text/css">
                .btn{
                    padding: 10px;
                    font-size: 20px;
                    color: black;
                    background-color: #FFD733;
                    border-radius: 6px;
                    border: 1px solid black;
                }
</style>

    <div class="caja" style="width:1110px; height:220px; overflow-y: auto">;
        <h2>Remisiones Vencidas</h2>
        <br>

        <?php
        
            include 'vistas_modelos/conexion/conn.php';
            $conf= new Configuracion();
            $conf->conectar();
            
            $query="SELECT * from remisiones where alerta='Remision vencida'";

            $datos=mysqli_query($conf->conectar(),$query);

            while($fila=mysqli_fetch_array($datos)){
                echo"<div>";
                echo"<p>";
                echo "<b>Numero Remision: </b>";
                echo $fila['numero_remision'];
                echo "  ";
                echo "<b>Fecha: </b>";
                echo $fila["fecha"];
                echo "  ";
                echo "<b>Fecha Caducado: </b>";
                echo $fila["fecha_caducado"];
                echo"</p>";
                echo"</div>";
                echo"<br>";
            }
            echo "<a href='vistas/remisiones.php' style='color:red'><u>Ir a remisiones </u></a>";
        ?>
    </div>

    <div class="caja" style="width:1110px; height:220px; overflow-y: auto">;
        <h2>Alquileres Vencidos</h2>
        <br>
        <?php
        
            $conf= new Configuracion();
            $conf->conectar();
            
            $query="SELECT * from alquileres where alerta='Vencido'";

            $datos=mysqli_query($conf->conectar(),$query);

            while($fila=mysqli_fetch_array($datos)){
                echo"<div>";
                echo"<p>";
                echo "<b>Equipo: </b>";
                echo $fila['equipo'];
                echo "  ";
                echo "<b>Fecha Alquiler: </b>";
                echo $fila["fecha_alquiler"];
                echo "  ";
                echo "<b>Fecha Devolucion: </b>";
                echo $fila["fecha_devolucion"];
                echo"</p>";
                echo"</div>";
                echo "<br>";
            }
            echo "<a href='vistas/alquileres.php' style='color:red'><u>Ir a alquileres </u></a>";
        ?>
    </div>

    <div class="caja" style="width:1110px; height:500px; overflow-y: auto">;
        <h2>OT Pendientes</h2>
        <br>
        <?php
        echo"<iframe id='inlineFrameExample'";
        echo"title='Inline Frame Example'";
        echo"width='1000'";
        echo "height='400'";
        echo "src='otpendientes/tablaot.php'>";
        echo"</iframe>";
        echo"<br>";
        echo"<br>";
            echo "<a href='http://localhost/versionF_app/ot/vista/ot.php' style='color:red'><u>Ir a OT </u></a>";
        ?>
    </div>

    <style type="text/css">
   
   .caja { 
        font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
        color: black; 
        font-size: 18px; 
        font-weight: 400; 
        text-align: center; 
        background: #FFD733; 
        margin: 40px 0 25px; 
        overflow: hidden; 
        padding: 20px; 
        border-radius: 35px 0px 35px 0px; 
        -moz-border-radius: 35px 0px 35px 0px; 
        -webkit-border-radius: 35px 0px 0px 0px; 
        border: 2px solid black;
    }
    </style>
                    <div id="contenedor--crud"></div>
            </div>
        </div>
    </section>
    <script src="assets/js/main.js"></script>

</body>
<!--<script src="login/bootstrap-4.3.1/js/bootstrap.min.js"></script>-->

</html>