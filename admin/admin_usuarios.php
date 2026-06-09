<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

// Solo el Superadmin puede acceder a esta página
$adminActual = verificarAdmin(['superadmin']);

$mensaje = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Token de seguridad inválido.';
    } else {
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'crear') {
            $resultado = AdminController::registrar($_POST);
            if ($resultado['ok']) {
                $mensaje = $resultado['mensaje'];
            } else {
                $errorMsg = $resultado['mensaje'];
            }
        }

        if ($accion === 'eliminar') {
            $idEliminar = intval($_POST['id'] ?? 0);
            $resultado = AdminController::eliminar($idEliminar);
            if ($resultado['ok']) {
                $mensaje = $resultado['mensaje'];
            } else {
                $errorMsg = $resultado['mensaje'];
            }
        }
    }
}

$usuarios = AdminController::listarTodos();
// Cargar vista
require_once __DIR__ . '/../app/views/admin/admin_usuarios.php';


