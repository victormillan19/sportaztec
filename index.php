<?php
include("conexion.php");
if (isset($_POST['btn-ingresar'])) {

  $usuario =  $_POST['usuario'];
  $clave = $_POST['clave'];

  $consulta = "SELECT idusuario,contrasena, rol from usuarios where idusuario ='$usuario' and contrasena = '$clave'";
  $result = mysqli_query($conexion,$consulta);

  $filas = mysqli_num_rows($result);

  if($filas > 0)
  {
    session_start();
    $_SESSION["usuario"] = $usuario;
    echo session_encode();

    $row = $result->fetch_assoc();
    $crol = $row['rol'];
    if($crol == 'Cliente'){
      header("location:menu_cliente.php");
    }else{
      header("location:menu_admin.php");
    }

  }else
  {
    echo "Error en el inicio de secion...";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sport Aztec | Login</title>
    <link rel="stylesheet" href="CSS\login.css">
</head>
<body>
  <section>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
        <h1>Sport Aztec</h1>

        <label >Usuario</label><br>     <input type="text"      name="usuario" placeholder="Usuario"><br>
        <label >Contraseña</label><br>  <input type="password"  name="clave" placeholder="Contraseña"><br>
        
        <input type="submit" name="btn-ingresar" value="Ingresar"><br>

        <a href="pre_registro.php">Registrate!</a>
      </form>
  </section>
</body>
</html>