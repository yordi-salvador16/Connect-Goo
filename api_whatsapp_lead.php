<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Metodo no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$tipo = $_POST['tipo'] ?? ($input['tipo'] ?? '');
$entidad_id = intval($_POST['entidad_id'] ?? ($input['entidad_id'] ?? 0));

if (!in_array($tipo, ['trabajador', 'publicidad', 'compartir']) || $entidad_id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'Datos invalidos']);
    exit;
}

$ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

try {
    $pdo = getConnection();
    
    // ANTI-SPAM: Verificar si esta misma persona (IP) ya hizo clic a este mismo trabajador en las últimas 24 horas
    $checkSql = "SELECT id FROM whatsapp_leads 
                 WHERE tipo = :tipo 
                 AND entidad_id = :entidad_id 
                 AND ip_address = :ip_address 
                 AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        ':tipo' => $tipo,
        ':entidad_id' => $entidad_id,
        ':ip_address' => $ip_address
    ]);

    if ($checkStmt->rowCount() > 0) {
        // Ya hizo clic hoy, no le sumamos otro para evitar fraude.
        echo json_encode(['ok' => true, 'msg' => 'Click ignorado (Anti-spam 24h)']);
        exit;
    }

    $sql = "INSERT INTO whatsapp_leads (tipo, entidad_id, ip_address) VALUES (:tipo, :entidad_id, :ip_address)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tipo' => $tipo,
        ':entidad_id' => $entidad_id,
        ':ip_address' => $ip_address
    ]);
    
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    error_log("Error al registrar lead: " . $e->getMessage());
    echo json_encode(['ok' => false, 'error' => 'Error interno']);
}
