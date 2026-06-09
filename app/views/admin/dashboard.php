<?php
// app/views/admin/dashboard.php
$pageTitle = 'Panel de Control';
$pageBreadcrumb = 'Inicio';
require_once __DIR__ . '/layout/header.php';

// Formatear fecha actual
$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$fechaHoy = date('d') . ' de ' . $meses[date('n') - 1] . ' del ' . date('Y');
$nombreAdmin = htmlspecialchars($adminActual['nombre'] ?? 'Admin', ENT_QUOTES, 'UTF-8');
?>

<div class="welcome-banner">
    <div class="banner-date">
        <i data-lucide="calendar" style="width:14px;height:14px;color:#a78bfa;"></i> <?= $fechaHoy ?>
    </div>
    <?php
    $hora = date('H');
    $saludo = ($hora < 12) ? 'Buenos días' : (($hora < 19) ? 'Buenas tardes' : 'Buenas noches');
    ?>
    <h1>¡<?= $saludo ?>, <?= $nombreAdmin ?>!</h1>
    <p>Resumen de impacto y visión general del rendimiento de <strong>ConnectGoo</strong> de hoy.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">TRABAJADORES</span>
            <span class="stat-value"><?= $totalTrabajadores ?? 0 ?></span>
        </div>
        <div class="stat-icon icon-blue">
            <i data-lucide="users"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">CIUDADES</span>
            <span class="stat-value"><?= $totalCiudades ?? 0 ?></span>
        </div>
        <div class="stat-icon icon-purple">
            <i data-lucide="map"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">CATEGORÍAS</span>
            <span class="stat-value"><?= $totalCategorias ?? 0 ?></span>
        </div>
        <div class="stat-icon icon-yellow">
            <i data-lucide="list"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">SUSCRIPTORES</span>
            <span class="stat-value"><?= $totalLeads ?? 0 ?></span>
        </div>
        <div class="stat-icon icon-green">
            <i data-lucide="mail"></i>
        </div>
    </div>
</div>

<!-- Gráfico de Actividad (NUEVO) -->
<div class="table-card" style="margin-bottom: 24px;">
    <div class="table-header">
        <h2>Actividad Reciente de la Plataforma</h2>
    </div>
    <div style="padding: 20px; height: 300px;">
        <canvas id="dashboardChart"></canvas>
    </div>
</div>

<div class="dashboard-layout">
    <!-- Main Column: Table -->
    <div class="table-card">
        <div class="table-header">
            <h2>Trabajadores Agregados Recientemente</h2>
            <a href="panel_admin.php?estado=pendiente" class="table-link">Ver todos →</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>TRABAJADOR</th>
                        <th>SERVICIO</th>
                        <th>ESTADO</th>
                        <th>FECHA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimosTrabajadores)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;color:#94a3b8;padding:30px;">No hay registros recientes</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($ultimosTrabajadores as $t): ?>
                        <tr>
                            <td>
                                <div class="row-item">
                                    <div class="row-img" style="display:flex;align-items:center;justify-content:center;background:#10b981;color:white;font-weight:700;">
                                        <?= strtoupper(substr($t['nombre'], 0, 1)) ?>
                                    </div>
                                    <span class="row-name"><?= htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($t['servicio'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php if($t['estado'] === 'aprobado'): ?>
                                    <span style="background:#ecfdf5;color:#059669;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;">Activo</span>
                                <?php elseif($t['estado'] === 'pendiente'): ?>
                                    <span style="background:#fffbeb;color:#d97706;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;">Pendiente</span>
                                <?php else: ?>
                                    <span style="background:#fef2f2;color:#dc2626;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;">Rechazado</span>
                                <?php endif; ?>
                            </td>
                            <td style="color:#64748b;font-size:13px;"><?= date('d/m/Y', strtotime($t['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Side Column: Actions -->
    <div>
        <div class="action-card">
            <h3>Accesos Rápidos</h3>
            <p>Acciones de mantenimiento esenciales en un solo clic.</p>
            
            <a href="panel_admin.php?estado=pendiente" class="btn-action">
                <i data-lucide="check-circle" style="color:#10b981;"></i> Revisar Solicitudes
            </a>
            <br>
            <a href="admin_ciudades.php" class="btn-action">
                <i data-lucide="map-pin" style="color:#0ea5e9;"></i> Nueva Ciudad
            </a>
            <br>
            <a href="admin_categorias.php" class="btn-action">
                <i data-lucide="plus-circle" style="color:#8b5cf6;"></i> Nueva Categoría
            </a>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    
    // Crear un gradiente esmeralda
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.5)'); // Esmeralda fuerte
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)'); // Transparente

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Hace 6 días', 'Hace 5 días', 'Hace 4 días', 'Hace 3 días', 'Antes de ayer', 'Ayer', 'Hoy'],
            datasets: [{
                label: 'Nuevos Registros (Leads & Trabajadores)',
                data: [5, 8, 12, 7, 15, 22, 18], // Data simulada dinámica o real si se conecta a backend
                borderColor: '#10b981',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // Curvas suaves (Premium)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, family: 'Inter' },
                    bodyFont: { size: 14, family: 'Inter' },
                    displayColors: false,
                    callbacks: {
                        label: function(context) { return context.parsed.y + ' interacciones'; }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#e2e8f0' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            },
            interaction: { mode: 'index', intersect: false }
        }
    });
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
