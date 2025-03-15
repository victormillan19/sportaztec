<?php 
//include_once "menu_admin.php";
include("conexion.php");
include("menu_admin.php");
if (isset($_POST['btn-editar-usuario'])) {
    $user = $_POST['idusuario'];
    $clave = $_POST['contrasena'];
    $nombre = $_POST['Nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];
    $sesion = $_POST['sesion'];

    if ($rol == 'Cliente') {
        //UPDATE `clientes` SET `idcliente`='[value-1]',`idusuario`='[value-2]',`contrasena`='[value-3]',
        //`Nombre`='[value-4]',`correo`='[value-5]',`telefono`='[value-6]',`idnivel`='[value-7]',
        //`puntos`='[value-8]',`referencia`='[value-9]',`sesion`='[value-10]' WHERE 1
        $editar_c = "UPDATE clientes SET contrasena='$clave',Nombre='$nombre',correo ='$correo',telefono='$telefono'
        ,sesion='$sesion' WHERE idusuario = '$user'";

        //UPDATE `usuarios` SET `idusuario`='[value-1]',`contrasena`='[value-2]',`Nombre`='[value-3]',
        //`correo`='[value-4]',`telefono`='[value-5]',`rol`='[value-6]',`sesion`='[value-7]' WHERE 1
        $editar_u = "UPDATE usuarios SET contrasena='$clave',Nombre='$nombre',
        correo='$correo',telefono=$telefono,rol='$rol',sesion='$sesion' WHERE idusuario = '$user'";

        $rc = mysqli_query($conexion, $editar_c);
        $ru = mysqli_query($conexion, $editar_u);

        if($ru){
            if($rc){
                echo "<script>alert('Los datos se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
            }else{
                echo "<script>alert('Los datos NO se actualizaron correctamente para clientes!');location.assign('gestion_usuarios.php');</script>";
            }
        }else{
            echo "<script>alert('Los datos NO se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
        }

    }else{
        //UPDATE `usuarios` SET `idusuario`='[value-1]',`contrasena`='[value-2]',`Nombre`='[value-3]',
        //`correo`='[value-4]',`telefono`='[value-5]',`rol`='[value-6]',`sesion`='[value-7]' WHERE 1
        $editar_u = "UPDATE usuarios SET contrasena='$clave',Nombre='$nombre',
        correo='$correo',telefono=$telefono,rol='$rol',sesion='$sesion' WHERE idusuario = '$user'";
        $ru = mysqli_query($conexion, $editar_u);
        if ($ru) {
            echo "<script>alert('Los datos se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
        }else{
            echo "<script>alert('Los datos NO se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
        }
    }
}

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
            echo "<script>alert('Los datos se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
        }else{
            echo "<script>alert('Los datos NO se actualizaron correctamente para clientes!');location.assign('gestion_usuarios.php');</script>";
        }
    }else{
        echo "<script>alert('Los datos NO se actualizaron correctamente!');location.assign('gestion_usuarios.php');</script>";
    }

}
?>

    <main class="main">
        <h1>GESTION DE USUARIOS</h1><br>
        
          <section class="divi" >
            <h3>Usuarios</h3><br/>
            <table>
                <tr>
                    <th colspan="8"><a class="agregar" href="pre_registro_admin.php">Agregar</a></th>
                </tr>
                <tr>
                    <th>Usuario</th>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Rol</th>
                    <th>Sesion</th>
                    <th colspan="1">Acciones</th>
                </tr>
                <?php
                    $consulta = "select*from usuarios";
                    $resultado = mysqli_query($conexion, $consulta);
                    while ($fila = mysqli_fetch_array($resultado)) {
                        $id = $fila['idusuario'];
                        $contrasena = $fila['contrasena'];
                        $nombre = $fila['Nombre'];
                        $correo = $fila['correo'];
                        $telefono = $fila['telefono'];
                        $rol = $fila['rol'];
                        $sesion = $fila['sesion'];
                ?>
                <tr>
                    <td>
                        <?php echo $id; ?>
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
                        <?php echo $rol; ?>
                    </td>
                    <td>
                        <?php echo $sesion; ?>
                    </td>
                    <td>
                        <a 
                        class="modificar" 
                        href="gestion_usuarios.php?
                        v1=<?php echo $id;?>&
                        v2=<?php echo $contrasena;?>&
                        v3=<?php echo $nombre;?>&
                        v4=<?php echo $correo;?>&
                        v5=<?php echo $telefono;?>&
                        v6=<?php echo $rol;?>&
                        v7=<?php echo $sesion;?>">Editar</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </section>
        <?php
            
            if (isset($_GET['v1'])){
                $mid = trim($_GET['v1']);
                $mclave = trim($_GET['v2']);
                $mnombre = trim($_GET['v3']);
                $mcorreo = trim($_GET['v4']);
                $mtelefono = trim($_GET['v5']);
                $mrol = trim($_GET['v6']);
                $msesion = trim($_GET['v7']);
                ?>
                <div class="overlay">
                    <div class="popup">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <div class="contenedor-inputs">
                                <a href="gestion_usuarios.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">x</i></a>
                                <h2>Editar Usuario</h2>

                                <label>ID Usuario</label><br>
                                <input type="text" name="idusuario" value="<?php echo "$mid"; ?>" placeholder="master/Arnaza19" maxlength="15" readonly><br>

                                <label>Clave</label><br>
                                <input type="text" name="contrasena" value="<?php echo "$mclave"; ?>" placeholder="******" maxlength="12"><br>

                                <label>Nombre</label><br>
                                <input type="text" name="Nombre" value="<?php echo "$mnombre"; ?>" placeholder="Juan Perez Mora"  maxlength="80"><br>

                                <label>Correo</label><br>
                                <input type="email" name="correo" value="<?php echo "$mcorreo"; ?>" placeholder="user@gmail.com" maxlength="50"><br>

                                <label>Telefono</label><br>
                                <input type="number" name="telefono" value="<?php echo "$mtelefono"; ?>" placeholder="6640000000" maxlength="10"><br>

                                <label>Rol</label><br>
                                <select name="rol">
                                    <?php
                                    if ($mrol == 'Cliente'){
                                        ?>
                                        <option>Cliente</option>
                                        <option>Admin</option>
                                        <?php
                                    }else if($mrol == 'Admin'){
                                        ?>
                                        <option>Admin</option>
                                        <option>Cliente</option>
                                        <?php
                                    }
                                    ?>
                                    
                                </select><br>

                                <label>Sesion</label><br>
                                <select name="sesion">
                                <?php
                                    if ($msesion == 'Activa'){
                                        ?>
                                        <option>Activa</option>
                                        <option>Inactiva</option>
                                        <?php
                                    }else if($mrol == 'Inactiva'){
                                        ?>
                                        <option>Inactiva</option>
                                        <option>Activa</option>
                                        <?php
                                    }
                                    ?>
                                </select><br>
                                </div>
                            <input type="submit" name="btn-editar-usuario" value="Guardar" ><br>
                        </form>
                    </div>
                </div>
                <?php

            }
            ?>
        <section class="divi">
            
            <h3>Clientes</h3>
                
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
                    $consulta = "select*from clientes";
                    $resultado = mysqli_query($conexion, $consulta);
                    $i = 0;
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
                        $i++;
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
                    <td><a class="modificar" href="gestion_usuarios.php?
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
                                <a href="gestion_usuarios.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">x</i></a>
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

                                <label>Nivel</label>
                                <select name="nivel">
                                    <?php
                                    if($mnivel = 1){
                                        ?>
                                        <option value="1">Nivel Diamante</option>
                                        <option value="4">Nivel Bronce</option>
                                        <option value="3">Nivel Plata</option>
                                        <option value="2">Nivel Oro</option>
                                        <?php
                                    }elseif($mnivel = 2){
                                        ?>
                                        <option value="2">Nivel Oro</option>
                                        <option value="1">Nivel Diamante</option>
                                        <option value="4">Nivel Bronce</option>
                                        <option value="3">Nivel Plata</option>
                                        <?php
                                    }elseif($mnivel = 3){
                                        ?>
                                        <option value="3">Nivel Plata</option>
                                        <option value="1">Nivel Diamante</option>
                                        <option value="4">Nivel Bronce</option>
                                        <option value="2">Nivel Oro</option>
                                        <?php
                                    }elseif($mnivel = 4){
                                        ?>
                                        <option value="4">Nivel Bronce</option>
                                        <option value="1">Nivel Diamante</option>
                                        <option value="3">Nivel Plata</option>
                                        <option value="2">Nivel Oro</option>
                                        <?php
                                    }
                                    ?>
                                </select><br>
                                
                                <label>Puntos</label><br>
                                <input type="number" name="puntos" value="<?php echo "$mpuntos"; ?>" maxlength="10"><br>
                                
                                <label>Referencia</label><br>
                                <input type="text" name="referencia" value="<?php echo "$mreferencia"; ?>" placeholder="Juan Perez Mora"  maxlength="80"><br>

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

        <section class="divi" >
        <h3>Niveles</h3><br/>
        <table class="">
                <tr class="encabezado">
                    <th>ID</th>
                    <th>Nivel</th>
                    <th>Porcentaje</th>
                </tr>
                <?php
                $consulta   = "SELECT * from nivel";
                $resultado  = mysqli_query($conexion,$consulta);
                $i = 0;
                while($fila = mysqli_fetch_array($resultado)){
                    $id_f           = $fila['idnivel'];
                    $nivel_f       = $fila['nivel'];
                    $porcentaje_f       = $fila['porcentaje'];

                    $i++;
                ?>
                    <tr>
                        <td><?php echo $id_f; ?></td>
                        <td><?php echo $nivel_f; ?></td>
                        <td><?php echo $porcentaje_f; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </section>
    </main>
</body>
</html>