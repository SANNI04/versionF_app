<?php

include '../conexion/conn.php';

    $conf = new Configuracion();
    $conf->conectar();

    $query="SELECT codigo_orden FROM ordenes_compra";
    $resultado=$conf->consulta($query);
    
    $ejecutar=mysqli_query($conf->conectar(),$query);
    
    while($fila=mysqli_fetch_array($ejecutar)){
        {
            echo "<option value='".$fila['codigo_orden']."'>".$fila['codigo_orden']."</option>";
        }
    }
    
?>