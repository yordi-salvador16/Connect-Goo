<?php
// app/views/admin/admin_categorias.php
// Variables esperadas: $mensaje, $error, $categorias
$pageTitle = 'Administrar Categorías';
$pageBreadcrumb = 'Gestión > Categorías';
require_once __DIR__ . '/layout/header.php';
?>

<div style="width: 100%; max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom:20px;">
        <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Gestión de Categorías</h2>
        <p style="color:var(--text-muted); font-size:14px;">Agrega, edita, activa o desactiva los servicios visibles para los usuarios.</p>
    </div>

    <?php if ($mensaje): ?>
        <div style="background:#ecfdf5;color:#065f46;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #a7f3d0;">
            <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="background:#fef2f2;color:#991b1b;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #fecaca;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="action-card" style="margin-bottom: 30px;">
        <h3 style="margin-bottom: 16px; display:flex; align-items:center; gap:8px;">
            <i data-lucide="plus-circle" style="color:var(--sidebar-active);"></i> Agregar nueva categoría
        </h3>

        <form method="POST" action="admin_categorias.php" style="display:flex; flex-direction:column; gap:16px;">
            <?= campoCSRF() ?>
            <input type="hidden" name="accion" value="crear">

            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Nombre del servicio *</label>
                <input type="text" name="nombre" placeholder="Ej: Albañilería, Jardinería, Delivery" required style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
            </div>

            <div style="display:flex; flex-direction:column; gap:4px;">
                <label style="font-size:13px; font-weight:600;">Ícono o emoji</label>
                <input type="text" name="icono" placeholder="Ej: 🧱, 🌱, 🛵" value="🔧" style="padding:10px; border:1px solid var(--border-color); border-radius:8px; font-family:inherit;">
            </div>

            <button type="submit" style="background:var(--sidebar-active); color:white; border:none; padding:12px; border-radius:8px; font-weight:600; cursor:pointer; margin-top:8px;">
                Agregar categoría
            </button>
        </form>
    </div>

    <h3 style="margin-bottom: 16px; color:var(--text-main);">Categorías registradas</h3>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
        <?php foreach ($categorias as $categoria): ?>
            <div style="background:white; border-radius:12px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); display:flex; flex-direction:column; overflow:hidden;">
                
                <div style="padding:20px; flex-grow:1;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                        <div style="width:40px; height:40px; background:#f8fafc; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                            <?= htmlspecialchars($categoria['icono'] ?: '🔧', ENT_QUOTES, 'UTF-8') ?>
                        </div>
                        <span style="font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; <?= $categoria['estado'] ? 'background:#ecfdf5;color:#059669;' : 'background:#fef2f2;color:#dc2626;' ?>">
                            <?= $categoria['estado'] ? 'VISIBLE' : 'OCULTO' ?>
                        </span>
                    </div>

                    <h4 style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:4px;">
                        <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                    </h4>
                    <p style="font-size:13px; font-weight:600; color:<?= $categoria['estado'] ? '#059669' : '#dc2626' ?>; margin:0;">
                        Estado: <?= $categoria['estado'] ? 'Activo' : 'Inactivo' ?>
                    </p>
                </div>

                <div style="padding:16px 20px; border-top:1px solid var(--border-color); display:flex; flex-direction:column; gap:12px;">
                    <details style="border:1px solid var(--border-color); border-radius:8px; padding:12px; background:#f8fafc;">
                        <summary style="font-size:13px; font-weight:600; cursor:pointer; color:var(--sidebar-active);">Editar categoría</summary>

                        <form method="POST" action="admin_categorias.php" style="display:flex; flex-direction:column; gap:12px; margin-top:12px; padding-top:12px; border-top:1px solid var(--border-color);">
                            <?= campoCSRF() ?>
                            <input type="hidden" name="accion" value="editar">
                            <input type="hidden" name="categoria_id" value="<?= $categoria['id'] ?>">

                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <label style="font-size:12px; font-weight:600;">Nombre del servicio</label>
                                <input type="text" name="nombre" value="<?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>" required style="padding:8px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; font-family:inherit;">
                            </div>

                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <label style="font-size:12px; font-weight:600;">Ícono o emoji</label>
                                <input type="text" name="icono" value="<?= htmlspecialchars($categoria['icono'] ?: '🔧', ENT_QUOTES, 'UTF-8') ?>" style="padding:8px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; font-family:inherit;">
                            </div>

                            <button type="submit" style="background:#3b82f6; color:white; border:none; padding:10px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                Guardar
                            </button>
                        </form>
                    </details>

                    <form method="POST" action="admin_categorias.php" style="margin:0;">
                        <?= campoCSRF() ?>
                        <input type="hidden" name="accion" value="cambiar_estado">
                        <input type="hidden" name="categoria_id" value="<?= $categoria['id'] ?>">
                        <input type="hidden" name="nuevo_estado" value="<?= $categoria['estado'] ? 0 : 1 ?>">

                        <?php if ($categoria['estado']): ?>
                            <button type="submit" style="width:100%; background:#fff; color:#ef4444; border:1px solid #fecaca; padding:10px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                Desactivar (Ocultar)
                            </button>
                        <?php else: ?>
                            <button type="submit" style="width:100%; background:#fff; color:#10b981; border:1px solid #a7f3d0; padding:10px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                Activar (Mostrar)
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
