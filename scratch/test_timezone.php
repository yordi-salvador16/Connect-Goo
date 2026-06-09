<?php
require_once __DIR__ . '/../app/config/database.php';

echo "PHP Current Time: " . date('Y-m-d H:i:s') . "\n";
echo "PHP Default Timezone: " . date_default_timezone_get() . "\n";

try {
    $pdo = getConnection();
    if ($pdo) {
        $stmt = $pdo->query("SELECT NOW() AS mysql_now, @@session.time_zone AS mysql_tz, @@global.time_zone AS mysql_glob_tz");
        $res = $stmt->fetch();
        echo "MySQL NOW(): " . $res['mysql_now'] . "\n";
        echo "MySQL Session TZ: " . $res['mysql_tz'] . "\n";
        echo "MySQL Global TZ: " . $res['mysql_glob_tz'] . "\n";
    }
} catch (Exception $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
}
