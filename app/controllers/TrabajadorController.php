<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Trabajador.php';

// Para guardar el email del trabajador como lead
if (!class_exists('LeadController')) {
    require_once __DIR__ . '/LeadController.php';
}

class TrabajadorController
{
    private static function obtenerPlan($planId)
    {
        $pdo = getConnection();

        $stmt = $pdo->prepare("SELECT * FROM planes WHERE id = ? AND estado = 1 LIMIT 1");
        $stmt->execute([$planId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private static function tipoPlan($nombre)
    {
        $nombre = strtolower($nombre ?? '');

        if (strpos($nombre, 'premium') !== false) {
            return 'premium';
        }

        if (strpos($nombre, 'destacado') !== false) {
            return 'destacado';
        }

        return 'basico';
    }

    private static function categoriaEsEmprendimiento($categoriaId)
    {
        $pdo = getConnection();

        $stmt = $pdo->prepare("SELECT nombre FROM categorias WHERE id = ? LIMIT 1");
        $stmt->execute([$categoriaId]);
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$categoria) {
            return false;
        }

        $nombre = strtolower($categoria['nombre']);

        return strpos($nombre, 'emprendimiento') !== false;
    }

    private static function guardarFotoPerfil($archivo)
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

        if ($archivo['size'] > 2 * 1024 * 1024) {
            return false;
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombreArchivo = 'trabajador_' . time() . '_' . rand(1000, 9999) . '.' . $extension;

        $directorio = __DIR__ . '/../../uploads/trabajadores/';
        $rutaFinal = $directorio . $nombreArchivo;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        if (!move_uploaded_file($archivo['tmp_name'], $rutaFinal)) {
            return false;
        }

        return 'uploads/trabajadores/' . $nombreArchivo;
    }

    public static function listarAprobadosPorCategoria($categoriaId, $ciudadId = null)
    {
        return Trabajador::obtenerAprobadosPorCategoria($categoriaId, $ciudadId);
    }

    public static function obtenerPerfil($id)
    {
        return Trabajador::obtenerPerfilAprobado($id);
    }

    public static function listarPorEstado($estado)
    {
        return Trabajador::obtenerPorEstado($estado);
    }

    public static function contarPorEstado($estado)
    {
        return Trabajador::contarPorEstado($estado);
    }

    public static function crearSolicitud($post, $files = [])
    {
        $errores = [];

        $planId = intval($post['plan_id'] ?? 1);
        $plan = self::obtenerPlan($planId);

        if (!$plan) {
            $errores[] = 'El plan seleccionado no es válido.';
            $tipoPlan = 'basico';
            $planId = 1;
        } else {
            $tipoPlan = self::tipoPlan($plan['nombre']);
        }

        $categoriaId = intval($post['categoria_id'] ?? 0);
        $esEmprendimiento = self::categoriaEsEmprendimiento($categoriaId);
        $requiereMapaEmprendimiento = $esEmprendimiento && in_array($tipoPlan, ['destacado', 'premium']);

        $datos = [
            'nombre' => trim($post['nombre'] ?? ''),
            'email' => trim($post['email'] ?? ''),
            'categoria_id' => $categoriaId,
            'plan_id' => $planId,
            'especialidad' => trim($post['especialidad'] ?? ''),
            'zona' => trim($post['zona'] ?? ''),
            'direccion' => trim($post['direccion'] ?? ''),
            'google_maps_url' => trim($post['google_maps_url'] ?? ''),
            'latitud' => trim($post['latitud'] ?? ''),
            'longitud' => trim($post['longitud'] ?? ''),
            'whatsapp' => preg_replace('/[^0-9]/', '', $post['whatsapp'] ?? ''),
            'experiencia' => intval($post['experiencia'] ?? 0),
            'descripcion' => trim($post['descripcion'] ?? ''),
            'foto_perfil' => null,
            'horario_atencion' => trim($post['horario_atencion'] ?? ''),
            'referencia_zona' => trim($post['referencia_zona'] ?? ''),
            'atiende_domicilio' => isset($post['atiende_domicilio']) ? 1 : 0
        ];

        if ($datos['nombre'] === '') {
            $errores[] = 'El nombre completo o nombre del negocio es obligatorio.';
        }

        if ($datos['email'] === '' || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico es obligatorio y debe ser válido.';
        }

        if ($datos['categoria_id'] <= 0) {
            $errores[] = 'Debes seleccionar el servicio que ofreces.';
        }

        if ($datos['zona'] === '') {
            $errores[] = 'La zona donde trabajas es obligatoria.';
        }

        if ($datos['whatsapp'] === '') {
            $errores[] = 'El número de WhatsApp es obligatorio.';
        } elseif (strlen($datos['whatsapp']) < 9) {
            $errores[] = 'El número de WhatsApp debe tener al menos 9 dígitos.';
        }

        if ($datos['experiencia'] < 0) {
            $errores[] = 'Los años de experiencia no pueden ser negativos.';
        }

        if ($datos['descripcion'] === '') {
            $errores[] = 'La descripción del servicio es obligatoria.';
        }

        if ($esEmprendimiento && $datos['direccion'] === '') {
            $errores[] = 'La dirección es obligatoria para emprendimientos locales.';
        }

        if ($datos['google_maps_url'] !== '' && !filter_var($datos['google_maps_url'], FILTER_VALIDATE_URL)) {
            $errores[] = 'El enlace de Google Maps no es válido.';
        }

        if ($datos['latitud'] !== '' && !is_numeric($datos['latitud'])) {
            $errores[] = 'La latitud no es válida.';
        }

        if ($datos['longitud'] !== '' && !is_numeric($datos['longitud'])) {
            $errores[] = 'La longitud no es válida.';
        }

        if (!$esEmprendimiento) {
            $datos['direccion'] = '';
            $datos['google_maps_url'] = '';
            $datos['latitud'] = null;
            $datos['longitud'] = null;
        }

        if ($requiereMapaEmprendimiento && $datos['google_maps_url'] === '' && $datos['direccion'] !== '') {
            $query = $datos['direccion'] . ' ' . $datos['zona'] . ' Tingo María Perú';
            $datos['google_maps_url'] = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($query);
        }

        if ($tipoPlan === 'basico') {
            if ($datos['especialidad'] === '') {
                $datos['especialidad'] = $esEmprendimiento ? 'Emprendimiento local' : 'Servicio general';
            }

            $datos['horario_atencion'] = '';
            $datos['referencia_zona'] = '';
            $datos['atiende_domicilio'] = 1;

            if (!$requiereMapaEmprendimiento) {
                $datos['google_maps_url'] = '';
                $datos['latitud'] = null;
                $datos['longitud'] = null;
            }
        }

        if ($tipoPlan === 'destacado') {
            if ($datos['especialidad'] === '') {
                $errores[] = $esEmprendimiento
                    ? 'Indica el rubro o producto principal del emprendimiento.'
                    : 'La especialidad es obligatoria para el plan Destacado.';
            }

            if ($datos['horario_atencion'] === '') {
                $errores[] = 'El horario de atención es obligatorio para el plan Destacado.';
            }

            $foto = self::guardarFotoPerfil($files['foto_perfil'] ?? null);

            if ($foto === false) {
                $errores[] = 'No se pudo guardar la foto. Usa JPG, PNG o WEBP menor a 2 MB.';
            } elseif ($foto !== null) {
                $datos['foto_perfil'] = $foto;
            }
        }

        if ($tipoPlan === 'premium') {
            if ($datos['especialidad'] === '') {
                $errores[] = $esEmprendimiento
                    ? 'Indica el rubro o producto principal del emprendimiento.'
                    : 'La especialidad es obligatoria para el plan Premium.';
            }

            if ($datos['horario_atencion'] === '') {
                $errores[] = 'El horario de atención es obligatorio para el plan Premium.';
            }

            if ($datos['referencia_zona'] === '') {
                $errores[] = 'La referencia de atención es obligatoria para el plan Premium.';
            }

            $foto = self::guardarFotoPerfil($files['foto_perfil'] ?? null);

            if ($foto === false) {
                $errores[] = 'No se pudo guardar la foto. Usa JPG, PNG o WEBP menor a 2 MB.';
            } elseif ($foto === null) {
                $errores[] = 'El plan Premium debe incluir una foto de perfil o imagen representativa.';
            } else {
                $datos['foto_perfil'] = $foto;
            }
        }

        $datos['latitud'] = $datos['latitud'] !== '' ? $datos['latitud'] : null;
        $datos['longitud'] = $datos['longitud'] !== '' ? $datos['longitud'] : null;

        if (!isset($post['acepta'])) {
            $errores[] = 'Debes aceptar que tu información sea revisada antes de publicarse.';
        }

        if (!empty($errores)) {
            return [
                'ok' => false,
                'errores' => $errores
            ];
        }

        try {
            $exito = Trabajador::crearSolicitud($datos);

            if (!$exito) {
                return [
                    'ok' => false,
                    'errores' => ['No se pudo guardar la solicitud en la base de datos. Inténtalo de nuevo.']
                ];
            }

            // Guardar el email del trabajador como lead
            if (!empty($datos['email'])) {
                try {
                    LeadController::guardarEmail($datos['email'], 'registro_trabajador');
                } catch (Exception $e) {
                    error_log("Error al guardar lead del trabajador: " . $e->getMessage());
                }
            }

            return [
                'ok' => true,
                'errores' => []
            ];
        } catch (Exception $e) {
            error_log("Error en TrabajadorController::crearSolicitud: " . $e->getMessage());
            return [
                'ok' => false,
                'errores' => ['Error en la base de datos: ' . $e->getMessage()]
            ];
        }
    }

    public static function actualizarDesdeAdmin($id, $post)
    {
        $errores = [];

        $datos = [
            'nombre' => trim($post['nombre'] ?? ''),
            'categoria_id' => intval($post['categoria_id'] ?? 0),
            'plan_id' => intval($post['plan_id'] ?? 1),
            'servicio' => trim($post['servicio'] ?? ''),
            'especialidad' => trim($post['especialidad'] ?? ''),
            'zona' => trim($post['zona'] ?? ''),
            'direccion' => trim($post['direccion'] ?? ''),
            'google_maps_url' => trim($post['google_maps_url'] ?? ''),
            'latitud' => trim($post['latitud'] ?? ''),
            'longitud' => trim($post['longitud'] ?? ''),
            'whatsapp' => preg_replace('/[^0-9]/', '', $post['whatsapp'] ?? ''),
            'experiencia' => intval($post['experiencia'] ?? 0),
            'descripcion' => trim($post['descripcion'] ?? ''),
            'disponibilidad' => trim($post['disponibilidad'] ?? 'Disponible previa coordinación'),
            'horario_atencion' => trim($post['horario_atencion'] ?? ''),
            'referencia_zona' => trim($post['referencia_zona'] ?? ''),
            'atiende_domicilio' => isset($post['atiende_domicilio']) ? 1 : 0,
            'foto_perfil' => trim($post['foto_perfil'] ?? '')
        ];

        if ($datos['nombre'] === '') {
            $errores[] = 'El nombre no puede estar vacío.';
        }

        if ($datos['categoria_id'] <= 0) {
            $errores[] = 'Debes seleccionar una categoría válida.';
        }

        if ($datos['whatsapp'] === '') {
            $errores[] = 'El WhatsApp no puede estar vacío.';
        }

        if ($datos['zona'] === '') {
            $errores[] = 'La zona no puede estar vacía.';
        }

        if ($datos['descripcion'] === '') {
            $errores[] = 'La descripción no puede estar vacía.';
        }

        if ($datos['google_maps_url'] !== '' && !filter_var($datos['google_maps_url'], FILTER_VALIDATE_URL)) {
            $errores[] = 'El enlace de Google Maps no es válido.';
        }

        $datos['latitud'] = $datos['latitud'] !== '' ? $datos['latitud'] : null;
        $datos['longitud'] = $datos['longitud'] !== '' ? $datos['longitud'] : null;

        if (!empty($errores)) {
            return [
                'ok' => false,
                'mensaje' => implode(' ', $errores)
            ];
        }

        Trabajador::actualizarDesdeAdmin($id, $datos);

        return [
            'ok' => true,
            'mensaje' => 'Datos del trabajador actualizados correctamente.'
        ];
    }

    public static function aprobar($id)
    {
        Trabajador::aprobar($id);
        return 'Perfil aprobado correctamente.';
    }

    public static function rechazar($id)
    {
        Trabajador::rechazar($id);
        return 'Solicitud rechazada correctamente.';
    }

    public static function eliminarAprobado($id)
    {
        Trabajador::eliminarAprobado($id);
        return 'Perfil aprobado eliminado correctamente.';
    }

    public static function listarAprobadosConPlan()
    {
        return Trabajador::obtenerAprobadosConPlan();
    }

    public static function listarDestacadosHome($limite = 8)
    {
        return Trabajador::obtenerDestacadosHome($limite);
    }
}

