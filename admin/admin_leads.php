<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/LeadController.php';

$adminActual = verificarAdmin();

// Filtro por origen
$filtro = $_GET['filtro'] ?? 'todos';
$filtrosPermitidos = ['todos', 'google_login', 'registro_trabajador'];

if (!in_array($filtro, $filtrosPermitidos)) {
    $filtro = 'todos';
}

$leads = ($filtro === 'todos') 
    ? LeadController::listar() 
    : LeadController::listar($filtro);

$conteos = LeadController::contarPorOrigen();

// Responder a peticiones AJAX en segundo plano para auto-actualización en tiempo real
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json; charset=utf-8');
    ob_start();
    // Incluir la parcial para peticiones AJAX
    require __DIR__ . '/../app/views/admin/partials/ajax_leads.php';
    $leadsHtml = ob_get_clean();
    
    echo json_encode([
        'conteos' => $conteos,
        'leads_html' => $leadsHtml
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Cargar vista
require_once __DIR__ . '/../app/views/admin/admin_leads.php';


