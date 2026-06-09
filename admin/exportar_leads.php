<?php
/**
 * SCRIPT PARA EXPORTAR LEADS A CSV (EXCEL)
 */

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/controllers/LeadController.php';

// Solo administradores pueden exportar
verificarAdmin();

$leads = LeadController::listar();

// Configurar cabeceras para descarga de archivo
$filename = "suscriptores_conecta_tingo_" . date('Y-m-d') . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Crear el puntero de salida
$output = fopen('php://output', 'w');

// Añadir el BOM para que Excel reconozca los caracteres especiales (tildes, etc)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Cabeceras de las columnas
fputcsv($output, ['ID', 'Email', 'Origen', 'Fecha de Registro']);

// Añadir los datos
foreach ($leads as $lead) {
    fputcsv($output, [
        $lead['id'],
        $lead['email'],
        $lead['origen'],
        $lead['created_at']
    ]);
}

fclose($output);
exit;


