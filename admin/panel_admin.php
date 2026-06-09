<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/TrabajadorController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_once __DIR__ . '/../app/controllers/PlanController.php';

$adminActual = verificarAdmin();

$mensaje = '';
$errorMsg = '';

if (isset($_GET['error']) && $_GET['error'] === 'sin_permisos') {
    $errorMsg = 'No tienes permisos para acceder a esa sección.';
}

$categorias = CategoriaController::listarActivas();
$planes = PlanController::listarActivos();

$estado = $_GET['estado'] ?? 'pendiente';
$estadosPermitidos = ['pendiente', 'aprobado', 'rechazado'];

if (!in_array($estado, $estadosPermitidos)) {
    $estado = 'pendiente';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Token de seguridad inválido. Recarga la página.';
    } else {
        $trabajador_id = intval($_POST['trabajador_id'] ?? 0);
        $accion = $_POST['accion'] ?? '';

        if ($trabajador_id > 0) {
            if ($accion === 'aprobar' && adminTieneRol($adminActual, ['superadmin', 'admin', 'moderador'])) {
                $mensaje = TrabajadorController::aprobar($trabajador_id);
                $estado = 'pendiente';
            }

            if ($accion === 'rechazar' && adminTieneRol($adminActual, ['superadmin', 'admin', 'moderador'])) {
                $mensaje = TrabajadorController::rechazar($trabajador_id);
                $estado = 'pendiente';
            }

            if ($accion === 'guardar_edicion' && adminTieneRol($adminActual, ['superadmin', 'admin'])) {
                $resultado = TrabajadorController::actualizarDesdeAdmin($trabajador_id, $_POST);
                $mensaje = $resultado['mensaje'];
            }

            if ($accion === 'eliminar_aprobado' && adminTieneRol($adminActual, ['superadmin', 'admin'])) {
                $mensaje = TrabajadorController::eliminarAprobado($trabajador_id);
                $estado = 'aprobado';
            }
        }
    }
}

$totalPendientes = TrabajadorController::contarPorEstado('pendiente');
$totalAprobados = TrabajadorController::contarPorEstado('aprobado');
$totalRechazados = TrabajadorController::contarPorEstado('rechazado');

$trabajadores = TrabajadorController::listarPorEstado($estado);

// Responder a peticiones AJAX en segundo plano para auto-actualización en tiempo real
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json; charset=utf-8');
    ob_start();
    $csrfToken = campoCSRF();
    ob_start();
    require __DIR__ . '/../app/views/admin/partials/ajax_trabajadores.php';
    $trabajadoresHtml = ob_get_clean();
    
    echo json_encode([
        'totalPendientes' => $totalPendientes,
        'totalAprobados' => $totalAprobados,
        'totalRechazados' => $totalRechazados,
        'trabajadores_html' => $trabajadoresHtml
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function estadoTexto($estado) {
    if ($estado === 'pendiente') return 'Pendiente';
    if ($estado === 'aprobado') return 'Aprobado';
    if ($estado === 'rechazado') return 'Rechazado';
    return $estado;
}

function selectedOption($actual, $valor) {
    return intval($actual) === intval($valor) ? 'selected' : '';
}

function checkedOption($valor) {
    return intval($valor) === 1 ? 'checked' : '';
}

// ====== ENRUTAMIENTO MVC ======
if (!isset($_GET['estado'])) {
    // === MODO DASHBOARD (Panel Principal) ===
    require_once __DIR__ . '/../app/controllers/CiudadController.php';
    require_once __DIR__ . '/../app/controllers/LeadController.php';
    
    // Obtener estadísticas globales
    $totalTrabajadores = TrabajadorController::contarPorEstado('aprobado');
    $ciudades = CiudadController::listarTodas();
    $totalCiudades = is_array($ciudades) ? count($ciudades) : 0;
    $totalCategorias = is_array($categorias) ? count($categorias) : 0;
    
    $conteoLeads = LeadController::contarPorOrigen();
    $totalLeads = $conteoLeads['total'] ?? 0;
    
    // Obtener últimos trabajadores pendientes para la tabla
    $ultimosTrabajadores = TrabajadorController::listarPorEstado('pendiente');
    if (count($ultimosTrabajadores) > 5) {
        $ultimosTrabajadores = array_slice($ultimosTrabajadores, 0, 5);
    }
    
    // Cargar Vista
    require_once __DIR__ . '/../app/views/admin/dashboard.php';

} else {
    // === MODO GESTIÓN (Solicitudes) ===
    // Ya tenemos $trabajadores y los totales calculados arriba
    
    // Cargar Vista
    require_once __DIR__ . '/../app/views/admin/solicitudes.php';
}


