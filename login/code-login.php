<?php
//INICIALIZAR LA SESION
session_start();
    
    if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] === true){
        header("location: ../main.php");
        exit;
    }

require_once "conexion.php";

$nombre = $clave ="";
$nombre_err = $clave_err = "";

    if($_SERVER["REQUEST_METHOD"] === "POST"){ //LLAMADA MEDIANTE EL METODO POST
    
        if(empty(trim($_POST["nombre"]))){
            $nombre_err = "Por favor, ingrese el nombre de usuario";
        }else{
            $nombre = trim($_POST["nombre"]);
        }
    
        if(empty(trim($_POST["clave"]))){
            $clave_err = "Por favor, ingrese una contraseña";
        }else{
            $clave = trim($_POST["clave"]);
        }
    
//VALIDAR CREDENCIALES

    if(empty($nombre_err) && empty($clave_err)){
        
        $sql = "SELECT index_id, nombre, clave, role_id FROM usuarios WHERE nombre = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_nombre);
           
            $param_nombre = $nombre;
         
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            }
           
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $index_id, $nombre, $hashed_clave, $role_id);
            
            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($clave, $hashed_clave)){
                    session_start();

                    // ALMACENAR DATOS EN VARABLES DE SESION
                    $_SESSION["usuario"] = true;
                    $_SESSION["index_id"] = $index_id;
                    $_SESSION["role_id"] = $role_id;
                    $_SESSION["nombre"] = $nombre;

                    if ($role_id==1){       //administrador
                        header("location: ../main.php");
                        }elseif ($role_id==2){
                            header("location: ../main2.php");
                        }
                    else{
                        if( $role_id==3){
                            header("location: ../main3.php");
                        }
                        }
                    }else{
                        $clave_err = "La contraseña que has introducido no es valida";
                    }
                    
                } 
            }else{
                    $nombre_err = "No se ha encontrado ninguna cuenta con ese nombre de usuario.";
                }
            
        }else{
                    echo "UPS! algo salio mal, intentalo mas tarde";
                }
    }

    mysqli_close($link);
    
}

?>














