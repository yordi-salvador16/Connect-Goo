<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/config/session.php';

iniciarSesionSegura();

$error = '';

// Logout
if (isset($_GET['logout'])) {
    // Limpiar token de sesión en BD
    if (!empty($_SESSION['admin_id'])) {
        Admin::actualizarSessionToken($_SESSION['admin_id'], '');
    }
    cerrarSesion();
    header("Location: login_admin.php");
    exit;
}

// Si ya está logueado, redirigir al panel
if (!empty($_SESSION['admin_id']) && !empty($_SESSION['session_token'])) {
    header("Location: panel_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = AdminController::login($_POST['usuario'] ?? '', $_POST['password'] ?? '');

    if ($resultado['ok']) {
        header("Location: panel_admin.php");
        exit;
    } else {
        $error = $resultado['mensaje'];
    }
}
// Cargar vista
require_once __DIR__ . '/../app/views/admin/login_admin.php';


