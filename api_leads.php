<?php
// Desactivar cualquier salida de errores previa para que no rompa el JSON
error_reporting(0);
ini_set('display_errors', 0);

// Limpiar cualquier búfer de salida previo
if (ob_get_level()) ob_end_clean();

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/app/controllers/LeadController.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        
        if (empty($email)) {
            echo json_encode(['ok' => false, 'error' => 'Email requerido']);
            exit;
        }

        $resultado = LeadController::guardarEmail($email);
        echo json_encode($resultado);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    }
} catch (Throwable $e) {
    // Si algo falla catastróficamente, lo devolvemos como JSON
    echo json_encode([
        'ok' => false, 
        'error' => 'Error crítico: ' . $e->getMessage()
    ]);
}
