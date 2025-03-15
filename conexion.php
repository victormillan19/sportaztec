<?php

    $host   =   "localhost";
    $user   =   "root";
    $pass   =   "";
    $dbname =   "sa";

    //mysqli(host,usuario,contraseña,nombre_bd)
    $conexion = new mysqli($host,$user,$pass,$dbname);
    
    //Muestra en la paguina si hay conexion
    if($conexion == false)
        echo " Conexion no establecida...".mysqli_connect_error();
    else
    
?>