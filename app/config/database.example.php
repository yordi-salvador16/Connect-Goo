<?php

// Configurar la zona horaria por defecto en PHP para Perú
date_default_timezone_set('America/Lima');

function getConnection()
{
    // === REEMPLAZAR ESTOS DATOS POR TUS CREDENCIALES REALES ===
    $host = 'localhost';
    $dbname = 'nombre_de_tu_base_de_datos';
    $user = 'tu_usuario';
    $password = 'tu_contraseña';

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $password,
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Configurar la zona horaria de la sesión de MySQL para Perú (GMT-5)
        $pdo->exec("SET time_zone = '-05:00'");

        return $pdo;

    } catch (PDOException $e) {
        $logFile = __DIR__ . '/../../registro_de_errores';
        $fecha = date('Y-m-d H:i:s');
        $mensaje = "[$fecha] Error de conexión a BD: " . $e->getMessage() . "\n";
        @file_put_contents($logFile, $mensaje, FILE_APPEND);

        return null;
    }
}
