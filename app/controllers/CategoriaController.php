<?php

require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController
{
    public static function listarActivas()
    {
        return Categoria::obtenerActivas();
    }

    public static function buscarActivas($termino)
    {
        $termino = trim($termino);

        if ($termino === '') {
            return Categoria::obtenerActivas();
        }

        return Categoria::buscarActivas($termino);
    }

    public static function listarTodas()
    {
        return Categoria::obtenerTodas();
    }

    public static function buscarPorId($id)
    {
        return Categoria::buscarPorId($id);
    }

    public static function crear($nombre, $icono)
    {
        $nombre = trim($nombre);
        $icono = trim($icono) ?: '🔧';

        if ($nombre === '') {
            return [
                'ok' => false,
                'mensaje' => 'El nombre de la categoría es obligatorio.'
            ];
        }

        Categoria::crear($nombre, $icono);

        return [
            'ok' => true,
            'mensaje' => 'Categoría agregada correctamente.'
        ];
    }

    public static function actualizar($id, $nombre, $icono)
    {
        $id = intval($id);
        $nombre = trim($nombre);
        $icono = trim($icono) ?: '🔧';

        if ($id <= 0) {
            return [
                'ok' => false,
                'mensaje' => 'Categoría no válida.'
            ];
        }

        if ($nombre === '') {
            return [
                'ok' => false,
                'mensaje' => 'El nombre de la categoría es obligatorio.'
            ];
        }

        Categoria::actualizar($id, $nombre, $icono);

        return [
            'ok' => true,
            'mensaje' => 'Categoría actualizada correctamente.'
        ];
    }

    public static function cambiarEstado($id, $estado)
    {
        Categoria::cambiarEstado($id, $estado);

        return [
            'ok' => true,
            'mensaje' => 'Estado de categoría actualizado correctamente.'
        ];
    }
}
