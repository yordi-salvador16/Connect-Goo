<?php
// app/views/public/home.php
// Variables esperadas: $ciudades, $publicidades, $destacadosHome
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Connectgoo - Servicios confiables en tu ciudad</title>
    <meta name="description" content="Encuentra electricistas, técnicos, gasfiteros y más profesionales verificados. Contacta directo por WhatsApp.">
    <meta property="og:title" content="Connectgoo - Servicios confiables en tu ciudad">
    <meta property="og:description" content="Encuentra electricistas, técnicos, limpieza y más profesionales verificados. Contacta directo por WhatsApp.">
    <meta property="og:image" content="https://connectgoo.com/assets/img/connectgoo-social.jpg">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://connectgoo.com/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- PWA Manifest & Theme -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#10b981">
    <link rel="stylesheet" href="assets/css/styles.css?v=4.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MTT70080MN"></script>
    <script> 
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-MTT70080MN');
    </script>

    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Preload LCP Image -->
    <link rel="preload" href="assets/img/hero.png" as="image">

    <!-- Lucide Icons (Deferred to not block render) -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-premium">

<!-- ====== NAVBAR ====== -->
<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="gap: 8px;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 40%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>

    <button class="cg-menu-toggle" type="button" aria-label="Abrir menu">
        <i data-lucide="menu"></i>
    </button>

    <nav class="cg-nav" id="mainNav">
        <a href="#ciudades" class="cg-nav-location">
            <i data-lucide="map-pin" style="width:14px;height:14px;"></i>
            <span>Tingo María</span>
        </a>
        <a href="nosotros.php">Nosotros</a>
        <a href="categorias.php">Buscar servicios</a>
        <a href="planes.php">Registrar servicio</a>
        
        <!-- NUEVO BOTON SECTOR AGRO -->
        <a href="categorias.php?tab=agro" style="display:flex; align-items:center; gap:6px; background:#ecfdf5; color:#059669; padding:8px 16px; border-radius:20px; text-decoration:none; font-weight:700; border:1px solid #10b981; margin-left:10px;">
            <i data-lucide="sprout" style="width:16px;height:16px;"></i> Sector Agro
        </a>

        <a href="nosotros.php#contacto" class="nav-contact-icon desktop-only" title="Soporte y Contacto" style="display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#f1f5f9; color:#475569; text-decoration:none; margin-left:8px; transition:all 0.3s;">
            <i data-lucide="headset" style="width:20px;height:20px;"></i>
        </a>

        <?php if (!isset($_COOKIE['lead_registered'])): ?>
        <div class="g_id_signin"
             data-type="standard"
             data-shape="pill"
             data-theme="outline"
             data-text="signin_with"
             data-size="medium"
             data-logo_alignment="left">
        </div>
        <?php endif; ?>
    </nav>
</header>

