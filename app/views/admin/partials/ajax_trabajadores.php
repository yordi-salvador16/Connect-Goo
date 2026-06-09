<?php
// app/views/admin/partials/ajax_trabajadores.php
// Variables esperadas: $trabajadores, $estado, $adminActual, $categorias, $planes, $csrfToken

if (count($trabajadores) === 0): ?>
    <div class="cg-empty-state">
        <div class="cg-empty-icon">
            <i data-lucide="inbox"></i>
        </div>
        <h3 class="cg-empty-title">No hay solicitudes en estado <?= htmlspecialchars(estadoTexto($estado), ENT_QUOTES, 'UTF-8') ?></h3>
        <p class="cg-empty-desc">Cuando los trabajadores se registren, aparecerán aquí para su revisión.</p>
    </div>
<?php else:
    foreach ($trabajadores as $trabajador):
        $tId = intval($trabajador['id']);
        $nombre = htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8');
        $servicio = htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8');
        $zona = htmlspecialchars($trabajador['zona'], ENT_QUOTES, 'UTF-8');
        $whatsapp = htmlspecialchars($trabajador['whatsapp'], ENT_QUOTES, 'UTF-8');
        $experiencia = htmlspecialchars($trabajador['experiencia'], ENT_QUOTES, 'UTF-8');
        $planNombre = htmlspecialchars($trabajador['plan_nombre'] ?? 'Sin plan', ENT_QUOTES, 'UTF-8');
        $planPrecio = htmlspecialchars($trabajador['plan_precio'] ?? '0.00', ENT_QUOTES, 'UTF-8');
        $estadoStr = htmlspecialchars($trabajador['estado'], ENT_QUOTES, 'UTF-8');
        $estadoTextoStr = htmlspecialchars(estadoTexto($trabajador['estado']), ENT_QUOTES, 'UTF-8');
        
        $especialidad = htmlspecialchars($trabajador['especialidad'] ?? '', ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars($trabajador['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
        $categoriaNombre = htmlspecialchars($trabajador['categoria_nombre'] ?? 'Sin categoría', ENT_QUOTES, 'UTF-8');
        $disponibilidad = htmlspecialchars($trabajador['disponibilidad'] ?? '', ENT_QUOTES, 'UTF-8');
        $horario = htmlspecialchars($trabajador['horario_atencion'] ?? 'No registrado', ENT_QUOTES, 'UTF-8');
        $referencia = htmlspecialchars($trabajador['referencia_zona'] ?? 'No registrada', ENT_QUOTES, 'UTF-8');
        $createdAt = htmlspecialchars($trabajador['created_at'], ENT_QUOTES, 'UTF-8');
        ?>
        <article class="request-card" data-id="<?= $tId ?>">
            <div class="request-top">
                <div>
                    <h2>
                        <?= $nombre ?>
                        <?php if (isset($trabajador['registrado_con_google']) && intval($trabajador['registrado_con_google']) === 1): ?>
                            <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 9999px; margin-left: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; vertical-align: middle; border: 1px solid #bae6fd;">🔑 Google Verificado</span>
                        <?php endif; ?>
                    </h2>
                    <p class="service-name"><?= $servicio ?></p>
                </div>
                <span class="badge <?= $estadoStr ?>"><?= $estadoTextoStr ?></span>
            </div>
            
            <div class="request-info">
                <p><strong>Zona:</strong> <?= $zona ?></p>
                <p><strong>WhatsApp:</strong> <?= $whatsapp ?></p>
                <p><strong>Experiencia:</strong> <?= $experiencia ?> años</p>
                <p><strong>Plan:</strong> <?= $planNombre ?> - S/ <?= $planPrecio ?></p>
            </div>
            
            <details class="details-box">
                <summary>Ver detalles</summary>
                <p><strong>Especialidad:</strong> <?= $especialidad ?></p>
                <p><strong>Descripción:</strong> <?= $descripcion ?></p>
                <p><strong>Categoría:</strong> <?= $categoriaNombre ?></p>
                <p><strong>Disponibilidad:</strong> <?= $disponibilidad ?></p>
                <p><strong>Horario:</strong> <?= $horario ?></p>
                <p><strong>Referencia:</strong> <?= $referencia ?></p>
                <p><strong>Fecha de registro:</strong> <?= $createdAt ?></p>
            </details>
            
            <?php if (adminTieneRol($adminActual, ['superadmin', 'admin'])): ?>
                <details class="details-box edit-details">
                    <summary>Editar datos del trabajador</summary>
                    <form method="POST" action="panel_admin.php?estado=<?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>" class="admin-edit-form">
                        <?= $csrfToken ?>
                        <input type="hidden" name="trabajador_id" value="<?= $tId ?>">
                        <input type="hidden" name="accion" value="guardar_edicion">
                        <input type="hidden" name="servicio" value="<?= $servicio ?>">
                        
                        <label>Nombre completo</label>
                        <input type="text" name="nombre" value="<?= $nombre ?>" required>
                        
                        <label>Categoría / servicio</label>
                        <select name="categoria_id" required>
                            <?php foreach ($categorias as $cat): 
                                $selected = selectedOption($trabajador['categoria_id'], $cat['id']); ?>
                                <option value="<?= intval($cat['id']) ?>" <?= $selected ?>><?= htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                        <label>Plan</label>
                        <select name="plan_id" required>
                            <?php foreach ($planes as $pl): 
                                $selected = selectedOption($trabajador['plan_id'], $pl['id']); ?>
                                <option value="<?= intval($pl['id']) ?>" <?= $selected ?>><?= htmlspecialchars($pl['nombre'], ENT_QUOTES, 'UTF-8') ?> - S/ <?= number_format($pl['precio'], 2) ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                        <label>Especialidad</label>
                        <input type="text" name="especialidad" value="<?= $especialidad ?>">
                        
                        <label>Zona donde trabaja</label>
                        <input type="text" name="zona" value="<?= $zona ?>" required>
                        
                        <label>WhatsApp</label>
                        <input type="text" name="whatsapp" value="<?= $whatsapp ?>" required>
                        
                        <label>Años de experiencia</label>
                        <input type="number" name="experiencia" min="0" value="<?= $experiencia ?>">
                        
                        <label>Disponibilidad</label>
                        <input type="text" name="disponibilidad" value="<?= $disponibilidad ?>">
                        
                        <label>Horario de atención</label>
                        <input type="text" name="horario_atencion" value="<?= $horario ?>">
                        
                        <label>Referencia de zona</label>
                        <input type="text" name="referencia_zona" value="<?= $referencia ?>">
                        
                        <?php $domicilioChecked = checkedOption($trabajador['atiende_domicilio'] ?? 1); ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="atiende_domicilio" <?= $domicilioChecked ?>>
                            Atiende a domicilio o previa coordinación
                        </label>
                        
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="4" required><?= $descripcion ?></textarea>
                        
                        <label>Foto URL (Opcional)</label>
                        <input type="text" name="foto_perfil" value="<?= htmlspecialchars($trabajador['foto_perfil'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        
                        <button type="submit" class="btn-primary form-button">Guardar cambios</button>
                    </form>
                </details>
            <?php endif; ?>
            
            <?php if ($trabajador['estado'] === 'pendiente'): ?>
                <div class="admin-actions">
                    <form method="POST" action="panel_admin.php?estado=pendiente">
                        <?= $csrfToken ?>
                        <input type="hidden" name="trabajador_id" value="<?= $tId ?>">
                        <input type="hidden" name="accion" value="aprobar">
                        <button type="submit" class="btn-approve">Aprobar</button>
                    </form>
                    <form method="POST" action="panel_admin.php?estado=pendiente">
                        <?= $csrfToken ?>
                        <input type="hidden" name="trabajador_id" value="<?= $tId ?>">
                        <input type="hidden" name="accion" value="rechazar">
                        <button type="submit" class="btn-reject">Rechazar</button>
                    </form>
                </div>
            <?php endif; ?>
            
            <?php if ($trabajador['estado'] === 'aprobado' && adminTieneRol($adminActual, ['superadmin', 'admin'])): ?>
                <div class="admin-actions">
                    <a class="btn-secondary" target="_blank" href="../perfil.php?id=<?= $tId ?>">Ver perfil público</a>
                    <form method="POST" action="panel_admin.php?estado=aprobado" onsubmit="return confirm('¿Seguro que deseas eliminar este perfil aprobado? Esta acción no se puede deshacer.');">
                        <?= $csrfToken ?>
                        <input type="hidden" name="trabajador_id" value="<?= $tId ?>">
                        <input type="hidden" name="accion" value="eliminar_aprobado">
                        <button type="submit" class="btn-reject">Eliminar perfil</button>
                    </form>
                </div>
            <?php endif; ?>
            
        </article>
    <?php endforeach;
endif;
?>
