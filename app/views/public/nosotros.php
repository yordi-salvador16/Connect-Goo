<?php
// app/views/public/nosotros.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nosotros y Contacto - Connectgoo</title>
    <meta name="description" content="Conoce la misión y visión de Connectgoo, y contáctanos si necesitas ayuda.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="stylesheet" href="assets/css/styles.css?v=4.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.0">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-premium">

<!-- ====== NAVBAR ====== -->
<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="display:flex; align-items:center; gap:6px; text-decoration:none;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>

    <button class="cg-menu-toggle" type="button" aria-label="Abrir menu">
        <i data-lucide="menu"></i>
    </button>

    <nav class="cg-nav" id="mainNav">
        <a href="nosotros.php">Nosotros</a>
        <a href="categorias.php">Buscar servicios</a>
        <a href="planes.php">Registrar servicio</a>
        <a href="nosotros.php#contacto" class="nav-contact-icon desktop-only" title="Soporte y Contacto" style="display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:50%; background:#ecfdf5; color:#059669; text-decoration:none; margin-left:8px; transition:all 0.3s;">
            <i data-lucide="headset" style="width:20px;height:20px;"></i>
        </a>
    </nav>
</header>

<main class="main-content-premium" style="padding-top: 100px;">
    <!-- ====== ACERCA DE NOSOTROS ====== -->
    <section class="premium-section reveal" id="nosotros" style="padding: 60px 20px;">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="section-heading text-center" style="margin-bottom: 60px;">
                <h2 style="font-size: 42px; font-weight: 900; letter-spacing: -1.5px; color: #0f172a; margin-bottom: 16px;">Redefiniendo la conexión local.</h2>
                <p style="font-size: 18px; color: #64748b; max-width: 600px; margin: 0 auto; line-height: 1.6;">Construimos el puente directo entre el talento experto y las personas, potenciando la economía de la ciudad sin fricciones ni intermediarios.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
                <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08); border: 1px solid rgba(16, 185, 129, 0.1); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, rgba(255,255,255,0) 70%); border-radius: 50%;"></div>
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; color: white;">
                        <i data-lucide="target" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Nuestra Misión</h3>
                    <p style="color: #475569; font-size: 16px; line-height: 1.6;">Impulsar el talento independiente conectándolo de manera transparente con clientes que exigen resultados rápidos. Eliminamos las barreras tradicionales para asegurar un mercado local más dinámico y justo para todos.</p>
                </div>
                
                <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08); border: 1px solid rgba(37, 99, 235, 0.1); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(37,99,235,0.1) 0%, rgba(255,255,255,0) 70%); border-radius: 50%;"></div>
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; color: white;">
                        <i data-lucide="globe-2" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Nuestra Visión</h3>
                    <p style="color: #475569; font-size: 16px; line-height: 1.6;">Consolidarnos como la infraestructura digital central para el desarrollo económico de Tingo María y la región. Queremos ser el sistema operativo diario para todo servicio profesional independiente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CONTÁCTANOS ====== -->
    <section class="premium-section reveal" id="contacto">
        <div class="section-heading text-center">
            <h2 class="section-title"><i data-lucide="messages-square" style="color:#8b5cf6;"></i> Contáctanos</h2>
            <p class="section-desc">¿Necesitas ayuda para registrar tu servicio o tienes alguna duda?</p>
        </div>
        
        <div class="contact-card">
            <form id="contactForm" class="premium-form">
                <div class="form-group">
                    <label>Nombre completo</label>
                    <input type="text" id="contact_name" class="form-input" placeholder="Ej. Juan Pérez" required>
                </div>
                <div class="form-group">
                    <label>Celular / WhatsApp</label>
                    <input type="tel" id="contact_phone" class="form-input" pattern="[0-9]+" title="Solo se permiten números" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej. 987654321" required>
                </div>
                <div class="form-group">
                    <label>¿En qué podemos ayudarte?</label>
                    <textarea id="contact_message" class="form-input" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                <button type="submit" class="btn-hero-primary" style="width: 100%; justify-content: center; border: none; cursor: pointer;">
                    Enviar Mensaje <i data-lucide="send" style="width: 18px; height: 18px;"></i>
                </button>
            </form>
            <div id="contact-success" style="display: none; text-align: center; padding: 30px 20px; background: #ecfdf5; border-radius: 12px; color: #059669; font-weight: 600; margin-top: 20px; border: 1px solid #10b981;">
                <i data-lucide="check-circle-2" style="width: 48px; height: 48px; margin-bottom: 16px;"></i><br>
                <span style="font-size: 20px;">¡Mensaje enviado correctamente!</span><br>
                <span style="font-size: 15px; color: #475569; font-weight: 400; display: block; margin-top: 8px;">Nuestro equipo se comunicará contigo al WhatsApp muy pronto.</span>
            </div>
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
                <a href="https://www.facebook.com/share/1AFUDaV7LW/" target="_blank">
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

<script src="assets/js/main.js?v=4.0"></script>

<script>
// ====== CONTACT FORM HANDLER ======
document.addEventListener("DOMContentLoaded", function() {
    const contactForm = document.getElementById('contactForm');
    if(contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = contactForm.querySelector('button');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader-2" class="cg-spin" style="width: 18px; height: 18px;"></i> Enviando...';
            btn.disabled = true;
            lucide.createIcons();

            const data = {
                nombre: document.getElementById('contact_name').value,
                telefono: document.getElementById('contact_phone').value,
                mensaje: document.getElementById('contact_message').value
            };

            fetch('api_contacto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.ok) {
                    contactForm.style.display = 'none';
                    document.getElementById('contact-success').style.display = 'block';
                    lucide.createIcons();
                } else {
                    alert('Error: ' + data.error);
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                    lucide.createIcons();
                }
            })
            .catch(err => {
                alert('Hubo un error de conexión.');
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                lucide.createIcons();
            });
        });
    }
});
</script>

<style>
    .cg-spin { animation: spin 1s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
    .nav-contact-icon:hover { background: #d1fae5 !important; transform: scale(1.05); }
</style>

<script>lucide.createIcons();</script>
</body>
</html>
