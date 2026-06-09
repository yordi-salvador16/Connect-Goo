<?php

require_once __DIR__ . '/../models/Resena.php';

class ResenaController
{
    public static function calificar($datos)
    {
        $trabajador_id = intval($datos['trabajador_id'] ?? 0);
        $nombre = trim($datos['nombre_cliente'] ?? '');
        $puntuacion = intval($datos['puntuacion'] ?? 0);
        $comentario = trim($datos['comentario'] ?? '');

        if ($trabajador_id <= 0 || $nombre === '' || $puntuacion < 1 || $puntuacion > 5) {
            return [
                'ok' => false,
                'mensaje' => 'Por favor, completa todos los campos correctamente.'
            ];
        }

        try {
            Resena::crear($trabajador_id, $nombre, $puntuacion, $comentario);
            return [
                'ok' => true,
                'mensaje' => '¡Gracias por tu calificación!'
            ];
        } catch (Exception $e) {
            return [
                'ok' => false,
                'mensaje' => 'Hubo un error al guardar tu reseña.'
            ];
        }
    }

    public static function obtenerResenas($trabajador_id)
    {
        return Resena::obtenerPorTrabajador($trabajador_id);
    }
}
