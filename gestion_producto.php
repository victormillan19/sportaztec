<?php
include("conexion.php");
include("menu_admin.php");

if(isset($_GET['btn-agregar-producto'])){
?>
<div class="overlay">
    <div class="popup">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <div class="contenedor-inputs">
                <a href="gestion_producto.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">X</i></a>
                <h4>AGREGAR PRODUCTO</h4><BR>
                <label>Nombre</label><br>
                <input type="text" name="nombre" placeholder="Ejemplo :Pelota roja" ><br>
                <label>Precio</label><br>
                <input type="number" name="precio" ><br>
                <label>Descuento</label><br>
                <input type="number" name="descuento" ><br>
                <label>Descripción</label><br>
                <textarea name="descripcion" rows="4" cols="55" maxlength="200">Descripcion</textarea><br><br>
            </div>
            <input type="file" name="imagenproducto"/>
            <input type="submit" name="btn-alta-producto" value="Guardar" ><br>
        </form>
    </div>
</div>
<?php
}

if(isset($_POST['btn-alta-producto'])){
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $descripcion = $_POST['descripcion'];
    $imagenproducto = addslashes(file_get_contents($_FILES['imagenproducto']['tmp_name']));

    $alta_producto = "INSERT INTO productos( nombre, precio, descuento, descripcion, imagenproducto) 
    VALUES ('$nombre',$precio,$descuento,'$descripcion','$imagenproducto')";
    $resultado = mysqli_query($conexion,$alta_producto);
    if ($resultado){
        echo "<script>alert('El producto se agrego con exito!');location.assign('gestion_producto.php');</script>";
    }else{
        echo "<script>alert('El producto no se agrego con exito!');location.assign('gestion_producto.php');</script>";
    }
}

if(isset($_GET["m1"])){
    $idproducto = trim($_GET['m1']);

    $consulta_editar_producto = "SELECT * FROM productos WHERE idproducto = $idproducto";
    $resultado = mysqli_query($conexion, $consulta_editar_producto);
    while ($fila = mysqli_fetch_array($resultado)) {
        $idproducto = $fila['idproducto'];
        $nombre = $fila['nombre'];
        $precio = $fila['precio'];
        $descuento = $fila['descuento'];
        $descripcion = $fila['descripcion'];
        $imagen =  $fila['imagenproducto'];
    }

?>

    <div class="overlay">
        <div class="popup">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                <div class="contenedor-inputs">
                    <a href="gestion_producto.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">X</i></a>
                    <h4>EDITAR PRODUCTO</h4><BR>
                    <label>Id producto</label><br>
                    <input type="number"    name= "id"  value="<?php echo $idproducto; ?>" readonly>
                    <label>Nombre</label><br>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="Ejemplo :Pelota roja" ><br>
                    <label>Precio</label><br>
                    <input type="number" name="precio" value="<?php echo $precio; ?>"><br>
                    <label>Descuento</label><br>
                    <input type="number" name="descuento" value="<?php echo $descuento; ?>"><br>
                    <label>Descripción</label><br>
                    <textarea name="descripcion"  rows="3" cols="55" maxlength="200"><?php echo $descripcion; ?></textarea><br><br>
                    <img height="70px" src="data:image/png;base64,<?php echo base64_encode($imagen) ?>"/>
                </div>
                    <!--<input type="file" required name="imagenproducto"/>-->
                
                <input type="submit" name="btn-editar-producto" value="Guardar" ><br>
            </form>
        </div>
    </div>

<?php
    
}

