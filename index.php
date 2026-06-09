<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/PublicidadController.php';
require_once __DIR__ . '/app/controllers/CiudadController.php';
require_once __DIR__ . '/app/controllers/TrabajadorController.php';

$ciudades = [];
try {
    $ciudades = CiudadController::listarTodas();
} catch (Exception $e) {
    $ciudades = [];
    error_log("Error al cargar ciudades: " . $e->getMessage());
}

$publicidades = [];
try {
    $publicidades = PublicidadController::listarAprobadas();
    if (!is_array($publicidades)) $publicidades = [];
} catch (Exception $e) {
    $publicidades = [];
    error_log("Error al cargar publicidades: " . $e->getMessage());
}

$destacadosHome = [];
try {
    $destacadosHome = TrabajadorController::listarDestacadosHome(8);
    if (!is_array($destacadosHome)) $destacadosHome = [];
} catch (Exception $e) {
    $destacadosHome = [];
    error_log("Error al cargar destacados home: " . $e->getMessage());
}
// Cargar la vista pública
require_once __DIR__ . '/app/views/public/home.php';

