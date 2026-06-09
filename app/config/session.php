<?php

/**
 * Middleware de sesión centralizado para el panel de administración.
 * Maneja: inicio seguro, verificación de admin, tokens CSRF, logout.
 */

require_once __DIR__ . '/database.php';

function iniciarSesionSegura()
{
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.cookie_samesite', 'Lax');
        session_start();
    }
}

function verificarAdmin($rolesPermitidos = [])
{
    iniciarSesionSegura();

    if (empty($_SESSION['admin_id']) || empty($_SESSION['session_token'])) {
        header("Location: login_admin.php");
        exit;
    }

    // Verificar que el token de sesión coincide con el almacenado
    $pdo = getConnection();
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT id, nombre, usuario, rol, session_token FROM administradores WHERE id = ? LIMIT 1");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch();

        if (!$admin || $admin['session_token'] !== $_SESSION['session_token']) {
            cerrarSesion();
            header("Location: login_admin.php");
            exit;
        }

        // Verificar rol si se especifican roles permitidos
        if (!empty($rolesPermitidos) && !in_array($admin['rol'], $rolesPermitidos)) {
            header("Location: panel_admin.php?error=sin_permisos");
            exit;
        }

        return $admin;
    }

    header("Location: login_admin.php");
    exit;
}

function generarCSRF()
{
    iniciarSesionSegura();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verificarCSRF($token)
{
    iniciarSesionSegura();

    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function generarSessionToken()
{
    return bin2hex(random_bytes(32));
}

function cerrarSesion()
{
    iniciarSesionSegura();
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

function campoCSRF()
{
    $token = generarCSRF();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

function adminTieneRol($admin, $roles)
{
    if (is_string($roles)) {
        $roles = [$roles];
    }
    return in_array($admin['rol'] ?? '', $roles);
}

function textoRol($rol)
{
    $roles = [
        'superadmin' => 'Super Administrador',
        'admin' => 'Administrador',
        'moderador' => 'Moderador'
    ];
    return $roles[$rol] ?? 'Sin rol';
}
