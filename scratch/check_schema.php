<?php
require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getConnection();
    if (!$pdo) {
        die("No se pudo conectar.\n");
    }

    echo "--- TABLA: publicidad_negocios ---\n";
    $stmt = $pdo->query("DESCRIBE publicidad_negocios");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }

    echo "\n--- TABLA: trabajadores ---\n";
    $stmt = $pdo->query("DESCRIBE trabajadores");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }

    echo "\n--- TABLA: planes ---\n";
    $stmt = $pdo->query("DESCRIBE planes");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