if(isset($_GET['m2'])){
    $idproducto = trim($_GET['m2']);
    $consulta_editar_producto = "SELECT imagenproducto FROM productos WHERE idproducto = $idproducto";
    $resultado = mysqli_query($conexion, $consulta_editar_producto);
    while ($fila = mysqli_fetch_array($resultado)) {
        $imagen =  $fila['imagenproducto'];
    }
?>
<div class="overlay">
    <div class="popup">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
            <div class="contenedor-inputs">
                <a href="gestion_producto.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">X</i></a>
                <h4>CAMBIAR IMAGEN DE PRODUCTO</h4><BR>
                <input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
                <img height="70px" src="data:image/png;base64,<?php echo base64_encode($imagen) ?>"/><br>
            </div>
            <input type="file" name="imagenproducto"/><br>
            <input type="submit" name="btn-editar-imagen-producto" value="Guardar" ><br>
        </form>
        
    </div>
</div>
<?php

}

if(isset($_POST['btn-editar-producto'])){
    $idproducto = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $descripcion = $_POST['descripcion'];
    /* $imagenproducto = addslashes(file_get_contents($_FILES['imagenproducto']['tmp_name'])); */

    //UPDATE `productos` SET `idproducto`='[value-1]',`nombre`='[value-2]',`precio`='[value-3]',`descuento`='[value-4]',
    //`descripcion`='[value-5]',`imagenproducto`='[value-6]' WHERE 1
    $consulta_editar_producto = "UPDATE productos SET nombre='$nombre',precio=$precio,descuento=$descuento,
    descripcion='$descripcion' WHERE idproducto = '$idproducto'";
    $rp = mysqli_query($conexion, $consulta_editar_producto);
    if($rp){
        echo "<script>alert('Los datos se actualizaron correctamente!');location.assign('gestion_producto.php');</script>";
    }else{
        echo "<script>alert('Los datos NO se actualizaron correctamente!');location.assign('gestion_producto.php');</script>";
    }
}

if(isset($_POST['btn-editar-imagen-producto'])){
    $idproducto = $_POST['idproducto'];
    $imagenproducto = addslashes(file_get_contents($_FILES['imagenproducto']['tmp_name']));

    $consulta_imagen = "UPDATE productos SET imagenproducto='$imagenproducto' WHERE idproducto = '$idproducto'";
    $rimg = mysqli_query($conexion, $consulta_imagen);
    if($rimg){
        echo "<script>alert('La imagen se guardo correctamente!');location.assign('gestion_producto.php');</script>";
    }else{
        echo "<script>alert('La imagen no se guardo correctamente!');location.assign('gestion_producto.php');</script>";
    }

}

if(isset($_GET['m3'])){
    $idproducto = trim($_GET['m3']);

    $borrar_producto = "DELETE FROM productos WHERE idproducto = $idproducto";
    $resultado = mysqli_query($conexion, $borrar_producto);
    if ($resultado) {
        echo "<script>alert('El producto se borro con exito!');location.assign('gestion_producto.php');</script>";
    }
}

if(isset($_GET['btn-actualizar-almacen'])){

    ?>
    <div class="overlay">
                <div class="popup">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
                        <div class="contenedor-inputs">
                            <a href="gestion_producto.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">X</i></a>
                            <h4>AGREGAR ACTUALIZACION DE ALMACEN</h4><BR>
                            <input type="hidden" name="idalmacen" value="">
                            <input type="hidden" name="fecha" value="">
                            <label>ID Producto</label><br>
                            <?php
                            $consulta = "SELECT * FROM productos";
                            $r = mysqli_query($conexion, $consulta);
                            ?>
                            <select name="idproducto">
                            <?php
                            while( $fila = mysqli_fetch_array( $r )){
                                ?><option value="<?php echo $fila['idproducto']; ?>"><?php echo $fila['nombre']; ?></option><?php
                            }
                            ?>
                            </select>
                            <label>Cantidad</label><br>
                            <input type="number" name="cantidad" ><br>
                        </div>
                        <input type="submit" name="btn-alta-almacen" value="Guardar" ><br>
                    </form>
                </div>
            </div>
    <?php
    
}

