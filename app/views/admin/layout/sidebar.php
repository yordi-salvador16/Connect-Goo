<?php
// app/views/admin/layout/sidebar.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo-icon">
            <i data-lucide="map-pin"></i>
        </div>
        <div class="sidebar-brand">
            Connect
            <span>Goo</span>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <?= strtoupper(substr($adminActual['nombre'] ?? 'Admin', 0, 1)) ?>
        </div>
        <div class="user-info">
            <span class="user-name"><?= htmlspecialchars($adminActual['nombre'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
            <span class="user-role"><?= strtoupper($adminActual['rol'] ?? 'SUPER ADMIN') ?></span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Navegación</div>
        
        <a href="panel_admin.php" class="nav-item <?= $currentPage === 'panel_admin.php' ? 'active' : '' ?>">
            <i data-lucide="layout-dashboard"></i> Panel Principal
        </a>

        <div class="nav-section">Gestión</div>
        
        <a href="panel_admin.php?estado=pendiente" class="nav-item <?= (isset($_GET['estado'])) ? 'active' : '' ?>">
            <i data-lucide="users"></i> Solicitudes
        </a>
        
        <a href="admin_ciudades.php" class="nav-item <?= $currentPage === 'admin_ciudades.php' ? 'active' : '' ?>">
            <i data-lucide="map"></i> Ciudades
        </a>
        
        <a href="admin_categorias.php" class="nav-item <?= $currentPage === 'admin_categorias.php' ? 'active' : '' ?>">
            <i data-lucide="list"></i> Categorías
        </a>

        <?php if (isset($adminActual['rol']) && $adminActual['rol'] === 'superadmin'): ?>
            <a href="admin_usuarios.php" class="nav-item <?= $currentPage === 'admin_usuarios.php' ? 'active' : '' ?>">
                <i data-lucide="shield"></i> Administradores
            </a>
        <?php endif; ?>

        <div class="nav-section">Audiencia</div>

        <a href="admin_mensajes.php" class="nav-item <?= $currentPage === 'admin_mensajes.php' ? 'active' : '' ?>">
            <i data-lucide="message-square"></i> Mensajes de Ayuda
        </a>

        <a href="admin_leads.php" class="nav-item <?= $currentPage === 'admin_leads.php' ? 'active' : '' ?>">
            <i data-lucide="users"></i> Turistas Google
        </a>

        <?php if (isset($adminActual['rol']) && in_array($adminActual['rol'], ['superadmin', 'admin'])): ?>
        <div class="nav-section">Reportes</div>

        <a href="panel_metricas.php" class="nav-item <?= $currentPage === 'panel_metricas.php' ? 'active' : '' ?>">
            <i data-lucide="bar-chart-2"></i> Métricas AARRR
        </a>
        
        <a href="panel_ingresos.php" class="nav-item <?= $currentPage === 'panel_ingresos.php' ? 'active' : '' ?>">
            <i data-lucide="dollar-sign"></i> Ingresos
        </a>
        <?php endif; ?>

        <div class="nav-section">Configuración</div>

        <a href="admin_versiones.php" class="nav-item <?= $currentPage === 'admin_versiones.php' ? 'active' : '' ?>">
            <i data-lucide="history"></i> Historial de Versiones
        </a>

        <a href="admin_ajustes.php" class="nav-item <?= $currentPage === 'admin_ajustes.php' ? 'active' : '' ?>">
            <i data-lucide="settings"></i> Ajustes de mi cuenta
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="login_admin.php?logout=1" class="nav-item" style="color: #ef4444;">
            <i data-lucide="log-out"></i> Cerrar Sesión
        </a>
    </div>
</aside>