<main class="main-content-premium">
    <!-- ====== HERO PREMIUM ====== -->
    <section class="premium-hero reveal">
        <div class="premium-hero-content">
            <div class="hero-badge" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); border: 1px solid rgba(16, 185, 129, 0.2); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.1); color: #0f172a; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                <span style="display:flex; align-items:center; justify-content:center; background:#10b981; color:white; width:18px; height:18px; border-radius:50%;">
                   <i data-lucide="check" style="width:12px;height:12px;stroke-width:3;"></i>
                </span>
                <span>Conectando talento local</span>
            </div>
            
            <h1 class="hero-title">
                Encuentra a tu <span class="text-gradient"><span id="typewriter-text"></span><span class="cursor-blink">|</span></span> de confianza
            </h1>
            
            <p class="hero-subtitle">
                Contacta directo por WhatsApp a expertos locales evaluados por tu comunidad.
            </p>

            <div class="hero-actions">
                <a href="categorias.php" class="btn-hero-primary">
                    Buscar Servicios <i data-lucide="arrow-right" style="width:18px;height:18px;"></i>
                </a>
                <a href="planes.php" class="btn-hero-secondary" style="background: white; border: 2px solid #e2e8f0; color: #1e293b; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 700; transition: all 0.3s;">
                    Ofrecer mi servicio
                </a>
            </div>

            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; margin-top: 20px;">
                <div style="display: flex; align-items: center;">
                    <img src="https://i.pravatar.cc/100?img=32" alt="Usuario de la comunidad" style="width: 36px; height: 36px; border-radius: 50%; border: 3px solid #f8fafc; margin-right: -12px;" loading="lazy">
                    <img src="https://i.pravatar.cc/100?img=12" alt="Cliente satisfecho" style="width: 36px; height: 36px; border-radius: 50%; border: 3px solid #f8fafc; margin-right: -12px;" loading="lazy">
                    <img src="https://i.pravatar.cc/100?img=45" alt="Profesional activo" style="width: 36px; height: 36px; border-radius: 50%; border: 3px solid #f8fafc; margin-right: -12px;" loading="lazy">
                    <img src="https://i.pravatar.cc/100?img=60" alt="Usuario verificado" style="width: 36px; height: 36px; border-radius: 50%; border: 3px solid #f8fafc;" loading="lazy">
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748b; font-weight: 600;">
                    <div style="display: flex; color: #fbbf24; gap: 2px;">
                        <i data-lucide="star" style="width:14px;height:14px;fill:currentColor;"></i>
                        <i data-lucide="star" style="width:14px;height:14px;fill:currentColor;"></i>
                        <i data-lucide="star" style="width:14px;height:14px;fill:currentColor;"></i>
                        <i data-lucide="star" style="width:14px;height:14px;fill:currentColor;"></i>
                        <i data-lucide="star" style="width:14px;height:14px;fill:currentColor;"></i>
                    </div>
                    <span>La comunidad sigue creciendo</span>
                </div>
            </div>

            <div class="hero-trust-indicators desktop-only">
                <div class="trust-item">
                    <i data-lucide="check-circle-2"></i> Perfiles verificados
                </div>
                <div class="trust-item">
                    <i data-lucide="star"></i> Calificaciones reales
                </div>
                <div class="trust-item">
                    <i data-lucide="message-circle"></i> Trato directo
                </div>
            </div>
        </div>

        <!-- HERO VISUAL DESKTOP (Bento/Glassmorphism) -->
        <div class="premium-hero-visual desktop-only" id="parallax-container">
            <div class="bento-container">
                <div class="bento-image-card" id="parallax-img">
                    <img src="assets/img/hero.png" alt="Profesional Connectgoo">
                    <div class="glass-floating-card top-card" id="dynamic-service-card" style="transition: opacity 0.4s ease;">
                        <div class="glass-icon bg-emerald-light" id="dynamic-service-icon-bg" style="background: rgba(16, 185, 129, 0.15);"><i data-lucide="zap" style="color:#059669;"></i></div>
                        <div class="glass-text">
                            <strong id="dynamic-service-title">Electricista</strong>
                            <span id="dynamic-service-desc">Instalaciones seguras</span>
                        </div>
                    </div>
                    <div class="glass-floating-card bottom-card">
                        <div class="glass-icon bg-blue-light"><i data-lucide="map-pin" style="color:#2563eb;"></i></div>
                        <div class="glass-text">
                            <strong>Cerca de ti</strong>
                            <span>Tingo María y alrededores</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CATEGORÍAS RÁPIDAS MÓVIL ====== -->
    <div class="mobile-quick-categories mobile-only">
        <a href="trabajadores.php?categoria=1" class="quick-cat"><i data-lucide="zap"></i> Electricidad</a>
        <a href="trabajadores.php?categoria=2" class="quick-cat"><i data-lucide="droplets"></i> Gasfitería</a>
        <a href="trabajadores.php?categoria=3" class="quick-cat"><i data-lucide="smartphone"></i> Técnicos</a>
        <a href="categorias.php" class="quick-cat"><i data-lucide="brush"></i> Pintura</a>
        <a href="planes.php" class="quick-cat"><i data-lucide="plus-circle"></i> Anunciar</a>
        <a href="categorias.php" class="quick-cat-all"><i data-lucide="grid-3x3"></i> Ver Todos</a>
    </div>

    <!-- ====== SERVICIOS DESTACADOS (Lista Limpia Mobile & Desktop) ====== -->
    <section class="premium-section reveal bg-white rounded-section shadow-sm">
        <div class="section-heading">
            <h2 class="section-title"><i data-lucide="sparkles" style="color:#f59e0b;"></i> Servicios Destacados</h2>
            <p class="section-desc">Profesionales mejor valorados listos para ayudarte hoy.</p>
        </div>

        <?php if (!empty($destacadosHome)): ?>
        <div class="premium-horizontal-scroll">
            <?php foreach ($destacadosHome as $w): ?>
                <?php 
                    $foto = !empty($w['foto_perfil']) ? htmlspecialchars($w['foto_perfil']) : '';
                    $nombre = htmlspecialchars($w['nombre']);
                    $servicio = htmlspecialchars($w['servicio']);
                    $atiende = ($w['atiende_domicilio'] == 1) ? 'A domicilio' : 'Local';
                    
                    $emoji = '🛠️';
                    if (stripos($servicio, 'electri') !== false) $emoji = '⚡';
                    elseif (stripos($servicio, 'gasfi') !== false || stripos($servicio, 'plome') !== false) $emoji = '💧';
                    elseif (stripos($servicio, 'celu') !== false || stripos($servicio, 'tec') !== false) $emoji = '📱';
                    
                    $inicial = !empty($nombre) ? strtoupper(substr($nombre, 0, 1)) : 'P';
                    $colors = ['#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#06b6d4'];
                    $bgColor = $colors[crc32($nombre) % count($colors)];
                ?>
                <a href="perfil.php?id=<?= $w['id'] ?>" class="premium-worker-card">
                    <div class="worker-card-header">
                        <div class="worker-avatar">
                            <?php if (!empty($foto)): ?>
                                <img src="<?= $foto ?>" alt="<?= $nombre ?>">
                            <?php else: ?>
                                <div class="avatar-initial" style="background-color: <?= $bgColor ?>;"><?= $inicial ?></div>
                            <?php endif; ?>
                            <div class="verified-badge"><i data-lucide="check-circle-2"></i></div>
                        </div>
                    </div>
                    <div class="worker-card-body">
                        <span class="worker-service"><?= $emoji ?> <?= $servicio ?></span>
                        <h3 class="worker-name"><?= $nombre ?></h3>
                        <span class="worker-location"><i data-lucide="map-pin"></i> <?= $atiende ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="cg-empty-state">
                <div class="cg-empty-icon">
                    <i data-lucide="ghost"></i>
                </div>
                <h3 class="cg-empty-title">Aún no hay profesionales destacados</h3>
                <p class="cg-empty-desc">Sé el primero en aparecer aquí y multiplica tus clientes en la plataforma.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- ====== PUBLICIDADES ====== -->
    <?php if (!empty($publicidades)): ?>
    <section class="premium-section reveal bg-white rounded-section shadow-sm">
        <div class="section-heading">
            <h2 class="section-title"><i data-lucide="megaphone" style="color:#2563eb;"></i> Anuncios Destacados</h2>
            <p class="section-desc">Apoya a los negocios locales de nuestra ciudad.</p>
        </div>
        <div class="premium-horizontal-scroll">
            <?php foreach ($publicidades as $p): ?>
                <?php
                $img = !empty($p['imagen_negocio']) ? htmlspecialchars($p['imagen_negocio']) : 'assets/img/default-ad.jpg';
                $negocio = htmlspecialchars($p['nombre_negocio']);
                $whatsapp = htmlspecialchars($p['whatsapp'] ?? '');
                $desc = htmlspecialchars($p['descripcion'] ?? '');
                
                // Limpiar el número de WhatsApp
                $numeroLimpio = preg_replace('/[^0-9]/', '', $whatsapp);
                if (strlen($numeroLimpio) === 9) $numeroLimpio = '51' . $numeroLimpio;
                $linkWsp = !empty($numeroLimpio) ? "https://wa.me/{$numeroLimpio}?text=" . urlencode("Hola, vi su anuncio en Connectgoo.") : '#';
                ?>
                <div class="premium-worker-card">
                    <div class="worker-card-header" style="height: 160px; background: url('<?= $img ?>') center/cover; position: relative;">
                        <div class="verified-badge" style="top: 12px; right: 12px; bottom: auto; background: rgba(0,0,0,0.7); color: white; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: bold; width: auto; height: auto;">
                            Patrocinado
                        </div>
                    </div>
                    <div class="worker-card-body">
                        <div class="worker-service" style="background: #eff6ff; color: #2563eb; margin-bottom: 4px;">Negocio Local</div>
                        <h3 class="worker-name"><?= $negocio ?></h3>
                        <?php if (!empty($p['direccion'])): ?>
                            <span class="worker-location" style="margin-top: 4px; font-weight: 600;"><i data-lucide="map-pin"></i> <?= htmlspecialchars($p['direccion']) ?></span>
                        <?php endif; ?>
                        <p class="worker-location" style="margin-top: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #64748b;"><?= $desc ?></p>
                        
                        <div style="margin-top: 15px; display: flex; gap: 8px;">
                            <?php if (!empty($p['direccion'])): ?>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode(htmlspecialchars($p['direccion']) . ', Tingo María') ?>" target="_blank" style="display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #475569; padding: 10px; border-radius: 8px; font-weight: bold; text-decoration: none; width: 50px; flex-shrink: 0;" title="Ver Ruta en Mapa">
                                    <i data-lucide="map-pin" style="width:20px;height:20px;"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?= $linkWsp ?>" onclick="event.stopPropagation();" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #25d366; color: white; padding: 10px; border-radius: 8px; font-weight: bold; text-decoration: none; flex-grow: 1;">
                                <svg style="width:18px;height:18px;" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 3.825 0 6.937 3.112 6.937 6.937 0 3.825-3.112 6.937-6.937 6.937z"/></svg> Contáctanos
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ====== CIUDADES ====== -->
    <section class="premium-section reveal" id="ciudades">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; max-width: 1100px; margin-left: auto; margin-right: auto; padding: 0 10px;">
            <h2 style="font-size: 22px; font-weight: 800; color: #1e293b; margin: 0;">Lugar</h2>
            <button id="geoBtn" style="background:rgba(16,185,129,0.1); border:none; color:#059669; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:20px; transition:all 0.2s;">
                <i data-lucide="navigation" style="width:14px;height:14px;"></i> Mi ubicación
            </button>
        </div>

        <div class="cities-grid">
            <?php foreach ($ciudades as $ciudad): ?>
                <?php if ($ciudad['activa']): ?>
                    <a href="categorias.php?ciudad=<?= htmlspecialchars($ciudad['slug'], ENT_QUOTES, 'UTF-8') ?>" class="city-card active">
                        <div class="city-icon">
                            <?= ($ciudad['slug'] === 'tingo-maria') ? '<i data-lucide="trees"></i>' : '<i data-lucide="landmark"></i>' ?>
                        </div>
                        <div class="city-info">
                            <h3><?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <span><?= htmlspecialchars($ciudad['departamento'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <span class="city-status success">Disponible</span>
                    </a>
                <?php else: ?>
                    <div class="city-card inactive">
                        <div class="city-icon"><i data-lucide="map-pin"></i></div>
                        <div class="city-info">
                            <h3><?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <span><?= htmlspecialchars($ciudad['departamento'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <span class="city-status warning">Próximamente</span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ====== CTA NEGOCIOS ====== -->
    <section class="premium-cta reveal">
        <div class="cta-content">
            <span class="cta-badge">Publicidad para Negocios</span>
            <h2>Impulsa las ventas de tu local</h2>
            <p>Destaca tu restaurante, tienda o empresa frente a toda la ciudad. Publica tu anuncio gráfico hoy mismo.</p>
            <a href="planes_publicidad.php" class="btn-cta-primary">Publicitar mi negocio</a>
        </div>
    <!-- HERO VISUAL DESKTOP (Bento/Glassmorphism) -->
    <!-- (Rest of the hero is above, we keep what's inside <main>) -->
        <div class="cta-visual desktop-only">
            <i data-lucide="briefcase" style="width:120px;height:120px;color:rgba(255,255,255,0.2);"></i>
        </div>
    </section>

</main>

<!-- Bottom nav spacer para evitar superposición en mobile -->
<div class="mobile-nav-spacer"></div>

<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<!-- ====== FOOTER ====== -->
<footer class="premium-footer">
    <div class="footer-grid">
        <div class="footer-brand-col">
            <div class="footer-logo"><i data-lucide="map-pin"></i> Connectgoo</div>
            <p>La red de servicios locales más confiable de tu ciudad.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/share/1AFUDaV7LW/" target="_blank" aria-label="Visita nuestro Facebook" rel="noopener noreferrer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
            </div>
        </div>
        <div class="footer-links-col">
            <h4>Plataforma</h4>
            <a href="categorias.php">Buscar servicios</a>
            <a href="planes.php">Registrar servicio</a>
            <a href="planes_publicidad.php">Publicidad</a>
        </div>
        <div class="footer-links-col">
            <h4>Legal</h4>
            <a href="#">Términos y condiciones</a>
            <a href="#">Privacidad</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Connectgoo. Todos los derechos reservados.</p>
    </div>
</footer>

<!-- ====== SCRIPTS ====== -->
<script src="assets/js/main.js?v=4.0"></script>

<?php if (!isset($_COOKIE['lead_registered'])): ?>
<div id="g_id_onload"
     data-client_id="1013745195759-q8ebirncb0a12j31auejrdvmsb3ucohe.apps.googleusercontent.com"
     data-context="use"
     data-ux_mode="popup"
     data-callback="handleGoogleResponse"
     data-auto_prompt="true">
</div>

<script>
function handleGoogleResponse(response) {
    fetch('api_google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ credential: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            const date = new Date();
            date.setTime(date.getTime() + (365*24*60*60*1000));
            document.cookie = "lead_registered=1; expires=" + date.toUTCString() + "; path=/";
            showToast('¡Bienvenido! Te has suscrito correctamente.', 'success');
            setTimeout(() => location.reload(), 1500);
        }
    })
    .catch(err => console.error("Error en Google Login:", err));
}
<?php endif; ?>

<style>
    #dynamic-service-card {
        transition: opacity 0.4s ease-in-out;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const services = [
            { title: 'Electricista', desc: 'Instalaciones seguras', icon: 'zap', color: '#059669', bg: 'rgba(16, 185, 129, 0.15)' },
            { title: 'Gasfitero', desc: 'Reparaciones rápidas', icon: 'droplets', color: '#2563eb', bg: 'rgba(37, 99, 235, 0.15)' },
            { title: 'Limpieza', desc: 'Hogares impecables', icon: 'sparkles', color: '#8b5cf6', bg: 'rgba(139, 92, 246, 0.15)' },
            { title: 'Pintor', desc: 'Acabados perfectos', icon: 'paintbrush-2', color: '#f59e0b', bg: 'rgba(245, 158, 11, 0.15)' },
            { title: 'Técnico PC', desc: 'Soporte y arreglo', icon: 'monitor', color: '#0f766e', bg: 'rgba(15, 118, 110, 0.15)' }
        ];
        
        let currentIndex = 0;
        const titleEl = document.getElementById('dynamic-service-title');
        const descEl = document.getElementById('dynamic-service-desc');
        const iconBgEl = document.getElementById('dynamic-service-icon-bg');
        const cardEl = document.getElementById('dynamic-service-card');
        
        if(titleEl && descEl && iconBgEl && cardEl) {
            setInterval(() => {
                cardEl.style.opacity = 0; // Fade out
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % services.length;
                    const s = services[currentIndex];
                    
                    titleEl.innerText = s.title;
                    descEl.innerText = s.desc;
                    iconBgEl.style.background = s.bg;
                    iconBgEl.innerHTML = `<i data-lucide="${s.icon}" style="color:${s.color};"></i>`;
                    lucide.createIcons();
                    
                    cardEl.style.opacity = 1; // Fade in
                }, 400); // 400ms duration matching the CSS transition
            }, 3500); // Change every 3.5 seconds
        }
    });
