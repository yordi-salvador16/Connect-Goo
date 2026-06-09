<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/config/database.php';

// Superadmin o admin general puede ver los mensajes
$adminActual = verificarAdmin(['superadmin', 'admin']);

$mensaje = '';
$errorMsg = '';
$db = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Token de seguridad inválido.';
    } else {
        $accion = $_POST['accion'] ?? '';
        
        if ($accion === 'marcar_leido') {
            $id = intval($_POST['id'] ?? 0);
            try {
                $stmt = $db->prepare("UPDATE contactos SET leido = 1 WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $mensaje = "Mensaje marcado como atendido.";
            } catch (Exception $e) {
                $errorMsg = "Error al marcar mensaje.";
            }
        }
        
        if ($accion === 'eliminar') {
            $id = intval($_POST['id'] ?? 0);
            try {
                $stmt = $db->prepare("DELETE FROM contactos WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $mensaje = "Mensaje eliminado.";
            } catch (Exception $e) {
                $errorMsg = "Error al eliminar mensaje.";
            }
        }
    }
}

// Obtener mensajes

$mensajes = [];
try {
    $stmt = $db->query("SELECT * FROM contactos ORDER BY leido ASC, id DESC");
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Falla si la tabla recién se creará y la consulta falla (muy raro en PDO si ya se hizo IF NOT EXISTS)
}

// Cargar vista
require_once __DIR__ . '/../app/views/admin/admin_mensajes.php';
