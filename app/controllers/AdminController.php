<?php

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../config/session.php';

class AdminController
{
    public static function login($usuario, $password)
    {
        try {
            $usuario = trim($usuario);
            $password = trim($password);

            if ($usuario === '' || $password === '') {
                return [
                    'ok' => false,
                    'mensaje' => 'Ingrese usuario y contraseña.',
                    'admin' => null
                ];
            }

            $admin = Admin::buscarPorUsuario($usuario);

            if (!$admin || !Admin::verificarPassword($admin, $password)) {
                return [
                    'ok' => false,
                    'mensaje' => 'Usuario o contraseña incorrectos.',
                    'admin' => null
                ];
            }

            // Generar token de sesión
            $sessionToken = generarSessionToken();
            Admin::actualizarSessionToken($admin['id'], $sessionToken);

            // Configurar sesión
            iniciarSesionSegura();
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nombre'] = $admin['nombre'];
            $_SESSION['admin_usuario'] = $admin['usuario'];
            $_SESSION['admin_rol'] = $admin['rol'] ?? 'admin';
            $_SESSION['session_token'] = $sessionToken;

            return [
                'ok' => true,
                'mensaje' => 'Acceso correcto.',
                'admin' => $admin
            ];
        } catch (Exception $e) {
            return [
                'ok' => false,
                'mensaje' => 'Error de sistema: ' . $e->getMessage(),
                'admin' => null
            ];
        }
    }

    public static function cambiarPassword($adminId, $actual, $nueva, $confirmar)
    {
        $actual = trim($actual);
        $nueva = trim($nueva);
        $confirmar = trim($confirmar);

        if ($actual === '' || $nueva === '' || $confirmar === '') {
            return ['ok' => false, 'mensaje' => 'Todos los campos son obligatorios.'];
        }

        if (strlen($nueva) < 6) {
            return ['ok' => false, 'mensaje' => 'La nueva contraseña debe tener al menos 6 caracteres.'];
        }

        if ($nueva !== $confirmar) {
            return ['ok' => false, 'mensaje' => 'La nueva contraseña y la confirmación no coinciden.'];
        }

        $admin = Admin::buscarPorUsuario($_SESSION['admin_usuario'] ?? '');
        if (!$admin) {
            return ['ok' => false, 'mensaje' => 'No se encontró el administrador.'];
        }

        if (!Admin::verificarPassword($admin, $actual)) {
            return ['ok' => false, 'mensaje' => 'La contraseña actual es incorrecta.'];
        }

        Admin::cambiarPassword($adminId, $nueva);

        return ['ok' => true, 'mensaje' => 'Contraseña actualizada correctamente.'];
    }

    public static function actualizarPerfil($adminId, $nombre, $usuario)
    {
        $nombre = trim($nombre);
        $usuario = trim($usuario);

        if ($nombre === '' || $usuario === '') {
            return ['ok' => false, 'mensaje' => 'El nombre y usuario son obligatorios.'];
        }

        if (strlen($usuario) < 3) {
            return ['ok' => false, 'mensaje' => 'El usuario debe tener al menos 3 caracteres.'];
        }

        $resultado = Admin::actualizarPerfil($adminId, $nombre, $usuario);

        if ($resultado['ok']) {
            $_SESSION['admin_nombre'] = $nombre;
            $_SESSION['admin_usuario'] = $usuario;
        }

        return $resultado;
    }

    public static function listarTodos()
    {
        return Admin::obtenerTodos();
    }

    public static function registrar($datos)
    {
        $nombre = trim($datos['nombre'] ?? '');
        $usuario = trim($datos['usuario'] ?? '');
        $password = trim($datos['password'] ?? '');
        $rol = $datos['rol'] ?? 'admin';

        if ($nombre === '' || $usuario === '' || $password === '') {
            return ['ok' => false, 'mensaje' => 'Todos los campos son obligatorios.'];
        }

        // Verificar si el usuario ya existe
        if (Admin::buscarPorUsuario($usuario)) {
            return ['ok' => false, 'mensaje' => 'El nombre de usuario ya está en uso.'];
        }

        $resultado = Admin::registrar([
            'nombre' => $nombre,
            'usuario' => $usuario,
            'password' => $password,
            'rol' => $rol
        ]);

        return $resultado 
            ? ['ok' => true, 'mensaje' => 'Administrador creado correctamente.']
            : ['ok' => false, 'mensaje' => 'Error al crear el administrador.'];
    }

    public static function eliminar($id)
    {
        // No permitir que un admin se elimine a sí mismo
        if (intval($id) === intval($_SESSION['admin_id'])) {
            return ['ok' => false, 'mensaje' => 'No puedes eliminar tu propia cuenta.'];
        }

        $resultado = Admin::eliminar($id);
        return $resultado 
            ? ['ok' => true, 'mensaje' => 'Administrador eliminado correctamente.']
            : ['ok' => false, 'mensaje' => 'Error al eliminar el administrador.'];
    }
}
