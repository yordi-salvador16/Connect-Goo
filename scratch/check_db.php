<?php
require_once __DIR__ . '/app/config/database.php';

try {
    $pdo = getConnection();
    if (!$pdo) {
        die("No se pudo conectar a la base de datos.\n");
    }

    echo "Tabla: trabajadores\n";
    $stmt = $pdo->query("DESCRIBE trabajadores");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }

    echo "\nTabla: categorias\n";
    $stmt = $pdo->query("DESCRIBE categorias");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }

    echo "\nTabla: planes\n";
    $stmt = $pdo->query("DESCRIBE planes");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
