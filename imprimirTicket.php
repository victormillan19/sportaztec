<?php
if (!isset($_GET["id"])) {
    
}
    $id = $_GET["id"];
    
include("conexion.php");
$sql = "SELECT idventa, fecha, total FROM venta WHERE idventa = $id";
$r = mysqli_query($conexion, $sql);

if (!$r) {
    exit("No existe venta con el id proporcionado");
}
$sql = "SELECT p.idproducto,p.precio,pv.cantidad 
FROM productos p INNER JOIN procesoventa pv 
ON p.idproducto = pv.idproducto 
WHERE pv.idventa = $id";
$r = mysqli_query($conexion,$sql);
if (!$r) {
    exit("No hay productos");
}
?>
<style>
    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.producto,
    th.producto {
        width: 75px;
        max-width: 75px;
    }

    td.cantidad,
    th.cantidad {
        width: 50px;
        max-width: 50px;
        word-break: break-all;
    }

    td.precio,
    th.precio {
        width: 50px;
        max-width: 50px;
        word-break: break-all;
        text-align: right;
    }

    .centrado {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 175px;
        max-width: 175px;
    }

    img {
        max-width: inherit;
        width: inherit;
    }

    @media print {

        .oculto-impresion,
        .oculto-impresion * {
            display: none !important;
        }
    }
</style>
<body>
<div class="ticket">
<img src="IMG\logo.png" alt="Logotipo">
        <p class="centrado">TICKET DE VENTA
            <br>Id Venta:  <?php  $id = print_r($_GET["id"]);?>
            <br><?php $fecha = print_r($_GET["fecha"]); ?>
            <br>Usuario: <?php $iduauario = print_r($_GET["idusuario"]); ?>
            <br>Apartado: <?php $apartado = print_r($_GET["apartado"]); ?>
        </p>
        <table>
            <thead>
                <tr>
                    <th class="cantidad"></th>
                    <th class="producto"></th>
                    <th class="precio">TOTAL</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM procesoventa INNER JOIN productos USING (idproducto) WHERE idventa = $id";
            $r = mysqli_query($conexion, $sql);
            while($fila = mysqli_fetch_array($r)){
                $cantidad = print_r($fila['cantidad']);
                $nombre = $fila['nombre'];
                $precio = $fila['precio'];
                $descuento = $fila['descuento'];
             
            ?>
            <tr>
                <td> <?php echo $cantidad; ?></td>
                <td> <?php echo $nombre; ?></td>
                <td> <?php echo $precio; ?></td>
                <td> <?php echo $descuento; ?></td>
            </tr>
            <?php 
            }      
            ?>
                <tr>
                    <td colspan="2" style="text-align: right;">TOTAL</td>
                    <td class="precio">
                        <strong>$<?php echo number_format($total = print_r($_GET["total"]), 2) ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!</p>
</div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.print();
        setTimeout(() => {
            window.location.href = "gestion_ventas.php";
        }, 1000);
    });
</script>
