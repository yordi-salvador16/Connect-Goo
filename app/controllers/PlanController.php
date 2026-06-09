<?php

require_once __DIR__ . '/../models/Plan.php';

class PlanController
{
    public static function listarActivos()
    {
        return Plan::obtenerActivos();
    }

    public static function ingresosPlanes()
    {
        return Plan::calcularIngresosPlanes();
    }

    public static function contarPlanesActivos()
    {
        return Plan::contarPlanesActivos();
    }
}
