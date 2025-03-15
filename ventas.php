<?php
include("conexion.php");
include("menu_cliente.php");
$granTotal = 0;
$cuenta = $_SESSION["usuario"];
?>
<main class="main">

<h1>COMPRAS</h1><br>
    <section class="divi">
        <table>
            <tr>
                <th colspan="6"><h3>COMPRAS</h3><br/></th>
            </tr>
            <tr>
                <th>ID Compra</th>
                <th>ID Cliente</th>
                <th>Fecha</th>
                <th>Apartado</th>
                <th>Total</th>
            </tr>
            <?php
            $consulta = "SELECT * FROM venta WHERE idusuario = '$cuenta'";
            $resultado = mysqli_query($conexion,$consulta);
            while ( $fila = mysqli_fetch_array( $resultado )){
                $idventa  = $fila['idventa'];
                $idusuario = $fila['idusuario'];
                $fecha = $fila['fecha'];
                $Apartado = $fila['Apartado'];
                $total = $fila['total'];
                $pagado = $fila['pagado'];
            ?>
            <tr>
                <td> <?php echo $idventa; ?></td>
                <td> <?php echo $idusuario; ?></td>
                <td> <?php echo $fecha; ?></td>
                <td> <?php echo $Apartado; ?></td>
                <td> <?php echo $total; ?></td>
                <td> <a class="agregar" href="imprimirTicket.php?
                id=<?php echo $idventa;?>&
                idusuario=<?php echo $idusuario;?>&
                fecha=<?php echo $fecha;?>&
                apartado=<?php echo $Apartado;?>&
                total=<?php echo $total;?>">🎫 Ticket</a></td>  
            </tr>
            <?php
            }            
            ?>
            </tr>
        </table>
    </section>
