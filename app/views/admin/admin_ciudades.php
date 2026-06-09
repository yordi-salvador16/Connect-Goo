<?php
// app/views/admin/admin_ciudades.php
// Variables esperadas: $mensaje, $errorMsg, $ciudades
$pageTitle = 'Gestión de Ciudades';
$pageBreadcrumb = 'Gestión > Ciudades';
require_once __DIR__ . '/layout/header.php';
?>

<div style="width: 100%; max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom:20px;">
        <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Gestión de Ciudades</h2>
        <p style="color:var(--text-muted); font-size:14px;">Controla en qué ciudades está disponible Connectgoo.</p>
    </div>

    <?php if ($mensaje): ?>
        <div style="background:#ecfdf5;color:#065f46;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #a7f3d0;">
            <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div style="background:#fef2f2;color:#991b1b;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #fecaca;">
            <?= htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="action-card" style="margin-bottom: 30px;">
        <h3 style="margin-bottom: 16px; display:flex; align-items:center; gap:8px;">
            <i data-lucide="plus-circle" style="color:var(--sidebar-active);"></i> Añadir nueva ciudad
        </h3>

        <form action="" method="POST" style="display:flex; flex-direction:column; gap:16px;">
            <?= campoCSRF() ?>
            <input type="hidden" name="accion" value="crear">
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
                <div style="display:flex; flex-direction:column; gap:4px;">
                    <label style="font-size:13px; font-weight:600;">Nombre de la ciudad *</label>
                    <input type="text" name="nombre" placeholder="Ej: Lima, Cusco..." required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
                </div>
                
                <div style="display:flex; flex-direction:column; gap:4px;">
                    <label style="font-size:13px; font-weight:600;">Departamento / Región</label>
                    <input type="text" name="departamento" placeholder="Ej: Lima, Cusco..." style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="activa" id="activa" checked style="width:16px; height:16px; accent-color:var(--sidebar-active);">
                <label for="activa" style="font-size:14px; font-weight:500; cursor:pointer;">Activar inmediatamente</label>
            </div>

            <button type="submit" style="background:var(--sidebar-active); color:white; border:none; padding:12px; border-radius:8px; font-weight:600; cursor:pointer; margin-top:8px;">
                Registrar ciudad
            </button>
        </form>
    </div>

    <h3 style="margin-bottom: 16px; color:var(--text-main);">Ciudades registradas</h3>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
        <?php foreach ($ciudades as $c): ?>
            <div style="background:white; border-radius:12px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); display:flex; flex-direction:column; overflow:hidden;">
                
                <div style="padding:20px; flex-grow:1;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                        <div style="width:40px; height:40px; background:#f8fafc; border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--sidebar-active);">
                            <i data-lucide="map-pin"></i>
                        </div>
                        <span style="font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; <?= $c['activa'] ? 'background:#ecfdf5;color:#059669;' : 'background:#fef2f2;color:#dc2626;' ?>">
                            <?= $c['activa'] ? 'ACTIVA' : 'INACTIVA' ?>
                        </span>
                    </div>

                    <h4 style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:4px;">
                        <?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:8px;">
                        <?= htmlspecialchars($c['departamento'] ?? '-', ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($c['pais'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <p style="font-size:11px; font-family:monospace; color:#94a3b8; margin:0;">
                        Slug: <?= htmlspecialchars($c['slug'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                
                <div style="padding:12px 20px; border-top:1px solid var(--border-color); background:#f8fafc; display:flex; justify-content:flex-end;">
                    <form action="" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta ciudad?');" style="margin:0;">
                        <?= campoCSRF() ?>
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" style="background:#fef2f2; border:1px solid #fecaca; color:#ef4444; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