if(isset($_POST['btn-alta-almacen'])){
    $idproducto = $_POST['idproducto'];
    $cantidad = $_POST['cantidad'];

    $insertar = "INSERT INTO almacen(fecha) VALUES (NOW())";
    $r = mysqli_query($conexion, $insertar);

    if ($r){
        $consulta = "SELECT * FROM almacen where fecha = NOW()";
        $r = mysqli_query($conexion, $consulta);
        while($rn= mysqli_fetch_array($r)){
            $idalmacen = $rn['idalmacen'];
            $fecha = $rn['fecha'];

            $insertar = "INSERT INTO actualizacionalmacen(idalmacen ,idproducto, cantidad) 
            VALUES ( $idalmacen,$idproducto,$cantidad)";
            $r = mysqli_query($conexion, $insertar);
            if ($r){
                echo "<script>alert('Alta exitosa!');location.assign('gestion_producto.php');</script>";
            }else{
                echo "<script>alert('Alta no exitosa!');location.assign('gestion_producto.php');</script>";
            }
        }
            
    }else{
        echo "<script>alert('Alta no exitosa!');location.assign('gestion_producto.php');</script>";
    }
}

if ( isset($_GET['btn-editar-almacen'])){
    $idactualizacionalmacen1 = trim($_GET['btn-editar-almacen']);

    $consulta_editar_producto = "SELECT idactualizacionalmacen, idalmacen, idproducto, cantidad FROM actualizacionalmacen WHERE idactualizacionalmacen = $idactualizacionalmacen1";
    $resultado = mysqli_query($conexion, $consulta_editar_producto);
    while ($fila = mysqli_fetch_array($resultado)) {
        $idactualizacionalmacen = $fila['idactualizacionalmacen'];
        $idalmacen = $fila['idalmacen'];
        $idproducto = $fila['idproducto'];
        $cantidad = $fila['cantidad'];
    }
    ?>
        <div class="overlay">
            <div class="popup">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" >
                    <div class="contenedor-inputs">
                        <a href="gestion_producto.php" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times">X</i></a>
                        <h4>AGREGAR ACTUALIZACION DE ALMACEN</h4><BR>
                        <input type="number" name="idactualizacionalmacen" value="<?php echo $idactualizacionalmacen; ?>" readonly>
                        <input type="number" name="idalmacen" value="<?php echo $idalmacen; ?>" readonly>
                        <label>ID Producto</label><br>
                        <?php
                        $consulta = "SELECT * FROM productos";
                        $r = mysqli_query($conexion, $consulta);
                        ?>
                        <select name="idproducto">
                        <?php
                         while( $fila = mysqli_fetch_array( $r )){
                            ?><option value="<?php echo $fila['idproducto']; ?>"><?php echo $fila['nombre']; ?></option><?php
                        }
                        ?>
                        </select>
                        <label>Cantidad</label><br>
                        <input type="number" name="cantidad" value="<?php echo  $cantidad; ?>"><br>
                    </div>
                    <input type="submit" name="btn-editar-almacen-pro" value="Guardar" ><br>
                </form>
            </div>
        </div>
    <?php
}

