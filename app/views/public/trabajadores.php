<?php
// app/views/public/trabajadores.php
// Variables esperadas: $categoria, $ciudad, $slugCiudad, $trabajadores, $publicidadesCategoria
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?> en <?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?> - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/trabajadores.css?v=1.0">
</head>
<body class="bg-premium">

<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="display:flex; align-items:center; gap:6px; text-decoration:none;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>
</header>

<div class="trab-page">

    <a href="categorias.php?ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" class="btn-back-circle" title="Volver a Categorías">
        <i data-lucide="arrow-left"></i>
    </a>

    <h1 class="trab-title"><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="trab-subtitle">
        <span class="trab-count"><?= count($trabajadores) ?></span> profesionales en <?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?>
    </p>

    <!-- ====== SECCIÓN DE ANUNCIOS PREMIUM AUSPICIADOS DE LA CATEGORÍA ====== -->
    <?php if (!empty($publicidadesCategoria)): ?>
        <div class="cg-category-ads-section">
            <span class="cg-ad-badge"><i data-lucide="sparkles" style="width: 12px; height: 12px; vertical-align: middle;"></i> Anuncio Auspiciado</span>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <?php foreach ($publicidadesCategoria as $pub): ?>
                    <article class="cg-ad-card-premium">
                        <div class="cg-ad-card-premium-header">
                            <div class="cg-ad-card-premium-avatar">
                                <?php if (!empty($pub['imagen_negocio'])): ?>
                                    <img src="<?= htmlspecialchars($pub['imagen_negocio'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($pub['nombre_negocio'], ENT_QUOTES, 'UTF-8') ?>">
                                <?php else: ?>
                                    <?= strtoupper(substr($pub['nombre_negocio'], 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="cg-ad-card-premium-name"><?= htmlspecialchars($pub['nombre_negocio'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <span class="cg-ad-card-premium-type"><?= htmlspecialchars($pub['tipo_negocio'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        </div>
                        <p class="cg-ad-card-premium-desc"><?= htmlspecialchars($pub['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                        
                        <div class="cg-ad-card-premium-meta">
                            <span>📍 <?= htmlspecialchars($pub['direccion'] ?: $pub['zona'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if (!empty($pub['horario_atencion'])): ?>
                                <span>🕐 <?= htmlspecialchars($pub['horario_atencion'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Mapa desplegable si tiene coordenadas -->
                        <?php if (!empty($pub['latitud']) && !empty($pub['longitud'])): ?>
                            <div id="mapa_ad_<?= $pub['id'] ?>" class="ad-map-container" style="height: 200px; border-radius: 12px; margin-top: 4px; border: 1.5px solid #cbd5e1; display: none; z-index: 1;"></div>
                        <?php endif; ?>

                        <div class="trab-card-actions" style="margin-top: 4px;">
                            <a class="trab-btn trab-btn-primary" target="_blank"
                               data-track="whatsapp" data-tipo="publicidad" data-id="<?= htmlspecialchars($pub['id'], ENT_QUOTES, 'UTF-8') ?>"
                               href="https://wa.me/51<?= htmlspecialchars($pub['whatsapp'], ENT_QUOTES, 'UTF-8') ?>?text=<?= urlencode('Hola, vi tu anuncio premium en Connectgoo.') ?>"
                               style="background: #25D366; color: white;">
                                <i data-lucide="message-circle" style="width: 14px; height: 14px; vertical-align: middle; margin-right: 4px;"></i> <?= htmlspecialchars($pub['texto_cta'] ?: 'Contactar', ENT_QUOTES, 'UTF-8') ?>
                            </a>
                            
                            <?php if (!empty($pub['latitud']) && !empty($pub['longitud'])): ?>
                                <button class="trab-btn trab-btn-secondary toggle-ad-map-btn" 
                                        style="background: #f1f5f9; color: #475569; box-shadow: none;"
                                        data-id="<?= $pub['id'] ?>" 
                                        data-lat="<?= $pub['latitud'] ?>" 
                                        data-lng="<?= $pub['longitud'] ?>" 
                                        data-nombre="<?= htmlspecialchars($pub['nombre_negocio'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-tipo="<?= htmlspecialchars($pub['tipo_negocio'], ENT_QUOTES, 'UTF-8') ?>">
                                    📍 Ver ubicación
                                </button>
                            <?php elseif (!empty($pub['google_maps_url'])): ?>
                                <a class="trab-btn trab-btn-secondary" style="background: #f1f5f9; color: #475569; box-shadow: none;" target="_blank" href="<?= htmlspecialchars($pub['google_maps_url'], ENT_QUOTES, 'UTF-8') ?>">
                                    📍 Ubicación
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($trabajadores) === 0): ?>
        <div class="trab-empty">
            <i data-lucide="users" style="width: 48px; height: 48px; color: #94a3b8; margin-bottom: 16px;"></i>
            <h2>Sin profesionales aún</h2>
            <p>Pronto agregaremos trabajadores verificados para esta categoría.</p>
            <a href="categorias.php?ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" class="btn-primary" style="display:inline-block; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; margin-top: 16px;">
                Ver otras categorías
            </a>
        </div>
    <?php else: ?>
        <div class="trab-list">
            <?php foreach ($trabajadores as $t): ?>
                <article class="trab-card">
                    <div class="trab-card-header">
                        <div class="trab-card-avatar">
                            <?php if (!empty($t['foto_perfil'])): ?>
                                <img src="<?= htmlspecialchars($t['foto_perfil'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                            <?php else: ?>
                                <?= strtoupper(substr($t['nombre'], 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="trab-card-name"><?= htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
                            <span class="trab-card-service"><?= htmlspecialchars($t['especialidad'] ?: $t['servicio'], ENT_QUOTES, 'UTF-8') ?></span>
                            <div class="trab-card-badges">
                                <?php if ($t['verificado']): ?>
                                    <span class="trab-badge v"><i data-lucide="shield-check" style="width:10px;height:10px;display:inline-block;"></i> Verificado</span>
                                <?php endif; ?>
                                <?php if ($t['destacado']): ?>
                                    <span class="trab-badge d"><i data-lucide="star" style="width:10px;height:10px;display:inline-block;"></i> Destacado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="trab-card-info">
                        <span class="trab-chip"><i data-lucide="map-pin"></i> <?= htmlspecialchars($t['zona'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="trab-chip"><i data-lucide="briefcase"></i> <?= htmlspecialchars($t['experiencia'], ENT_QUOTES, 'UTF-8') ?> años</span>
                        <span class="trab-chip"><i data-lucide="star"></i> <?= htmlspecialchars($t['calificacion'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <div class="trab-card-actions">
                        <a class="trab-btn trab-btn-primary" href="perfil.php?id=<?= $t['id'] ?>">
                            Ver perfil
                        </a>
                        <a class="trab-btn trab-btn-secondary" target="_blank"
                           data-track="whatsapp" data-tipo="trabajador" data-id="<?= htmlspecialchars($t['id'], ENT_QUOTES, 'UTF-8') ?>"
                           href="https://wa.me/51<?= htmlspecialchars($t['whatsapp'], ENT_QUOTES, 'UTF-8') ?>?text=<?= urlencode('Hola, vi tu perfil en Connectgoo y necesito información sobre tu servicio de ' . $t['servicio'] . '.') ?>">
                           <i data-lucide="message-circle" style="width: 16px; height: 16px;"></i> WhatsApp
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script src="assets/js/main.js?v=3.3"></script>
<script>
    // Cargar CSS de Leaflet de manera dinámica si no está presente
    if (!document.querySelector('link[href*="leaflet.css"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        link.crossOrigin = '';
        document.head.appendChild(link);
    }
    // Cargar JS de Leaflet de manera dinámica si no está presente y enlazar el click handler
    if (typeof L === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.crossOrigin = '';
        script.onload = initAdMaps;
        document.head.appendChild(script);
    } else {
        initAdMaps();
    }

    function initAdMaps() {
        const mapInstances = {};
        
        document.querySelectorAll('.toggle-ad-map-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const lat = parseFloat(this.getAttribute('data-lat'));
                const lng = parseFloat(this.getAttribute('data-lng'));
                const nombre = this.getAttribute('data-nombre');
                const tipo = this.getAttribute('data-tipo');
                
                const container = document.getElementById(`mapa_ad_${id}`);
                if (!container) return;
                
                if (container.style.display === 'none') {
                    container.style.display = 'block';
                    this.classList.add('active');
                    this.innerHTML = '❌ Cerrar ubicación';
                    
                    // Inicializar si no se ha hecho
                    if (!mapInstances[id]) {
                        const mapaCalles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        });

                        const mapaSatelite = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            attribution: '&copy; Google Maps'
                        });

                        const map = L.map(`mapa_ad_${id}`, {
                            layers: [mapaCalles],
                            zoomControl: true,
                            scrollWheelZoom: false
                        }).setView([lat, lng], 17);

                        const baseMaps = {
                            "🗺️ Vista Calles": mapaCalles,
                            "🛰️ Vista Satélite": mapaSatelite
                        };
                        L.control.layers(baseMaps, null, { collapsed: false }).addTo(map);

                        L.marker([lat, lng]).addTo(map)
                            .bindPopup(`<strong>${nombre}</strong><br>${tipo}`)
                            .openPopup();
                            
                        mapInstances[id] = map;
                    } else {
                        // Refrescar tamaño por si acaso se inicializó oculto
                        setTimeout(() => {
                            mapInstances[id].invalidateSize();
                        }, 100);
                    }
                } else {
                    container.style.display = 'none';
                    this.classList.remove('active');
                    this.innerHTML = '📍 Ver ubicación';
                }
            });
        });
    }
</script>
<script>lucide.createIcons();</script>
</body>
</html>
