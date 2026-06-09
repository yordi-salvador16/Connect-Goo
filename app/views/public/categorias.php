<?php
// app/views/public/categorias.php
// Variables esperadas: $ciudad, $slugCiudad, $busqueda, $categorias
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - Connectgoo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- PWA Manifest & Theme -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#10b981">
    <link rel="stylesheet" href="assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="assets/css/premium-home.css?v=1.1">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-premium">

<header class="cg-navbar">
    <a href="index.php" class="cg-brand" style="display:flex; align-items:center; gap:6px; text-decoration:none;">
        <i data-lucide="shield-check" style="width:28px;height:28px;color:#10b981; stroke-width: 2.5;"></i>
        <span style="font-weight: 900; letter-spacing: -1px; font-size: 24px; background: linear-gradient(135deg, #0f172a 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">ConnectGoo</span>
    </a>
</header>

<main class="main-content-premium directorio-container">

    <header class="directorio-header">
        <h1>Explorar</h1>
        <p>En <strong><?= htmlspecialchars($ciudad['nombre'], ENT_QUOTES, 'UTF-8') ?></strong></p>
    </header>

    <section class="search-card">
        <form method="GET" action="categorias.php" class="search-form">
            <input type="hidden" name="ciudad" value="<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>">
            <label for="buscar">Buscar categoría o servicio</label>

            <div class="search-input-group">
                <input
                    type="text"
                    id="buscar"
                    name="buscar"
                    class="search-input"
                    placeholder="Ej: Electricista, tractor, limpieza..."
                    value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>"
                >
                <button type="submit" class="btn-search">
                    Buscar
                </button>
            </div>

            <?php if ($busqueda !== ''): ?>
                <a href="categorias.php?ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" style="color: #ef4444; font-size: 14px; font-weight: 600; text-decoration: none; margin-top: 5px;">Limpiar búsqueda</a>
            <?php endif; ?>
        </form>
    </section>

    <?php if (count($categorias) === 0): ?>
        <div class="cg-empty-state">
            <div class="cg-empty-icon">
                <i data-lucide="search-x"></i>
            </div>
            <h3 class="cg-empty-title">No se encontraron categorías</h3>
            <p class="cg-empty-desc">No hay servicios que coincidan con "<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>".</p>
            <a href="categorias.php?ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" class="btn-primary" style="margin-top: 15px;">Ver todas las categorías</a>
        </div>
    <?php else: ?>

        <?php 
        // Lógica para separar categorías Urbanas vs Agro
        $cat_urbanas = [];
        $cat_agro = [];
        $agroIcons = ['🚜', '🚚', '👨‍🌾', '🚁', '🌱', '🌾'];

        foreach ($categorias as $cat) {
            $isAgro = false;
            if (isset($cat['sector']) && $cat['sector'] === 'agro') {
                $isAgro = true;
            } else if (in_array($cat['icono'], $agroIcons)) {
                $isAgro = true;
            }

            if ($isAgro) {
                $cat_agro[] = $cat;
            } else {
                $cat_urbanas[] = $cat;
            }
        }

        // Función para mapear emojis a iconos de Lucide
        function getLucideIcon($emoji) {
            $map = [
                '⚡' => 'zap',
                '💧' => 'droplets',
                '📱' => 'smartphone',
                '🛺' => 'truck',
                '🗺️' => 'map',
                '✨' => 'sparkles',
                '🔨' => 'hammer',
                '🚀' => 'rocket',
                '💻' => 'laptop',
                '🔧' => 'settings',
                '⚙️' => 'settings',
                '⚙' => 'settings',
                '🪠' => 'droplets',
                '🚜' => 'tractor',
                '🚚' => 'truck',
                '👨‍🌾' => 'users',
                '🚁' => 'plane',
                '🌱' => 'leaf',
                '🌾' => 'sprout'
            ];
            return $map[$emoji] ?? 'settings';
        }
        ?>

        <!-- SWITCH (PESTAÑAS) -->
        <section class="tabs-container">
            <button id="btn-urban" class="tab-btn tab-active" onclick="showTab('urban')">
                <i data-lucide="building-2" style="width: 20px; height: 20px;"></i> Ciudad
            </button>
            <button id="btn-agro" class="tab-btn tab-inactive" onclick="showTab('agro')">
                <i data-lucide="tractor" style="width: 20px; height: 20px;"></i> Campo (Agro)
            </button>
        </section>

        <!-- SECCIÓN URBANA -->
        <section id="content-urban">
            <div class="category-section-title">
                <div class="category-icon-large bg-dark">
                    <i data-lucide="home"></i>
                </div>
                <div>
                    <h2>Servicios Urbanos</h2>
                    <p>Reparaciones en casa, tecnología y oficios generales.</p>
                </div>
            </div>

            <?php if(empty($cat_urbanas)): ?>
                <p style="text-align: center; color: #64748b; padding: 40px 0;">No hay categorías urbanas disponibles.</p>
            <?php else: ?>
                <div class="categories-grid">
                    <?php foreach ($cat_urbanas as $categoria): ?>
                        <?php 
                        $nombreMostrar = $categoria['nombre'];
                        if (strtolower($nombreMostrar) === 'gasfitero') $nombreMostrar = 'Plomero (Gasfitero)';
                        ?>
                        <a href="trabajadores.php?categoria=<?= $categoria['id'] ?>&ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" class="urban-card">
                            <div class="urban-icon-bg">
                                <i data-lucide="<?= getLucideIcon($categoria['icono']) ?>"></i>
                            </div>
                            <h3><?= htmlspecialchars($nombreMostrar, ENT_QUOTES, 'UTF-8') ?></h3>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECCIÓN AGRO -->
        <section id="content-agro" class="hidden">
            <div class="category-section-title agro-title">
                <div class="category-icon-large bg-emerald">
                    <i data-lucide="leaf"></i>
                </div>
                <div>
                    <h2>Servicios Agrícolas</h2>
                    <p>Soluciones para tu chacra, maquinaria y transporte rural.</p>
                </div>
            </div>

            <?php if(empty($cat_agro)): ?>
                <div class="cg-empty-state">
                    <div class="cg-empty-icon" style="background: #ecfdf5; color: #10b981;">
                        <i data-lucide="tractor"></i>
                    </div>
                    <h3 class="cg-empty-title">Aún no hay categorías Agro</h3>
                    <p class="cg-empty-desc">Próximamente agregaremos servicios para el campo.</p>
                </div>
            <?php else: ?>
                <div class="categories-grid">
                    <?php foreach ($cat_agro as $categoria): ?>
                        <a href="trabajadores.php?categoria=<?= $categoria['id'] ?>&ciudad=<?= htmlspecialchars($slugCiudad, ENT_QUOTES, 'UTF-8') ?>" class="agro-card">
                            <div class="agro-icon-bg">
                                <i data-lucide="<?= getLucideIcon($categoria['icono']) ?>"></i>
                            </div>
                            <h3><?= htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    <?php endif; ?>

