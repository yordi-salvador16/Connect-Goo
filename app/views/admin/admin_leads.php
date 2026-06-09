<?php
// app/views/admin/admin_leads.php
// Variables esperadas: $leads, $conteos, $filtro
$pageTitle = 'Turistas Google (Leads)';
$pageBreadcrumb = 'Usuarios > Turistas Google';
require_once __DIR__ . '/layout/header.php';
?>

<div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Usuarios Registrados</h2>
        <p style="color:var(--text-muted); font-size:14px;">Todos los usuarios que interact&uacute;an con Connectgoo, clasificados por tipo.</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="exportar_leads.php" style="background:#008b45; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; color:white; text-decoration:none; display:flex; align-items:center; gap:6px;">
            <i data-lucide="download" style="width:16px;height:16px;"></i> Descargar Excel
        </a>
    </div>
</div>

    <!-- Contadores por tipo -->
    <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Total registros</span>
            <strong id="count-total" style="display:block; font-size:24px; color:var(--text-main); margin:8px 0;"><?= $conteos['total'] ?? 0 ?></strong>
        </div>
        <div style="background:white; border:1px solid var(--border-color); border-left:4px solid #2563eb; border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted); display:flex; align-items:center; gap:6px;">
                <i data-lucide="mail" style="width:16px; height:16px; color:#2563eb;"></i> Google Login
            </span>
            <strong id="count-google" style="display:block; font-size:24px; color:#2563eb; margin:8px 0;"><?= $conteos['google_login'] ?? 0 ?></strong>
        </div>
        <div style="background:white; border:1px solid var(--border-color); border-left:4px solid #16a34a; border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted); display:flex; align-items:center; gap:6px;">
                <i data-lucide="briefcase" style="width:16px; height:16px; color:#16a34a;"></i> Trabajadores
            </span>
            <strong id="count-trabajadores" style="display:block; font-size:24px; color:#16a34a; margin:8px 0;"><?= $conteos['registro_trabajador'] ?? 0 ?></strong>
        </div>
    </section>

    <!-- Filtros -->
    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:24px;">
        <a href="admin_leads.php?filtro=todos" style="text-decoration:none; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:600; transition:all 0.2s; <?= $filtro === 'todos' ? 'background:var(--sidebar-active); color:white;' : 'background:white; color:var(--text-muted); border:1px solid var(--border-color);' ?>">
            Todos <span style="background:<?= $filtro === 'todos' ? 'rgba(255,255,255,0.2)' : '#f1f5f9' ?>; padding:2px 8px; border-radius:12px; font-size:11px; margin-left:6px;" id="tab-count-total"><?= $conteos['total'] ?? 0 ?></span>
        </a>
        <a href="admin_leads.php?filtro=google_login" style="text-decoration:none; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:600; transition:all 0.2s; <?= $filtro === 'google_login' ? 'background:#2563eb; color:white;' : 'background:white; color:var(--text-muted); border:1px solid var(--border-color);' ?>">
            Google Login <span style="background:<?= $filtro === 'google_login' ? 'rgba(255,255,255,0.2)' : '#f1f5f9' ?>; padding:2px 8px; border-radius:12px; font-size:11px; margin-left:6px;" id="tab-count-google"><?= $conteos['google_login'] ?? 0 ?></span>
        </a>
        <a href="admin_leads.php?filtro=registro_trabajador" style="text-decoration:none; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:600; transition:all 0.2s; <?= $filtro === 'registro_trabajador' ? 'background:#16a34a; color:white;' : 'background:white; color:var(--text-muted); border:1px solid var(--border-color);' ?>">
            Trabajadores <span style="background:<?= $filtro === 'registro_trabajador' ? 'rgba(255,255,255,0.2)' : '#f1f5f9' ?>; padding:2px 8px; border-radius:12px; font-size:11px; margin-left:6px;" id="tab-count-trabajadores"><?= $conteos['registro_trabajador'] ?? 0 ?></span>
        </a>
    </div>

    <section>
        <div style="margin-bottom: 16px;">
            <h2 style="font-size: 16px; color: var(--text-main);">
                <?php
                    $titulos = [
                        'todos' => 'Todos los registros',
                        'google_login' => 'Visitantes con Google Login',
                        'registro_trabajador' => 'Correos de trabajadores registrados'
                    ];
                    echo $titulos[$filtro] ?? 'Registros';
                ?>
            </h2>
        </div>

        <div id="leads-list-container" style="transition: opacity 0.15s ease; display:flex; flex-direction:column; gap:12px;">
            <?php require __DIR__ . '/partials/ajax_leads.php'; ?>
        </div>
    </section>

</main>

<script src="../assets/js/main.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const currentFiltro = new URLSearchParams(window.location.search).get('filtro') || 'todos';
    
    // Función para auto-actualizar los registros sin recargar la página
    function autoUpdateLeads() {
        fetch(`admin_leads.php?filtro=${currentFiltro}&ajax=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.conteos) {
                    // Actualizar contadores principales
                    document.getElementById('count-total').textContent = data.conteos.total || 0;
                    document.getElementById('count-google').textContent = data.conteos.google_login || 0;
                    document.getElementById('count-trabajadores').textContent = data.conteos.registro_trabajador || 0;
                    
                    // Actualizar contadores de las pestañas de filtro
                    document.getElementById('tab-count-total').textContent = data.conteos.total || 0;
                    document.getElementById('tab-count-google').textContent = data.conteos.google_login || 0;
                    document.getElementById('tab-count-trabajadores').textContent = data.conteos.registro_trabajador || 0;
                }
                
                if (data && data.leads_html !== undefined) {
                    const container = document.getElementById('leads-list-container');
                    
                    // Solo actualizamos el DOM si el HTML ha cambiado, para evitar parpadeos
                    if (container.innerHTML !== data.leads_html) {
                        container.style.opacity = '0.5';
                        setTimeout(() => {
                            container.innerHTML = data.leads_html;
                            container.style.opacity = '1';
                        }, 150);
                    }
                }
            })
            .catch(err => console.error("Error al actualizar registros automáticamente:", err));
    }
    
    // Ejecutar cada 4 segundos para un tiempo real ultra-fluido y óptimo
    setInterval(autoUpdateLeads, 4000);
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>


