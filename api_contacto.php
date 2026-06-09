<?php
require_once __DIR__ . '/app/config/database.php';
header('Content-Type: application/json');

// Recibir JSON del frontend
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
    exit;
}

$nombre = trim($input['nombre'] ?? '');
$telefono = trim($input['telefono'] ?? '');
$mensaje = trim($input['mensaje'] ?? '');

if (empty($nombre) || empty($telefono) || empty($mensaje)) {
    echo json_encode(['ok' => false, 'error' => 'Todos los campos son obligatorios']);
    exit;
}

try {
    $db = getConnection();
    
    // Insertar el mensaje
    $stmt = $db->prepare("INSERT INTO contactos (nombre, telefono, mensaje) VALUES (:nombre, :telefono, :mensaje)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':telefono' => $telefono,
        ':mensaje' => $mensaje
    ]);

    echo json_encode(['ok' => true]);

} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
}
