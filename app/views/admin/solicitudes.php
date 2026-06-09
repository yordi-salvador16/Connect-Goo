<?php
// app/views/admin/solicitudes.php
$pageTitle = 'Solicitudes y Trabajadores';
$pageBreadcrumb = 'Gestión > Solicitudes';
require_once __DIR__ . '/layout/header.php';
?>

<?php if ($errorMsg): ?>
    <div style="background:#fef2f2;color:#991b1b;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #fecaca;">
        <?= htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if ($mensaje): ?>
    <div style="background:#ecfdf5;color:#065f46;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #a7f3d0;">
        <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<!-- Summary Cards para estados -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">PENDIENTES</span>
            <span class="stat-value" id="count-pendiente"><?= $totalPendientes ?></span>
        </div>
        <div class="stat-icon icon-yellow">
            <i data-lucide="clock"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">APROBADOS</span>
            <span class="stat-value" id="count-aprobado"><?= $totalAprobados ?></span>
        </div>
        <div class="stat-icon icon-green">
            <i data-lucide="check-circle"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-title">RECHAZADOS</span>
            <span class="stat-value" id="count-rechazado"><?= $totalRechazados ?></span>
        </div>
        <div class="stat-icon" style="background:#fef2f2;color:#dc2626;">
            <i data-lucide="x-circle"></i>
        </div>
    </div>
</div>

<!-- TABS de Navegación -->
<div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;background:white;padding:10px;border-radius:12px;box-shadow:var(--shadow-sm);border:1px solid var(--border-color);">
    <a href="panel_admin.php?estado=pendiente" style="flex:1;text-align:center;padding:10px 10px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;transition:all 0.2s;<?= $estado === 'pendiente' ? 'background:#10b981;color:white;' : 'background:transparent;color:var(--text-muted);' ?>">
        Pendientes
    </a>
    <a href="panel_admin.php?estado=aprobado" style="flex:1;text-align:center;padding:10px 10px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;transition:all 0.2s;<?= $estado === 'aprobado' ? 'background:#10b981;color:white;' : 'background:transparent;color:var(--text-muted);' ?>">
        Aprobados
    </a>
    <a href="panel_admin.php?estado=rechazado" style="flex:1;text-align:center;padding:10px 10px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;transition:all 0.2s;<?= $estado === 'rechazado' ? 'background:#10b981;color:white;' : 'background:transparent;color:var(--text-muted);' ?>">
        Rechazados
    </a>
</div>

