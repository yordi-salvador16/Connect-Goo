<?php

require_once __DIR__ . '/../models/Ciudad.php';

class CiudadController
{
    public static function listarActivas()
    {
        return Ciudad::listarActivas();
    }

    public static function listarTodas()
    {
        return Ciudad::listarTodas();
    }

    public static function buscarPorSlug($slug)
    {
        $slug = trim(strtolower($slug));
        return Ciudad::buscarPorSlug($slug);
    }

    public static function buscarPorId($id)
    {
        return Ciudad::buscarPorId(intval($id));
    }

    public static function registrar($datos)
    {
        $nombre = trim($datos['nombre'] ?? '');
        $departamento = trim($datos['departamento'] ?? '');
        $activa = isset($datos['activa']) ? 1 : 0;

        if (empty($nombre)) {
            return ['ok' => false, 'mensaje' => 'El nombre de la ciudad es obligatorio.'];
        }

        // Generar slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));

        $pdo = getConnection();
        $stmt = $pdo->prepare("INSERT INTO ciudades (nombre, slug, departamento, activa) VALUES (?, ?, ?, ?)");
        
        try {
            $stmt->execute([$nombre, $slug, $departamento, $activa]);
            return ['ok' => true, 'mensaje' => 'Ciudad registrada correctamente.'];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ['ok' => false, 'mensaje' => 'Esta ciudad ya está registrada (slug duplicado).'];
            }
            return ['ok' => false, 'mensaje' => 'Error al registrar ciudad: ' . $e->getMessage()];
        }
    }

    public static function eliminar($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM ciudades WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            return ['ok' => true, 'mensaje' => 'Ciudad eliminada correctamente.'];
        } catch (PDOException $e) {
            return ['ok' => false, 'mensaje' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }
}
