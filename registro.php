<?php
    $rol = $_POST['rol'];
    include("conexion.php");
    if(isset($_POST['btn-alta-cliente'])){
        $user = $_POST['idcliente'];
        $clave = $_POST['contrasena'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $nivel = $_POST['nivel'];
        $referencia = $_POST['referencia'];

        //verificamos la referencia
        $verifi = "SELECT * FROM clientes where idusuario = '$referencia'";
        $result = mysqli_query($conexion, $verifi);
        $filas = mysqli_num_rows($result);
        if($filas > 0){
            //INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) 
            //VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
            $alta_usuario = "INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) 
            VALUES ('$user','$clave','$nombre','$correo',$telefono,'Cliente','Activa')";

            $result = mysqli_query($conexion, $alta_usuario);
            if ($result) {
                //INSERT INTO clientes(idcliente, idusuario, contrasena, Nombre, correo, telefono, idnivel, puntos, referencia, sesion) 
                //VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
                $alta_cliente = "INSERT INTO clientes (idcliente, contrasena, Nombre, correo, telefono, idnivel, puntos,referencia, sesion) 
                VALUES ('$user','$clave','$nombre','$correo',$telefono,$nivel,0,'$referencia','Activa')";

                $result = mysqli_query($conexion, $alta_cliente);
                if ($result) {
                    echo "<script>alert('Se ha registrado correctamente!')</script>";
                    header('location:index.php? a=Exito');

                    $consulta = "SELECT idusuario,contrasena, rol from usuarios where idusuario ='$user' and contrasena = '$clave'";
                    $result = mysqli_query($conexion,$consulta);

                    $filas = mysqli_num_rows($result);

                    if($filas > 0)
                    {
                        $row = $result->fetch_assoc();
                        $crol = $row['rol'];
                        if($crol == 'Cliente'){
                        header("location:c_inicio.php");
                        }else{
                        header("location:gestion_usuarios.php");
                        }
                    }else
                    {
                        echo "Error en el inicio de secion...";
                    }

                }else{
                    echo "<script>alert('No se ha registrado correctamente!')</script>";
                    header('location:registro.php?');
                }
            }

        }else{
            //INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
            $alta_usuario = "INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) 
            VALUES ('$user','$clave','$nombre','$correo',$telefono,'Cliente','Activa')";
            $result = mysqli_query($conexion, $alta_usuario);
            if ($result) {
                //INSERT INTO clientes(idcliente, idusuario, contrasena, Nombre, correo, telefono, idnivel, puntos, referencia, sesion) 
                //VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
                $alta_cliente = "INSERT INTO clientes (idusuario, contrasena, Nombre, correo, telefono, idnivel, puntos, referencia, sesion) 
                VALUES ('$user','$clave','$nombre','$correo',$telefono,$nivel,0,NULL,'Activa')";
                $result = mysqli_query($conexion, $alta_cliente);
                if ($result) {
                    echo "<script>alert('Se ha registrado correctamente!')</script>";
                    header('location:index.php? a=Exito');
                }
                else{
                    echo "<script>alert('No se ha registrado correctamente!')</script>";
                    header('location:registro.php?');
                }
            }
        }
        
    }
    if(isset($_POST['btn-alta-usuario'])){
        $user = $_POST['idusuario'];
        $clave = $_POST['contrasena'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];

        //INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
        $alta_usuario = "INSERT INTO usuarios(idusuario, contrasena, Nombre, correo, telefono, rol, sesion) 
        VALUES ('$user','$clave','$nombre','$correo',$telefono,'Admin','Activa')";
        $result = mysqli_query($conexion, $alta_usuario);

        if ($result) {
            echo "<script>alert('Se ha registrado correctamente!')</script>";
            header('location:index.php? a=Exito');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sport Aztec | Registro</title>
    <link rel="stylesheet" href="CSS\login.css">
</head>

<body>

<?php
//$rol = $_POST['rol'];
if ($rol == 'Cliente'){
?>

    <section class="registro">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

            <h2>Registro cliente</h2><br/> 
            <input type="hidden" name="rol" value="<?php $rol; ?>">  
            <label>Nombre de usuario</label><br>
            <input type="text" name="idcliente" placeholder="master/Arnaza19" maxlength="15"><br>
            <label>Contraseña</label><br>
            <input type="text" name="contrasena" placeholder="******" maxlength="12"><br>
            <label>Nombre</label><br>
            <input type="text" name="nombre" placeholder="Juan Perez Mora"  maxlength="50"><br>
            <label>Correo</label><br>
            <input type="email" name="correo" placeholder="user@gmail.com" maxlength="50"><br>
            <label>Telefono</label><br>
            <input type="number" name="telefono" placeholder="6640000000" maxlength="10"><br>
            <label>Nivel</label><br>
            <select name="nivel">
                <option value="4">Nivel Bronce</option>
                <option value="3">Nivel Plata</option>
                <option value="2">Nivel Oro</option>
                <option value="1">Nivel Diamante</option>
            </select><br>
            <label>Referencia</label><br>
            <input type="text" name="referencia" placeholder="Juan Perez Mora" maxlength="50"><br>

            <input type="submit" name="btn-alta-cliente" value="Registrar"><br>
            <a href="index.php">Inicia sesion!</a> <a href="pre_registro.php">Regresar</a>

        </form>
    </section>
<?php
}
if ($rol == 'Admin'){
?>

    <section class="registro">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        
            <h2>Registro usuario</h2><br/>
            <input type="hidden" name="rol" value="<?php $rol; ?>">  
            <label>Nombre de usuario</label><br>
            <input type="text" name="idusuario" placeholder="master/Arnaza19" maxlength="15"><br>
            <label>Contraseña</label><br>
            <input type="text" name="contrasena" placeholder="******" maxlength="12"><br>
            <label>Nombre</label><br>
            <input type="text" name="nombre" placeholder="Juan Perez Mora"  maxlength="50"><br>
            <label>Correo</label><br>
            <input type="email" name="correo" placeholder="user@gmail.com" maxlength="50"><br>
            <label>Telefono</label><br>
            <input type="number" name="telefono" placeholder="6640000000" maxlength="10"><br>

            <input type="submit" name="btn-alta-usuario" value="Registrar"><br>
            <a href="index.php">Inicia sesion!</a><a href="pre_registro.php=">Regresar</a>

        </form>
    </section>

<?php
}

?>

</body>

</html>