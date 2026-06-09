<?php
/**
 * API para procesar el Login de Google y guardar el Lead
 */

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/app/controllers/LeadController.php';

    $input = json_decode(file_get_contents('php://input'), true);
    $credential = $input['credential'] ?? '';

    if (empty($credential)) {
        echo json_encode(['ok' => false, 'error' => 'No se recibió la credencial de Google']);
        exit;
    }

    // Decodificar el JWT de Google de forma manual (sin librerías externas)
    // El JWT tiene 3 partes separadas por puntos. La segunda parte es el payload en Base64.
    $parts = explode('.', $credential);
    if (count($parts) !== 3) {
        echo json_encode(['ok' => false, 'error' => 'Token de Google inválido']);
        exit;
    }

    $payload = $parts[1];
    // Reemplazar caracteres de Base64URL a Base64 estándar
    $jsonPayload = base64_decode(strtr($payload, '-_', '+/'));
    $userData = json_decode($jsonPayload, true);

    $email = $userData['email'] ?? '';
    $nombre = $userData['name'] ?? '';

    if (empty($email)) {
        echo json_encode(['ok' => false, 'error' => 'No se pudo obtener el email de Google']);
        exit;
    }

    // Guardar el lead en la base de datos
    $origen = $input['origen'] ?? 'google_login';
    $resultado = LeadController::guardarEmail($email, $origen);

    if ($resultado['ok']) {
        // Establecer cookies para autocompletar formularios en PHP
        setcookie('lead_registered', '1', time() + (365*24*60*60), '/');
        setcookie('lead_email', $email, time() + (365*24*60*60), '/');
        setcookie('lead_nombre', $nombre, time() + (365*24*60*60), '/');
    }

    echo json_encode($resultado);

} catch (Throwable $e) {
    echo json_encode([
        'ok' => false,
        'error' => 'Error crítico: ' . $e->getMessage()
    ]);
}
