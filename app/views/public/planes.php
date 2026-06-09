<?php
// app/views/public/planes.php
// Variables esperadas: $planes
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes para trabajadores - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/planes.css?v=1.1">
</head>
<body class="bg-premium">

<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="display:flex; align-items:center; gap:6px; text-decoration:none;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>
</header>

<main class="planes-page">

    <a href="index.php" class="btn-back-circle" title="Volver al inicio">
        <i data-lucide="arrow-left"></i>
    </a>

    <header class="page-header">
        <h1>Ofrece tus servicios <br><span style="color: #64748b; font-size: 20px;">(Para Trabajadores)</span></h1>
        <div class="launch-offer">&#127881; &iexcl;OFERTA DE LANZAMIENTO: TODOS LOS PLANES SON GRATIS!</div>
        <p>
            Ideal para <strong>electricistas, t&eacute;cnicos, limpieza y profesionales independientes</strong>. 
            Crea tu perfil para que los clientes te encuentren y te contacten por WhatsApp.
        </p>
    </header>

    <section class="worker-plans-grid">
        <?php foreach ($planes as $plan): ?>
            <article class="<?= clasePlan($plan['nombre']) ?>">
                <?php if ($plan['nombre'] === 'Destacado'): ?>
                    <div class="plan-badge featured-badge">M&aacute;s elegido</div>
                <?php endif; ?>

                <?php if ($plan['nombre'] === 'Premium'): ?>
                    <div class="plan-badge premium-badge">Mayor visibilidad</div>
                <?php endif; ?>

                <div class="plan-header">
                    <h2>Plan <?= htmlspecialchars($plan['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <h3>Gratis</h3>
                    <p class="plan-desc"><?= htmlspecialchars(descripcionPlan($plan['nombre']), ENT_QUOTES, 'UTF-8') ?></p>
                </div>

                <ul class="plan-features">
                    <?php foreach (beneficiosPlan($plan['nombre']) as $beneficio): ?>
                        <li><i data-lucide="check-circle-2" style="width:18px;height:18px;color:#10b981;flex-shrink:0;"></i> <span><?= htmlspecialchars($beneficio, ENT_QUOTES, 'UTF-8') ?></span></li>
                    <?php endforeach; ?>
                </ul>

                <div class="plan-footer">
                    <a href="registrar_servicio.php?plan=<?= $plan['id'] ?>" class="btn-plan">
                        Elegir plan <?= htmlspecialchars($plan['nombre'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <div class="launch-badge">&iexcl;Gratis Hoy!</div>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <!-- ====== MATRIZ DE COMPARACIÓN ====== -->
    <section class="feature-matrix-section">
        <h2 class="matrix-title">Comparar Beneficios al Detalle</h2>
        <div class="matrix-container" style="overflow-x: auto;">
            <table class="feature-matrix-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Caracter&iacute;sticas</th>
                        <th>B&aacute;sico</th>
                        <th>Destacado</th>
                        <th class="col-premium">Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="feature-name">Aparici&oacute;n en directorio</td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Bot&oacute;n directo a WhatsApp</td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Posicionamiento en listas</td>
                        <td>Normal</td>
                        <td>Prioritario</td>
                        <td class="col-premium">M&aacute;xima Prioridad</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Etiqueta "Destacado" en perfil</td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Insignia "Profesional Verificado"</td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Mapa interactivo de ubicaci&oacute;n</td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Horarios de atenci&oacute;n</td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="notice-box">
        <i data-lucide="info"></i> 
        <div>
            Nota: El administrador debe revisar y aprobar cada perfil antes de que aparezca p&uacute;blicamente para garantizar la seguridad de la comunidad y la calidad de los servicios.
        </div>
    </section>

</main>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script>lucide.createIcons();</script>
</body>
</html>
