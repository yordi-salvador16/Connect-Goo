<?php

require_once __DIR__ . '/../config/database.php';

class Plan
{
    public static function obtenerActivos()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT *
            FROM planes
            WHERE estado = 1
            ORDER BY precio ASC
        ");

        return $stmt->fetchAll();
    }

    public static function calcularIngresosPlanes()
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->query("
            SELECT COALESCE(SUM(p.precio), 0)
            FROM trabajadores t
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.estado = 'aprobado'
        ");

        return $stmt->fetchColumn();
    }

    public static function contarPlanesActivos()
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->query("
            SELECT COUNT(*)
            FROM trabajadores t
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.estado = 'aprobado'
            AND p.precio > 0
        ");

        return $stmt->fetchColumn();
    }
}
