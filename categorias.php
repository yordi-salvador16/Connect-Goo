<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/CategoriaController.php';
require_once __DIR__ . '/app/controllers/CiudadController.php';

$slugCiudad = trim($_GET['ciudad'] ?? 'tingo-maria');
$ciudad = CiudadController::buscarPorSlug($slugCiudad);
if (!$ciudad) {
    $ciudad = CiudadController::buscarPorSlug('tingo-maria');
    $slugCiudad = 'tingo-maria';
}

$busqueda = trim($_GET['buscar'] ?? '');
$categorias = [];
try {
    $categorias = CategoriaController::buscarActivas($busqueda);
    if (!is_array($categorias)) $categorias = [];
} catch (Exception $e) {
    $categorias = [];
    error_log("Error en categorias.php: " . $e->getMessage());
}
// Cargar vista
require_once __DIR__ . '/app/views/public/categorias.php';

