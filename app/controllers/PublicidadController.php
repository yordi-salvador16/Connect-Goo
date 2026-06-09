<?php

require_once __DIR__ . '/../models/Publicidad.php';

class PublicidadController
{
    private static function obtenerConfigPlan($tipoPublicidad)
    {
        $planes = [
            'Anuncio simple' => [
                'monto' => 0.00,
                'duracion_dias' => 15,
                'prioridad' => 1
            ],
            'Promoción por categoría' => [
                'monto' => 0.00,
                'duracion_dias' => 30,
                'prioridad' => 2
            ],
            'Banner destacado' => [
                'monto' => 0.00,
                'duracion_dias' => 30,
                'prioridad' => 3
            ]
        ];

        return $planes[$tipoPublicidad] ?? $planes['Anuncio simple'];
    }

    private static function guardarImagen($archivo)
    {
        if (!isset($archivo) || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        $mime = mime_content_type($archivo['tmp_name']);

        if (!in_array($mime, $permitidos)) {
            return false;
        }

        if ($archivo['size'] > 3 * 1024 * 1024) {
            return false;
        }

        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'publicidad_' . time() . '_' . rand(1000, 9999) . '.' . strtolower($extension);

        $directorio = __DIR__ . '/../../uploads/publicidad/';
        $rutaFinal = $directorio . $nombreArchivo;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        if (!move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
            return false;
        }

        return 'uploads/publicidad/' . $nombreArchivo;
    }

    public static function crearSolicitud($post, $files = [])
    {
        $errores = [];

        $tipoPublicidad = trim($post['tipo_publicidad'] ?? 'Anuncio simple');
        $configPlan = self::obtenerConfigPlan($tipoPublicidad);

        $datos = [
            'nombre_negocio' => trim($post['nombre_negocio'] ?? ''),
            'tipo_negocio' => trim($post['tipo_negocio'] ?? ''),
            'zona' => trim($post['zona'] ?? 'Tingo María'),
            'direccion' => trim($post['direccion'] ?? ''),
            'referencia' => trim($post['referencia'] ?? ''),
            'google_maps_url' => trim($post['google_maps_url'] ?? ''),
            'latitud' => trim($post['latitud'] ?? ''),
            'longitud' => trim($post['longitud'] ?? ''),
            'imagen_negocio' => null,
            'horario_atencion' => trim($post['horario_atencion'] ?? ''),
            'whatsapp' => preg_replace('/[^0-9]/', '', $post['whatsapp'] ?? ''),
            'descripcion' => trim($post['descripcion'] ?? ''),
            'redes_sociales' => trim($post['redes_sociales'] ?? ''),
            'texto_cta' => trim($post['texto_cta'] ?? 'Contactar por WhatsApp'),
            'tipo_publicidad' => $tipoPublicidad,
            'categoria_id' => intval($post['categoria_id'] ?? 0),
            'monto' => $configPlan['monto'],
            'duracion_dias' => $configPlan['duracion_dias'],
            'prioridad' => $configPlan['prioridad']
        ];

        if ($datos['nombre_negocio'] === '') {
            $errores[] = 'El nombre del negocio es obligatorio.';
        }

        if ($datos['tipo_negocio'] === '') {
            $errores[] = 'Debes indicar qué vendes o qué servicio ofreces.';
        }

        if ($datos['whatsapp'] === '') {
            $errores[] = 'El número de WhatsApp es obligatorio.';
        }

        if ($datos['descripcion'] === '') {
            $errores[] = 'La descripción es obligatoria.';
        }

        if ($tipoPublicidad === 'Promoción por categoría') {
            if ($datos['categoria_id'] <= 0) {
                $errores[] = 'Debes seleccionar una categoría relacionada.';
            }
            if ($datos['horario_atencion'] === '') {
                $errores[] = 'El horario de atención es obligatorio para este plan.';
            }
            if ($datos['direccion'] === '') {
                $errores[] = 'La dirección es obligatoria para este plan.';
            }
        }

        if ($tipoPublicidad === 'Banner destacado') {
            if ($datos['direccion'] === '') {
                $errores[] = 'La dirección es obligatoria para un banner destacado.';
            }

            $imagen = self::guardarImagen($files['imagen_negocio'] ?? null);

            if ($imagen === false) {
                $errores[] = 'No se pudo guardar la imagen. Usa JPG, PNG o WEBP menor a 3 MB.';
            } elseif ($imagen === null) {
                $errores[] = 'El banner destacado debe incluir una imagen del negocio.';
            } else {
                $datos['imagen_negocio'] = $imagen;
            }
        }

        if ($datos['google_maps_url'] === '' && $datos['direccion'] !== '') {
            $query = $datos['direccion'] . ' ' . $datos['zona'] . ' Tingo María Perú';
            $datos['google_maps_url'] = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($query);
        }

        if (!isset($post['acepta'])) {
            $errores[] = 'Debes aceptar que el anuncio sea revisado.';
        }

        if (!empty($errores)) {
            return [
                'ok' => false,
                'errores' => $errores
            ];
        }

        Publicidad::crearSolicitud($datos);

        return [
            'ok' => true,
            'errores' => []
        ];
    }

    public static function listarTodas()
    {
        return Publicidad::obtenerTodas();
    }

    public static function listarAprobadas()
    {
        return Publicidad::obtenerAprobadas();
    }

    public static function listarAprobadasPorCategoria($categoriaId)
    {
        return Publicidad::obtenerAprobadasPorCategoria($categoriaId);
    }

    public static function aprobar($id)
    {
        Publicidad::aprobar($id);
        return 'Publicidad aprobada correctamente. Ya se asignó fecha de inicio y vencimiento.';
    }

    public static function rechazar($id)
    {
        Publicidad::rechazar($id);
        return 'Publicidad rechazada correctamente.';
    }

    public static function ingresosPublicidad()
    {
        return Publicidad::calcularIngresosPublicidad();
    }

    public static function contarAprobadas()
    {
        return Publicidad::contarAprobadas();
    }

    public static function contarPendientes()
    {
        return Publicidad::contarPendientes();
    }

    public static function eliminar($id)
    {
        Publicidad::eliminar($id);
        return 'Publicidad eliminada permanentemente con éxito.';
    }

    public static function actualizarDesdeAdmin($id, $post, $files = [])
    {
        $id = intval($id);
        $tipoPublicidad = trim($post['tipo_publicidad'] ?? 'Anuncio simple');
        $configPlan = self::obtenerConfigPlan($tipoPublicidad);

        $datos = [
            'nombre_negocio' => trim($post['nombre_negocio'] ?? ''),
            'tipo_negocio' => trim($post['tipo_negocio'] ?? ''),
            'zona' => trim($post['zona'] ?? 'Tingo María'),
            'direccion' => trim($post['direccion'] ?? ''),
            'referencia' => trim($post['referencia'] ?? ''),
            'whatsapp' => preg_replace('/[^0-9]/', '', $post['whatsapp'] ?? ''),
            'descripcion' => trim($post['descripcion'] ?? ''),
            'redes_sociales' => trim($post['redes_sociales'] ?? ''),
            'horario_atencion' => trim($post['horario_atencion'] ?? ''),
            'categoria_id' => intval($post['categoria_id'] ?? 0),
            'tipo_publicidad' => $tipoPublicidad,
            'texto_cta' => trim($post['texto_cta'] ?? 'Contactar por WhatsApp'),
            'monto' => floatval($post['monto'] ?? $configPlan['monto']),
            'duracion_dias' => intval($post['duracion_dias'] ?? $configPlan['duracion_dias'])
        ];

        // Manejo de imagen si se sube una nueva
        if (isset($files['imagen_negocio']) && $files['imagen_negocio']['error'] !== UPLOAD_ERR_NO_FILE) {
            $imagen = self::guardarImagen($files['imagen_negocio']);
            if ($imagen !== false) {
                $pdo = getConnection();
                $stmt = $pdo->prepare("UPDATE publicidad_negocios SET imagen_negocio = ? WHERE id = ?");
                $stmt->execute([$imagen, $id]);
            }
        }

        Publicidad::actualizarDesdeAdmin($id, $datos);

        return [
            'ok' => true,
            'mensaje' => 'Datos de publicidad actualizados correctamente.'
        ];
    }
}