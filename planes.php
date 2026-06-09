<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/app/controllers/PlanController.php';

$planes = PlanController::listarActivos();

function precioPlan($precio) {
    return 'Gratis';
}

function descripcionPlan($nombre) {
    if ($nombre === 'Básico') {
        return 'Ideal para trabajadores que desean aparecer en la plataforma sin costo.';
    }
    if ($nombre === 'Destacado') {
        return 'Mayor visibilidad dentro de la categoría para recibir más oportunidades de contacto.';
    }
    if ($nombre === 'Premium') {
        return 'Mayor prioridad visual, etiqueta recomendada y perfil más llamativo para clientes.';
    }
    return 'Plan de visibilidad para trabajadores locales.';
}

function beneficiosPlan($nombre) {
    if ($nombre === 'Básico') {
        return [
            'Perfil visible después de aprobación',
            'Contacto directo por WhatsApp',
            'Zona y descripción del servicio',
            'Aparece en la lista general'
        ];
    }
    if ($nombre === 'Destacado') {
        return [
            'Aparece antes que los perfiles básicos',
            'Etiqueta “Destacado”',
            'Mayor visibilidad en su categoría',
            'Más oportunidades de contacto'
        ];
    }
    if ($nombre === 'Premium') {
        return [
            'Etiqueta “Recomendado”',
            'Prioridad en resultados de búsqueda',
            'Perfil más llamativo para clientes',
            'Mayor presencia en la plataforma'
        ];
    }
    return ['Perfil visible', 'Contacto por WhatsApp', 'Revisión por administrador'];
}

function clasePlan($nombre) {
    if ($nombre === 'Destacado') return 'worker-plan-card featured';
    if ($nombre === 'Premium') return 'worker-plan-card premium';
    return 'worker-plan-card';
}
// Cargar vista
require_once __DIR__ . '/app/views/public/planes.php';

