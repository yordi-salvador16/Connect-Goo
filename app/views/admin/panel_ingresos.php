<?php
// app/views/admin/panel_ingresos.php
// Variables esperadas: $mensaje, $totalIngresos, $ingresosPlanes, $planesActivos, 
// $ingresosPublicidad, $anunciosActivos, $publicidadPendiente, $trabajadores, $publicidades
$pageTitle = 'Panel de Ingresos';
$pageBreadcrumb = 'Reportes > Ingresos';
require_once __DIR__ . '/layout/header.php';
?>

<div style="max-width: 1000px;">
    
    <div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:flex-end;">
        <div>
            <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Panel de ingresos</h2>
            <p style="color:var(--text-muted); font-size:14px;">Controla planes de trabajadores, publicidad local y anuncios activos de Connectgoo.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="panel_admin.php" style="background:white; border:1px solid var(--border-color); padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; color:var(--text-main); text-decoration:none;">Trabajadores</a>
            <a href="admin_categorias.php" style="background:white; border:1px solid var(--border-color); padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; color:var(--text-main); text-decoration:none;">Categorías</a>
        </div>
    </div>

    <?php if ($mensaje): ?>
        <div style="background:#ecfdf5;color:#065f46;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:600;border:1px solid #a7f3d0;">
            <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div style="background:white; border:2px solid var(--sidebar-active); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Total estimado</span>
            <strong style="display:block; font-size:24px; color:var(--sidebar-active); margin:8px 0;"><?= precioTexto($totalIngresos) ?></strong>
            <p style="font-size:12px; color:#64748b; margin:0;">Planes + publicidad aprobada</p>
        </div>

        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Planes trabajadores</span>
            <strong style="display:block; font-size:24px; color:#10b981; margin:8px 0;"><?= precioTexto($ingresosPlanes) ?></strong>
            <p style="font-size:12px; color:#64748b; margin:0;"><?= intval($planesActivos) ?> planes activos</p>
        </div>

        <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Publicidad aprobada</span>
            <strong style="display:block; font-size:24px; color:#10b981; margin:8px 0;"><?= precioTexto($ingresosPublicidad) ?></strong>
            <p style="font-size:12px; color:#64748b; margin:0;"><?= intval($anunciosActivos) ?> anuncios activos</p>
        </div>

        <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
            <span style="font-size:13px; font-weight:600; color:#b45309;">Por revisar</span>
            <strong style="display:block; font-size:24px; color:#d97706; margin:8px 0;"><?= intval($publicidadPendiente) ?></strong>
            <p style="font-size:12px; color:#b45309; margin:0;">Solicitudes pendientes</p>
        </div>
    </section>

    <section style="margin-bottom: 40px;">
        <div style="margin-bottom: 16px;">
            <h2 style="font-size: 16px; color: var(--text-main);">Trabajadores con planes</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Perfiles aprobados que generan ingresos o visibilidad dentro de la plataforma.</p>
        </div>

        <?php if (count($trabajadores) === 0): ?>
            <div style="background:white; border:1px dashed var(--border-color); border-radius:12px; padding:30px; text-align:center; color:var(--text-muted);">
                <p>No hay trabajadores aprobados todavía</p>
            </div>
        <?php else: ?>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <?php foreach ($trabajadores as $trabajador): ?>
                    <div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
                        <div>
                            <strong style="font-size:15px; color:var(--text-main);"><?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <p style="margin:4px 0 0 0; font-size:13px; color:var(--text-muted);">
                                <?= htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8') ?>
                                · Plan <span style="font-weight:600;"><?= htmlspecialchars($trabajador['plan_nombre'] ?? 'Sin plan', ENT_QUOTES, 'UTF-8') ?></span>
                            </p>
                        </div>
                        <span style="font-weight:800; font-size:16px; color:#10b981;">
                            <?= precioTexto($trabajador['precio'] ?? 0) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section>
        <div style="margin-bottom: 16px;">
            <h2 style="font-size: 16px; color: var(--text-main);">Solicitudes de publicidad</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Revisa anuncios, duración, vencimiento, ubicación y datos del negocio.</p>
        </div>

        <?php if (count($publicidades) === 0): ?>
            <div style="background:white; border:1px dashed var(--border-color); border-radius:12px; padding:30px; text-align:center; color:var(--text-muted);">
                <p>No hay solicitudes de publicidad</p>
            </div>
        <?php else: ?>

            <div style="display:flex; flex-direction:column; gap:16px;">
                <?php foreach ($publicidades as $pub): ?>
                    <?php
                        $dias = diasRestantes($pub['fecha_fin'] ?? null);
                        $esAprobado = (($pub['estado'] ?? '') === 'aprobado');
                    ?>

                    <?php if ($esAprobado): ?>
                        <!-- VERSIÓN COMPACTA PARA PUBLICIDADES APROBADAS -->
                        <div style="background:white; border:1px solid var(--border-color); border-left:4px solid #10b981; border-radius:12px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 2px rgba(0,0,0,0.02);">
                            <div style="display:flex; align-items:center; gap:16px;">
                                <div style="width:40px; height:40px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                                    <?php if (!empty($pub['imagen_negocio'])): ?>
                                        <img src="<?= htmlspecialchars($pub['imagen_negocio'], ENT_QUOTES, 'UTF-8') ?>" style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <span style="font-weight:bold; color:#64748b;"><?= strtoupper(substr($pub['nombre_negocio'], 0, 1)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <strong style="font-size:15px; color:var(--text-main); display:flex; align-items:center; gap:8px;">
                                        <?= htmlspecialchars($pub['nombre_negocio'], ENT_QUOTES, 'UTF-8') ?>
                                        <span style="font-size:10px; background:#dcfce7; color:#15803d; padding:2px 6px; border-radius:4px;">
                                            <?= htmlspecialchars(etiquetaEstadoPublicidad($pub), ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </strong>
                                    <p style="margin:4px 0 0 0; font-size:12px; color:var(--text-muted);">
                                        <?= htmlspecialchars($pub['tipo_publicidad'], ENT_QUOTES, 'UTF-8') ?> · 
                                        Vence: <strong><?= fechaTexto($pub['fecha_fin'] ?? null) ?></strong> (<?= intval($dias) ?> días restantes)
                                    </p>
                                </div>
                            </div>
                            
                            <div style="display:flex; align-items:center; gap:16px;">
                                <span style="font-weight:800; font-size:16px; color:#10b981;">
                                    <?= precioTexto($pub['monto'] ?? 0) ?>
                                </span>
                                
                                <form method="POST" action="panel_ingresos.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente esta publicidad?');">
                                    <?= campoCSRF() ?>
                                    <input type="hidden" name="publicidad_id" value="<?= intval($pub['id']) ?>">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <button type="submit" style="background:none; border:none; color:#ef4444; font-size:13px; font-weight:600; cursor:pointer; text-decoration:underline;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- VERSIÓN COMPLETA PARA PUBLICIDADES PENDIENTES O RECHAZADAS -->
                        <article class="request-card income-ad-card" style="background:white; border-radius:16px; border:1px solid var(--border-color); overflow:hidden; display:flex; box-shadow:var(--shadow-sm);">
                            <div style="width:250px; background:#f8fafc; flex-shrink:0;">
                                <?php if (!empty($pub['imagen_negocio'])): ?>
                                    <img src="<?= htmlspecialchars($pub['imagen_negocio'], ENT_QUOTES, 'UTF-8') ?>" style="width:100%; height:100%; object-fit:cover;">
                                <?php else: ?>
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:48px; font-weight:900; color:#cbd5e1;">
                                        <?= strtoupper(substr($pub['nombre_negocio'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column;">
                                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                                    <div>
                                        <h2 style="font-size:18px; margin:0 0 4px 0; color:var(--text-main);"><?= htmlspecialchars($pub['nombre_negocio'], ENT_QUOTES, 'UTF-8') ?></h2>
                                        <p style="font-size:13px; color:var(--sidebar-active); font-weight:600; margin:0;">
                                            <?= htmlspecialchars($pub['tipo_publicidad'], ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    </div>
                                    <span style="font-size:12px; font-weight:700; padding:4px 10px; border-radius:20px; <?= (($pub['estado'] ?? '') === 'pendiente') ? 'background:#fef9c3;color:#a16207;' : 'background:#fee2e2;color:#b91c1c;' ?>">
                                        <?= htmlspecialchars(estadoTexto($pub['estado'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>

                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:13px; color:var(--text-muted); margin-bottom:16px;">
                                    <p style="margin:0;"><strong>Tipo:</strong> <?= htmlspecialchars($pub['tipo_negocio'] ?? 'No registrado', ENT_QUOTES, 'UTF-8') ?></p>
                                    <p style="margin:0;"><strong>Zona:</strong> <?= htmlspecialchars($pub['zona'] ?? 'No registrada', ENT_QUOTES, 'UTF-8') ?></p>
                                    <p style="margin:0;"><strong>WhatsApp:</strong> <?= htmlspecialchars($pub['whatsapp'] ?? 'No registrado', ENT_QUOTES, 'UTF-8') ?></p>
                                    <p style="margin:0;"><strong>Monto:</strong> <span style="color:#10b981; font-weight:bold;"><?= precioTexto($pub['monto'] ?? 0) ?></span></p>
                                    <p style="margin:0;"><strong>Duración:</strong> <?= htmlspecialchars($pub['duracion_dias'] ?? '0', ENT_QUOTES, 'UTF-8') ?> días</p>
                                    <p style="margin:0;"><strong>Categoría:</strong> <?= htmlspecialchars($pub['categoria_nombre'] ?? 'No aplica', ENT_QUOTES, 'UTF-8') ?></p>
                                </div>

                                <?php if (($pub['estado'] ?? '') === 'pendiente'): ?>
                                    <div style="display:flex; gap:12px; margin-top:auto; padding-top:16px; border-top:1px solid var(--border-color);">
                                        <form method="POST" action="panel_ingresos.php" style="flex:1;">
                                            <?= campoCSRF() ?>
                                            <input type="hidden" name="publicidad_id" value="<?= intval($pub['id']) ?>">
                                            <input type="hidden" name="accion" value="aprobar">
                                            <button type="submit" style="width:100%; background:#10b981; color:white; border:none; padding:10px; border-radius:8px; font-weight:600; cursor:pointer;">
                                                Aprobar publicidad
                                            </button>
                                        </form>

                                        <form method="POST" action="panel_ingresos.php">
                                            <?= campoCSRF() ?>
                                            <input type="hidden" name="publicidad_id" value="<?= intval($pub['id']) ?>">
                                            <input type="hidden" name="accion" value="rechazar">
                                            <button type="submit" style="background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:10px 16px; border-radius:8px; font-weight:600; cursor:pointer;">
                                                Rechazar
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="panel_ingresos.php" onsubmit="return confirm('¿Eliminar esta solicitud permanentemente?');">
                                            <?= campoCSRF() ?>
                                            <input type="hidden" name="publicidad_id" value="<?= intval($pub['id']) ?>">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <button type="submit" style="background:white; color:#ef4444; border:1px solid #fca5a5; padding:10px 16px; border-radius:8px; font-weight:600; cursor:pointer;">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (($pub['estado'] ?? '') === 'rechazado'): ?>
                                     <div style="margin-top:auto; padding-top:16px; border-top:1px solid var(--border-color);">
                                         <form method="POST" action="panel_ingresos.php" onsubmit="return confirm('¿Eliminar permanentemente?');">
                                             <?= campoCSRF() ?>
                                             <input type="hidden" name="publicidad_id" value="<?= intval($pub['id']) ?>">
                                             <input type="hidden" name="accion" value="eliminar">
                                             <button type="submit" style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:8px 16px; border-radius:8px; font-weight:600; cursor:pointer;">
                                                 Eliminar permanentemente
                                             </button>
                                         </form>
                                     </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </section>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
