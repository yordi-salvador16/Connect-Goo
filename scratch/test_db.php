<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getConnection();
    if (!$pdo) {
        echo "Error: No se pudo conectar a la base de datos.\n";
        exit;
    }

    echo "Conexión exitosa.\n";

    // Probar consulta de planes
    $stmt = $pdo->query("SELECT COUNT(*) FROM trabajadores WHERE estado = 'aprobado'");
    echo "Trabajadores aprobados: " . $stmt->fetchColumn() . "\n";

    // Probar consulta de publicidad
    $stmt = $pdo->query("SELECT COUNT(*) FROM publicidad_negocios");
    echo "Publicidades totales: " . $stmt->fetchColumn() . "\n";

    echo "Todo parece estar en orden con la base de datos.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
