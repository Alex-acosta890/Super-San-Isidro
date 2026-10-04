<?php

$servidor = "DESKTOP-P54CACR";
$baseDatos = "PruebaLaragonSQ1L";

try {

    $conexion = new PDO(
        "sqlsrv:Server=$servidor;Database=$baseDatos",
        null,
        null
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());

}