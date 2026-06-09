<?php

require_once __DIR__ . '/../config/database.php';

class Publicidad
{
    public static function crearSolicitud($datos)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        // Auto-migración defensiva: Asegura que todas las columnas existan en la tabla publicidad_negocios
        $columnasRequeridas = [
            'referencia' => "VARCHAR(255) DEFAULT '' AFTER direccion",
            'latitud' => "VARCHAR(50) DEFAULT '' AFTER google_maps_url",
            'longitud' => "VARCHAR(50) DEFAULT '' AFTER latitud",
            'imagen_negocio' => "VARCHAR(255) DEFAULT NULL AFTER longitud",
            'texto_cta' => "VARCHAR(100) DEFAULT 'Contactar por WhatsApp' AFTER redes_sociales",
            'monto' => "DECIMAL(10, 2) DEFAULT 0.00 AFTER categoria_id",
            'duracion_dias' => "INT DEFAULT 15 AFTER monto",
            'prioridad' => "INT DEFAULT 1 AFTER duracion_dias",
            'fecha_inicio' => "DATE DEFAULT NULL AFTER estado",
            'fecha_fin' => "DATE DEFAULT NULL AFTER fecha_inicio"
        ];

        foreach ($columnasRequeridas as $columna => $definicion) {
            try {
                $check = $pdo->query("SHOW COLUMNS FROM publicidad_negocios LIKE '$columna'")->fetch();
                if (!$check) {
                    $pdo->exec("ALTER TABLE publicidad_negocios ADD COLUMN $columna $definicion");
                }
            } catch (Exception $e) {
                // Si la columna ya existe o falla temporalmente, ignorar
            }
        }

        $stmt = $pdo->prepare("
            INSERT INTO publicidad_negocios
            (
                nombre_negocio,
                tipo_negocio,
                zona,
                direccion,
                referencia,
                google_maps_url,
                latitud,
                longitud,
                imagen_negocio,
                horario_atencion,
                whatsapp,
                descripcion,
                redes_sociales,
                texto_cta,
                tipo_publicidad,
                categoria_id,
                monto,
                duracion_dias,
                prioridad,
                estado
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')
        ");

        return $stmt->execute([
            $datos['nombre_negocio'],
            $datos['tipo_negocio'],
            $datos['zona'],
            $datos['direccion'],
            $datos['referencia'],
            $datos['google_maps_url'],
            $datos['latitud'],
            $datos['longitud'],
            $datos['imagen_negocio'],
            $datos['horario_atencion'],
            $datos['whatsapp'],
            $datos['descripcion'],
            $datos['redes_sociales'],
            $datos['texto_cta'],
            $datos['tipo_publicidad'],
            $datos['categoria_id'],
            $datos['monto'],
            $datos['duracion_dias'],
            $datos['prioridad']
        ]);
    }

    public static function obtenerTodas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT 
                p.*,
                c.nombre AS categoria_nombre
            FROM publicidad_negocios p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            ORDER BY p.created_at DESC
        ");

        return $stmt->fetchAll();
    }

    public static function obtenerAprobadas()
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->query("
            SELECT 
                p.*,
                c.nombre AS categoria_nombre
            FROM publicidad_negocios p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.estado = 'aprobado'
            AND (p.fecha_fin IS NULL OR p.fecha_fin >= CURDATE())
            ORDER BY p.prioridad DESC, p.created_at DESC
        ");

        return $stmt->fetchAll();
    }

    public static function obtenerAprobadasPorCategoria($categoriaId)
    {
        $pdo = getConnection();
        if (!$pdo) return [];

        $stmt = $pdo->prepare("
            SELECT *
            FROM publicidad_negocios
            WHERE estado = 'aprobado'
            AND categoria_id = ?
            AND tipo_publicidad = 'Promoción por categoría'
            AND (fecha_fin IS NULL OR fecha_fin >= CURDATE())
            ORDER BY prioridad DESC, created_at DESC
        ");

        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll();
    }

    public static function aprobar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE publicidad_negocios
            SET estado = 'aprobado',
                fecha_inicio = CURDATE(),
                fecha_fin = DATE_ADD(CURDATE(), INTERVAL duracion_dias DAY)
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function rechazar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE publicidad_negocios
            SET estado = 'rechazado'
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function eliminar($id)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            DELETE FROM publicidad_negocios
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function calcularIngresosPublicidad()
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->query("
            SELECT COALESCE(SUM(monto), 0)
            FROM publicidad_negocios
            WHERE estado = 'aprobado'
        ");

        return $stmt->fetchColumn();
    }

    public static function contarAprobadas()
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->query("
            SELECT COUNT(*)
            FROM publicidad_negocios
            WHERE estado = 'aprobado'
            AND (fecha_fin IS NULL OR fecha_fin >= CURDATE())
        ");

        return $stmt->fetchColumn();
    }

    public static function contarPendientes()
    {
        $pdo = getConnection();
        if (!$pdo) return 0;

        $stmt = $pdo->query("
            SELECT COUNT(*)
            FROM publicidad_negocios
            WHERE estado = 'pendiente'
        ");

        return $stmt->fetchColumn();
    }

    public static function actualizarDesdeAdmin($id, $datos)
    {
        $pdo = getConnection();
        if (!$pdo) throw new Exception('No se pudo conectar a la base de datos.');

        $stmt = $pdo->prepare("
            UPDATE publicidad_negocios
            SET nombre_negocio = ?,
                tipo_negocio = ?,
                zona = ?,
                direccion = ?,
                referencia = ?,
                whatsapp = ?,
                descripcion = ?,
                redes_sociales = ?,
                horario_atencion = ?,
                categoria_id = ?,
                tipo_publicidad = ?,
                texto_cta = ?,
                monto = ?,
                duracion_dias = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $datos['nombre_negocio'],
            $datos['tipo_negocio'],
            $datos['zona'],
            $datos['direccion'],
            $datos['referencia'],
            $datos['whatsapp'],
            $datos['descripcion'],
            $datos['redes_sociales'] ?? '',
            $datos['horario_atencion'] ?? '',
            intval($datos['categoria_id'] ?? 0),
            $datos['tipo_publicidad'],
            $datos['texto_cta'] ?? 'Contactar por WhatsApp',
            floatval($datos['monto'] ?? 0.00),
            intval($datos['duracion_dias'] ?? 15),
            intval($id)
        ]);
    }
}