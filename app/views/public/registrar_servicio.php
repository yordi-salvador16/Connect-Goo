<?php
// app/views/public/registrar_servicio.php
// Variables esperadas: $enviado, $errores, $planActual, $tipoPlan, $requiereEspecialidad, $requiereHorario, $muestraFoto, $requiereFoto, $requiereReferencia, $muestraMapaEmprendimiento, $categorias, $ciudades, $planSeleccionado
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar mi servicio - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">
    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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

    <a href="planes.php" class="btn-back-circle" title="Volver a planes">
        <i data-lucide="arrow-left"></i>
    </a>

    <header class="page-header">
        <h1>Registra tu servicio</h1>
        <p>Completa tus datos para solicitar aparecer en Connectgoo.</p>
    </header>

    <?php if ($enviado): ?>

        <section class="success-card">
            <div class="success-icon">🎉</div>
            <h2>Solicitud enviada correctamente</h2>
            <p>Gracias por registrar tu servicio. Un administrador revisará tu información antes de publicar tu perfil para asegurar la calidad de la plataforma.</p>
            <p><strong>Estado de solicitud:</strong> Pendiente de revisión</p>
            <a href="index.php" class="btn-primary">Volver al inicio</a>
        </section>

    <?php else: ?>

        <section class="selected-plan-card <?= htmlspecialchars($tipoPlan, ENT_QUOTES, 'UTF-8') ?>">
            <span class="plan-badge">Plan seleccionado</span>
            <h2>Plan <?= htmlspecialchars($planActual['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
            <h3><?= precioPlanTexto($planActual['precio']) ?></h3>
            <p><?= htmlspecialchars(descripcionPlanTrabajador($tipoPlan), ENT_QUOTES, 'UTF-8') ?></p>
            <a href="planes.php" class="clear-search">Cambiar plan</a>
        </section>

        <?php if (!empty($errores)): ?>
            <section class="error-box">
                <strong>Revisa los siguientes campos:</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="form-card">

            <form method="POST" action="registrar_servicio.php" enctype="multipart/form-data">

                <input type="hidden" name="plan_id" value="<?= intval($planSeleccionado) ?>">
                <input type="hidden" name="registrado_con_google" id="registrado_con_google" value="<?= isset($_COOKIE['lead_registered']) ? '1' : '0' ?>">

                <!-- Campo Honeypot Oculto (Trampa Anti-Bots) -->
                <div style="display:none;" aria-hidden="true">
                    <label for="cg_website_url">Deja este campo vacío si eres humano:</label>
                    <input type="text" name="cg_website_url" id="cg_website_url" value="" tabindex="-1" autocomplete="off">
                </div>

                <?php if (!isset($_COOKIE['lead_registered'])): ?>
                <div id="google-autofill-box" class="google-autofill-container" style="margin-bottom: 25px; padding: 20px; background: #ecfdf5; border: 1.5px dashed #10b981; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.05);">
                    <p style="margin: 0 0 16px 0; font-size: 15px; font-weight: 800; color: #065f46;">💡 ¿Quieres autocompletar con tu cuenta de Google?</p>
                    <div style="display: flex; justify-content: center;">
                        <div class="g_id_signin"
                             data-type="standard"
                             data-shape="pill"
                             data-theme="outline"
                             data-text="signin_with"
                             data-size="large"
                             data-logo_alignment="left">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <label>Nombre completo o nombre del negocio *</label>
                <input type="text" name="nombre" placeholder="Ej: Juan Pérez o Bodega La Esquina" value="<?= old('nombre') ?: htmlspecialchars($_COOKIE['lead_nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label>Correo electrónico *</label>
                <input type="email" name="email" placeholder="Ej: tucorreo@gmail.com" value="<?= old('email') ?: htmlspecialchars($_COOKIE['lead_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label>Servicio que ofrece *</label>
                <select name="categoria_id" id="categoria_id" required>
                    <option value="">Selecciona un servicio</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option 
                            value="<?= intval($categoria['id']) ?>"
                            data-nombre="<?= htmlspecialchars(strtolower($categoria['nombre']), ENT_QUOTES, 'UTF-8') ?>"
                            <?= intval($_POST['categoria_id'] ?? 0) === intval($categoria['id']) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Ciudad donde ofreces el servicio *</label>
                <select name="ciudad_id" id="ciudad_id" required>
                    <option value="">Selecciona tu ciudad</option>
                    <?php foreach ($ciudades as $ciudad): ?>
                        <option 
                            value="<?= intval($ciudad['id']) ?>"
                            <?= intval($_POST['ciudad_id'] ?? 0) === intval($ciudad['id']) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($requiereEspecialidad): ?>
                    <label id="especialidad-label">Especialidad o rubro principal *</label>
                    <input 
                        type="text" 
                        name="especialidad" 
                        placeholder="Ej: Instalaciones eléctricas, venta de abarrotes, comida rápida" 
                        value="<?= old('especialidad') ?>" 
                        required
                    >
                <?php else: ?>
                    <div class="notice-box">
                        <i data-lucide="info" style="color:#3b82f6;"></i> En el plan Básico no es necesario detallar especialidad. Solo se mostrará el servicio principal, zona, dirección si es emprendimiento y WhatsApp.
                    </div>
                <?php endif; ?>

                <label>Zona donde trabaja o atiende *</label>
                <input type="text" name="zona" placeholder="Ej: Castillo Grande, Centro de Tingo María" value="<?= old('zona') ?>" required>

                <section id="emprendimiento-fields" class="conditional-fields hidden">
                    <h2>Datos del emprendimiento local</h2>
                    <p>
                        Esta información se mostrará cuando el servicio seleccionado sea 
                        <strong>Emprendimientos locales</strong>.
                    </p>

                    <label style="margin-top:0;">Dirección del negocio *</label>
                    <input 
                        type="text" 
                        id="direccion" 
                        name="direccion" 
                        placeholder="Ej: Av. Raymondi 458, Tingo María" 
                        value="<?= old('direccion') ?>"
                    >

                    <?php if ($muestraMapaEmprendimiento): ?>
                        <!-- Librerías de Leaflet Map (100% Gratis, Sin Claves de API) -->
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

                        <div class="map-actions" style="margin-top: 16px; margin-bottom: 12px; display: flex; gap: 8px;">
                            <button type="button" id="btnUsarUbicacion" class="btn-secondary" style="flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                📍 Usar mi ubicación GPS
                            </button>
                        </div>

                        <div id="mapaNegocio" class="map-box" style="height: 320px; border-radius: 16px; border: 2px solid #cbd5e1; margin-bottom: 15px; position: relative; z-index: 1;"></div>

                        <input type="hidden" name="latitud" id="latitud" value="<?= old('latitud') ?>">
                        <input type="hidden" name="longitud" id="longitud" value="<?= old('longitud') ?>">

                        <label>Enlace de Google Maps, opcional</label>
                        <input 
                            type="url" 
                            id="google_maps_url" 
                            name="google_maps_url" 
                            placeholder="Se generará automáticamente si eliges una ubicación"
                            value="<?= old('google_maps_url') ?>"
                            readonly
                            style="background-color: #f1f5f9; cursor: not-allowed; color: #64748b;"
                        >

                        <div class="notice-box">
                            <i data-lucide="lightbulb" style="color:#f59e0b;"></i> Arrastra el marcador en el mapa de arriba o haz clic en cualquier lugar para ubicar con precisión tu emprendimiento en la ciudad.
                        </div>

                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const latInput = document.getElementById("latitud");
                            const lngInput = document.getElementById("longitud");
                            const mapsUrlInput = document.getElementById("google_maps_url");
                            const btnGPS = document.getElementById("btnUsarUbicacion");
                            
                            // Coordenadas por defecto (Tingo María)
                            let defaultLat = -9.29532;
                            let defaultLng = -75.9974;
                            
                            // Si ya existen coordenadas previas guardadas (por ejemplo si falló la validación)
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
                            
                            // Agregar un marcador arrastrable (draggable)
                            const marker = L.marker([defaultLat, defaultLng], {
                                draggable: true
                            }).addTo(map);
                            
                            // Función para actualizar coordenadas en los inputs
                            function updateCoordinates(lat, lng) {
                                latInput.value = lat.toFixed(6);
                                lngInput.value = lng.toFixed(6);
                                if (mapsUrlInput) {
                                    mapsUrlInput.value = `https://www.google.com/maps/search/?api=1&query=${lat.toFixed(6)},${lng.toFixed(6)}`;
                                }
                            }
                            
                            // Inicializar campos con valores por defecto si estaban vacíos
                            updateCoordinates(defaultLat, defaultLng);
                            
                            // Al arrastrar el marcador
                            marker.on('dragend', function (e) {
                                const position = marker.getLatLng();
                                updateCoordinates(position.lat, position.lng);
                            });
                            
                            // Al hacer clic en cualquier parte del mapa, mover el marcador allí
                            map.on('click', function (e) {
                                marker.setLatLng(e.latlng);
                                updateCoordinates(e.latlng.lat, e.latlng.lng);
                            });
                            
                            // Geolocalización del dispositivo mediante GPS optimizada para interiores y móviles
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
                </section>

                <label>Número de WhatsApp *</label>
                <input type="tel" name="whatsapp" pattern="[0-9]+" title="Solo se permiten números" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 999123456" value="<?= old('whatsapp') ?>" required>

                <div class="notice-box">
                    <i data-lucide="smartphone" style="color:#10b981;"></i> Tu WhatsApp aparecerá en tu perfil para que los clientes puedan contactarte directamente con un solo clic.
                </div>

                <label>Años de experiencia *</label>
                <input type="number" name="experiencia" placeholder="Ej: 5" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?= old('experiencia') ?>" required>

                <?php if ($muestraFoto): ?>
                    <label>
                        Foto de perfil o imagen representativa <?= $requiereFoto ? '*' : '' ?>
                    </label>
                    <input 
                        type="file" 
                        name="foto_perfil" 
                        accept="image/jpeg,image/png,image/webp" 
                        <?= $requiereFoto ? 'required' : '' ?>
                    >

                    <div class="notice-box">
                        <i data-lucide="camera" style="color:#8b5cf6;"></i> <?= $requiereFoto 
                            ? 'En el plan Premium la foto es obligatoria para generar mayor confianza.' 
                            : 'En el plan Destacado la foto es opcional, pero ayuda a que tu perfil se vea más confiable.' 
                        ?>
                        Formatos permitidos: JPG, PNG o WEBP. Tamaño máximo: 2 MB.
                    </div>
                <?php endif; ?>

                <?php if ($requiereHorario): ?>
                    <label>Horario de atención *</label>
                    <input 
                        type="text" 
                        name="horario_atencion" 
                        placeholder="Ej: Lunes a sábado de 8:00 a.m. a 6:00 p.m." 
                        value="<?= old('horario_atencion') ?>" 
                        required
                    >
                <?php endif; ?>

                <?php if ($requiereReferencia): ?>
                    <label>Referencia de zona o forma de atención *</label>
                    <input 
                        type="text" 
                        name="referencia_zona" 
                        placeholder="Ej: Frente al mercado modelo o atiendo a domicilio previa coordinación" 
                        value="<?= old('referencia_zona') ?>" 
                        required
                    >

                    <label class="checkbox-label">
                        <input type="checkbox" name="atiende_domicilio" <?= isset($_POST['atiende_domicilio']) ? 'checked' : 'checked' ?>>
                        Atiendo a domicilio o previa coordinación.
                    </label>
                <?php else: ?>
                    <input type="hidden" name="atiende_domicilio" value="1">
                <?php endif; ?>

                <label>Breve descripción del servicio o negocio *</label>
                <textarea name="descripcion" rows="5" placeholder="Describe tu experiencia, servicios, productos o promociones..." required><?= old('descripcion') ?></textarea>

                <div class="notice-box" style="margin-top: 24px;">
                    <i data-lucide="shield-check" style="color:#0ea5e9;"></i> Tu perfil no se publicará automáticamente. Primero será revisado por un administrador para asegurar que la información sea correcta.
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" name="acepta" required>
                    Acepto que mi información sea revisada antes de publicarse.
                </label>

                <button type="submit" class="form-button">Enviar solicitud</button>

            </form>

        </section>

    <?php endif; ?>

</main>

<script src="assets/js/main.js?v=3.3"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const categoriaSelect = document.getElementById("categoria_id");
    const emprendimientoFields = document.getElementById("emprendimiento-fields");
    const direccionInput = document.getElementById("direccion");

    function actualizarCamposEmprendimiento() {
        if (!categoriaSelect || !emprendimientoFields || !direccionInput) return;

        const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
        const nombreCategoria = selectedOption ? selectedOption.dataset.nombre || "" : "";
        const esEmprendimiento = nombreCategoria.includes("emprendimiento");

        if (esEmprendimiento) {
            emprendimientoFields.classList.remove("hidden");
            direccionInput.setAttribute("required", "required");
        } else {
            emprendimientoFields.classList.add("hidden");
            direccionInput.removeAttribute("required");
        }
    }

    if (categoriaSelect) {
        categoriaSelect.addEventListener("change", actualizarCamposEmprendimiento);
        actualizarCamposEmprendimiento();
    }
});
</script>
<?php if (!isset($_COOKIE['lead_registered'])): ?>
<div id="g_id_onload"
     data-client_id="1013745195759-q8ebirncb0a12j31auejrdvmsb3ucohe.apps.googleusercontent.com"
     data-context="use"
     data-ux_mode="popup"
     data-callback="handleGoogleResponse"
     data-auto_prompt="false">