if(isset($_POST['btn-editar-almacen-pro'])){
    $idactualizacionalmacen = $_POST['idactualizacionalmacen'];
    $idalmacen = $_POST['idalmacen'];
    $idproducto = $_POST['idproducto'];
    $cantidad = $_POST['cantidad'];

    $editar = "UPDATE actualizacionalmacen SET idproducto=$idproducto,cantidad=$cantidad WHERE idactualizacionalmacen = $idactualizacionalmacen";
    $r = mysqli_query($conexion, $editar);
    if ($r){
        echo "<script>alert('Modificacion en almacen exitosa!');location.assign('gestion_producto.php');</script>";
    }else{
        echo "<script>alert('Modificacion en almacen no exitosa!');location.assign('gestion_producto.php');</script>";
    }
}
?>
<main class="main">
    <h1>GESTION DE ALMACEN</h1><br>
    <section  class="divi" >
        
        <table>
            <tr>
                <th colspan="10"><h3>Productos</h3><br/></th>
            </tr>
            <tr>
                <th colspan="10"><a class="agregar" href="gestion_producto.php?btn-agregar-producto">Agregar</a></th>
            </tr>
            <tr>
                <th>Imagen</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Descripcion</th>
                <th>Existentes</th>
                <th colspan="2">Acciones</th>
            </tr>
            <?php
            $consulta = "SELECT * FROM productos";
            $resultado = mysqli_query($conexion,$consulta);
            while ( $fila = mysqli_fetch_array( $resultado )){
                $idproducto = $fila['idproducto'];
                $nombre = $fila['nombre'];
                $precio = $fila['precio'];
                $descuento = $fila['descuento'];
                $descripcion = $fila['descripcion'];
                $imagenproducto = $fila['imagenproducto'];
            ?>
            <tr>
                <td><img height="70px" src="data:image/png;base64,<?php echo base64_encode($imagenproducto); ?>"></td>
                <td> <?php echo $idproducto; ?></td>
                <td> <?php echo $nombre; ?></td>
                <td> <?php echo $precio; ?></td>
                <td> <?php echo $descuento; ?></td>
                <td style="width:350px"> <?php echo $descripcion; ?></td>
                <td style="width:50px"> 
                <?php $consulta = "SELECT SUM(actualizacionalmacen.cantidad) AS existentes FROM actualizacionalmacen 
                WHERE actualizacionalmacen.idproducto = $idproducto";
                $r = mysqli_query($conexion, $consulta);
                while($row = mysqli_fetch_array($r)){
                    $existentes = $row['existentes'];
                }
                echo $existentes; ?></td>
                
                <td> <a class="modificar" href="gestion_producto.php?m1=<?php echo $idproducto; ?>">Editar</a></td>
                <td> <a class="modificar" href="gestion_producto.php?m2=<?php echo $idproducto; ?>">Editar imagen</a></td>
                <td> <a class="borrar" href="gestion_producto.php?m3=<?php echo $idproducto; ?>">Borrar</a></td>
            </tr>
            <?php
            }            
            ?>
        </table>
    </section>
    
    <section  class="divi" >
        <!-- SELECT idalmacen,idactualizacionalmacen,fecha,idproducto,nombre,cantidad FROM 
        actualizacionalmacen INNER JOIN almacen USING (idalmacen) INNER JOIN productos USING (idproducto) -->
        <table>
            <tr>
                <th colspan="7"><h3>Almacen</h3><br/></th>
            </tr>
            <tr>
                <th colspan="7"><a class="agregar" href="gestion_producto.php?btn-actualizar-almacen">Agregar Actualizacion</a></th>
            </tr>
            <tr>
                <th>ID Almacen</th>
                <th>ID Actualizacion</th>
                <th>Fecha</th>
                <th>ID producto</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th colspan="1">Acciones</th>
            </tr>
            <?php
            $consulta = "SELECT idalmacen,idactualizacionalmacen,fecha,idproducto,nombre,cantidad FROM 
            actualizacionalmacen INNER JOIN almacen USING (idalmacen) INNER JOIN productos USING (idproducto)";
            $resultado = mysqli_query($conexion,$consulta);
            while ( $fila = mysqli_fetch_array( $resultado )){
                $idalmacen = $fila['idalmacen'];
                $idactualizacionalmacen = $fila['idactualizacionalmacen'];
                $fecha = $fila['fecha'];
                $idproducto = $fila['idproducto'];
                $nombre = $fila['nombre'];
                $cantidad = $fila['cantidad'];
            ?>
            <tr>
                <td> <?php echo $idalmacen; ?></td>
                <td> <?php echo $idactualizacionalmacen; ?></td>
                <td> <?php echo $fecha; ?></td>
                <td> <?php echo $idproducto; ?></td>
                <td> <?php echo $nombre; ?></td>
                <td> <?php echo $cantidad; ?></td>
                <td> <a class="modificar" href="gestion_producto.php?btn-editar-almacen=<?php echo $idactualizacionalmacen; ?>">Editar</a></td>
            </tr>
            <?php
            }            
            ?>
        </table>
    </section>
</main>
</body>
</html>