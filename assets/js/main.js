document.addEventListener("DOMContentLoaded", function () {

    // ====== TOAST NOTIFICATION SYSTEM ======
    window.showToast = function(message, type) {
        type = type || 'info';
        var toast = document.createElement('div');
        toast.className = 'cg-toast cg-toast-' + type;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        requestAnimationFrame(function() {
            toast.classList.add('cg-toast-show');
        });
        
        setTimeout(function() {
            toast.classList.remove('cg-toast-show');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    };

    // ====== SMOOTH SCROLL ======
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function (e) {
            var targetId = this.getAttribute('href');
            if (targetId === '#') return;
            var target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Close mobile menu if open
                var nav = document.getElementById('mainNav');
                if (nav) nav.classList.remove('open');
            }
        });
    });

    // ====== MOBILE MENU ======
    var menuButton = document.querySelector(".cg-menu-toggle");
    var navLinks = document.getElementById("mainNav");

    if (menuButton && navLinks) {
        menuButton.addEventListener("click", function () {
            navLinks.classList.toggle("open");
            var icon = menuButton.querySelector('i, svg');
            if (icon) {
                var isOpen = navLinks.classList.contains('open');
                icon.setAttribute('data-lucide', isOpen ? 'x' : 'menu');
                lucide.createIcons();
            }
        });
    }

    // ====== GEOLOCATION ======
    var geoBtn = document.getElementById('geoBtn');
    if (geoBtn) {
        geoBtn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                showToast('Tu navegador no soporta geolocalizacion.', 'error');
                return;
            }
            
            geoBtn.disabled = true;
            geoBtn.innerHTML = '<i data-lucide="loader-2" class="cg-spin"></i> Detectando...';
            lucide.createIcons();
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    showToast('Ubicacion detectada! Redirigiendo...', 'success');
                    setTimeout(function() {
                        window.location.href = "categorias.php?ciudad=tingo-maria";
                    }, 1000);
                },
                function(error) {
                    geoBtn.disabled = false;
                    geoBtn.innerHTML = '<i data-lucide="navigation"></i> Usar mi ubicacion';
                    lucide.createIcons();
                    showToast('No pudimos obtener tu ubicacion. Selecciona manualmente.', 'error');
                },
                { timeout: 8000 }
            );
        });
    }

    // ====== HERO DYNAMIC CARDS ======
    var services = [
        { icon: "⚡", title: "Electricista", subtitle: "Instalaciones y reparaciones", extraTitle: "Disponible hoy", extraSubtitle: "Atencion rapida" },
        { icon: "💧", title: "Gasfitero", subtitle: "Fugas y tuberias", extraTitle: "A domicilio", extraSubtitle: "Previa coordinacion" },
        { icon: "📱", title: "Tec. celulares", subtitle: "Pantalla y software", extraTitle: "Centro de Tingo", extraSubtitle: "Revision rapida" },
        { icon: "🛵", title: "Mototaxi", subtitle: "Traslado rapido", extraTitle: "Disponible ahora", extraSubtitle: "Por WhatsApp" },
        { icon: "🧹", title: "Limpieza", subtitle: "Hogar y oficina", extraTitle: "Verificado", extraSubtitle: "Confiable" },
        { icon: "🧭", title: "Guia turistico", subtitle: "Rutas y paseos", extraTitle: "Tingo Maria", extraSubtitle: "Experiencia local" },
        { icon: "🪚", title: "Carpinteria", subtitle: "Muebles y reparaciones", extraTitle: "Trabajo local", extraSubtitle: "Cotiza por WhatsApp" },
        { icon: "🏪", title: "Negocios", subtitle: "Tiendas locales", extraTitle: "Promociones", extraSubtitle: "Cerca de ti" }
    ];

    var useDb = (typeof dbWorkers !== "undefined" && Array.isArray(dbWorkers) && dbWorkers.length > 0);
    var servicesList = useDb ? dbWorkers : services;
    var currentIndex = 0;

    var iconEl = document.getElementById("dynamic-icon");
    var titleEl = document.getElementById("dynamic-title");
    var subtitleEl = document.getElementById("dynamic-subtitle");
    var extraTitleEl = document.getElementById("dynamic-extra-title");
    var extraSubtitleEl = document.getElementById("dynamic-extra-subtitle");
    var topCard = document.getElementById("dynamic-card-top");
    var bottomCard = document.getElementById("dynamic-card-bottom");

    function getIconForService(service, specialty) {
        var text = ((service || "") + " " + (specialty || "")).toLowerCase();
        if (text.indexOf("electr") !== -1) return "⚡";
        if (text.indexOf("gasfi") !== -1 || text.indexOf("agua") !== -1 || text.indexOf("tuberia") !== -1) return "💧";
        if (text.indexOf("limp") !== -1 || text.indexOf("aseo") !== -1) return "🧹";
        if (text.indexOf("celu") !== -1 || text.indexOf("compu") !== -1 || text.indexOf("tecn") !== -1) return "📱";
        if (text.indexOf("moto") !== -1 || text.indexOf("viaje") !== -1 || text.indexOf("flete") !== -1) return "🛵";
        if (text.indexOf("turi") !== -1 || text.indexOf("gui") !== -1 || text.indexOf("selva") !== -1) return "🧭";
        if (text.indexOf("carp") !== -1 || text.indexOf("mader") !== -1) return "🪚";
        if (text.indexOf("repa") !== -1 || text.indexOf("dulce") !== -1 || text.indexOf("past") !== -1 || text.indexOf("tort") !== -1) return "🍰";
        return "🏪";
    }

    function rotateServices() {
        if (!iconEl || !titleEl || !topCard || !bottomCard) return;

        topCard.classList.add("fade-swap");
        bottomCard.classList.add("fade-swap");
        var heroImg = document.getElementById("dynamic-hero-img");
        if (heroImg) heroImg.style.opacity = "0.15";

        setTimeout(function () {
            currentIndex = (currentIndex + 1) % servicesList.length;
            var item = servicesList[currentIndex];

            if (useDb) {
                // Real DB worker
                var nameText = item.nombre || "";
                var serviceText = item.servicio || "Servicio verificado";
                var specText = item.especialidad || "";
                
                iconEl.textContent = getIconForService(item.servicio, item.especialidad);
                titleEl.textContent = nameText;
                subtitleEl.textContent = serviceText + (specText ? " · " + specText : "");
                
                extraTitleEl.textContent = (parseInt(item.atiende_domicilio) === 1) ? "🏡 A domicilio" : "📍 Local físico";
                extraSubtitleEl.textContent = item.zona || "Tingo María";
                
                var linkEl = document.getElementById("dynamic-hero-link");
                if (linkEl) {
                    linkEl.href = "perfil.php?id=" + item.id;
                }
                
                if (heroImg) {
                    heroImg.src = item.foto_perfil ? item.foto_perfil : "assets/img/hero.png";
                }
            } else {
                // Static fallback list
                iconEl.textContent = item.icon;
                titleEl.textContent = item.title;
                subtitleEl.textContent = item.subtitle;
                extraTitleEl.textContent = item.extraTitle;
                extraSubtitleEl.textContent = item.extraSubtitle;
                
                var linkEl = document.getElementById("dynamic-hero-link");
                if (linkEl) {
                    linkEl.href = "categorias.php";
                }
                if (heroImg) {
                    heroImg.src = "assets/img/hero.png";
                }
            }

            if (heroImg) heroImg.style.opacity = "1";
            topCard.classList.remove("fade-swap");
            bottomCard.classList.remove("fade-swap");
        }, 250);
    }

    setInterval(rotateServices, 3000);

    // ====== SCROLL REVEAL ======
    var revealElements = document.querySelectorAll('.reveal');
    
    var revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(function(el) {
        revealObserver.observe(el);
    });

    // ====== CHATBOT GUIDE ======
    var guideSteps = [
        {
            emoji: '1',
            title: 'Bienvenido a Connectgoo!',
            text: 'Te ayudo a encontrar servicios confiables en tu ciudad. Sigue esta guia rapida.',
            action: null
        },
        {
            emoji: '2',
            title: 'Elige tu ciudad',
            text: 'Selecciona donde necesitas el servicio. Puedes usar tu ubicacion automatica.',
            action: { label: 'Ir a ciudades', href: '#ciudades' }
        },
        {
            emoji: '3',
            title: 'Busca el servicio',
            text: 'Elige una categoria: electricista, gasfitero, tecnico, limpieza y mas.',
            action: { label: 'Ver servicios', href: 'categorias.php' }
        },
        {
            emoji: '4',
            title: 'Contacta directo',
            text: 'Revisa el perfil del profesional y escribele por WhatsApp. Sin intermediarios!',
            action: null
        }
    ];

    var guideStep = 0;
    var guidePanel = document.getElementById('guidePanel');
    var guideBody = document.getElementById('guideBody');
    var guideDots = document.getElementById('guideDots');
    var guideToggle = document.getElementById('guideToggle');
    var guideClose = document.getElementById('guideClose');
    var guidePrev = document.getElementById('guidePrev');
    var guideNext = document.getElementById('guideNext');

    function renderGuide() {
        if (!guideBody || !guideDots) return;
        var s = guideSteps[guideStep];
        guideBody.innerHTML = '<div class="cg-guide-step">' +
            '<div class="cg-guide-emoji">' + s.emoji + '</div>' +
            '<strong>' + s.title + '</strong>' +
            '<p>' + s.text + '</p>' +
            (s.action ? '<a href="' + s.action.href + '" class="cg-guide-action">' + s.action.label + '</a>' : '') +
            '</div>';
        
        var dots = '';
        for (var i = 0; i < guideSteps.length; i++) {
            dots += '<span class="cg-dot' + (i === guideStep ? ' active' : '') + '"></span>';
        }
        guideDots.innerHTML = dots;
        
        if (guidePrev) guidePrev.style.visibility = guideStep === 0 ? 'hidden' : 'visible';
        if (guideNext) guideNext.textContent = guideStep === guideSteps.length - 1 ? '✓' : '';
        if (guideNext && guideStep < guideSteps.length - 1) {
            guideNext.innerHTML = '<i data-lucide="chevron-right" style="width:16px;height:16px;"></i>';
            lucide.createIcons();
        }
    }

    if (guideToggle) {
        guideToggle.addEventListener('click', function() {
            guidePanel.classList.toggle('open');
            if (guidePanel.classList.contains('open')) {
                renderGuide();
                lucide.createIcons();
            }
        });
    }
    if (guideClose) {
        guideClose.addEventListener('click', function() {
            guidePanel.classList.remove('open');
            localStorage.setItem('cg_guide_seen', '1');
        });
    }
    if (guideNext) {
        guideNext.addEventListener('click', function() {
            if (guideStep < guideSteps.length - 1) {
                guideStep++;
                renderGuide();
                lucide.createIcons();
            } else {
                guidePanel.classList.remove('open');
                localStorage.setItem('cg_guide_seen', '1');
                showToast('Listo! Ya sabes como usar Connectgoo.', 'success');
            }
        });
    }
    if (guidePrev) {
        guidePrev.addEventListener('click', function() {
            if (guideStep > 0) {
                guideStep--;
                renderGuide();
                lucide.createIcons();
            }
        });
    }

    // Auto-open for new users after 3 seconds
    if (!localStorage.getItem('cg_guide_seen') && guidePanel) {
        setTimeout(function() {
            guidePanel.classList.add('open');
            renderGuide();
            lucide.createIcons();
        }, 3000);
    }
    // ====== WHATSAPP LEADS TRACKING ======
    document.querySelectorAll('a[data-track="whatsapp"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var tipo = this.getAttribute('data-tipo');
            var id = this.getAttribute('data-id');
            
            console.log("Clic detectado en WhatsApp:", tipo, id);

            if (tipo && id) {
                // Formulario de datos para que sea compatible con sendBeacon o fetch simple
                var formData = new FormData();
                formData.append('tipo', tipo);
                formData.append('entidad_id', id);

                // Alternativa más robusta: sendBeacon
                if (navigator.sendBeacon) {
                    navigator.sendBeacon('/api_whatsapp_lead.php', formData);
                    console.log("Enviado via sendBeacon");
                } else {
                    fetch('/api_whatsapp_lead.php', {
                        method: 'POST',
                        body: formData,
                        keepalive: true
                    }).then(r => console.log("Fetch completado"))
                      .catch(err => console.error("Error tracking click:", err));
                }
            }
        });
    });

});
