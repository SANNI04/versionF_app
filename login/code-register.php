<?php

require_once "conexion.php";
    
// Definir variable e inicializar con valores vacio
$nombre = $clave = $identificacion_usuario = $primer_nombre = $segundo_nombre = $primer_apellido = $segundo_apellido = "";
$nombre_err = $clave_err = $ide_err = $n1_err = $n2_err = $a1_err = $a2_err ="";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        // VALIDANDO INPUT DE NOMBRE DE USUARIO
        if(empty(trim($_POST["nombre"]))){
            $nombre_err = "Por favor, ingrese un nombre de usuario";
        }else{
            //prepara una declaracion de seleccion
            $sql = "SELECT index_id FROM usuarios WHERE nombre = ?";
            
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_nombre);
                
            $param_nombre = trim($_POST["nombre"]);
                
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
                    
        if(mysqli_stmt_num_rows($stmt) == 1){
            $nombre_err = "Este nombre de usuario ya está en uso";
        }else{
             $nombre = trim($_POST["nombre"]);
            }
        }else{
             echo "Ups! Algo salió mal, inténtalo mas tarde";
            }
        }
    }

        // VALIDANDO CONTRASEÑA
        if(empty(trim($_POST["clave"]))){
            $clave_err = "Por favor, ingrese una contraseña";
        }if(strlen(trim($_POST["clave"])) < 10){
            $clave_err = "La contraseña debe de tener al menos 10 caracteres";
        }if(!preg_match ("/[a-z]/",$_POST["clave"])){
            $clave_err = "La contraseña debe de tener al menos 1 letra minuscula";
        }if(!preg_match ("/[A-Z]/",$_POST["clave"])){
            $clave_err = "La contraseña debe de tener al menos 1 letra mayuscula";
        }if (!preg_match("/[0-9]/",$_POST["clave"])){
            $clave_err = "La contraseña debe de tener al menos 1 numero";
        }
        else{
            $clave = trim($_POST["clave"]);
        }

          //VALIDACIONES

         if(empty(trim($_POST["identificacion_usuario"]))){
            $ide_err = "Por favor, ingrese una identificacion";
        }else{
            $identificacion_usuario = trim($_POST["identificacion_usuario"]);
        }

           if(empty(trim($_POST["primer_nombre"]))){
            $n1_err = "Por favor, ingrese la informacion correspondiente";
        }else{
            $primer_nombre = trim($_POST["primer_nombre"]);
        }
           
           if(empty(trim($_POST["segundo_nombre"]))){
            $n2_err = "Por favor, ingrese la informacion correspondiente";
        }else{
            $segundo_nombre = trim($_POST["segundo_nombre"]);
        }

           
           if(empty(trim($_POST["primer_apellido"]))){
            $a1_err = "Por favor, ingrese la informacion correspondiente";
        }else{
            $primer_apellido = trim($_POST["primer_apellido"]);
        }

        
        if(empty(trim($_POST["segundo_apellido"]))){
            $a2_err = "Por favor, ingrese la informacion correspondiente";
        }else{
            $segundo_apellido = trim($_POST["segundo_apellido"]);
        }
        
        
        // COMPROBANDO LOS ERRORES DE ENTRADA ANTES DE INSERTAR LOS DATOS EN LA BASE DE DATOS
        if(empty($nombre_err) && empty($clave_err) && empty($ide_err) && empty($n1_err) && empty($n2_err) && empty($a1_err) && empty($a2_err)){
            
            $sql = "INSERT INTO usuarios (nombre, clave, identificacion_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
    
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt,"sssssss",$param_nombre,$param_password,$param_identificacion,$param_primerN,$param_segundoN,$param_primerA,$param_segundoA);
                
                // ESTABLECIENDO PARAMETRO
                $param_nombre = $nombre;
                $param_password = password_hash($clave, PASSWORD_DEFAULT); // ENCRIPTANDO CONTRASEÑA
                $param_identificacion = $identificacion_usuario;
                $param_primerN = $primer_nombre;
                $param_segundoN = $segundo_nombre;
                $param_primerA = $primer_apellido;
                $param_segundoA = $segundo_apellido;


                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                }else{
                    echo "Algo Salio mal, intentalo despues";
                }
            }
        }
        
        mysqli_close($link);
        
    }
    
?>