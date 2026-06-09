<?php
// app/views/admin/admin_ajustes.php
// Variables esperadas: $mensajePerfil, $errorPerfil, $mensajePassword, $errorPassword, $adminData
$pageTitle = 'Ajustes';
$pageBreadcrumb = 'Ajustes';
require_once __DIR__ . '/layout/header.php';
?>

<div style="width: 100%; max-width: 1200px; margin: 0 auto;">

    <div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:flex-end;">
        <div>
            <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">⚙️ Ajustes de administrador</h2>
            <p style="color:var(--text-muted); font-size:14px;">Gestiona tu perfil, contraseña y configuración de seguridad.</p>
        </div>
    </div>

    <!-- INFORMACIÓN DE SESIÓN -->
    <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Rol actual</span>
            <strong style="display:block; font-size:18px; color:#10b981; margin:8px 0;"><?= htmlspecialchars(textoRol($adminData['rol'] ?? 'admin'), ENT_QUOTES, 'UTF-8') ?></strong>
        </div>

        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Usuario</span>
            <strong style="display:block; font-size:18px; color:var(--sidebar-active); margin:8px 0;"><?= htmlspecialchars($adminData['usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </div>

        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Último acceso</span>
            <strong style="display:block; font-size:16px; color:var(--text-main); margin:8px 0;">
                <?php if (!empty($adminData['ultimo_acceso'])): ?>
                    <?= date('d/m/Y H:i', strtotime($adminData['ultimo_acceso'])) ?>
                <?php else: ?>
                    Primera sesión
                <?php endif; ?>
            </strong>
        </div>
    </section>

    <!-- 2-COLUMN LAYOUT -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px; align-items: start;">
        
        <!-- LEFT COLUMN: EDITAR PERFIL -->
        <section style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:24px; box-shadow:var(--shadow-sm);">
            <h2 style="font-size:16px; margin-bottom: 16px; color: var(--text-main); display:flex; align-items:center; gap:8px;">
                <i data-lucide="user" style="width:18px;height:18px;color:#10b981;"></i> Mi perfil
            </h2>

            <?php if ($mensajePerfil): ?>
                <div style="background:#ecfdf5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-weight:600;border:1px solid #a7f3d0;font-size:14px;">
                    <?= htmlspecialchars($mensajePerfil, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <?php if ($errorPerfil): ?>
                <div style="background:#fef2f2;color:#b91c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-weight:600;border:1px solid #fecaca;font-size:14px;">
                    <?= htmlspecialchars($errorPerfil, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="admin_ajustes.php" style="display:flex; flex-direction:column; gap:16px;">
                <?= campoCSRF() ?>
                <input type="hidden" name="accion" value="actualizar_perfil">

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px;">Nombre completo</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($adminData['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required style="width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-family:inherit;">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px;">Nombre de usuario</label>
                    <input type="text" name="usuario" value="<?= htmlspecialchars($adminData['usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required minlength="3" style="width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-family:inherit;">
                </div>

                <div style="background:#f8fafc; padding:12px; border-radius:8px; border-left:4px solid #94a3b8; font-size:13px; color:var(--text-muted);">
                    El nombre de usuario se utiliza para iniciar sesión. Asegúrate de recordarlo.
                </div>

                <button type="submit" style="background:#10b981; color:white; border:none; padding:12px 20px; border-radius:8px; font-weight:600; cursor:pointer; align-self:flex-start; margin-top:8px;">Guardar cambios</button>
            </form>
        </section>

        <!-- RIGHT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- CAMBIAR CONTRASEÑA -->
            <section style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:24px; box-shadow:var(--shadow-sm);">
                <h2 style="font-size:16px; margin-bottom: 16px; color: var(--text-main); display:flex; align-items:center; gap:8px;">
                    <i data-lucide="key" style="width:18px;height:18px;color:#4f46e5;"></i> Cambiar contraseña
                </h2>

                <?php if ($mensajePassword): ?>
                    <div style="background:#ecfdf5;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-weight:600;border:1px solid #a7f3d0;font-size:14px;">
                        <?= htmlspecialchars($mensajePassword, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if ($errorPassword): ?>
                    <div style="background:#fef2f2;color:#b91c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-weight:600;border:1px solid #fecaca;font-size:14px;">
                        <?= htmlspecialchars($errorPassword, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="admin_ajustes.php" style="display:flex; flex-direction:column; gap:16px;">
                    <?= campoCSRF() ?>
                    <input type="hidden" name="accion" value="cambiar_password">

                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px;">Contraseña actual</label>
                        <input type="password" name="password_actual" placeholder="••••••••" required style="width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-family:inherit;">
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:16px;">
                        <div>
                            <label style="display:block; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px;">Nueva contraseña</label>
                            <input type="password" name="password_nueva" placeholder="Mínimo 6" required minlength="6" style="width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-family:inherit;">
                        </div>
                        <div>
                            <label style="display:block; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px;">Confirmar nueva</label>
                            <input type="password" name="password_confirmar" placeholder="Mínimo 6" required minlength="6" style="width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; font-family:inherit;">
                        </div>
                    </div>

                    <button type="submit" style="background:#4f46e5; color:white; border:none; padding:12px 20px; border-radius:8px; font-weight:600; cursor:pointer; align-self:flex-start; margin-top:8px;">Actualizar contraseña</button>
                </form>
            </section>

            <!-- SEGURIDAD -->
            <section style="background:white; border:1px solid #fecaca; border-radius:12px; padding:24px; box-shadow:var(--shadow-sm);">
                <h2 style="font-size:16px; margin-bottom: 16px; color: #b91c1c; display:flex; align-items:center; gap:8px;">
                    <i data-lucide="shield-alert" style="width:18px;height:18px;"></i> Seguridad
                </h2>

                <div style="background:#fef2f2; padding:12px 16px; border-radius:8px; border:1px solid #fecaca; font-size:13px; color:#991b1b; margin-bottom:16px;">
                    <strong style="display:block; margin-bottom:4px;">Token de sesión activo</strong>
                    Tu sesión está protegida con un token único. Si sospechas acceso no autorizado, invalida el token actual cerrando sesión.
                </div>

                <a href="login_admin.php?logout=1" style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:white; padding:12px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none; justify-content:center;">
                    <i data-lucide="log-out" style="width:16px;height:16px;"></i> Cerrar sesión
                </a>
            </section>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
