<?php
require_once __DIR__ . '/../app/config/session.php';
$adminActual = verificarAdmin(); // Todos los admins pueden ver las versiones

// Variables para la vista
$pageTitle = 'Historial de Versiones';
$pageBreadcrumb = 'Configuración > Historial de Versiones';

require_once __DIR__ . '/../app/views/admin/admin_versiones.php';
