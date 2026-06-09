<?php
// track_pwa_install.php
require_once __DIR__ . '/app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getConnection();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        // Registrar instalación en la base de datos
        $stmt = $pdo->prepare("INSERT INTO pwa_installs (user_agent, fecha) VALUES (?, NOW())");
        $stmt->execute([$userAgent]);
        
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