<section  class="divi">
        <table>
            <tr>
                <th colspan="9"><h3>Productos</h3><br/></th>
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
                <td>
                    <form action="ventas.php" method="post">
                        <input type="hidden" name="idproducto" value="<?php echo $idproducto;?>">
                        <input type="hidden" name="nombre" value="<?php echo $nombre;?>">
                        <input type="number" name="cantidad" value="1" style="width: 55px; padding: 0px; margin: 1px;">
                        <input type="hidden" name="precio" value="<?php echo $precio;?>">
                        <input type="hidden" name="descuento" value="<?php echo $descuento;?>">
                        <input type="submit" class="agregar" value="Agregar" name="btn-agregar-productos" style="padding: 1px; margin: 1px;"> 
                    </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </section>
    <?php
    if(isset($_REQUEST['btn-agregar-productos'])){
        $idproducto = $_REQUEST['idproducto'];
        $nombre = $_REQUEST['nombre'];
        $cantidad   = $_REQUEST['cantidad'];
        $precio = $_REQUEST['precio'];
        $descuento  = $_REQUEST['descuento'];

        $_SESSION["carrito"][$idproducto]["nombre"] = $nombre;
        $_SESSION["carrito"][$idproducto]["cantidad"] = $cantidad;
        $_SESSION["carrito"][$idproducto]["precio"] = $precio;
        $_SESSION["carrito"][$idproducto]["descuento"] = $descuento;
    }
    ?>
    <section  class="divi"  >
        <table>
            <tr>
                <th colspan="6"><h3>🛒  CARRITO</h3></th>
            </tr>
            <tr>
                <th>ID producto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Total</th>
            </tr>
            <?php
            $granTotalfinal = 0;
                if(isset($_SESSION["carrito"])){
                    foreach($_SESSION["carrito"] as $producto => $arreglo){
                        $granTotal += $arreglo["cantidad"] * $arreglo["precio"] - $arreglo["descuento"];
                        $granTotalfinal += $granTotal;
                        ?>
                        <tr>
                            <td><?php echo $producto; ?></td>
                        <?php
                        foreach($arreglo as $key => $value){
                            ?>
                            <td><?php echo $value; ?></td>
                            <?php
                        }
                        ?>
                            <td><?php echo $granTotal; ?></td>
                        </tr>
                        <?php
                    }
                }
            ?>
            <tr>
                <th colspan="5"></th>
                <th><?php echo $granTotalfinal; ?></th>
            </tr>
            <tr>
                <td colspan="6">
                    <a class="agregar" href="ventas.php?btn-insertar-venta=<?php echo $granTotalfinal;?>">Comprar</a><label>  </label>
                    <a class="modificar" href="ventas.php?btn-insertar-venta-a=<?php echo $granTotalfinal;?>">Apartar</a><label>  </label>
                    <a class="borrar" href="ventas.php?btn-borrar-venta">Cancelar</a></td>
                <!-- <td><a class="modificar" href="crear_venta.php">Apartar</a></td> -->
            </tr>
            
        </table>        
    </section>
    <?php
    if(isset($_REQUEST['btn-borrar-venta'])){
        unset($_SESSION['carrito']);
        header("location:ventas.php");
    }
    if(isset($_REQUEST['btn-insertar-venta'])){
        $granTotalfinal = $_REQUEST['btn-insertar-venta'];
        //INSERT INTO `venta`(`idventa`, `idusuario`, `fecha`, `Apartado`, `total`, `pagado`) 
        //VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
       
        $sql = "INSERT INTO venta(idusuario,fecha, Apartado, total, pagado) 
        VALUES ('$cuenta',NOW(),'no apartado',$granTotalfinal,'pagado')";
        $r = mysqli_query($conexion,$sql);
        if ($r){

            $sql = "SELECT idventa FROM venta ORDER BY idventa DESC LIMIT 1";
            $r = mysqli_query($conexion,$sql);
            while ($fila = mysqli_fetch_array($r)){
                $idventa = $fila['idventa'];
                if(isset($_SESSION["carrito"])){
                    foreach($_SESSION["carrito"] as $producto => $arreglo){
                        
                        $cant = $arreglo["cantidad"];
                        $desc = $arreglo["descuento"];
                        $sql = "INSERT INTO procesoventa(idventa, cantidad, descuento, idproducto) 
                        VALUES ($idventa,$cant,$desc,$producto)";
                        $r = mysqli_query($conexion, $sql);
                        

                        $insertar = "INSERT INTO almacen(fecha) VALUES (NOW())";
                        $r = mysqli_query($conexion, $insertar);
                        if ($r){
                            $consulta = "SELECT * FROM almacen where fecha = NOW()";
                            $r = mysqli_query($conexion, $consulta);
                            while($rn= mysqli_fetch_array($r)){
                                $idalmacen = $rn['idalmacen'];
                                $fecha = $rn['fecha'];
                                $cant = -1 * $cant;
                                $insertar = "INSERT INTO actualizacionalmacen(idalmacen ,idproducto, cantidad) 
                                VALUES ( $idalmacen,$producto,$cant)";
                                $r = mysqli_query($conexion, $insertar);
                                if ($r){
                                    unset($_SESSION['carrito']);
                                    echo "<script>alert('Compra exitosa!');location.assign('ventas.php');</script>";
                                }
                            }
                        }
                    }
                }
            }
        }
        
        
    }
    if(isset($_REQUEST['btn-insertar-venta-a'])){
        $granTotalfinal = $_REQUEST['btn-insertar-venta-a'];
        //INSERT INTO `venta`(`idventa`, `idusuario`, `fecha`, `Apartado`, `total`, `pagado`) 
        //VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
       
        $sql = "INSERT INTO venta(idusuario,fecha, Apartado, total, pagado) 
        VALUES ('$cuenta',NOW(),'apartado',$granTotalfinal,'no pagado')";
        $r = mysqli_query($conexion,$sql);
        if ($r){

            $sql = "SELECT idventa FROM venta ORDER BY idventa DESC LIMIT 1";
            $r = mysqli_query($conexion,$sql);
            while ($fila = mysqli_fetch_array($r)){
                $idventa = $fila['idventa'];
                if(isset($_SESSION["carrito"])){
                    foreach($_SESSION["carrito"] as $producto => $arreglo){
                        
                        $cant = $arreglo["cantidad"];
                        $desc = $arreglo["descuento"];
                        $sql = "INSERT INTO procesoventa(idventa, cantidad, descuento, idproducto) 
                        VALUES ($idventa,$cant,$desc,$producto)";
                        $r = mysqli_query($conexion, $sql);
                        

                        $insertar = "INSERT INTO almacen(fecha) VALUES (NOW())";
                        $r = mysqli_query($conexion, $insertar);
                        if ($r){
                            $consulta = "SELECT * FROM almacen where fecha = NOW()";
                            $r = mysqli_query($conexion, $consulta);
                            while($rn= mysqli_fetch_array($r)){
                                $idalmacen = $rn['idalmacen'];
                                $fecha = $rn['fecha'];
                                $cant = -1 * $cant;
                                $insertar = "INSERT INTO actualizacionalmacen(idalmacen ,idproducto, cantidad) 
                                VALUES ( $idalmacen,$producto,$cant)";
                                $r = mysqli_query($conexion, $insertar);
                                if ($r){
                                    unset($_SESSION['carrito']);
                                    echo "<script>alert('Compra exitosa!');location.assign('ventas.php');</script>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
    </main>
</body>
</html>