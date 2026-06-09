<?php
// app/views/public/perfil.php
// Variables esperadas: $trabajador, $mensajeWhatsApp, $mensajeResena, $resenas, $id
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?> - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO y OpenGraph para WhatsApp/Facebook -->
    <?php
        $descCorta = mb_substr($trabajador['descripcion'], 0, 150) . '...';
        $imagenOg = !empty($trabajador['foto_perfil']) ? 'https://connectgoo.com/' . $trabajador['foto_perfil'] : 'https://connectgoo.com/assets/img/default-avatar.png';
        $tituloOg = $trabajador['nombre'] . ' | ' . $trabajador['servicio'] . ' en ' . ($trabajador['ciudad_nombre'] ?? 'Tingo María');
    ?>
    <meta name="description" content="<?= htmlspecialchars($descCorta, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($tituloOg, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($descCorta, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($imagenOg, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="https://connectgoo.com/perfil.php?id=<?= $trabajador['id'] ?>">

    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <!-- <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0"> -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <link rel="stylesheet" href="assets/css/perfil.css?v=1.1">
</head>
<body>

<div class="perfil-page">

    <a href="trabajadores.php?categoria=<?= $trabajador['categoria_id'] ?>&ciudad=<?= htmlspecialchars($trabajador['ciudad_slug'] ?? 'tingo-maria', ENT_QUOTES, 'UTF-8') ?>" class="btn-back-circle" title="Volver a la lista">
        <i data-lucide="arrow-left"></i>
    </a>

    <!-- Header Hero Section -->
    <div class="perfil-header">
        <div class="perfil-avatar">
            <?php if (!empty($trabajador['foto_perfil'])): ?>
                <img src="<?= htmlspecialchars($trabajador['foto_perfil'], ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
            <?php else: ?>
                <?= strtoupper(substr($trabajador['nombre'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div class="perfil-header-info">
            <h1 class="perfil-name"><?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="perfil-servicio"><?= htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8') ?></div>
            <div class="perfil-badges">
                <?php if ($trabajador['verificado']): ?>
                    <span class="perfil-badge verified"><i data-lucide="shield-check" style="width:14px;height:14px;"></i> Verificado</span>
                <?php endif; ?>
                <?php if ($trabajador['destacado']): ?>
                    <span class="perfil-badge featured"><i data-lucide="star" style="width:14px;height:14px;"></i> Destacado</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Info rápida (Glassmorphism Chips) -->
    <div class="perfil-info-grid">
        <div class="info-chip">
            <div class="info-chip-icon"><i data-lucide="map-pin"></i></div>
            <div class="info-chip-text">
                <strong><?= htmlspecialchars($trabajador['ciudad_nombre'] ?? 'Tingo María', ENT_QUOTES, 'UTF-8') ?></strong>
                <?= htmlspecialchars($trabajador['zona'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
        <div class="info-chip">
            <div class="info-chip-icon"><i data-lucide="briefcase"></i></div>
            <div class="info-chip-text">
                <strong><?= htmlspecialchars($trabajador['experiencia'], ENT_QUOTES, 'UTF-8') ?> años</strong>
                Experiencia
            </div>
        </div>
        <div class="info-chip">
            <div class="info-chip-icon"><i data-lucide="star"></i></div>
            <div class="info-chip-text">
                <strong><?= htmlspecialchars($trabajador['calificacion'], ENT_QUOTES, 'UTF-8') ?></strong>
                Calificación
            </div>
        </div>
        <div class="info-chip">
            <div class="info-chip-icon"><i data-lucide="clock"></i></div>
            <div class="info-chip-text">
                <strong><?= $trabajador['disponibilidad'] === 'Disponible previa coordinación' ? 'Disponible' : htmlspecialchars($trabajador['disponibilidad'], ENT_QUOTES, 'UTF-8') ?></strong>
                Estado
            </div>
        </div>
    </div>

    <?php if (!empty($trabajador['especialidad']) && $trabajador['especialidad'] !== 'Servicio general'): ?>
    <div class="perfil-section">
        <h2><i data-lucide="award"></i> Especialidad</h2>
        <p><?= htmlspecialchars($trabajador['especialidad'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    <?php endif; ?>

    <!-- Descripción -->
    <div class="perfil-section">
        <h2><i data-lucide="info"></i> Sobre el servicio</h2>
        <p><?= htmlspecialchars($trabajador['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <!-- Verificación -->
    <div class="perfil-section">
        <h2><i data-lucide="shield-check"></i> Verificación Connectgoo</h2>
        <div class="verif-row">
            <span class="verif-tag"><i data-lucide="check-circle-2" style="width:16px;"></i> Identidad validada</span>
            <span class="verif-tag"><i data-lucide="check-circle-2" style="width:16px;"></i> Experiencia probada</span>
            <span class="verif-tag"><i data-lucide="check-circle-2" style="width:16px;"></i> Aprobado</span>
            <span class="verif-tag"><i data-lucide="check-circle-2" style="width:16px;"></i> WhatsApp verificado</span>
        </div>
    </div>

    <?php if (!empty($trabajador['horario_atencion'])): ?>
    <div class="perfil-section">
        <h2><i data-lucide="calendar"></i> Horario de Atención</h2>
        <p><?= htmlspecialchars($trabajador['horario_atencion'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
    <?php endif; ?>

    <?php if (!empty($trabajador['latitud']) && !empty($trabajador['longitud'])): ?>
    <div class="perfil-section">
        <h2><i data-lucide="map"></i> Ubicación del Negocio</h2>
        <p style="margin-bottom: 16px;">📍 Ubicación exacta en <?= htmlspecialchars($trabajador['ciudad_nombre'] ?? 'Tingo María', ENT_QUOTES, 'UTF-8') ?>.</p>
        
        <!-- Leaflet Map CSS y JS (100% Gratis) -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        
        <div id="mapaPerfil" style="height: 240px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 16px; position: relative; z-index: 1;"></div>
        
        <div style="display: flex;">
            <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $trabajador['latitud'] ?>,<?= $trabajador['longitud'] ?>" 
               target="_blank" class="btn-primary"
               style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; text-decoration: none; font-size: 15px; font-weight: 700; padding: 14px; border-radius: 14px;">
                🚀 ¿Cómo llegar? (Abrir en Maps)
            </a>
        </div>
        
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lat = parseFloat("<?= $trabajador['latitud'] ?>");
            const lng = parseFloat("<?= $trabajador['longitud'] ?>");
            
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

            const map = L.map('mapaPerfil', {
                layers: [mapaCalles],
                zoomControl: true,
                scrollWheelZoom: false // Para evitar atrapar el scroll del usuario en celular
            }).setView([lat, lng], 16);

            // Agregar selector de capas visible en la parte superior derecha
            const baseMaps = {
                "🗺️ Vista Calles": mapaCalles,
                "🛰️ Vista Satélite": mapaSatelite
            };
            L.control.layers(baseMaps, null, { collapsed: false }).addTo(map);
            
            L.marker([lat, lng]).addTo(map)
                .bindPopup("<strong><?= htmlspecialchars($trabajador['nombre'], ENT_QUOTES, 'UTF-8') ?></strong><br><?= htmlspecialchars($trabajador['servicio'], ENT_QUOTES, 'UTF-8') ?>")
                .openPopup();
        });
        </script>
    </div>
    <?php endif; ?>

    <!-- Opiniones -->
    <div class="perfil-section">
        <h2><i data-lucide="message-square"></i> Opiniones (<?= count($resenas) ?>)</h2>

        <?php if ($mensajeResena): ?>
            <div class="alert <?= strpos($mensajeResena, 'Gracias') !== false ? 'alert-success' : 'alert-error' ?>" style="margin-bottom: 16px; padding: 12px 16px; border-radius: 12px; font-size: 14px; font-weight: 600; text-align: center; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                <?= $mensajeResena ?>
            </div>
        <?php endif; ?>

        <?php if (count($resenas) === 0): ?>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1;">
                <p style="color: #64748b; font-size: 14px; margin: 0;">Aún no hay opiniones. ¡Sé el primero en calificar!</p>
            </div>
        <?php else: ?>
            <?php foreach ($resenas as $resena): ?>
                <div class="review-card">
                    <div class="review-header">
                        <strong><?= htmlspecialchars($resena['nombre_cliente'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span style="color: #f59e0b; font-size: 14px; letter-spacing: 2px;"><?= str_repeat('★', $resena['puntuacion']) ?><span style="color: #cbd5e1;"><?= str_repeat('★', 5 - $resena['puntuacion']) ?></span></span>
                    </div>
                    <p><?= htmlspecialchars($resena['comentario'], ENT_QUOTES, 'UTF-8') ?></p>
                    <span class="review-date"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Formulario compacto -->
        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #f1f5f9;">
            <?php if (isset($_COOKIE['lead_registered'])): ?>
                <form method="POST" class="rating-form">
                    <input type="hidden" name="accion" value="calificar">
                    <input type="hidden" name="trabajador_id" value="<?= $id ?>">
                    
                    <div style="display: flex; align-items: center; gap: 8px; background: #eff6ff; border: 1.5px solid #bfdbfe; padding: 12px 16px; border-radius: 12px; font-size: 14px; color: #1e3a8a; margin-bottom: 16px;">
                        Comentando como: <strong style="color: #1d4ed8;"><?= htmlspecialchars($_COOKIE['lead_nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?></strong>
                    </div>
                    
                    <label>Tu Calificación</label>
                    <div class="star-rating" style="margin-bottom: 8px;">
                        <input type="radio" id="star5" name="puntuacion" value="5" required /><label for="star5"></label>
                        <input type="radio" id="star4" name="puntuacion" value="4" /><label for="star4"></label>
                        <input type="radio" id="star3" name="puntuacion" value="3" /><label for="star3"></label>
                        <input type="radio" id="star2" name="puntuacion" value="2" /><label for="star2"></label>
                        <input type="radio" id="star1" name="puntuacion" value="1" /><label for="star1"></label>
                    </div>

                    <label>Tu Comentario</label>
                    <textarea name="comentario" required placeholder="¿Cómo fue tu experiencia con este profesional?"></textarea>

                    <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; border-radius: 14px; font-size: 16px; font-weight: 800; margin-top: 8px;">Publicar opinión</button>
                </form>
            <?php else: ?>
                <div style="text-align: center; padding: 24px 20px; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 20px;">
                    <div style="width: 56px; height: 56px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i data-lucide="lock" style="color: #64748b; width: 24px; height: 24px;"></i>
                    </div>
                    <strong style="display: block; font-size: 16px; color: #1e293b; margin-bottom: 8px;">¿Quieres dejar una opinión?</strong>
                    <p style="font-size: 14px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">Debes iniciar sesión con Google para garantizar reseñas reales y confiables.</p>
                    <button type="button" onclick="document.getElementById('loginGateOverlay').classList.add('active')" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 24px; border-radius: 14px; font-size: 15px; font-weight: 800; border: none; cursor: pointer; margin: 0 auto; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);">
                        Iniciar sesión para opinar
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- WhatsApp Sticky Bottom -->
<div class="wa-sticky">
    <button class="btn-share" data-id="<?= htmlspecialchars($trabajador['id'], ENT_QUOTES, 'UTF-8') ?>" title="Recomendar / Compartir Perfil">
        <i data-lucide="share-2"></i>
    </button>
    
    <div style="flex: 1;">
        <?php if (isset($_COOKIE['lead_registered'])): ?>
            <a data-track="whatsapp" data-tipo="trabajador" data-id="<?= htmlspecialchars($trabajador['id'], ENT_QUOTES, 'UTF-8') ?>"
               href="https://wa.me/51<?= htmlspecialchars($trabajador['whatsapp'], ENT_QUOTES, 'UTF-8') ?>?text=<?= $mensajeWhatsApp ?>" target="_blank">
                <i data-lucide="message-circle"></i>
                Contactar por WhatsApp
            </a>
        <?php else: ?>
            <button onclick="document.getElementById('loginGateOverlay').classList.add('active')">
                <i data-lucide="message-circle"></i>
                Contactar por WhatsApp
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Google Login -->
<div class="login-gate-overlay" id="loginGateOverlay">
    <div class="login-gate-modal">
        <button class="close-modal" onclick="document.getElementById('loginGateOverlay').classList.remove('active')">&times;</button>
        <div style="width: 64px; height: 64px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
            <i data-lucide="shield-check" style="color: #10b981; width: 32px; height: 32px;"></i>
        </div>
        <h2>Seguridad Connectgoo</h2>
        <p>Inicia sesión con Google de forma rápida y segura para poder ver el contacto y dejar opiniones.</p>
        <div id="g_id_onload"
             data-client_id="1013745195759-q8ebirncb0a12j31auejrdvmsb3ucohe.apps.googleusercontent.com"
             data-callback="onClientGoogleLogin"
             data-auto_prompt="false">
        </div>
        <div class="g_id_signin"
             data-type="standard"
             data-shape="pill"
             data-theme="outline"
             data-text="signin_with"
             data-size="large"
             data-logo_alignment="center"
             style="display: flex; justify-content: center; margin-top: 24px;">
        </div>
    </div>
</div>

<script src="assets/js/main.js?v=3.3"></script>
<script>
    lucide.createIcons();

    // ====== SHARE PROFILE EVENT ======
    document.querySelectorAll('.btn-share').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var nombre = <?= json_encode($trabajador['nombre']) ?>;
            var servicio = <?= json_encode($trabajador['servicio']) ?>;
            var url = window.location.href;
            
            var shareText = "¡Te recomiendo a " + nombre + " para el servicio de " + servicio + " en ConnectGoo! Revisa su perfil aquí: " + url;
            
            console.log("Compartiendo perfil de:", nombre, id);
            
            // Track share in background via sendBeacon or fetch
            var formData = new FormData();
            formData.append('tipo', 'compartir');
            formData.append('entidad_id', id);
            
            if (navigator.sendBeacon) {
                navigator.sendBeacon('api_whatsapp_lead.php', formData);
            } else {
                fetch('api_whatsapp_lead.php', { method: 'POST', body: formData, keepalive: true });
            }
            
            // Web Share API or fallback
            if (navigator.share) {
                navigator.share({
                    title: nombre + ' - ConnectGoo',
                    text: shareText,
                    url: url
                }).then(function() {
                    if (window.showToast) showToast('¡Perfil recomendado con éxito!', 'success');
                }).catch(function(err) {
                    console.log('Compartido cancelado o no disponible', err);
                });
            } else {
                // Fallback to WhatsApp share
                var waUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareText);
                window.open(waUrl, '_blank');
            }
        });
    });

    function onClientGoogleLogin(response) {
        fetch('api_google_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                credential: response.credential,
                origen: 'solicitud_servicio'
            })
        })
        .then(r => r.json())
        .then(data => {
            document.cookie = 'lead_registered=1; path=/; max-age=' + (365*24*60*60);
            document.getElementById('loginGateOverlay').classList.remove('active');
            location.reload();
        })
        .catch(err => {
            alert('Error al registrar. Intenta de nuevo.');
        });
    }
</script>

<!-- Bottom nav spacer NO es necesario aquí porque el WA sticky cubre el bottom nav -->

</body>
</html>