</script>

<script>
// ====== TYPEWRITER EFFECT ======
document.addEventListener("DOMContentLoaded", function() {
    const words = ["Electricista", "Gasfitero", "Técnico PC", "Pintor", "Jardinero"];
    let i = 0;
    let timer;
    const typewriterEl = document.getElementById("typewriter-text");
    
    function typingEffect() {
        if (!typewriterEl) return;
        let word = words[i].split("");
        var loopTyping = function() {
            if (word.length > 0) {
                typewriterEl.innerHTML += word.shift();
            } else {
                setTimeout(deletingEffect, 2000); // Pause before deleting
                return;
            }
            timer = setTimeout(loopTyping, 100);
        };
        loopTyping();
    }

    function deletingEffect() {
        let word = words[i].split("");
        var loopDeleting = function() {
            if (word.length > 0) {
                word.pop();
                typewriterEl.innerHTML = word.join("");
            } else {
                i = (i + 1) % words.length;
                setTimeout(typingEffect, 500); // Pause before typing next word
                return;
            }
            timer = setTimeout(loopDeleting, 50);
        };
        loopDeleting();
    }
    
    // Start effect
    if(typewriterEl) typingEffect();
});

// ====== 3D PARALLAX EFFECT ======
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('parallax-container');
    const imgCard = document.getElementById('parallax-img');
    const dynamicCard = document.getElementById('dynamic-service-card'); // top card
    const bottomCard = document.querySelector('.bottom-card'); // bottom card

    if (container && imgCard && dynamicCard && bottomCard) {
        container.addEventListener("mousemove", (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            
            // Move image slightly
            imgCard.style.transform = `translateY(${yAxis}px) translateX(${xAxis}px)`;
            
            // Move cards in opposite direction (parallax)
            dynamicCard.style.transform = `translateY(${-yAxis * 1.5}px) translateX(${-xAxis * 1.5}px)`;
            bottomCard.style.transform = `translateY(${-yAxis * 1.2}px) translateX(${-xAxis * 1.2}px)`;
        });

        // Reset on mouse leave
        container.addEventListener("mouseleave", (e) => {
            imgCard.style.transform = `translateY(0px) translateX(0px)`;
            dynamicCard.style.transform = `translateY(0px) translateX(0px)`;
            bottomCard.style.transform = `translateY(0px) translateX(0px)`;
            
            imgCard.style.transition = 'all 0.5s ease';
            dynamicCard.style.transition = 'all 0.5s ease, opacity 0.4s ease-in-out';
            bottomCard.style.transition = 'all 0.5s ease';
        });

        // Remove transition on hover so it reacts instantly
        container.addEventListener("mouseenter", (e) => {
            imgCard.style.transition = 'none';
            dynamicCard.style.transition = 'opacity 0.4s ease-in-out'; // keep opacity transition
            bottomCard.style.transition = 'none';
        });
    }
});
</script>