</div>

<script>
function decodeJwt(token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}

function handleGoogleResponse(response) {
    try {
        const userData = decodeJwt(response.credential);
        
        // Registrar que viene verificado por Google
        const regGoogleInput = document.getElementById('registrado_con_google');
        if (regGoogleInput) regGoogleInput.value = '1';
        
        // Autocompletar inputs en tiempo real de forma ultra-veloz
        if (userData.email) {
            const emailInput = document.querySelector('input[name="email"]');
            if (emailInput) emailInput.value = userData.email;
        }
        if (userData.name) {
            const nombreInput = document.querySelector('input[name="nombre"]');
            if (nombreInput) nombreInput.value = userData.name;
        }

        // Ocultar caja de autocompletado con desvanecimiento elegante
        const box = document.getElementById('google-autofill-box');
        if (box) {
            box.style.transition = 'all 0.4s ease';
            box.style.opacity = '0';
            setTimeout(() => box.remove(), 400);
        }

        // Guardar el lead en segundo plano en la base de datos de adquisición
        fetch('api_google_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                credential: response.credential, 
                origen: 'registro_trabajador' 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                // Establecer las cookies en JS para futuras visitas
                const date = new Date();
                date.setTime(date.getTime() + (365*24*60*60*1000));
                document.cookie = "lead_registered=1; expires=" + date.toUTCString() + "; path=/";
                document.cookie = "lead_email=" + encodeURIComponent(userData.email) + "; expires=" + date.toUTCString() + "; path=/";
                document.cookie = "lead_nombre=" + encodeURIComponent(userData.name) + "; expires=" + date.toUTCString() + "; path=/";
            }
        })
        .catch(err => console.error("Error al registrar lead:", err));
    } catch (e) {
        console.error("Error procesando login:", e);
    }
}
</script>
<?php endif; ?>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script>lucide.createIcons();</script>
</body>
</html>
