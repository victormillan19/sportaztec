<?php
session_start();
session_encode();
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menù Sistema | Gestion</title>
    <link rel="stylesheet" href="CSS\estilos-sistema.css">
</head>
<body>
    <header class="header">
        <div class="menu">
            <nav>
                <ul>
                    <a href="" class="logo">Sport Aztec</a>
                    <li><a href="gestion_usuarios.php">Gestion de Usuarios</a></li>
                    <li><a href="gestion_producto.php">Gestion de Producto</a></li>
                    <li><a href="gestion_ventas.php">Gestion de Ventas</a></li>
                    <li><a href="index.php">Cerrar Sesion de <?php echo $_SESSION["usuario"];?></a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    
