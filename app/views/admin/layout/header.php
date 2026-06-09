<?php
// app/views/admin/layout/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Panel de Control' ?> - ConnectGoo</title>
    <link rel="stylesheet" href="../assets/css/admin-premium.css?v=1.3">
    <!-- Lucide Icons para el admin -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <main class="admin-main">
        <header class="admin-header">
            <div class="header-left">
                <div class="header-breadcrumbs">Panel de Administraci&oacute;n &gt; <?= $pageBreadcrumb ?? 'Inicio' ?></div>
                <div class="header-title-container">
                    <button class="mobile-toggle" id="mobileToggle">
                        <i data-lucide="menu"></i>
                    </button>
                    <h1 class="header-title"><?= $pageTitle ?? 'Panel de Control' ?></h1>
                </div>
            </div>
            
            <div class="header-right">
                <a href="../index.php" target="_blank" class="btn-portal">
                    <i data-lucide="external-link" style="width:16px;height:16px;"></i> Explorar Portal
                </a>
            </div>
        </header>
        
        <div class="admin-content">
