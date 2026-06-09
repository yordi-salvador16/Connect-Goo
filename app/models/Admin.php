<?php

require_once __DIR__ . '/../config/database.php';

class Admin
{
    public static function buscarPorUsuario($usuario)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT *
            FROM administradores
            WHERE usuario = ?
            LIMIT 1
        ");

        $stmt->execute([$usuario]);
        return $stmt->fetch();
    }

    public static function obtenerPorId($id)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT id, nombre, usuario, rol, ultimo_acceso
            FROM administradores
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function verificarPassword($admin, $password)
    {
        if (!$admin || empty($admin['password'])) return false;

        // Soportar texto plano temporal (pre-migración) y bcrypt
        if (password_get_info($admin['password'])['algo'] === 0) {
            // Contraseña en texto plano (legacy)
            return $admin['password'] === $password;
        }

        return password_verify($password, $admin['password']);
    }

    public static function actualizarSessionToken($id, $token)
    {
        $pdo = getConnection();
        if (!$pdo) return false;

        $stmt = $pdo->prepare("
            UPDATE administradores
            SET session_token = ?, ultimo_acceso = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$token, $id]);
    }

    public static function cambiarPassword($id, $nuevaPassword)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            UPDATE administradores
            SET password = ?
            WHERE id = ?
        ");

        return $stmt->execute([$hash, $id]);
    }

    public static function actualizarPerfil($id, $nombre, $usuario)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        // Verificar que el usuario no esté en uso por otro admin
        $stmt = $pdo->prepare("SELECT id FROM administradores WHERE usuario = ? AND id != ? LIMIT 1");
        $stmt->execute([$usuario, $id]);
        if ($stmt->fetch()) {
            return ['ok' => false, 'mensaje' => 'El nombre de usuario ya está en uso por otro administrador.'];
        }

        $stmt = $pdo->prepare("
            UPDATE administradores
            SET nombre = ?, usuario = ?
            WHERE id = ?
        ");

        $stmt->execute([$nombre, $usuario, $id]);
        return ['ok' => true, 'mensaje' => 'Perfil actualizado correctamente.'];
    }

    public static function obtenerTodos()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT id, nombre, usuario, rol, ultimo_acceso
            FROM administradores
            ORDER BY id ASC
        ");

        return $stmt->fetchAll();
    }

    public static function registrar($datos)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            INSERT INTO administradores (nombre, usuario, password, rol)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $datos['nombre'],
            $datos['usuario'],
            $hash,
            $datos['rol']
        ]);
    }

    public static function eliminar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("DELETE FROM administradores WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
