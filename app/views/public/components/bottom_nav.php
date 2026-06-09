<!-- ====== BARRA DE NAVEGACION INFERIOR (MOBILE) ====== -->
<nav class="cg-bottomnav" id="bottomNav">
    <a href="index.php" class="cg-bottomnav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'active' : ''; ?>">
        <i data-lucide="home"></i>
        <span>Inicio</span>
    </a>
    <a href="categorias.php" class="cg-bottomnav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'categorias.php' || basename($_SERVER['PHP_SELF']) === 'trabajadores.php') ? 'active' : ''; ?>">
        <i data-lucide="search"></i>
        <span>Buscar</span>
    </a>
    <a href="planes.php" class="cg-bottomnav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'planes.php' || basename($_SERVER['PHP_SELF']) === 'registrar_servicio.php') ? 'active' : ''; ?>">
        <i data-lucide="plus-circle"></i>
        <span>Ofrecer</span>
    </a>
    <a href="planes_publicidad.php" class="cg-bottomnav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'planes_publicidad.php' || basename($_SERVER['PHP_SELF']) === 'solicitar_publicidad.php') ? 'active' : ''; ?>">
        <i data-lucide="megaphone"></i>
        <span>Publicitar</span>
    </a>
    <a href="nosotros.php#contacto" class="cg-bottomnav-item <?php echo (basename($_SERVER['PHP_SELF']) === 'nosotros.php') ? 'active' : ''; ?>">
        <i data-lucide="headset"></i>
        <span>Ayuda</span>
    </a>
</nav>
