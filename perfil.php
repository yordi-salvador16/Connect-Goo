    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/registro_de_errores');

    require_once __DIR__ . '/app/controllers/TrabajadorController.php';

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $trabajador = null;
    try {
        $trabajador = TrabajadorController::obtenerPerfil($id);
    } catch (Exception $e) {
        error_log("Error en perfil.php: " . $e->getMessage());
    }

    if (!$trabajador) {
        echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Error - Connectgoo</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="assets/css/styles.css"></head><body><main class="container"><section class="empty-state"><h2>Perfil no encontrado</h2><p>El perfil solicitado no existe o no ha sido aprobado.</p><a href="categorias.php" class="btn-primary">Ver categorías</a></section></main></body></html>';
        exit;
    }

    $mensajeWhatsApp = urlencode("Hola, vi tu perfil en Connectgoo y necesito información sobre tu servicio de " . $trabajador['servicio'] . ".");

    // Reseñas
    require_once __DIR__ . '/app/controllers/ResenaController.php';
    $mensajeResena = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'calificar') {
        if (!isset($_COOKIE['lead_registered'])) {
            $mensajeResena = 'Error: Debes iniciar sesión con Google para poder comentar.';
        } else {
            // Asignamos de forma segura el nombre real desde la cookie de Google
            $_POST['nombre_cliente'] = $_COOKIE['lead_nombre'] ?? 'Usuario de Google';
            $resultado = ResenaController::calificar($_POST);
            $mensajeResena = $resultado['mensaje'];
        }
    }
    $resenas = ResenaController::obtenerResenas($id);
    // Cargar vista
require_once __DIR__ . '/app/views/public/perfil.php';
