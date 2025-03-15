<?php 
//include_once "menu_admin.php";
include("conexion.php");
include("menu_cliente.php");
if(isset($_POST['btn-editar-cliente'])) {
    $user = $_POST['idusuario'];
    $clave = $_POST['contrasena'];
    $nombre = $_POST['Nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $nivel = $_POST['nivel'];
    $puntos = $_POST['puntos'];
    $referencia = $_POST['referencia'];
    $sesion = $_POST['sesion'];

    $editar_cl = "UPDATE clientes SET contrasena='$clave', Nombre='$nombre',correo='$correo',telefono=$telefono,idnivel='$nivel',
    puntos=$puntos,referencia='$referencia',sesion='$sesion' WHERE idusuario = '$user'";

    $editar_us = "UPDATE usuarios SET contrasena='$clave',Nombre='$nombre',correo='$correo',telefono=$telefono, sesion='$sesion'
     WHERE idusuario = '$user'";

    $rc = mysqli_query($conexion, $editar_cl);
    $ru = mysqli_query($conexion, $editar_us);

    if($ru){
        if($rc){
            echo "<script>alert('Los datos se actualizaron correctamente!');location.assign('c_inicio.php');</script>";
        }else{
            echo "<script>alert('Los datos NO se actualizaron correctamente para clientes!');location.assign('c_inicio.php');</script>";
        }
    }else{
        echo "<script>alert('Los datos NO se actualizaron correctamente!');location.assign('c_inicio.php');</script>";
    }

}
?>
<main class="main">
<section class="divi">
            
            <h3>Cliente <?php $id = print_r($_SESSION["usuario"]);?></h3>
                
            <table>
                <tr>
                    <th>Usuario</th>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Nivel</th>
                    <th>Puntos</th>
                    <th>Referencia</th>
                    <th>sesion</th>
                    <th colspan="1">Acciones</th>
                </tr>
                <?php
                    
                    $consulta = "select*from clientes WHERE idcliente =$id";
                    $resultado = mysqli_query($conexion, $consulta);
                    
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $id = $fila['idcliente'];
                        $usuario = $fila['idusuario'];
                        $contrasena = $fila['contrasena'];
                        $nombre = $fila['Nombre'];
                        $correo = $fila['correo'];
                        $telefono = $fila['telefono'];
                        $idnivel = $fila['idnivel'];
                        $puntos = $fila['puntos'];
                        $referencia = $fila['referencia'];
                        $sesion = $fila['sesion'];
                       
                ?>
                <tr>
                    <td>
                        <?php echo $usuario; ?>
                    </td>
                    <td>
                        <?php echo $contrasena; ?>
                    </td>
                    <td>
                        <?php echo $nombre; ?>
                    </td>
                    <td>
                        <?php echo $correo; ?>
                    </td>
                    <td>
                        <?php echo $telefono; ?>
                    </td>
                    <td>
                        <?php echo $idnivel; ?>
                    </td>
                    <td>
                        <?php echo $puntos; ?>
                    </td>
                    <td>
                        <?php echo $referencia; ?>
                    </td>
                    <td>
                        <?php echo $sesion; ?>
                    </td>
                    <td><a class="modificar" href="c_inicio.php?
                    x1=<?php echo $usuario; ?>&
                    x2=<?php echo $contrasena; ?>&
                    x3=<?php echo $nombre; ?>&
                    x4=<?php echo $correo; ?>&
                    x5=<?php echo $telefono; ?>&
                    x6=<?php echo $idnivel; ?>&
                    x7=<?php echo $puntos; ?>&
                    x8=<?php echo $referencia; ?>&
                    x9=<?php echo $sesion; ?>">Editar</a></td>
                </tr>
                <?php } ?>
            </table>
        </section>
        <?php
            
            if (isset($_GET['x1'])){
                $musu = trim($_GET['x1']);
                $mclave = trim($_GET['x2']);
                $mnombre = trim($_GET['x3']);
                $mcorreo = trim($_GET['x4']);
                $mtelefono = trim($_GET['x5']);
                $mnivel = trim($_GET['x6']);
                $mpuntos = trim($_GET['x7']);
                $mreferencia = trim($_GET['x8']);
                $msesion = trim($_GET['x9']);
                ?>
                <div class="overlay">
                    <div class="popup">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <div class="contenedor-inputs">
                                <a href="c_inicio.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">x</i></a>
                                <h2>Editar Cliente</h2>

                                <label>ID Usuario</label><br>
                                <input type="text" name="idusuario" value="<?php echo "$musu"; ?>" placeholder="master/Arnaza19" maxlength="15" readonly><br>

                                <label>Clave</label><br>
                                <input type="text" name="contrasena" value="<?php echo "$mclave"; ?>" placeholder="******" maxlength="12"><br>

                                <label>Nombre</label><br>
                                <input type="text" name="Nombre" value="<?php echo "$mnombre"; ?>" placeholder="Juan Perez Mora"  maxlength="80"><br>

                                <label>Correo</label><br>
                                <input type="email" name="correo" value="<?php echo "$mcorreo"; ?>" placeholder="user@gmail.com" maxlength="50"><br>

                                <label>Telefono</label><br>
                                <input type="number" name="telefono" value="<?php echo "$mtelefono"; ?>" placeholder="6640000000" maxlength="10"><br>
                                
                                <label>Nivel</label><br>
                                <input type="text" name="nivel" value="<?php echo "$mnivel"; ?>" readonly><br>
                                
                                <label>Puntos</label><br>
                                <input type="number" name="puntos" value="<?php echo "$mpuntos"; ?>" maxlength="10" readonly><br>
                                
                                
                                <input type="hidden" name="referencia" value="<?php echo "$mreferencia"; ?>" placeholder="Juan Perez Mora"  maxlength="80" readonly>

                                <label>Sesion</label>
                                <select name="sesion">
                                <?php
                                    if ($msesion == 'Activa'){
                                        ?>
                                        <option>Activa</option>
                                        <option>Inactiva</option>
                                        <?php
                                    }else if($msesion == 'Inactiva'){
                                        ?>
                                        <option>Inactiva</option>
                                        <option>Activa</option>
                                        <?php
                                    }
                                    ?>
                                </select><br>
                                </div>
                            <input type="submit" name="btn-editar-cliente" value="Guardar" ><br>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
</main>
</body>
</html>