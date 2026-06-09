<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/registro_de_errores');

require_once __DIR__ . '/../app/config/session.php';
require_once __DIR__ . '/../app/config/database.php';

$adminActual = verificarAdmin(['superadmin', 'admin']);
$pdo = getConnection();

// ============================================================
// 📊 GOOGLE ANALYTICS INTEGRATION
// ============================================================
$isFase1 = (isset($_GET['fase']) && $_GET['fase'] === '1') || (isset($_POST['fase']) && $_POST['fase'] === '1');
$gaFile = $isFase1 ? __DIR__ . '/../app/config/fase1_metrics.json' : __DIR__ . '/../app/config/ga_metrics.json';

$gaData = [
    'usuarios_activos' => $isFase1 ? 150 : 461, 
    'vistas' => $isFase1 ? 400 : 1200,
    'trafico_tiktok' => 0,
    'trafico_facebook' => 0,
    'fase1_leads' => 35,
    'fase1_trabajadores' => 4,
    'fase1_clics' => 12
];

if (file_exists($gaFile)) {
    $savedData = json_decode(file_get_contents($gaFile), true);
    if (is_array($savedData)) {
        $gaData = array_merge($gaData, $savedData);
    }
}

$mensajeGA = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_ga') {
    $usuarios_activos = intval($_POST['usuarios_activos'] ?? $gaData['usuarios_activos']);
    $vistas = intval($_POST['vistas'] ?? $gaData['vistas']);
    $trafico_tiktok = intval($_POST['trafico_tiktok'] ?? 0);
    $trafico_facebook = intval($_POST['trafico_facebook'] ?? 0);
    $fase1_leads = intval($_POST['fase1_leads'] ?? $gaData['fase1_leads']);
    $fase1_trabajadores = intval($_POST['fase1_trabajadores'] ?? $gaData['fase1_trabajadores']);
    $fase1_clics = intval($_POST['fase1_clics'] ?? $gaData['fase1_clics']);
    
    $gaData = [
        'usuarios_activos' => $usuarios_activos, 
        'vistas' => $vistas,
        'trafico_tiktok' => $trafico_tiktok,
        'trafico_facebook' => $trafico_facebook,
        'fase1_leads' => $fase1_leads,
        'fase1_trabajadores' => $fase1_trabajadores,
        'fase1_clics' => $fase1_clics
    ];
    
    if (!is_dir(dirname($gaFile))) {
        mkdir(dirname($gaFile), 0777, true);
    }
    file_put_contents($gaFile, json_encode($gaData));
    $mensajeGA = "Métricas de " . ($isFase1 ? "Fase 1" : "Fase 2") . " sincronizadas correctamente.";
}

// ============================================================
// 📈 SIMULACIÓN ACADÉMICA DE PRECIOS
// ============================================================
$simFile = __DIR__ . '/../app/config/simulacion_precios.json';
$simData = [
    'precio_basico' => 15,
    'precio_estandar' => 30,
    'precio_premium' => 50,
    'precio_publicidad' => 40
];

if (file_exists($simFile)) {
    $savedSimData = json_decode(file_get_contents($simFile), true);
    if (is_array($savedSimData)) {
        $simData = array_merge($simData, $savedSimData);
    }
}

$mensajeSim = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_simulacion') {
    $simData = [
        'precio_basico' => floatval($_POST['precio_basico'] ?? 15),
        'precio_estandar' => floatval($_POST['precio_estandar'] ?? 30),
        'precio_premium' => floatval($_POST['precio_premium'] ?? 50),
        'precio_publicidad' => floatval($_POST['precio_publicidad'] ?? 40)
    ];
    
    if (!is_dir(dirname($simFile))) {
        mkdir(dirname($simFile), 0777, true);
    }
    file_put_contents($simFile, json_encode($simData));
    $mensajeSim = "Precios de simulación actualizados correctamente.";
}

// ============================================================
// 📊 REAL METRICS CALCULATION FROM DATABASE (AARRR Funnel)
// ============================================================

// 1. Adquisición (Acquisition)
$stmt = $pdo->query("SELECT COUNT(*) FROM leads");
$countLeads = intval($stmt->fetchColumn() ?? 0);

try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM pwa_installs");
    $countPWA = intval($stmt->fetchColumn() ?? 0);
} catch(Exception $e) {
    $countPWA = 0; // Si la tabla aún no existe, no rompemos el dashboard
}

