<?php
require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getConnection();
    if ($pdo) {
        $stmt = $pdo->query("SELECT email, created_at, origen FROM leads ORDER BY id DESC LIMIT 5");
        $leads = $stmt->fetchAll();
        foreach ($leads as $lead) {
            echo "Email: " . $lead['email'] . " | Created At: " . $lead['created_at'] . " | Origen: " . $lead['origen'] . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
