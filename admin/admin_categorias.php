<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';

$adminActual = verificarAdmin(['superadmin', 'admin']);

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
        $error = 'Token de seguridad inválido.';
    }
    $accion = (!empty($error)) ? '' : ($_POST['accion'] ?? '');

    if ($accion === 'crear') {
        $resultado = CategoriaController::crear($_POST['nombre'] ?? '', $_POST['icono'] ?? '🔧');

        if ($resultado['ok']) {
            $mensaje = $resultado['mensaje'];
        } else {
            $error = $resultado['mensaje'];
        }
    }

    if ($accion === 'editar') {
        $resultado = CategoriaController::actualizar(
            $_POST['categoria_id'] ?? 0,
            $_POST['nombre'] ?? '',
            $_POST['icono'] ?? '🔧'
        );

        if ($resultado['ok']) {
            $mensaje = $resultado['mensaje'];
        } else {
            $error = $resultado['mensaje'];
        }
    }

    if ($accion === 'cambiar_estado') {
        $categoria_id = intval($_POST['categoria_id'] ?? 0);
        $nuevo_estado = intval($_POST['nuevo_estado'] ?? 0);

        if ($categoria_id > 0) {
            $resultado = CategoriaController::cambiarEstado($categoria_id, $nuevo_estado);
            $mensaje = $resultado['mensaje'];
        }
    }
}

$categorias = CategoriaController::listarTodas();
// Cargar vista
require_once __DIR__ . '/../app/views/admin/admin_categorias.php';