</main>

<div class="cg-bottomnav-spacer" style="height: 80px;"></div>
<?php include __DIR__ . '/components/bottom_nav.php'; ?>

<script>
    lucide.createIcons();

    function showTab(tab) {
        const btnUrban = document.getElementById('btn-urban');
        const btnAgro = document.getElementById('btn-agro');
        const contentUrban = document.getElementById('content-urban');
        const contentAgro = document.getElementById('content-agro');

        if(tab === 'urban') {
            btnUrban.className = "tab-btn tab-active";
            btnAgro.className = "tab-btn tab-inactive";
            
            contentUrban.classList.remove('hidden');
            contentAgro.classList.add('hidden');
        } else {
            btnAgro.className = "tab-btn tab-active";
            btnUrban.className = "tab-btn tab-inactive";
            
            contentAgro.classList.remove('hidden');
            contentUrban.classList.add('hidden');
        }
    }

    // Comprobar si venimos con el parámetro ?tab=agro
    <?php if (isset($_GET['tab']) && $_GET['tab'] === 'agro'): ?>
        document.addEventListener('DOMContentLoaded', function() {
            showTab('agro');
        });
    <?php endif; ?>

    // Register Service Worker for PWA
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js').then(registration => {
                console.log('ServiceWorker registered:', registration.scope);
            });
        });
    }
</script>
</body>
</html>
