<?php
// app/views/admin/admin_usuarios.php
// Variables esperadas: $mensaje, $errorMsg, $usuarios, $adminActual
$pageTitle = 'Gestión de Administradores';
$pageBreadcrumb = 'Configuración > Administradores';
require_once __DIR__ . '/layout/header.php';
?>

<div style="width: 100%; max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom:20px;">
        <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Gestión de Administradores</h2>
        <p style="color:var(--text-muted); font-size:14px;">Crea o elimina accesos para el equipo de Connectgoo.</p>
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
            <i data-lucide="user-plus" style="color:var(--sidebar-active);"></i> Crear nuevo administrador
        </h3>

        <form action="" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:16px;">
            <?= campoCSRF() ?>
            <input type="hidden" name="accion" value="crear">

            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Nombre completo</label>
                <input type="text" name="nombre" placeholder="Ej: Juan Perez" required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
            </div>
            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Nombre de usuario</label>
                <input type="text" name="usuario" placeholder="Ej: juan.perez" required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
            </div>
            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Contraseña</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
            </div>
            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Rol de acceso</label>
                <select name="rol" required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit; background:white;">
                    <option value="admin">Administrador (Ver ingresos y aprobar)</option>
                    <option value="moderador">Moderador (Solo aprobar/rechazar)</option>
                    <option value="superadmin">Super Administrador (Control total)</option>
                </select>
            </div>
            
            <div style="grid-column: 1 / -1;">
                <button type="submit" style="width:100%; background:var(--sidebar-active); color:white; border:none; padding:12px; border-radius:8px; font-weight:600; cursor:pointer; margin-top:8px;">
                    Crear cuenta de acceso
                </button>
            </div>
        </form>
    </div>

    <h3 style="margin-bottom: 16px; color:var(--text-main);">Usuarios con acceso</h3>

    <div style="display:flex; flex-direction:column; gap:16px;">
        <?php foreach ($usuarios as $u): ?>
            <div style="background:white; border-radius:12px; padding:20px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); display:flex; flex-wrap:wrap; gap:16px; justify-content:space-between; align-items:center;">
                
                <div style="display:flex; align-items:center; gap:16px;">
                    <div style="width:48px; height:48px; background:#f8fafc; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; color:var(--sidebar-active);">
                        <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                    </div>
                    <div>
                        <h4 style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:2px;">
                            <?= htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8') ?>
                        </h4>
                        <p style="font-size:13px; color:var(--text-muted); margin-bottom:4px;">
                            Usuario: <code><?= htmlspecialchars($u['usuario'], ENT_QUOTES, 'UTF-8') ?></code>
                        </p>
                        <p style="font-size:11px; color:#94a3b8;">
                            Último acceso: <?= $u['ultimo_acceso'] ?? 'Nunca' ?>
                        </p>
                    </div>
                </div>
                
                <div style="display:flex; flex-direction:column; align-items:flex-end; gap:12px;">
                    <span style="font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; <?= $u['rol'] === 'superadmin' ? 'background:#ecfdf5;color:#059669;' : ($u['rol'] === 'admin' ? 'background:#fffbeb;color:#d97706;' : 'background:#f1f5f9;color:#475569;') ?>">
                        <?= strtoupper($u['rol']) ?>
                    </span>
                    
                    <?php if (intval($u['id']) !== intval($adminActual['id'])): ?>
                        <form action="" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este acceso?');">
                            <?= campoCSRF() ?>
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <button type="submit" style="background:none; border:none; color:#ef4444; font-size:13px; font-weight:600; cursor:pointer; text-decoration:underline;">
                                Eliminar
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