$traficoEstimado = max(1, intval($gaData['usuarios_activos'])); 
$vistasTotales = max(1, intval($gaData['vistas']));

// Cálculo de conversiones seguras y lógicas (máximo 100%)
$conversionAdquisicion = number_format(min(100.0, ($countLeads / $traficoEstimado) * 100), 1);
$conversionVistasALeads = number_format(min(100.0, ($countLeads / $vistasTotales) * 100), 1);

// Porcentaje de pérdidas/fuga en Adquisición (Drop-off)
$perdidaAdquisicion = number_format(100.0 - floatval($conversionVistasALeads), 1);

// Cálculo de distribución de fuentes de tráfico
$tiktokViews = intval($gaData['trafico_tiktok']);
$facebookViews = intval($gaData['trafico_facebook']);
$totalSocial = $tiktokViews + $facebookViews;

$pctTiktok = 0; $pctFacebook = 0; $pctOtros = 100;
if ($vistasTotales > 0) {
    $pctTiktok = min(100, round(($tiktokViews / $vistasTotales) * 100));
    $pctFacebook = min(100, round(($facebookViews / $vistasTotales) * 100));
    $pctOtros = max(0, 100 - ($pctTiktok + $pctFacebook));
}

// 2. Activación (Activation)
$stmt = $pdo->query("SELECT COUNT(*) FROM trabajadores");
$countTrabajadoresTotal = intval($stmt->fetchColumn() ?? 0);
$stmt = $pdo->query("SELECT COUNT(*) FROM trabajadores WHERE estado = 'aprobado'");
$countTrabajadoresAprobados = intval($stmt->fetchColumn() ?? 0);
$conversionActivacion = $countTrabajadoresTotal > 0 ? number_format(min(100.0, ($countTrabajadoresAprobados / $countTrabajadoresTotal) * 100), 1) : "0.0";

// Tasa de conversión de Lead General a Candidato a Trabajador
$conversionLeadATrabajador = $countLeads > 0 ? number_format(min(100.0, ($countTrabajadoresTotal / $countLeads) * 100), 1) : "0.0";

// Porcentaje de pérdidas en Registro e Aprobación
$perdidaLeadATrabajador = number_format(100.0 - floatval($conversionLeadATrabajador), 1);
$perdidaActivacion = number_format(100.0 - floatval($conversionActivacion), 1);

// 3. Retención (Retention)
$stmt = $pdo->query("SELECT COUNT(*) FROM whatsapp_leads WHERE tipo = 'trabajador'");
$countWhatsAppClicks = intval($stmt->fetchColumn() ?? 0);
$retencionChurn = 2.4; // Tasa de abandono baja (2.4%) por ser servicio gratuito en lanzamiento
$dauMauRatio = 18.5; // Coeficiente de recurrencia en el directorio

// NUEVO: Retención de Trabajadores Registrados que Regresan (Active Retention)
// Contamos cuántos trabajadores registrados y aprobados únicos han recibido contactos (WhatsApp clicks)
// Esto representa a los trabajadores activos y retenidos que continúan interactuando con clientes en la plataforma
$stmt = $pdo->query("SELECT COUNT(DISTINCT entidad_id) FROM whatsapp_leads WHERE tipo = 'trabajador'");
$countTrabajadoresActivosRetenidos = intval($stmt->fetchColumn() ?? 0);
$tasaRetencionTrabajadores = $countTrabajadoresAprobados > 0 ? number_format(min(100.0, ($countTrabajadoresActivosRetenidos / $countTrabajadoresAprobados) * 100), 1) : "0.0";
$tasaPerdidaTrabajadores = number_format(100.0 - floatval($tasaRetencionTrabajadores), 1);

// 4. Referencia (Referral)
$stmt = $pdo->query("SELECT COUNT(*) FROM whatsapp_leads WHERE tipo = 'compartir'");
$compartidosReales = intval($stmt->fetchColumn() ?? 0);
$compartidosEstimados = max($compartidosReales, round($countWhatsAppClicks * 0.15)); // Respaldo del 15% si aún es nuevo
$factorViral = $countLeads > 0 ? number_format(min(3.0, ($compartidosEstimados * 0.3) / $countLeads), 2) : "0.0";
$perdidaReferencia = number_format(max(0.0, 100.0 - (floatval($factorViral) * 100)), 1);

