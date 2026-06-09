<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

try {
    require_once __DIR__ . '/../app/config/session.php';
    require_once __DIR__ . '/../app/controllers/PlanController.php';
    require_once __DIR__ . '/../app/controllers/PublicidadController.php';
    require_once __DIR__ . '/../app/controllers/TrabajadorController.php';
    require_once __DIR__ . '/../app/controllers/CategoriaController.php';

    $adminActual = verificarAdmin(['superadmin', 'admin']);

    $mensaje = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verificarCSRF($_POST['csrf_token'] ?? '')) {
            $mensaje = 'Token de seguridad inválido.';
        } else {
            $publicidad_id = intval($_POST['publicidad_id'] ?? 0);
            $accion = $_POST['accion'] ?? '';

            if ($publicidad_id > 0) {
                if ($accion === 'aprobar') {
                    $mensaje = PublicidadController::aprobar($publicidad_id);
                }

                if ($accion === 'rechazar') {
                    $mensaje = PublicidadController::rechazar($publicidad_id);
                }

                if ($accion === 'eliminar') {
                    $mensaje = PublicidadController::eliminar($publicidad_id);
                }

                if ($accion === 'guardar_edicion') {
                    $res = PublicidadController::actualizarDesdeAdmin($publicidad_id, $_POST, $_FILES);
                    $mensaje = $res['mensaje'];
                }
            }
        }
    }

    $ingresosPlanes = PlanController::ingresosPlanes();
    $ingresosPublicidad = PublicidadController::ingresosPublicidad();
    $totalIngresos = $ingresosPlanes + $ingresosPublicidad;

    $planesActivos = PlanController::contarPlanesActivos();
    $anunciosActivos = PublicidadController::contarAprobadas();
    $publicidadPendiente = PublicidadController::contarPendientes();

    $trabajadores = TrabajadorController::listarAprobadosConPlan();
    $publicidades = PublicidadController::listarTodas();
    $categorias = CategoriaController::listarActivas();

} catch (Throwable $t) {
    $errorMsg = "[" . date('Y-m-d H:i:s') . "] Error fatal: " . $t->getMessage() . " en " . $t->getFile() . ":" . $t->getLine();
    file_put_contents(__DIR__ . '/registro_de_errores', $errorMsg . "\n", FILE_APPEND);
    die("<pre>" . htmlspecialchars($errorMsg) . "</pre>");
}

function estadoTexto($estado) {
    if ($estado === 'pendiente') return 'Pendiente';
    if ($estado === 'aprobado') return 'Aprobado';
    if ($estado === 'rechazado') return 'Rechazado';
    return $estado;
}

function fechaTexto($fecha) {
    if (empty($fecha) || $fecha === '0000-00-00' || $fecha === '0000-00-00 00:00:00') {
        return 'No asignada';
    }

    $ts = strtotime($fecha);
    if ($ts === false || $ts === -1) {
        return 'Fecha inválida';
    }

    return date('d/m/Y', $ts);
}

function publicidadVencida($pub) {
    if (($pub['estado'] ?? '') !== 'aprobado') {
        return false;
    }

    $fechaFin = $pub['fecha_fin'] ?? '';
    if (empty($fechaFin) || $fechaFin === '0000-00-00' || $fechaFin === '0000-00-00 00:00:00') {
        return false;
    }

    $tsFin = strtotime($fechaFin);
    if ($tsFin === false) return false;

    return $tsFin < strtotime(date('Y-m-d'));
}

function diasRestantes($fechaFin) {
    if (empty($fechaFin) || $fechaFin === '0000-00-00' || $fechaFin === '0000-00-00 00:00:00') {
        return null;
    }

    try {
        $hoy = new DateTime(date('Y-m-d'));
        $fin = new DateTime($fechaFin);
        $diferencia = $hoy->diff($fin);

        if ($fin < $hoy) {
            return 0;
        }

        return $diferencia->days;
    } catch (Exception $e) {
        return null;
    }
}

function etiquetaEstadoPublicidad($pub) {
    if (($pub['estado'] ?? '') === 'aprobado') {
        if (publicidadVencida($pub)) {
            return 'Vencido';
        }

        return 'Activo';
    }

    return estadoTexto($pub['estado'] ?? '');
}

function claseEstadoPublicidad($pub) {
    if (($pub['estado'] ?? '') === 'aprobado') {
        if (publicidadVencida($pub)) {
            return 'vencido';
        }

        return 'aprobado';
    }

    return $pub['estado'] ?? '';
}

function precioTexto($valor) {
    return 'S/ ' . number_format(floatval($valor ?? 0), 2);
}
// Cargar vista
require_once __DIR__ . '/../app/views/admin/panel_ingresos.php';


