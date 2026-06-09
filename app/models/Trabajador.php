<?php

require_once __DIR__ . '/../config/database.php';

class Trabajador
{
    public static function obtenerAprobadosPorCategoria($categoriaId, $ciudadId = null)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $sql = "
            SELECT t.*, p.nombre AS plan_nombre
            FROM trabajadores t
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.categoria_id = ?
            AND t.estado = 'aprobado'
        ";
        $params = [$categoriaId];

        if ($ciudadId) {
            $sql .= " AND t.ciudad_id = ?";
            $params[] = $ciudadId;
        }

        $sql .= " ORDER BY t.destacado DESC, t.calificacion DESC, t.created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPerfilAprobado($id)
    {
        $pdo = getConnection();
        if (!$pdo) return null;

        $stmt = $pdo->prepare("
            SELECT 
                t.*, 
                c.nombre AS categoria_nombre,
                p.nombre AS plan_nombre,
                ci.nombre AS ciudad_nombre,
                ci.slug AS ciudad_slug
            FROM trabajadores t
            LEFT JOIN categorias c ON t.categoria_id = c.id
            LEFT JOIN planes p ON t.plan_id = p.id
            LEFT JOIN ciudades ci ON t.ciudad_id = ci.id
            WHERE t.id = ?
            AND t.estado = 'aprobado'
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorEstado($estado)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->prepare("
            SELECT 
                t.*, 
                c.nombre AS categoria_nombre,
                p.nombre AS plan_nombre,
                p.precio AS plan_precio
            FROM trabajadores t
            LEFT JOIN categorias c ON t.categoria_id = c.id
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.estado = ?
            ORDER BY t.created_at DESC
        ");

        $stmt->execute([$estado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function contarPorEstado($estado)
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM trabajadores
            WHERE estado = ?
        ");

        $stmt->execute([$estado]);
        return $stmt->fetchColumn();
    }

    public static function crearSolicitud($datos)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        // Auto-migración: Asegura que la columna registrado_con_google exista
        try {
            $pdo->exec("ALTER TABLE trabajadores ADD COLUMN registrado_con_google TINYINT(1) DEFAULT 0");
        } catch (Exception $e) {
            // Ya existe o no se puede alterar, ignoramos
        }

        $stmtCategoria = $pdo->prepare("SELECT nombre FROM categorias WHERE id = ?");
        $stmtCategoria->execute([$datos['categoria_id']]);
        $categoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        $servicio = $categoria ? $categoria['nombre'] : 'Servicio local';
        $destacado = ($datos['plan_id'] > 1) ? 1 : 0;
        $registradoGoogle = intval($datos['registrado_con_google'] ?? 0);

        $stmt = $pdo->prepare("
            INSERT INTO trabajadores 
            (
                categoria_id,
                plan_id,
                ciudad_id,
                nombre,
                email,
                servicio,
                especialidad,
                zona,
                direccion,
                google_maps_url,
                latitud,
                longitud,
                whatsapp,
                experiencia,
                descripcion,
                foto_perfil,
                calificacion,
                disponibilidad,
                horario_atencion,
                referencia_zona,
                atiende_domicilio,
                estado,
                verificado,
                destacado,
                registrado_con_google
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0.0, 'Pendiente de revision', ?, ?, ?, 'pendiente', 0, ?, ?)
        ");

        return $stmt->execute([
            $datos['categoria_id'],
            $datos['plan_id'],
            $datos['ciudad_id'] ?? 1,
            $datos['nombre'],
            $datos['email'] ?? null,
            $servicio,
            $datos['especialidad'],
            $datos['zona'],
            $datos['direccion'],
            $datos['google_maps_url'],
            $datos['latitud'],
            $datos['longitud'],
            $datos['whatsapp'],
            $datos['experiencia'],
            $datos['descripcion'],
            $datos['foto_perfil'],
            $datos['horario_atencion'],
            $datos['referencia_zona'],
            $datos['atiende_domicilio'],
            $destacado,
            $registradoGoogle
        ]);
    }

    public static function actualizarDesdeAdmin($id, $datos)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmtCategoria = $pdo->prepare("SELECT nombre FROM categorias WHERE id = ?");
        $stmtCategoria->execute([$datos['categoria_id']]);
        $categoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        $servicio = $categoria ? $categoria['nombre'] : $datos['servicio'];
        $destacado = ($datos['plan_id'] > 1) ? 1 : 0;

        $stmt = $pdo->prepare("
            UPDATE trabajadores
            SET 
                categoria_id = ?,
                plan_id = ?,
                nombre = ?,
                servicio = ?,
                especialidad = ?,
                zona = ?,
                direccion = ?,
                google_maps_url = ?,
                latitud = ?,
                longitud = ?,
                whatsapp = ?,
                experiencia = ?,
                descripcion = ?,
                disponibilidad = ?,
                horario_atencion = ?,
                referencia_zona = ?,
                atiende_domicilio = ?,
                destacado = ?,
                foto_perfil = COALESCE(NULLIF(?, ''), foto_perfil)
            WHERE id = ?
        ");

        return $stmt->execute([
            $datos['categoria_id'],
            $datos['plan_id'],
            $datos['nombre'],
            $servicio,
            $datos['especialidad'],
            $datos['zona'],
            $datos['direccion'],
            $datos['google_maps_url'],
            $datos['latitud'],
            $datos['longitud'],
            $datos['whatsapp'],
            $datos['experiencia'],
            $datos['descripcion'],
            $datos['disponibilidad'],
            $datos['horario_atencion'],
            $datos['referencia_zona'],
            $datos['atiende_domicilio'],
            $destacado,
            $datos['foto_perfil'],
            $id
        ]);
    }

    public static function eliminarAprobado($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            DELETE FROM trabajadores
            WHERE id = ?
            AND estado = 'aprobado'
        ");

        return $stmt->execute([$id]);
    }

    public static function aprobar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE trabajadores
            SET estado = 'aprobado',
                verificado = 1,
                disponibilidad = 'Disponible previa coordinacion'
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function rechazar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE trabajadores
            SET estado = 'rechazado',
                verificado = 0,
                destacado = 0
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function obtenerAprobadosConPlan()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT t.nombre, t.servicio, t.estado, p.nombre AS plan_nombre, p.precio
            FROM trabajadores t
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.estado = 'aprobado'
            ORDER BY p.precio DESC, t.created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerDestacadosHome($limite = 8)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->prepare("
            SELECT t.id, t.nombre, t.servicio, t.especialidad, t.foto_perfil, t.atiende_domicilio, t.zona, t.whatsapp, p.nombre AS plan_nombre
            FROM trabajadores t
            LEFT JOIN planes p ON t.plan_id = p.id
            WHERE t.estado = 'aprobado'
            ORDER BY t.destacado DESC, p.precio DESC, t.created_at DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', intval($limite), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

