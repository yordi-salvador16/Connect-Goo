<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$adminActual = verificarAdmin();

$mensajePerfil = '';
$errorPerfil = '';
$mensajePassword = '';
$errorPassword = '';

$adminData = Admin::obtenerPorId($adminActual['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
        $errorPerfil = 'Token de seguridad inválido. Recarga la página.';
    } else {
        $accion = $_POST['accion'] ?? '';

        if ($accion === 'actualizar_perfil') {
            $resultado = AdminController::actualizarPerfil(
                $adminActual['id'],
                $_POST['nombre'] ?? '',
                $_POST['usuario'] ?? ''
            );

            if ($resultado['ok']) {
                $mensajePerfil = $resultado['mensaje'];
                $adminData = Admin::obtenerPorId($adminActual['id']);
            } else {
                $errorPerfil = $resultado['mensaje'];
            }
        }

        if ($accion === 'cambiar_password') {
            $resultado = AdminController::cambiarPassword(
                $adminActual['id'],
                $_POST['password_actual'] ?? '',
                $_POST['password_nueva'] ?? '',
                $_POST['password_confirmar'] ?? ''
            );

            if ($resultado['ok']) {
                $mensajePassword = $resultado['mensaje'];
            } else {
                $errorPassword = $resultado['mensaje'];
            }
        }
    }
}
// Cargar vista
require_once __DIR__ . '/../app/views/admin/admin_ajustes.php';