// 5. Ingresos Reales (Revenue) - LO QUE VA EN EL EMBUDO PRINCIPAL
$stmt = $pdo->query("
    SELECT SUM(p.precio) 
    FROM trabajadores t
    LEFT JOIN planes p ON t.plan_id = p.id
    WHERE t.estado = 'aprobado'
");
$ingresosPlanesReal = floatval($stmt->fetchColumn() ?? 0);

$stmt = $pdo->query("
    SELECT SUM(monto) 
    FROM publicidad_negocios 
    WHERE estado = 'aprobado'
");
$ingresosPublicidadReal = floatval($stmt->fetchColumn() ?? 0);

$totalIngresos = $ingresosPlanesReal + $ingresosPublicidadReal;

$stmt = $pdo->query("
    SELECT COUNT(*) 
    FROM trabajadores t 
    LEFT JOIN planes p ON t.plan_id = p.id 
    WHERE t.estado = 'aprobado' AND p.precio > 0
");
$countTrabajadoresPagoReal = intval($stmt->fetchColumn() ?? 0);

$arpu = $countTrabajadoresAprobados > 0 ? $totalIngresos / $countTrabajadoresAprobados : 0;
$arppu = $countTrabajadoresPagoReal > 0 ? $totalIngresos / $countTrabajadoresPagoReal : $totalIngresos;
$ltv = $arpu > 0 ? ($arpu / ($retencionChurn / 100)) : 0;
$ltvPago = $arppu > 0 ? ($arppu / ($retencionChurn / 100)) : 0;

// ============================================================
// 📈 CÁLCULO DE SIMULACIÓN ACADÉMICA (SOLO PARA LA TABLA)
// ============================================================
$stmt = $pdo->query("
    SELECT COALESCE(p.nombre, 'básico') as nombre, COUNT(t.id) as cantidad
    FROM trabajadores t
    LEFT JOIN planes p ON t.plan_id = p.id
    WHERE t.estado = 'aprobado'
    GROUP BY p.nombre
");
$planesWorkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ingresosPlanesSimulados = 0;
$desgloseSimulacion = []; 

foreach ($planesWorkers as $pw) {
    $nombrePlanOriginal = $pw['nombre'] ?? 'Básico';
    $nombrePlan = strtolower($nombrePlanOriginal);
    
    $precioSimulado = floatval($simData['precio_basico'] ?? 15);
    if (strpos($nombrePlan, 'premium') !== false || strpos($nombrePlan, 'destacado') !== false) {
        $precioSimulado = floatval($simData['precio_premium'] ?? 50);
    } elseif (strpos($nombrePlan, 'estándar') !== false || strpos($nombrePlan, 'estandar') !== false || strpos($nombrePlan, 'intermedio') !== false) {
        $precioSimulado = floatval($simData['precio_estandar'] ?? 30);
    }
    
    $subtotal = $precioSimulado * intval($pw['cantidad']);
    $ingresosPlanesSimulados += $subtotal;
    
    $desgloseSimulacion[] = [
        'plan' => ucfirst($nombrePlanOriginal),
        'precio' => $precioSimulado,
        'cantidad' => intval($pw['cantidad']),
        'subtotal' => $subtotal
    ];
}

$stmt = $pdo->query("
    SELECT COUNT(*) 
    FROM publicidad_negocios 
    WHERE estado = 'aprobado'
");
$cantidadPublicidad = intval($stmt->fetchColumn() ?? 0);
$ingresosPublicidadSimulados = $cantidadPublicidad * floatval($simData['precio_publicidad'] ?? 40);
$totalIngresosSimulados = $ingresosPlanesSimulados + $ingresosPublicidadSimulados;

// ============================================================
// 📍 NUEVAS CONSULTAS: ORIGEN DE TRÁFICO Y REGISTROS DIARIOS
// ============================================================

// A. Distribución real de leads por origen de registro en BD
$stmt = $pdo->query("SELECT origen, COUNT(*) as total FROM leads GROUP BY origen");
$origenesRealDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

$leadsPorOrigen = [
    'google_login' => 0,
    'registro_trabajador' => 0,
    'popup_salida' => 0
];
foreach ($origenesRealDB as $or) {
    if (isset($leadsPorOrigen[$or['origen']])) {
        $leadsPorOrigen[$or['origen']] = intval($or['total']);
    }
}

// B. Registros diarios en la plataforma (Últimos 10 días)
$sqlDailyLeads = "
    SELECT DATE(created_at) as fecha, COUNT(*) as total 
    FROM leads 
    GROUP BY DATE(created_at) 
    ORDER BY fecha DESC 
    LIMIT 10
";
$stmt = $pdo->query($sqlDailyLeads);
$registrosDiariosLeads = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlDailyTrabajadores = "
    SELECT DATE(created_at) as fecha, COUNT(*) as total 
    FROM trabajadores 
    GROUP BY DATE(created_at) 
    ORDER BY fecha DESC 
    LIMIT 10
";
$stmt = $pdo->query($sqlDailyTrabajadores);
$registrosDiariosTrabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Combinar registros diarios para mostrarlos en una sola tabla integrada
$registrosPorDia = [];
foreach ($registrosDiariosLeads as $rl) {
    $fecha = $rl['fecha'];
    $registrosPorDia[$fecha]['leads'] = intval($rl['total']);
    $registrosPorDia[$fecha]['trabajadores'] = 0;
}
foreach ($registrosDiariosTrabajadores as $rt) {
    $fecha = $rt['fecha'];
    if (!isset($registrosPorDia[$fecha])) {
        $registrosPorDia[$fecha]['leads'] = 0;
    }
    $registrosPorDia[$fecha]['trabajadores'] = intval($rt['total']);
}
krsort($registrosPorDia); // Ordenar por fecha descendente

// ============================================================
// 👷‍♂️ WORKERS & ADS DETAILED CLICKS LISTS
// ============================================================

// Obtener leads de trabajadores
$sqlTrabajadores = "
    SELECT t.id, t.nombre, t.servicio, COUNT(w.id) as total_clics 
    FROM trabajadores t
    LEFT JOIN whatsapp_leads w ON w.entidad_id = t.id AND w.tipo = 'trabajador'
    WHERE t.estado = 'aprobado'
    GROUP BY t.id, t.nombre, t.servicio
    ORDER BY total_clics DESC
";
$stmt = $pdo->query($sqlTrabajadores);
$leadsTrabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener leads de publicidad
$sqlPublicidad = "
    SELECT p.id, p.nombre_negocio, p.tipo_publicidad, COUNT(w.id) as total_clics 
    FROM publicidad_negocios p
    LEFT JOIN whatsapp_leads w ON w.entidad_id = p.id AND w.tipo = 'publicidad'
    WHERE p.estado = 'aprobado'
    GROUP BY p.id, p.nombre_negocio, p.tipo_publicidad
    ORDER BY total_clics DESC
";
$stmt = $pdo->query($sqlPublicidad);
$leadsPublicidad = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================================================
// 🔄 OVERRIDE PARA FASE 1 (MVP) - DEMOSTRACIÓN ACADÉMICA
// ============================================================
if ($isFase1) {
    $traficoEstimado = max(1, intval($gaData['usuarios_activos']));
    $countLeads = max(0, intval($gaData['fase1_leads']));
    $conversionAdquisicion = number_format(($countLeads / $traficoEstimado) * 100, 1);
    $perdidaAdquisicion = number_format(100 - $conversionAdquisicion, 1);

    $countTrabajadoresTotal = intval($gaData['fase1_trabajadores']) + 2; // Simulamos algunos rechazados
    $countTrabajadoresAprobados = intval($gaData['fase1_trabajadores']);
    $conversionActivacion = number_format(($countTrabajadoresAprobados / max(1, $countTrabajadoresTotal)) * 100, 1);
    $perdidaActivacion = number_format(100 - $conversionActivacion, 1);

    $countWhatsAppClicks = intval($gaData['fase1_clics']);
    $retencionChurn = 15.0; // Alto en MVP
    $dauMauRatio = 8.0; 
    $countTrabajadoresActivosRetenidos = max(0, $countTrabajadoresAprobados - 2);
    $tasaRetencionTrabajadores = number_format(($countTrabajadoresActivosRetenidos / max(1, $countTrabajadoresAprobados)) * 100, 1);
    $tasaPerdidaTrabajadores = number_format(100 - $tasaRetencionTrabajadores, 1);

    $compartidosReales = 2;
    $compartidosEstimados = 2;
    $factorViral = number_format((2 * 0.3) / max(1, $countLeads), 2);
    $perdidaReferencia = number_format(max(0, 100 - ($factorViral * 100)), 1);

    $totalIngresos = 0; // MVP fue gratuito
    $arpu = 0;
    $arppu = 0;
    $ltv = 0;
    $ltvPago = 0;
}

require_once __DIR__ . '/../app/views/admin/panel_metricas.php';


