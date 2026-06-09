<?php

require_once __DIR__ . '/../config/database.php';

class Categoria
{
    public static function obtenerActivas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT *
            FROM categorias
            WHERE estado = 1
            ORDER BY id ASC
        ");

        return $stmt->fetchAll();
    }

    public static function buscarActivas($termino)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->prepare("
            SELECT *
            FROM categorias
            WHERE estado = 1
            AND nombre LIKE ?
            ORDER BY id ASC
        ");

        $stmt->execute(['%' . $termino . '%']);
        return $stmt->fetchAll();
    }

    public static function obtenerTodas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT *
            FROM categorias
            ORDER BY estado DESC, id ASC
        ");

        return $stmt->fetchAll();
    }

    public static function buscarPorId($id)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT *
            FROM categorias
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear($nombre, $icono)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            INSERT INTO categorias (nombre, icono, estado)
            VALUES (?, ?, 1)
        ");

        return $stmt->execute([$nombre, $icono]);
    }

    public static function actualizar($id, $nombre, $icono)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE categorias
            SET nombre = ?, icono = ?
            WHERE id = ?
        ");

        return $stmt->execute([$nombre, $icono, $id]);
    }

    public static function cambiarEstado($id, $estado)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE categorias
            SET estado = ?
            WHERE id = ?
        ");

        return $stmt->execute([$estado, $id]);
    }
}
