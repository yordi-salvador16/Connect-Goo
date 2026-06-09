<?php
// app/views/admin/admin_mensajes.php
$pageTitle = 'Mensajes de Ayuda';
$pageBreadcrumb = 'Audiencia > Mensajes de Ayuda';
require_once __DIR__ . '/layout/header.php';
?>


<div class="content-header">
    <h2><i data-lucide="message-square" style="color:var(--primary-color);"></i> Mensajes de Ayuda</h2>
    <p>Solicitudes de contacto y ayuda para registro desde la página principal.</p>
</div>

<?php if (!empty($mensaje)): ?>
    <div class="alert alert-success">
        <i data-lucide="check-circle"></i> <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

<?php if (!empty($errorMsg)): ?>
    <div class="alert alert-danger">
        <i data-lucide="alert-circle"></i> <?= htmlspecialchars($errorMsg) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="card-body">
        <?php if (empty($mensajes)): ?>
            <div style="text-align:center; padding:40px; color:#64748b;">
                <i data-lucide="inbox" style="width:48px;height:48px;margin-bottom:10px;opacity:0.5;"></i>
                <p>No hay mensajes en la bandeja de entrada.</p>
            </div>
        <?php else: ?>
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:20px;">
                <?php foreach ($mensajes as $msg): ?>
                    <?php 
                        // Limpiar número (solo digitos)
                        $numero = preg_replace('/[^0-9]/', '', $msg['telefono']);
                        if (strlen($numero) == 9) { $numero = '51' . $numero; } // Agregar prefijo peruano
                        $textoWpp = urlencode("Hola " . $msg['nombre'] . ", nos escribiste desde ConnectGoo pidiendo ayuda con lo siguiente: " . $msg['mensaje']);
                    ?>
                    <article style="background:white; border-radius:16px; padding:24px; border:1px solid var(--border-color); box-shadow:var(--shadow-sm); display:flex; flex-direction:column; justify-content:space-between; transition:all 0.2s; position:relative; <?= $msg['leido'] ? 'opacity:0.75;background:#f8fafc;' : '' ?>">
                        
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; gap: 12px;">
                            <div style="min-width: 0;">
                                <h3 style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($msg['nombre']) ?></h3>
                                <span style="font-size:12px; color:var(--text-muted);"><?= date('d/m/Y H:i', strtotime($msg['fecha'])) ?></span>
                            </div>
                            <div style="flex-shrink: 0;">
                                <?php if ($msg['leido']): ?>
                                    <span class="badge badge-success">Atendido</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Pendiente</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="font-size:13px; color:var(--text-muted); margin-bottom:12px;">
                            <p style="margin:0;"><strong style="color:var(--text-main);"><i data-lucide="phone" style="width:13px; height:13px; display:inline-block; vertical-align:middle; margin-right:4px;"></i> Celular:</strong> <?= htmlspecialchars($msg['telefono']) ?></p>
                        </div>

                        <div style="font-size:14px; color:var(--text-main); line-height:1.5; margin-bottom:20px; background:#f8fafc; padding:16px; border-radius:12px; flex-grow:1; min-height:80px; white-space:normal; border: 1px solid rgba(0,0,0,0.02);">
                            <?= nl2br(htmlspecialchars($msg['mensaje'])) ?>
                        </div>

                        <div style="display:flex; gap:10px; border-top:1px solid var(--border-color); padding-top:16px; margin-top:auto;">
                            <!-- WhatsApp -->
                            <a href="https://wa.me/<?= $numero ?>?text=<?= $textoWpp ?>" target="_blank" style="flex:1; display:flex; align-items:center; justify-content:center; gap:6px; background:#25d366; color:white; padding:10px; border-radius:8px; font-weight:600; text-decoration:none; font-size:13px; transition:all 0.2s;" onmouseover="this.style.background='#20ba5a'" onmouseout="this.style.background='#25d366'">
                                <i data-lucide="message-circle" style="width:16px; height:16px;"></i> WhatsApp
                            </a>

                            <!-- Marcar como leído -->
                            <?php if (!$msg['leido']): ?>
                                <form method="POST" style="flex:1;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                    <input type="hidden" name="accion" value="marcar_leido">
                                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                    <button type="submit" style="width:100%; display:flex; align-items:center; justify-content:center; gap:6px; background:#3b82f6; color:white; border:none; padding:10px; border-radius:8px; font-weight:600; cursor:pointer; font-size:13px; transition:all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                        <i data-lucide="check" style="width:16px; height:16px;"></i> Atender
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Eliminar -->
                            <form method="POST" style="flex: <?= $msg['leido'] ? '1' : '0.4' ?>;" onsubmit="return confirm('¿Eliminar este mensaje?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                <button type="submit" style="width:100%; display:flex; align-items:center; justify-content:center; gap:6px; background:#fee2e2; color:#ef4444; border:1px solid #fecaca; padding:10px; border-radius:8px; font-weight:600; cursor:pointer; font-size:13px; transition:all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <i data-lucide="trash-2" style="width:16px; height:16px;"></i> <?= $msg['leido'] ? 'Eliminar' : '' ?>
                                </button>
                            </form>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.row-faded {
    background-color: #f8fafc;
    opacity: 0.8;
}
.row-faded td {
    color: #64748b;
}
</style>

<script>lucide.createIcons();</script>
<?php require_once __DIR__ . '/layout/footer.php'; ?>
