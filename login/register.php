<?php 
    include 'code-register.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background:linear-gradient(black,gray)">

    <div class="container">

        <div class="controls-register">
            <!--<img src="images/logo-magtimus-small.png" alt="" class="logo">-->
            <h2 class="title" style="color:yellow; text-align:center">Registro Usuario</h2><br>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
               
                <label for=""style="color:white">Nombre de Usuario:</label>
                <input type="text" name="nombre" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $nombre_err; ?></span>
                <label for=""style="color:white">Contraseña:</label>
                <input  type="password" propt="password" required="true" name="clave" class="form-control">
                <span class="msg-error"style="color:white"> <?php echo $clave_err; ?></span>
                <label for=""style="color:white">Identificacion:</label>
                <input type="text" name="identificacion_usuario" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $ide_err; ?></span>
                <label for=""style="color:white">Primer Nombre:</label>
                <input type="text" name="primer_nombre" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $n1_err; ?></span>
                <label for=""style="color:white">segundo Nombre:</label>
                <input type="text" name="segundo_nombre" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $n2_err; ?></span>
                <label for=""style="color:white">Primer Apellido:</label>
                <input type="text" name="primer_apellido" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $a1_err; ?></span>
                <label for=""style="color:white">Segundo Apellido:</label>
                <input type="text" name="segundo_apellido" class="form-control">
                <span class="msg-error"style="color:white"><?php echo $a2_err; ?></span>
                <br> 
                <input type="submit" class="btn btn-default btn-block btn-custom" style="background-color:yellow" value="Registrarse">

            </form>
            <br>
            <span class="text-footer" style="color:white">¿Ya te has registrado?
                <a href="index.php">Iniciar Sesión</a>
            </span>
            <br>
            <br>
            <div class="nota" style="color:white">
                <p>Nota: la contraseña debera contener almenos una letra minuscula,una mayuscula y un numero</p>
            </div>
        </div>
    </div>
</body>
</html>