<!-- Listado Container -->
<div id="trabajadores-list-container" style="transition: opacity 0.15s ease;">
    <?php if (count($trabajadores) === 0): ?>
        <div style="background:white;padding:50px;border-radius:16px;text-align:center;border:1px solid var(--border-color);">
            <i data-lucide="inbox" style="width:48px;height:48px;color:#cbd5e1;margin-bottom:16px;"></i>
            <h2 style="font-size:18px;color:var(--text-main);margin-bottom:8px;">No hay solicitudes en estado <?= htmlspecialchars(estadoTexto($estado), ENT_QUOTES, 'UTF-8') ?></h2>
            <p style="color:var(--text-muted);font-size:14px;">Cuando los trabajadores se registren, aparecerán aquí para su revisión.</p>
        </div>
    <?php else: ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(340px, 1fr));gap:20px;">
            <?php foreach ($trabajadores as $trabajador): ?>
                <article style="background:white;border-radius:16px;padding:24px;border:1px solid var(--border-color);box-shadow:var(--shadow-sm);">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                        <div>
                            <h2 style="font-size:18px;font-weight:700;color:var(--text-main);margin-bottom:4px;display:flex;align-items:center;gap:8px;">
                                <?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                <?php if (isset($trabajador['registrado_con_google']) && intval($trabajador['registrado_con_google']) === 1): ?>
                                    <span style="font-size:10px;background:#e0f2fe;color:#0369a1;padding:2px 8px;border-radius:20px;font-weight:700;display:flex;align-items:center;gap:4px;border:1px solid #bae6fd;">🔑 Google</span>
                                <?php endif; ?>
                            </h2>
                            <p style="font-size:14px;color:var(--sidebar-active);font-weight:600;"><?= htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;
                            <?= $trabajador['estado'] === 'pendiente' ? 'background:#fffbeb;color:#d97706;' : 
                               ($trabajador['estado'] === 'aprobado' ? 'background:#ecfdf5;color:#059669;' : 'background:#fef2f2;color:#dc2626;') ?>">
                            <?= htmlspecialchars(estadoTexto($trabajador['estado']), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>

                    <div style="font-size:13px;color:var(--text-muted);display:flex;flex-direction:column;gap:8px;margin-bottom:16px;background:#f8fafc;padding:16px;border-radius:12px;">
                        <p><strong style="color:var(--text-main);">Zona:</strong> <?= htmlspecialchars($trabajador['zona'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><strong style="color:var(--text-main);">WhatsApp:</strong> <?= htmlspecialchars($trabajador['whatsapp'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><strong style="color:var(--text-main);">Experiencia:</strong> <?= htmlspecialchars($trabajador['experiencia'], ENT_QUOTES, 'UTF-8') ?> años</p>
                        <p><strong style="color:var(--text-main);">Plan:</strong> <?= htmlspecialchars($trabajador['plan_nombre'] ?? 'Sin plan', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <details style="margin-bottom:16px;border:1px solid var(--border-color);border-radius:8px;padding:10px;">
                        <summary style="font-size:13px;font-weight:600;cursor:pointer;color:var(--text-main);">Ver más detalles</summary>
                        <div style="font-size:13px;color:var(--text-muted);display:flex;flex-direction:column;gap:8px;margin-top:10px;padding-top:10px;border-top:1px solid var(--border-color);">
                            <p><strong>Especialidad:</strong> <?= htmlspecialchars($trabajador['especialidad'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Descripción:</strong> <?= htmlspecialchars($trabajador['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Categoría:</strong> <?= htmlspecialchars($trabajador['categoria_nombre'] ?? 'Sin categoría', ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Disponibilidad:</strong> <?= htmlspecialchars($trabajador['disponibilidad'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Horario:</strong> <?= htmlspecialchars($trabajador['horario_atencion'] ?? 'No registrado', ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Referencia:</strong> <?= htmlspecialchars($trabajador['referencia_zona'] ?? 'No registrada', ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($trabajador['created_at'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    </details>

                    <?php if (adminTieneRol($adminActual, ['superadmin', 'admin'])): ?>
                    <details style="margin-bottom:16px;border:1px solid var(--border-color);border-radius:8px;padding:10px;">
                        <summary style="font-size:13px;font-weight:600;cursor:pointer;color:#3b82f6;">Editar datos del trabajador</summary>
                        <form method="POST" action="panel_admin.php?estado=<?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>" style="display:flex;flex-direction:column;gap:12px;margin-top:10px;padding-top:10px;border-top:1px solid var(--border-color);">
                            <?= campoCSRF() ?>
                            <input type="hidden" name="trabajador_id" value="<?= intval($trabajador['id']) ?>">
                            <input type="hidden" name="accion" value="guardar_edicion">
                            <input type="hidden" name="servicio" value="<?= htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8') ?>">
                            
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Nombre completo</label>
                                <input type="text" name="nombre" value="<?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?>" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                            </div>
                            
                            <!-- Select Categoria y Plan omitidos en el CSS inline por simplicidad, pero mantienen la estructura -->
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Categoría</label>
                                <select name="categoria_id" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= intval($categoria['id']) ?>" <?= selectedOption($trabajador['categoria_id'], $categoria['id']) ?>>
                                            <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Plan</label>
                                <select name="plan_id" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                                    <?php foreach ($planes as $plan): ?>
                                        <option value="<?= intval($plan['id']) ?>" <?= selectedOption($trabajador['plan_id'], $plan['id']) ?>>
                                            <?= htmlspecialchars($plan['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">WhatsApp</label>
                                <input type="text" name="whatsapp" value="<?= htmlspecialchars($trabajador['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                            </div>
                            
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Zona</label>
                                <input type="text" name="zona" value="<?= htmlspecialchars($trabajador['zona'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                            </div>
                            
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Descripción</label>
                                <textarea name="descripcion" rows="3" required style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;resize:vertical;"><?= htmlspecialchars($trabajador['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <label style="font-size:12px;font-weight:600;">Foto URL (Opcional)</label>
                                <input type="text" name="foto_perfil" value="<?= htmlspecialchars($trabajador['foto_perfil'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="padding:8px;border:1px solid #cbd5e1;border-radius:6px;font-family:inherit;">
                            </div>

                            <button type="submit" style="background:#3b82f6;color:white;border:none;padding:10px;border-radius:8px;font-weight:600;cursor:pointer;margin-top:10px;">Guardar cambios</button>
                        </form>
                    </details>
                    <?php endif; ?>

                    <div style="display:flex;gap:10px;margin-top:10px;">
                        <?php if ($trabajador['estado'] === 'pendiente'): ?>
                            <form method="POST" action="panel_admin.php?estado=pendiente" style="flex:1;">
                                <?= campoCSRF() ?>
                                <input type="hidden" name="trabajador_id" value="<?= intval($trabajador['id']) ?>">
                                <input type="hidden" name="accion" value="aprobar">
                                <button type="submit" style="width:100%;background:#10b981;color:white;border:none;padding:12px;border-radius:8px;font-weight:700;cursor:pointer;transition:all 0.2s;">Aprobar</button>
                            </form>
                            <form method="POST" action="panel_admin.php?estado=pendiente" style="flex:1;">
                                <?= campoCSRF() ?>
                                <input type="hidden" name="trabajador_id" value="<?= intval($trabajador['id']) ?>">
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit" style="width:100%;background:#ef4444;color:white;border:none;padding:12px;border-radius:8px;font-weight:700;cursor:pointer;transition:all 0.2s;">Rechazar</button>
                            </form>
                        <?php endif; ?>

                        <?php if ($trabajador['estado'] === 'aprobado' && adminTieneRol($adminActual, ['superadmin', 'admin'])): ?>
                            <a target="_blank" href="../perfil.php?id=<?= intval($trabajador['id']) ?>" style="flex:1;text-align:center;background:#f1f5f9;color:#334155;border:1px solid #e2e8f0;padding:12px;border-radius:8px;font-weight:700;text-decoration:none;">Ver perfil público</a>
                            
                            <form method="POST" action="panel_admin.php?estado=aprobado" onsubmit="return confirm('¿Seguro que deseas eliminar este perfil aprobado?');" style="flex:1;">
                                <?= campoCSRF() ?>
                                <input type="hidden" name="trabajador_id" value="<?= intval($trabajador['id']) ?>">
                                <input type="hidden" name="accion" value="eliminar_aprobado">
                                <button type="submit" style="width:100%;background:#fef2f2;color:#ef4444;border:1px solid #fecaca;padding:12px;border-radius:8px;font-weight:700;cursor:pointer;">Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const currentEstado = new URLSearchParams(window.location.search).get('estado') || 'pendiente';
    
    // Auto-refresh simple en solicitudes si no hay modales abiertos
    setInterval(() => {
        if (!document.querySelector('details[open]')) {
            // Un refresh simple a la página para mantener sincronizados los nuevos registros,
            // pero omitimos esta parte compleja de AJAX por la simplicidad de la migración MVC
            // window.location.reload(); 
        }
    }, 60000); // 1 minuto
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
