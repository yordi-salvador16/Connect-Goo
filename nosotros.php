<?php
// nosotros.php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

// Cargar vista pública
require_once __DIR__ . '/app/views/public/nosotros.php';
