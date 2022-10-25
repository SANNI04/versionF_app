<?php
    require "code-login.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <script src="js/jquery-3.4.1.js"></script>
  <script src="js/popper.min.js"></script>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css'>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div id="login-box">
      <div class="logo">
        <img src="images/logo.png" class="img img-responsive img-circle center-block"/>
        <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>  
      </div>  
  
      <div class="controls">
  
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!--de esta manera el formulario queda a la espera de oprimir el boton para registrarse los datos se envian mediante el metodo post-->

      <label for="" style="color:white">Nombre Usuario:</label>
      <input type="text" class="form-control" name="nombre"  autocomplete="username">
      <span class="msg-error" style="color:white"><?php echo $nombre_err; ?></span> <br>
      <label for="" style="color:white">Contraseña</label>
      <input type="password" class="form-control" name="clave" autocomplete="on"> <br>
      <span class="msg-error" style="color:white"><?php echo $clave_err; ?></span>

      <input type="submit" class="btn btn-default btn-block btn-custom" style="background-color:yellow;color:black" value="Iniciar"><br>
    </form>

    <span class="text-footer" style="color: white;">¿Aún no te has registrado?
        <a href="register.php">Registrate</a>
    </span>
  
      </div> 
    </div> 
  </div>

  <div id="particles-js"></div>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css'></script>
  <script src='https://code.jquery.com/jquery-1.11.1.min.js'></script><script  src="./script.js"></script>

</body>

</html>