<?php
// sitemap.php
// Generador dinámico de Sitemap XML para SEO
require_once __DIR__ . '/app/config/db.php';

header("Content-Type: text/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$baseUrl = "https://connectgoo.com";

// 1. Página de inicio y estáticas
$paginasEstaticas = [
    '/',
    '/nosotros.php',
    '/categorias.php',
    '/planes.php',
    '/planes_publicidad.php'
];

foreach ($paginasEstaticas as $url) {
    echo "\n  <url>";
    echo "\n    <loc>" . $baseUrl . $url . "</loc>";
    echo "\n    <changefreq>weekly</changefreq>";
    echo "\n    <priority>1.0</priority>";
    echo "\n  </url>";
}

try {
    // 2. Enlaces de Trabajadores (Perfiles dinámicos)
    // Solo mostramos los aprobados
    $stmt = $pdo->query("SELECT id, updated_at FROM trabajadores WHERE estado = 'aprobado'");
    $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($trabajadores as $t) {
        // Usar updated_at si existe, si no, la fecha actual o una por defecto
        $lastmod = !empty($t['updated_at']) ? date('c', strtotime($t['updated_at'])) : date('c');
        
        echo "\n  <url>";
        echo "\n    <loc>" . $baseUrl . "/perfil.php?id=" . $t['id'] . "</loc>";
        echo "\n    <lastmod>" . $lastmod . "</lastmod>";
        echo "\n    <changefreq>monthly</changefreq>";
        echo "\n    <priority>0.8</priority>";
        echo "\n  </url>";
    }

    // 3. Enlaces de Categorías Dinámicas
    // Por ahora, como es de Tingo María, podemos apuntar a categorias específicas
    $stmtCat = $pdo->query("SELECT id FROM categorias");
    $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categorias as $c) {
        echo "\n  <url>";
        echo "\n    <loc>" . $baseUrl . "/trabajadores.php?categoria=" . $c['id'] . "&amp;ciudad=tingo-maria</loc>";
        echo "\n    <changefreq>weekly</changefreq>";
        echo "\n    <priority>0.9</priority>";
        echo "\n  </url>";
    }

} catch (Exception $e) {
    // Ignorar errores de base de datos para el sitemap
}

echo "\n" . '</urlset>';
?>
