<?php

require_once __DIR__ . '/../config/database.php';

class Resena
{
    public static function crear($trabajador_id, $nombre_cliente, $puntuacion, $comentario)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            INSERT INTO resenas (trabajador_id, nombre_cliente, puntuacion, comentario, estado)
            VALUES (?, ?, ?, ?, 'aprobado')
        ");

        $stmt->execute([$trabajador_id, $nombre_cliente, $puntuacion, $comentario]);
        
        // Actualizar el promedio en la tabla trabajadores
        self::actualizarPromedioTrabajador($trabajador_id);
        
        return true;
    }

    public static function obtenerPorTrabajador($trabajador_id)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->prepare("
            SELECT * FROM resenas 
            WHERE trabajador_id = ? AND estado = 'aprobado'
            ORDER BY fecha DESC
        ");
        $stmt->execute([$trabajador_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizarPromedioTrabajador($trabajador_id)
    {
        $pdo = getConnection();
        if (!$pdo) return;

        // Calcular promedio
        $stmt = $pdo->prepare("
            SELECT AVG(puntuacion) as promedio 
            FROM resenas 
            WHERE trabajador_id = ? AND estado = 'aprobado'
        ");
        $stmt->execute([$trabajador_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $promedio = $resultado['promedio'] ?: 0.0;

        // Guardar en la tabla trabajadores
        $stmtUpdate = $pdo->prepare("
            UPDATE trabajadores 
            SET calificacion = ? 
            WHERE id = ?
        ");
        $stmtUpdate->execute([round($promedio, 1), $trabajador_id]);
    }
}
