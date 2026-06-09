<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/PublicidadController.php';
require_once __DIR__ . '/app/controllers/CategoriaController.php';

$tipoSeleccionado = $_GET['tipo'] ?? ($_POST['tipo_publicidad'] ?? 'Anuncio simple');

$planesConfig = [
    'Anuncio simple' => [
        'nombre' => 'Anuncio simple',
        'precio' => 'GRATIS',
        'duracion' => '15 días',
        'descripcion' => 'Aparecerás en la sección de promociones locales con tus datos básicos.',
        'requiere_categoria' => false,
        'requiere_imagen' => false,
        'requiere_redes' => true,
        'requiere_horario' => false,
        'requiere_direccion' => false,
        'requiere_cta' => false
    ],
    'Promoción por categoría' => [
        'nombre' => 'Promoción por categoría',
        'precio' => 'GRATIS',
        'duracion' => '30 días',
        'descripcion' => 'Destaca dentro de una categoría específica con horario y contacto.',
        'requiere_categoria' => true,
        'requiere_imagen' => false,
        'requiere_redes' => true,
        'requiere_horario' => true,
        'requiere_direccion' => true,
        'requiere_cta' => false
    ],
    'Banner destacado' => [
        'nombre' => 'Banner destacado',
        'precio' => 'GRATIS',
        'duracion' => '30 días',
        'descripcion' => 'Máxima visibilidad en la página principal con imagen, dirección y acción personalizada.',
        'requiere_categoria' => false,
        'requiere_imagen' => true,
        'requiere_redes' => true,
        'requiere_horario' => true,
        'requiere_direccion' => true,
        'requiere_cta' => true
    ]
];

if (!isset($planesConfig[$tipoSeleccionado])) {
    $tipoSeleccionado = 'Anuncio simple';
}

$planActual = $planesConfig[$tipoSeleccionado];

$requiereCategoria = $planActual['requiere_categoria'];
$requiereImagen = $planActual['requiere_imagen'];
$requiereRedes = $planActual['requiere_redes'];
$requiereHorario = $planActual['requiere_horario'];
$requiereDireccion = $planActual['requiere_direccion'];
$requiereCta = $planActual['requiere_cta'];

$googleMapsApiKey = 'AIzaSyBnirktb0-NE5aMorGdiHyV-yHUWU6R8Uk';
$categorias = CategoriaController::listarActivas();

$errores = [];
$enviado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // HONEYPOT ANTI-SPAM
    if (!empty($_POST['cg_website_url'])) {
        die('Spam detectado. Acceso bloqueado.');
    }

    $resultado = PublicidadController::crearSolicitud($_POST, $_FILES);

    if ($resultado['ok']) {
        $enviado = true;
    } else {
        $errores = $resultado['errores'];
    }
}
// Cargar vista
require_once __DIR__ . '/app/views/public/solicitar_publicidad.php';
