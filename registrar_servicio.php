<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/CategoriaController.php';
require_once __DIR__ . '/app/controllers/PlanController.php';
require_once __DIR__ . '/app/controllers/TrabajadorController.php';
require_once __DIR__ . '/app/controllers/CiudadController.php';

$errores = [];
$enviado = false;

$categorias = CategoriaController::listarActivas();
$planes = PlanController::listarActivos();
$ciudades = CiudadController::listarActivas();

$googleMapsApiKey = 'AIzaSyBnirktb0-NE5aMorGdiHyV-yHUWU6R8Uk';

$planSeleccionado = intval($_GET['plan'] ?? ($_POST['plan_id'] ?? 1));

$planActual = null;

foreach ($planes as $plan) {
    if (intval($plan['id']) === $planSeleccionado) {
        $planActual = $plan;
        break;
    }
}

if (!$planActual && count($planes) > 0) {
    $planActual = $planes[0];
    $planSeleccionado = intval($planActual['id']);
}

function tipoPlanTrabajador($nombre)
{
    $nombre = strtolower($nombre ?? '');

    if (strpos($nombre, 'premium') !== false) {
        return 'premium';
    }

    if (strpos($nombre, 'destacado') !== false) {
        return 'destacado';
    }

    return 'basico';
}

function precioPlanTexto($precio)
{
    return floatval($precio) <= 0 ? 'Gratis' : 'S/ ' . number_format($precio, 2) . ' / mes';
}

function descripcionPlanTrabajador($tipo)
{
    if ($tipo === 'premium') {
        return 'Perfil con mayor prioridad visual, foto obligatoria y datos completos para generar más confianza.';
    }

    if ($tipo === 'destacado') {
        return 'Perfil con mayor visibilidad, especialidad, horario y opción de foto para destacar en su categoría.';
    }

    return 'Perfil básico gratuito con información esencial para que los clientes puedan contactarte.';
}

function old($key)
{
    return htmlspecialchars($_POST[$key] ?? '', ENT_QUOTES, 'UTF-8');
}

$tipoPlan = tipoPlanTrabajador($planActual['nombre'] ?? 'Básico');

$requiereEspecialidad = in_array($tipoPlan, ['destacado', 'premium']);
$requiereHorario = in_array($tipoPlan, ['destacado', 'premium']);
$requiereFoto = $tipoPlan === 'premium';
$muestraFoto = in_array($tipoPlan, ['destacado', 'premium']);
$requiereReferencia = $tipoPlan === 'premium';
$muestraMapaEmprendimiento = in_array($tipoPlan, ['destacado', 'premium']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // HONEYPOT ANTI-SPAM
    if (!empty($_POST['cg_website_url'])) {
        die('Spam detectado. Acceso bloqueado.');
    }

    try {
        $resultado = TrabajadorController::crearSolicitud($_POST, $_FILES);

        if ($resultado['ok']) {
            $enviado = true;
        } else {
            $errores = $resultado['errores'];
        }
    } catch (Throwable $e) {
        $errores = ["Error interno: " . $e->getMessage()];
        // Log para el desarrollador
        error_log("[" . date('Y-m-d H:i:s') . "] Error fatal en registro: " . $e->getMessage() . " en " . $e->getFile() . ":" . $e->getLine());
    }
}
// Cargar vista
require_once __DIR__ . '/app/views/public/registrar_servicio.php';
