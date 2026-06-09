<?php

require_once __DIR__ . '/../config/database.php';

class Ciudad
{
    public static function listarActivas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT * FROM ciudades 
            WHERE activa = 1 
            ORDER BY nombre ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT * FROM ciudades 
            ORDER BY activa DESC, nombre ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorSlug($slug)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT * FROM ciudades 
            WHERE slug = ? 
            LIMIT 1
        ");

        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT * FROM ciudades 
            WHERE id = ? 
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
