<?php
// app/views/public/solicitar_publicidad.php
// Variables esperadas: $enviado, $errores, $planActual, $tipoSeleccionado, $requiereCategoria, $requiereImagen, $requiereRedes, $requiereHorario, $requiereDireccion, $requiereCta, $categorias
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar publicidad - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/registrar-servicio.css?v=1.1">
</head>
<body class="bg-premium">

<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="display:flex; align-items:center; gap:6px; text-decoration:none;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>
</header>

<main class="register-page">

    <a href="planes_publicidad.php" class="btn-back-circle" title="Cambiar de plan">
        <i data-lucide="arrow-left"></i>
    </a>

    <header class="page-header">
        <h1>Publicita tu Negocio</h1>
        <p style="font-size: 15px; color: #475569; margin: 0; font-weight: 500;">
            Plan seleccionado: <span class="plan-badge-inline" style="background:#10b981; color:white; padding:4px 12px; border-radius:50px; font-size:12px; font-weight:700; margin-left:8px; text-transform:uppercase;"><?= htmlspecialchars($planActual['nombre'], ENT_QUOTES, 'UTF-8') ?></span> (<?= htmlspecialchars($planActual['duracion'], ENT_QUOTES, 'UTF-8') ?>)
        </p>
    </header>

    <?php if ($enviado): ?>

        <section class="success-card">
            <div class="success-icon">🎉</div>
            <h2>¡Solicitud recibida!</h2>
            <p>Tu anuncio será revisado por el administrador antes de ser publicado en Connectgoo. Nos pondremos en contacto contigo pronto.</p>
            <a href="index.php" class="btn-primary">Volver al inicio</a>
        </section>

    <?php else: ?>

        <?php if (!empty($errores)): ?>
            <section class="error-box">
                <strong>Corrige los siguientes campos:</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="form-card">
            <form method="POST" action="solicitar_publicidad.php" enctype="multipart/form-data">

                <input type="hidden" name="tipo_publicidad" value="<?= htmlspecialchars($tipoSeleccionado, ENT_QUOTES, 'UTF-8') ?>">

                <!-- Campo Honeypot Oculto (Trampa Anti-Bots) -->
                <div style="display:none;" aria-hidden="true">
                    <label for="cg_website_url">Deja este campo vacío si eres humano:</label>
                    <input type="text" name="cg_website_url" id="cg_website_url" value="" tabindex="-1" autocomplete="off">
                </div>

                <div class="notice-box" style="margin-bottom: 30px; background: #ecfdf5; border-color: #a7f3d0; color: #065f46;">
                    <i data-lucide="gift"></i> ¡Activando plan GRATIS por lanzamiento!
                </div>

                <label>Nombre de tu Negocio *</label>
                <input type="text" name="nombre_negocio" placeholder="Ej: Café Aroma de Tingo" value="<?= htmlspecialchars($_POST['nombre_negocio'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label>¿Qué vendes o qué servicio ofreces? *</label>
                <input type="text" name="tipo_negocio" placeholder="Ej: Café, postres, desayunos" value="<?= htmlspecialchars($_POST['tipo_negocio'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label>Tu número de WhatsApp *</label>
                <input type="tel" name="whatsapp" pattern="[0-9]+" title="Solo se permiten números" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 999123456" value="<?= htmlspecialchars($_POST['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label>Descripción de tu promoción o negocio *</label>
                <textarea name="descripcion" rows="4" placeholder="Cuéntanos brevemente sobre lo que ofreces o cuál es tu promoción..." required><?= htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

                <?php if ($requiereRedes): ?>
                    <label>Enlace a tu Facebook o Instagram (Opcional)</label>
                    <input type="url" name="redes_sociales" placeholder="https://facebook.com/tu-negocio" value="<?= htmlspecialchars($_POST['redes_sociales'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php endif; ?>

                <?php if ($requiereHorario): ?>
                    <label>Horario de atención *</label>
                    <input type="text" name="horario_atencion" placeholder="Ej: Lunes a Sábado de 8:00 AM a 9:00 PM" value="<?= htmlspecialchars($_POST['horario_atencion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                <?php endif; ?>

                <?php if ($requiereCategoria): ?>
                    <label>¿En qué categoría quieres aparecer? *</label>
                    <select name="categoria_id" required>
                        <option value="">Selecciona una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= (isset($_POST['categoria_id']) && $_POST['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <?php if ($requiereDireccion): ?>
                    <label>Dirección física del local *</label>
                    <input type="text" name="direccion" placeholder="Ej: Av. Alameda 123 (Cerca a la plaza)" value="<?= htmlspecialchars($_POST['direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                    <!-- Librerías de Leaflet Map (100% Gratis, Sin Claves de API) -->
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

                    <div class="map-actions" style="margin-top: 16px; margin-bottom: 12px; display: flex; gap: 8px;">
                        <button type="button" id="btnUsarUbicacion" class="btn-secondary" style="flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                            📍 Usar mi ubicación GPS
                        </button>
                    </div>

                    <div id="mapaNegocio" class="map-box" style="height: 280px; border-radius: 16px; border: 2px solid #cbd5e1; margin-bottom: 15px; position: relative; z-index: 1;"></div>

                    <input type="hidden" name="latitud" id="latitud" value="<?= htmlspecialchars($_POST['latitud'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="longitud" id="longitud" value="<?= htmlspecialchars($_POST['longitud'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <label>Enlace de Google Maps, opcional</label>
                    <input 
                        type="url" 
                        id="google_maps_url" 
                        name="google_maps_url" 
                        placeholder="Se generará automáticamente si marcas el mapa"
                        value="<?= htmlspecialchars($_POST['google_maps_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        readonly
                        style="background-color: #f1f5f9; cursor: not-allowed; color: #64748b;"
                    >

                    <div class="notice-box">
                        <i data-lucide="lightbulb" style="color: #eab308;"></i> Arrastra el marcador en el mapa de arriba o haz clic en cualquier lugar para ubicar con precisión tu negocio.
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const latInput = document.getElementById("latitud");
                        const lngInput = document.getElementById("longitud");
                        const mapsUrlInput = document.getElementById("google_maps_url");
                        const btnGPS = document.getElementById("btnUsarUbicacion");
                        
                        let defaultLat = -9.29532;
                        let defaultLng = -75.9974;
                        
                        if (latInput.value && lngInput.value) {
                            defaultLat = parseFloat(latInput.value);
                            defaultLng = parseFloat(lngInput.value);
                        } else {
                            latInput.value = defaultLat;
                            lngInput.value = defaultLng;
                        }
                        
                        // Capas de mapa: Calles y Satélite de alta resolución
                        const mapaCalles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        });

                        const mapaSatelite = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            attribution: '&copy; Google Maps'
                        });

                        // Inicializar el mapa de Leaflet con la capa de calles activa por defecto
                        const map = L.map('mapaNegocio', {
                            layers: [mapaCalles]
                        }).setView([defaultLat, defaultLng], 15);

                        // Agregar selector de capas en la parte superior derecha de forma visible (no colapsada)
                        const baseMaps = {
                            "🗺️ Vista Calles": mapaCalles,
                            "🛰️ Vista Satélite (Casas)": mapaSatelite
                        };
                        L.control.layers(baseMaps, null, { collapsed: false }).addTo(map);
                        
                        const marker = L.marker([defaultLat, defaultLng], {
                            draggable: true
                        }).addTo(map);
                        
                        function updateCoordinates(lat, lng) {
                            latInput.value = lat.toFixed(6);
                            lngInput.value = lng.toFixed(6);
                            if (mapsUrlInput) {
                                mapsUrlInput.value = `https://www.google.com/maps/search/?api=1&query=${lat.toFixed(6)},${lng.toFixed(6)}`;
                            }
                        }
                        
                        updateCoordinates(defaultLat, defaultLng);
                        
                        marker.on('dragend', function (e) {
                            const position = marker.getLatLng();
                            updateCoordinates(position.lat, position.lng);
                        });
                        
                        map.on('click', function (e) {
                            marker.setLatLng(e.latlng);
                            updateCoordinates(e.latlng.lat, e.latlng.lng);
                        });
                        
                        if (btnGPS) {
                            btnGPS.addEventListener("click", function () {
                                if (!navigator.geolocation) {
                                    alert("Tu navegador no soporta geolocalización.");
                                    return;
                                }
                                
                                btnGPS.disabled = true;
                                btnGPS.textContent = "⌛ Obteniendo ubicación...";
                                
                                navigator.geolocation.getCurrentPosition(
                                    function (position) {
                                        const lat = position.coords.latitude;
                                        const lng = position.coords.longitude;
                                        
                                        map.setView([lat, lng], 17);
                                        marker.setLatLng([lat, lng]);
                                        updateCoordinates(lat, lng);
                                        
                                        btnGPS.disabled = false;
                                        btnGPS.textContent = "📍 Ubicación Obtenida";
                                        setTimeout(() => {
                                            btnGPS.textContent = "📍 Usar mi ubicación GPS";
                                        }, 3000);
                                    },
                                    function (error) {
                                        let msg = "No se pudo obtener la ubicación.";
                                        if (error.code === error.PERMISSION_DENIED) {
                                            msg = "Permiso de ubicación denegado. Asegúrate de dar permisos de ubicación a connectgoo.com en tu navegador Chrome o en los ajustes de tu celular.";
                                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                                            msg = "La ubicación no está disponible actualmente. Asegúrate de tener activa la 'Ubicación' en la barra superior de tu celular.";
                                        } else if (error.code === error.TIMEOUT) {
                                            msg = "Tiempo de espera agotado. Vuelve a intentarlo en un lugar con mejor señal o asegúrate de tener activa la 'Ubicación' (GPS) de tu celular.";
                                        }
                                        alert(msg);
                                        btnGPS.disabled = false;
                                        btnGPS.textContent = "📍 Usar mi ubicación GPS";
                                    },
                                    { enableHighAccuracy: false, timeout: 15000, maximumAge: 30000 }
                                );
                            });
                        }
                    });
                    </script>
                <?php endif; ?>

                <?php if ($requiereImagen): ?>
                    <label>Sube una foto de tu negocio o logo *</label>
                    <input type="file" name="imagen_negocio" accept="image/*" required>
                    <div class="notice-box">
                        <i data-lucide="image" style="color: #3b82f6;"></i> Sube una imagen clara para tu banner publicitario. Formatos permitidos: JPG, PNG o WEBP. Tamaño máximo: 3 MB.
                    </div>
                <?php endif; ?>

                <?php if ($requiereCta): ?>
                    <label>¿Qué quieres que diga el botón principal? *</label>
                    <select name="texto_cta" required>
                        <option value="Contactar por WhatsApp" <?= (isset($_POST['texto_cta']) && $_POST['texto_cta'] == 'Contactar por WhatsApp') ? 'selected' : '' ?>>Contactar por WhatsApp</option>
                        <option value="Pedir Delivery" <?= (isset($_POST['texto_cta']) && $_POST['texto_cta'] == 'Pedir Delivery') ? 'selected' : '' ?>>Pedir Delivery</option>
                        <option value="Reservar ahora" <?= (isset($_POST['texto_cta']) && $_POST['texto_cta'] == 'Reservar ahora') ? 'selected' : '' ?>>Reservar ahora</option>
                        <option value="Ver Catálogo" <?= (isset($_POST['texto_cta']) && $_POST['texto_cta'] == 'Ver Catálogo') ? 'selected' : '' ?>>Ver Catálogo</option>
                        <option value="Solicitar información" <?= (isset($_POST['texto_cta']) && $_POST['texto_cta'] == 'Solicitar información') ? 'selected' : '' ?>>Solicitar información</option>
                    </select>
                <?php endif; ?>

                <label class="checkbox-label">
                    <input type="checkbox" name="acepta" required>
                    Acepto que mi anuncio sea revisado por el administrador.
                </label>

                <button type="submit" class="form-button">Enviar solicitud de publicidad</button>

            </form>
        </section>

    <?php endif; ?>

</main>

<script src="assets/js/main.js?v=3.3"></script>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script>lucide.createIcons();</script>
</body>
</html>
