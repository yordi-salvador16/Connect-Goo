<?php
// app/views/public/planes_publicidad.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes de Publicidad - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/planes-publicidad.css?v=1.1">
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
        <h1>Publicita tu negocio <br><span style="color: #64748b; font-size: 20px;">(Para Locales Comerciales)</span></h1>
        <p>Ideal para <strong>restaurantes, tiendas, bodegas y locales f&iacute;sicos</strong>. Destaca tu marca con banners llamativos en la p&aacute;gina principal.</p>
    </header>

    <div style="text-align: center;">
        <div class="promo-banner">
            <i data-lucide="sparkles"></i> &iexcl;PROMOCI&Oacute;N LANZAMIENTO: Todos los planes son GRATIS por ahora!
        </div>
    </div>

    <section class="plans-grid">

        <article class="plan-card">
            <h2>Anuncio simple</h2>
            <h3>GRATIS <span>/ 15 d&iacute;as</span></h3>

            <p>Ideal para peque&ntilde;os negocios. Aparecer&aacute;s en la secci&oacute;n de promociones locales.</p>

            <ul>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Nombre del negocio</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Qu&eacute; vendes o servicio</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> N&uacute;mero de WhatsApp</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Descripci&oacute;n breve</li>
            </ul>

            <a class="btn-plan" href="solicitar_publicidad.php?tipo=Anuncio%20simple">
                Activar Anuncio
            </a>
        </article>

        <article class="plan-card featured">
            <span class="plan-badge">M&aacute;s Popular</span>

            <h2>Banner destacado</h2>
            <h3>GRATIS <span>/ 30 d&iacute;as</span></h3>

            <p>M&aacute;xima visibilidad. Aparece primero en la p&aacute;gina principal con imagen.</p>

            <ul>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Imagen del negocio</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Direcci&oacute;n / Referencia</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Horario de atenci&oacute;n</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px;"></i> Bot&oacute;n de WhatsApp</li>
                <li><i data-lucide="star" style="width: 18px; height: 18px;"></i> Mayor prioridad visual</li>
            </ul>

            <a class="btn-plan" href="solicitar_publicidad.php?tipo=Banner%20destacado">
                Activar Banner
            </a>
        </article>

        <article class="plan-card premium">
            <span class="plan-badge premium-badge" style="background:#3b82f6;color:white;position:absolute;top:-15px;left:50%;transform:translateX(-50%);padding:6px 16px;border-radius:50px;font-size:12px;font-weight:800;text-transform:uppercase;">Exclusivo</span>

            <h2>Auspiciador de Categor&iacute;a</h2>
            <h3 style="color:white;">GRATIS <span>/ 30 d&iacute;as</span></h3>

            <p style="color:#94a3b8;">Domina tu sector. Aparece en la parte superior de las categor&iacute;as relacionadas.</p>

            <ul style="color:#f1f5f9;">
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px; color: #10b981;"></i> Banner superior exclusivo</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px; color: #10b981;"></i> Direcci&oacute;n del negocio</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px; color: #10b981;"></i> Horario de atenci&oacute;n</li>
                <li><i data-lucide="check-circle-2" style="width: 18px; height: 18px; color: #10b981;"></i> Bot&oacute;n de WhatsApp VIP</li>
                <li><i data-lucide="link" style="width: 18px; height: 18px; color: #10b981;"></i> Enlace directo a perfil</li>
            </ul>

            <a class="btn-plan" href="solicitar_publicidad.php?tipo=Promoci%C3%B3n%20por%20categor%C3%ADa" style="background:white; color:#0f172a; margin-top:20px;">
                Dominar Categor&iacute;a
            </a>
        </article>

    </section>

    <!-- ====== MATRIZ DE COMPARACIÓN PUBLICIDAD ====== -->
    <section class="feature-matrix-section">
        <h2 class="matrix-title">Comparar Impacto Publicitario</h2>
        <div class="matrix-container" style="overflow-x: auto;">
            <table class="feature-matrix-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Beneficios</th>
                        <th>Anuncio Simple</th>
                        <th>Banner Destacado</th>
                        <th class="col-premium">Auspiciador de Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="feature-name">Aparici&oacute;n en promociones</td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Duraci&oacute;n inicial gratis</td>
                        <td>15 d&iacute;as</td>
                        <td>30 d&iacute;as</td>
                        <td class="col-premium">30 d&iacute;as</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Imagen gr&aacute;fica (Banner)</td>
                        <td><i data-lucide="x" class="icon-x"></i></td>
                        <td><i data-lucide="check" class="icon-check"></i></td>
                        <td class="col-premium"><i data-lucide="check" class="icon-check"></i></td>
                    </tr>
                    <tr>
                        <td class="feature-name">Ubicaci&oacute;n visual</td>
                        <td>Directorio base</td>
                        <td>Inicio (Destacados)</td>
                        <td class="col-premium">Inicio y Top Categor&iacute;as</td>
                    </tr>
                    <tr>
                        <td class="feature-name">Posicionamiento Exclusivo (Top 1)</td>
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
            Todos los anuncios serán revisados por el administrador antes de publicarse. La duración empieza a contarse desde el día de aprobación.
        </div>
    </section>

</main>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script>lucide.createIcons();</script>
</body>
</html>