<style>
    /* Spun icon animation for loading */
    .cg-spin { animation: spin 1s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<script>
    lucide.createIcons();
    
    // ==========================================
    // 📱 PWA INSTALLATION & METRICS TRACKING
    // ==========================================
    let deferredPrompt;
    
    // 1. Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js').then(registration => {
                console.log('SW registered');
            }).catch(e => console.log('SW error', e));
        });
    }

    // 2. Intercept the install prompt and show custom banner
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        
        // Crea y muestra un banner flotante muy premium
        const installBanner = document.createElement('div');
        installBanner.id = 'pwa-install-banner';
        installBanner.innerHTML = `
            <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 400px; background: white; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15); border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; justify-content: space-between; z-index: 9999; animation: slideUp 0.5s ease-out;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <i data-lucide="smartphone"></i>
                    </div>
                    <div>
                        <strong style="display: block; color: #1e293b; font-size: 15px;">Instalar App</strong>
                        <span style="color: #64748b; font-size: 13px;">Acceso rápido y sin internet</span>
                    </div>
                </div>
                <button id="btn-install-pwa" style="background: #10b981; color: white; border: none; padding: 10px 16px; border-radius: 12px; font-weight: 700; cursor: pointer;">Instalar</button>
            </div>
            <style>@keyframes slideUp { from { bottom: -100px; opacity: 0; } to { bottom: 20px; opacity: 1; } }</style>
        `;
        document.body.appendChild(installBanner);
        lucide.createIcons();

        // 3. Handle install button click
        document.getElementById('btn-install-pwa').addEventListener('click', async () => {
            if (deferredPrompt) {
                installBanner.style.display = 'none';
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    fetch('track_pwa_install.php', { method: 'POST' });
                }
                deferredPrompt = null;
            } else {
                // Failsafe: Si Google Chrome se pone estricto, le enseñamos manualmente
                alert("Para instalar: Ve a los 3 puntitos arriba a la derecha (Menú) y selecciona 'Agregar a la pantalla principal' o 'Instalar aplicación'.");
            }
        });
    }

    // El evento se dispara si Chrome autoriza la instalación automática
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
    });

    // Mostrar el banner a los 2 segundos de todas formas si están en un celular
    setTimeout(() => {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        const bannerExists = document.getElementById('pwa-install-banner');
        if (isMobile && !bannerExists && !window.matchMedia('(display-mode: standalone)').matches) {
            crearBannerInstalacion();
        }
    }, 2000);

    // Iniciar
    let deferredPrompt;
    function crearBannerInstalacion() {
        if(document.getElementById('pwa-install-banner')) return;
        
        // Crea y muestra un banner flotante muy premium
        const installBanner = document.createElement('div');
        installBanner.id = 'pwa-install-banner';
        installBanner.innerHTML = `
            <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 400px; background: white; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15); border: 1px solid #e2e8f0; padding: 16px; display: flex; align-items: center; justify-content: space-between; z-index: 9999; animation: slideUp 0.5s ease-out;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <i data-lucide="smartphone"></i>
                    </div>
                    <div>
                        <strong style="display: block; color: #1e293b; font-size: 15px;">Instalar App</strong>
                        <span style="color: #64748b; font-size: 13px;">Acceso rápido y sin internet</span>
                    </div>
                </div>
                <button id="btn-install-pwa" style="background: #10b981; color: white; border: none; padding: 10px 16px; border-radius: 12px; font-weight: 700; cursor: pointer;">Instalar</button>
            </div>
            <style>@keyframes slideUp { from { bottom: -100px; opacity: 0; } to { bottom: 20px; opacity: 1; } }</style>
        `;
        document.body.appendChild(installBanner);
        if(window.lucide) window.lucide.createIcons();

        document.getElementById('btn-install-pwa').addEventListener('click', async () => {
            if (deferredPrompt) {
                installBanner.style.display = 'none';
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    fetch('track_pwa_install.php', { method: 'POST' });
                }
                deferredPrompt = null;
            } else {
                alert("Para instalar: Presiona los 3 puntitos de arriba (Menú de Chrome) y selecciona 'Agregar a la pantalla principal'.");
            }
        });
    }

    // Fallback: Por si lo instala desde el menú de opciones directamente
    window.addEventListener('appinstalled', (evt) => {
        fetch('track_pwa_install.php', { method: 'POST' });
        const banner = document.getElementById('pwa-install-banner');
        if(banner) banner.style.display = 'none';
    });

    // ==========================================
    // 🚨 DETECTOR DE NAVEGADORES QUE BLOQUEAN PWA (TikTok, Facebook, iPhone)
    // ==========================================
    setTimeout(() => {
        const ua = navigator.userAgent || navigator.vendor || window.opera;
        const isInstagram = (ua.indexOf('Instagram') > -1);
        const isFacebook = (ua.indexOf('FBAN') > -1) || (ua.indexOf('FBAV') > -1);
        const isTikTok = (ua.indexOf('ByteLocale') > -1) || (ua.indexOf('TikTok') > -1);
        const isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
        
        // Si no se disparó el evento nativo (deferredPrompt) y estamos en una red social o iOS
        if (!deferredPrompt && (isInstagram || isFacebook || isTikTok || isIOS)) {
            const fallbackBanner = document.createElement('div');
            let mensaje = "Abre esta página en <strong>Chrome</strong> para instalar la App.";
            
            if (isIOS) {
                mensaje = "Para instalar la App: Toca <i data-lucide='share' style='width:14px;height:14px;vertical-align:middle;'></i> y selecciona <strong>'Agregar a inicio'</strong>";
            }
            
            fallbackBanner.innerHTML = `
                <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 400px; background: #fffbeb; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); border: 1px solid #fcd34d; padding: 12px; display: flex; align-items: center; justify-content: space-between; z-index: 9999; font-size: 13px; color: #92400e;">
                    <div>${mensaje}</div>
                    <button onclick="this.parentElement.style.display='none'" style="background:none; border:none; color:#b45309; font-weight:bold; cursor:pointer;">X</button>
                </div>
            `;
            document.body.appendChild(fallbackBanner);
            if(window.lucide) window.lucide.createIcons();
        }
    }, 3000); // Esperar 3 segundos para dar tiempo al navegador de disparar el evento normal

</script>
</body>
</html>
