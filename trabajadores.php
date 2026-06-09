<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/CategoriaController.php';
require_once __DIR__ . '/app/controllers/TrabajadorController.php';
require_once __DIR__ . '/app/controllers/CiudadController.php';

$slugCiudad = trim($_GET['ciudad'] ?? 'tingo-maria');
$ciudad = CiudadController::buscarPorSlug($slugCiudad);
if (!$ciudad) {
    $ciudad = CiudadController::buscarPorSlug('tingo-maria');
    $slugCiudad = 'tingo-maria';
}

$categoria_id = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;

$categoria = null;
$trabajadores = [];

try {
    $categoria = CategoriaController::buscarPorId($categoria_id);
} catch (Exception $e) {
    error_log("Error en trabajadores.php al buscar categoría: " . $e->getMessage());
}

if (!$categoria || !$categoria['estado']) {
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Error - Connectgoo</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="assets/css/styles.css?v=2.3"></head><body><main class="container"><section class="empty-state"><h2>Categoría no encontrada</h2><p>La categoría solicitada no existe o no está disponible.</p><a href="categorias.php" class="btn-primary">Ver categorías</a></section></main></body></html>';
    exit;
}

try {
    $trabajadores = TrabajadorController::listarAprobadosPorCategoria($categoria_id, $ciudad['id']);
    if (!is_array($trabajadores)) $trabajadores = [];
} catch (Exception $e) {
    $trabajadores = [];
    error_log("Error en trabajadores.php al cargar trabajadores: " . $e->getMessage());
}

$publicidadesCategoria = [];
try {
    require_once __DIR__ . '/app/controllers/PublicidadController.php';
    $publicidadesCategoria = PublicidadController::listarAprobadasPorCategoria($categoria_id);
    if (!is_array($publicidadesCategoria)) $publicidadesCategoria = [];
} catch (Exception $e) {
    $publicidadesCategoria = [];
    error_log("Error en trabajadores.php al cargar publicidad: " . $e->getMessage());
}
// Cargar vista
require_once __DIR__ . '/app/views/public/trabajadores.php';
