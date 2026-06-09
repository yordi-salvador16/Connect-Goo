<?php
require_once __DIR__ . '/app/config/database.php';

try {
    $pdo = getConnection();
    if (!$pdo) {
        die("No database connection.\n");
    }

    // Add 'sector' column if it doesn't exist
    $pdo->exec("ALTER TABLE categorias ADD COLUMN sector ENUM('urbano', 'agro') NOT NULL DEFAULT 'urbano'");
    echo "Added 'sector' column to 'categorias' table.\n";

    // Insert new Agro categories
    $agroCategories = [
        ['nombre' => 'Mecánica Agrícola', 'icono' => '🚜'],
        ['nombre' => 'Fletes y Transporte', 'icono' => '🚚'],
        ['nombre' => 'Mano de Obra (Peones)', 'icono' => '👨‍🌾'],
        ['nombre' => 'Drones Agrícolas', 'icono' => '🚁'],
        ['nombre' => 'Asesoría Agronómica', 'icono' => '🌱']
    ];

    $stmt = $pdo->prepare("INSERT INTO categorias (nombre, icono, estado, sector) VALUES (?, ?, 1, 'agro')");
    
    foreach ($agroCategories as $cat) {
        $stmt->execute([$cat['nombre'], $cat['icono']]);
        echo "Inserted Agro category: {$cat['nombre']}\n";
    }

    echo "Setup complete!\n";

} catch (Exception $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Column 'sector' already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
