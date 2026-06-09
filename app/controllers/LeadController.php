<?php

require_once __DIR__ . '/../config/database.php';

class LeadController
{
    public static function guardarEmail($email, $origen = 'popup_salida')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'error' => 'Email inválido'];
        }

        try {
            $pdo = getConnection();

            // Si ya existe, actualizar origen si es más específico
            $check = $pdo->prepare("SELECT id, origen FROM leads WHERE email = ? LIMIT 1");
            $check->execute([$email]);
            $existente = $check->fetch();
            if ($existente) {
                // Si el nuevo origen es más específico, actualizar
                if ($origen !== 'google_login' && $existente['origen'] === 'google_login') {
                    $update = $pdo->prepare("UPDATE leads SET origen = ? WHERE id = ?");
                    $update->execute([$origen, $existente['id']]);
                    return ['ok' => true, 'mensaje' => 'Origen actualizado'];
                }
                return ['ok' => true, 'mensaje' => 'Ya registrado'];
            }
            
            $stmt = $pdo->prepare("INSERT INTO leads (email, origen) VALUES (?, ?)");
            $stmt->execute([$email, $origen]);

            return ['ok' => true];
        } catch (Exception $e) {
            error_log("Error en LeadController: " . $e->getMessage());
            return ['ok' => false, 'error' => 'Error en base de datos: ' . $e->getMessage()];
        }
    }

    public static function listar($origen = null)
    {
        try {
            $pdo = getConnection();
            if ($origen) {
                $stmt = $pdo->prepare("SELECT * FROM leads WHERE origen = ? ORDER BY created_at DESC");
                $stmt->execute([$origen]);
            } else {
                $stmt = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC");
            }
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error al listar leads: " . $e->getMessage());
            return [];
        }
    }

    public static function contarPorOrigen()
    {
        try {
            $pdo = getConnection();
            $stmt = $pdo->query("
                SELECT origen, COUNT(*) as total 
                FROM leads 
                GROUP BY origen
            ");
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conteos = ['total' => 0];
            foreach ($resultados as $r) {
                $conteos[$r['origen']] = intval($r['total']);
                $conteos['total'] += intval($r['total']);
            }
            return $conteos;
        } catch (Exception $e) {
            error_log("Error al contar leads: " . $e->getMessage());
            return ['total' => 0];
        }
    }
}

