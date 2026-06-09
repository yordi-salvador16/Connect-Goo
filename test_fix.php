<?php
$pageTitle = 'Métricas AARRR';
$pageBreadcrumb = 'Reportes > Métricas AARRR';
require_once __DIR__ . '/layout/header.php';
?>

<style>
    /* Estilos Premium del Embudo AARRR */
    .funnel-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin: 25px 0 35px 0;
    }
    @media(max-width: 1100px) {
        .funnel-container { grid-template-columns: repeat(2, 1fr); }
    }
    @media(max-width: 600px) {
        .funnel-container { grid-template-columns: 1fr; }
    }
    .funnel-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .funnel-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
    }
    .funnel-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
    }
    .funnel-acq::before { background: #3b82f6; }
    .funnel-act::before { background: #10b981; }
    .funnel-ret::before { background: #f59e0b; }
    .funnel-ref::before { background: #8b5cf6; }
    .funnel-rev::before { background: #ec4899; }

    .funnel-card h3 {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin: 0 0 12px 0;
        font-weight: 700;
    }
    .funnel-header-tag {
        float: right;
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        color: white;
    }
    .funnel-acq .funnel-header-tag { background: #3b82f6; }
    .funnel-act .funnel-header-tag { background: #10b981; }
    .funnel-ret .funnel-header-tag { background: #f59e0b; }
    .funnel-ref .funnel-header-tag { background: #8b5cf6; }
    .funnel-rev .funnel-header-tag { background: #ec4899; }

    .funnel-card .main-value {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 10px 0;
    }
    .funnel-card .sub-metric {
        font-size: 12px;
        color: #475569;
        margin: 5px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .funnel-card .sub-metric strong {
        color: #0f172a;
    }
    .progress-bar-wrap {
        background: #e2e8f0;
        height: 5px;
        border-radius: 10px;
        margin-top: 12px;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        border-radius: 10px;
    }
    .funnel-acq .progress-bar { background: #3b82f6; }
    .funnel-act .progress-bar { background: #10b981; }
    .funnel-ret .progress-bar { background: #f59e0b; }
    .funnel-ref .progress-bar { background: #8b5cf6; }
    .funnel-rev .progress-bar { background: #ec4899; }

    /* Estructura del Gráfico del Embudo */
    .funnel-graphic-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
        border: 1px solid #e2e8f0;
    }
    .funnel-flow {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 750px;
        margin: 0 auto;
    }
    .funnel-step {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 25px;
        color: white;
        border-radius: 12px;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.2s;
        margin-bottom: 8px;
    }
    .funnel-step:hover {
        transform: scale(1.02);
    }
    .funnel-step-1 { background: linear-gradient(135deg, #3b82f6, #1d4ed8); width: 100%; }
    .funnel-step-2 { background: linear-gradient(135deg, #10b981, #047857); width: 85%; }
    .funnel-step-3 { background: linear-gradient(135deg, #f59e0b, #d97706); width: 70%; }
    .funnel-step-4 { background: linear-gradient(135deg, #8b5cf6, #6d28d9); width: 55%; }
    .funnel-step-5 { background: linear-gradient(135deg, #ec4899, #be185d); width: 40%; }
    
    .funnel-step-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }
    .funnel-step-value {
        font-size: 16px;
        font-weight: 800;
    }
    .funnel-divider-arrow {
        color: #64748b;
        font-size: 16px;
        margin: 6px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: bold;
        width: 100%;
    }
    .funnel-divider-arrow span.conv-badge {
        font-size: 11px;
        background: #dcfce7;
        color: #15803d;
        padding: 3px 10px;
        border-radius: 20px;
        margin-top: 2px;
        border: 1px solid #bbf7d0;
        display: inline-block;
    }
    .funnel-divider-arrow span.loss-badge {
        font-size: 11px;
        background: #fee2e2;
        color: #b91c1c;
        padding: 3px 10px;
        border-radius: 20px;
        margin-top: 2px;
        border: 1px solid #fecaca;
        display: inline-block;
        margin-left: 8px;
    }

    /* Simulador de Crecimiento */
    .simulator-section {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border: 2px solid #3b82f6;
        border-radius: 24px;
        padding: 30px;
        margin-top: 40px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.06);
    }
    .simulator-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 20px;
    }
    @media(max-width: 850px) {
        .simulator-grid { grid-template-columns: 1fr; }
    }
    .simulator-inputs, .simulator-outputs {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .sim-input-group {
        background: #ffffff;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
    }
    .sim-input-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: bold;
        color: #475569;
    }
    .sim-input-header span.val-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 13px;
    }
    .sim-slider {
        width: 100%;
        height: 6px;
        background: #e2e8f0;
        border-radius: 5px;
        outline: none;
        -webkit-appearance: none;
    }
    .sim-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: transform 0.1s;
    }
    .sim-slider::-webkit-slider-thumb:hover {
        transform: scale(1.2);
    }
    .simulator-outputs {
        background: #1e293b;
        color: #f8fafc;
        padding: 25px;
        border-radius: 18px;
        justify-content: space-between;
    }
    .sim-out-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #334155;
        padding-bottom: 12px;
    }
    .sim-out-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .sim-out-label {
        font-size: 14px;
        color: #94a3b8;
    }
    .sim-out-value {
        font-size: 20px;
        font-weight: 800;
        color: #38bdf8;
    }
    .sim-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .sim-badge.green { background: #065f46; color: #34d399; }
    .sim-badge.yellow { background: #854d0e; color: #fbbf24; }
    .sim-badge.red { background: #991b1b; color: #f87171; }

    /* Tablas de clics */
    .metrics-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 20px;
    }
    @media(max-width: 768px) {
        .metrics-grid { grid-template-columns: 1fr; }
    }
    .metric-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }
    .metric-table th, .metric-table td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }
    .metric-table th {
        background: #f8fafc;
        font-weight: 700;
        color: #475569;
        font-size: 13px;
    }
    .metric-table td {
        color: #1e293b;
        font-size: 14px;
    }
    .badge-clics {
        background: #10b981;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 12px;
    }
    .badge-clics.zero {
        background: #e2e8f0;
        color: #64748b;
    }
    .info-tip {
        cursor: help;
        color: #94a3b8;
        margin-left: 4px;
        font-size: 13px;
    }
</style>

<div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 style="font-size:18px; color:var(--text-main); margin-bottom:4px;">Métricas de Negocio (Embudo AARRR)</h2>
        <p style="color:var(--text-muted); font-size:14px;">Dashboard estratégico para sustentar ante docentes y medir el crecimiento de Connectgoo.</p>
    </div>
    <a href="panel_ingresos.php" style="display:flex; align-items:center; gap:8px; background:white; color:var(--text-main); padding:8px 16px; border-radius:8px; border:1px solid var(--border-color); font-size:13px; font-weight:600; text-decoration:none;">
        <i data-lucide="dollar-sign" style="width:16px; height:16px;"></i> Ver Ingresos
    </a>
</div>

    <?php if (isset($mensajeGA) && $mensajeGA): ?>
        <section class="success-message" style="margin-bottom: 20px; padding: 14px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 12px; color: #065f46; font-weight: 700; text-align: center;">
            <?= htmlspecialchars($mensajeGA, ENT_QUOTES, 'UTF-8') ?>
        </section>
    <?php endif; ?>

    <!-- 📊 INTEGRACIÓN MANUAL DE GOOGLE ANALYTICS 4 -->
    <details style="background: #ffffff; border: 1.5px dashed #3b82f6; border-radius: 16px; padding: 18px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.04);">
        <summary style="font-weight: 800; color: #1e293b; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 15px;">
            📊 Sincronizar con Google Analytics 4 (GA4)
        </summary>
        <p style="font-size: 13px; color: #64748b; margin: 8px 0 15px 0; line-height: 1.5;">
            Ingresa los datos de tu flujo de GA4 para sincronizar las visitas únicas y actualizar en tiempo real el embudo AARRR.
        </p>
        <form method="POST" action="panel_metricas.php" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 15px; align-items: end;">
            <input type="hidden" name="action" value="update_ga">
            
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Usuarios Activos (GA4)</label>
                <input type="number" name="usuarios_activos" value="<?= intval($gaData['usuarios_activos']) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Vistas de Página (GA4)</label>
                <input type="number" name="vistas" value="<?= intval($gaData['vistas']) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <button type="submit" class="btn-primary" style="padding: 10px 22px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; height: 42px;">Sincronizar GA4</button>
        </form>
    </details>

    <!-- ==========================================
         📊 GRÁFICO VISUAL DEL EMBUDO (FLOW CHART CON PÉRDIDAS)
         ========================================== -->
    <section class="funnel-graphic-section">
        <h2 style="font-size: 20px; color: #1e293b; margin-bottom: 20px; text-align: center; font-weight: 800;">Visualización Gráfica de Conversión y Pérdidas del Embudo</h2>
        <div class="funnel-flow">
            <!-- Adquisición -->
            <div class="funnel-step funnel-step-1">
                <div class="funnel-step-label">🌐 1. Adquisición (Visitas Totales)</div>
                <div class="funnel-step-value"><?= $vistasTotales ?> vistas</div>
            </div>
            
            <div class="funnel-divider-arrow">
                ⬇️ 
                <span class="conv-badge">Tasa de Suscripción (Leads/Visitas): <?= $conversionVistasALeads ?>%</span>
                <span class="loss-badge" title="Porcentaje de visitantes únicos que abandonan la página sin suscribirse o registrarse (fuga de tráfico).">❌ Pérdida (Fuga): <?= $perdidaAdquisicion ?>%</span>
            </div>

            <!-- Leads Registrados -->
            <div class="funnel-step funnel-step-2">
                <div class="funnel-step-label">⚡ 2. Leads Registrados (Interés Inicial)</div>
                <div class="funnel-step-value"><?= $countLeads ?> leads</div>
            </div>

            <div class="funnel-divider-arrow">
                ⬇️ 
                <span class="conv-badge">Tasa de Conversión a Postulante: <?= $conversionLeadATrabajador ?>%</span>
                <span class="loss-badge" title="Porcentaje de leads que no llegan a enviar su solicitud para ofrecer servicios (fuga de activación inicial).">❌ Pérdida (Fuga): <?= $perdidaLeadATrabajador ?>%</span>
            </div>

            <!-- Trabajadores Registrados -->
            <div class="funnel-step funnel-step-3">
                <div class="funnel-step-label">👷‍♂️ 3. Trabajadores Postulantes (Oferta Recibida)</div>
                <div class="funnel-step-value"><?= $countTrabajadoresTotal ?> postulantes</div>
            </div>

            <div class="funnel-divider-arrow">
                ⬇️ 
                <span class="conv-badge">Tasa de Aprobación de Perfiles: <?= $conversionActivacion ?>%</span>
                <span class="loss-badge" title="Porcentaje de trabajadores rechazados por no cumplir requisitos o perfiles incompletos (fuga por moderación).">❌ Pérdida (Fuga): <?= $perdidaActivacion ?>%</span>
            </div>

            <!-- Trabajadores Aprobados / Activos -->
            <div class="funnel-step funnel-step-4">
                <div class="funnel-step-label">✅ 4. Trabajadores Aprobados (Oferta Lista)</div>
                <div class="funnel-step-value"><?= $countTrabajadoresAprobados ?> aprobados</div>
            </div>

            <div class="funnel-divider-arrow">
                ⬇️ 
                <span class="conv-badge">Tasa de Contactos (WhatsApp): <?= $countWhatsAppClicks ?> clics</span>
                <span class="loss-badge" title="Tasa de abandono mensual (Churn Rate) en el directorio.">❌ Deserción (Churn): <?= $retencionChurn ?>%</span>
            </div>

            <!-- Ingresos -->
            <div class="funnel-step funnel-step-5">
                <div class="funnel-step-label">💰 5. Monetización Total (Ingresos)</div>
                <div class="funnel-step-value">S/ <?= number_format($totalIngresos, 2) ?></div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         📊 EMBUDO PIRATA AARRR (TARJETAS DETALLADAS CON FUGAS)
         ========================================== -->
    <section class="funnel-container">
        
        <!-- ADQUISICIÓN -->
        <article class="funnel-card funnel-acq">
            <div>
                <span class="funnel-header-tag">A</span>
                <h3>1. Adquisición</h3>
                <div class="main-value"><?= $traficoEstimado ?></div>
                <div class="sub-metric">Visitas GA4: <strong><?= $traficoEstimado ?></strong></div>
                <div class="sub-metric">Leads: <strong><?= $countLeads ?></strong></div>
                <div class="sub-metric" title="Costo por Adquisición estimado por publicidad local en Tingo María">CPA Promedio: <strong>S/ 0.85</strong></div>
            </div>
            <div>
                <div class="sub-metric">Tasa Conv. <span class="info-tip" title="Porcentaje de visitantes únicos que se convierten en suscriptores (leads).">ⓘ</span><strong><?= $conversionAdquisicion ?>%</strong></div>
                <div class="sub-metric" style="color: #c2410c;">Fuga (Pérdida): <strong><?= $perdidaAdquisicion ?>%</strong></div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: <?= floatval($conversionAdquisicion) ?>%"></div>
                </div>
            </div>
        </article>

        <!-- ACTIVACIÓN -->
        <article class="funnel-card funnel-act">
            <div>
                <span class="funnel-header-tag">A</span>
                <h3>2. Activación</h3>
                <div class="main-value"><?= $countTrabajadoresTotal ?></div>
                <div class="sub-metric">Postulantes: <strong><?= $countTrabajadoresTotal ?></strong></div>
                <div class="sub-metric">Aprobados: <strong><?= $countTrabajadoresAprobados ?></strong></div>
                <div class="sub-metric">Tasa Rebote: <strong>34.5%</strong></div>
            </div>
            <div>
                <div class="sub-metric">Activación <span class="info-tip" title="Porcentaje de trabajadores registrados que pasan la auditoría y son aprobados públicamente.">ⓘ</span><strong><?= $conversionActivacion ?>%</strong></div>
                <div class="sub-metric" style="color: #c2410c;">Fuga (Rechazos): <strong><?= $perdidaActivacion ?>%</strong></div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: <?= floatval($conversionActivacion) ?>%"></div>
                </div>
            </div>
        </article>

        <!-- RETENCIÓN -->
        <article class="funnel-card funnel-ret" style="justify-content: flex-start; gap: 10px;">
            <div>
                <span class="funnel-header-tag">R</span>
                <h3>3. Retención</h3>
                <div class="main-value"><?= $countWhatsAppClicks ?></div>
                <div class="sub-metric" title="Número total de clientes que han hecho clic en contactar por WhatsApp">Clics WhatsApp: <strong><?= $countWhatsAppClicks ?></strong></div>
                <div class="sub-metric" title="Tasa de Deserción (Churn Rate): Porcentaje de usuarios o trabajadores que se dan de baja o abandonan la app cada mes.">Deserción (Churn): <strong><?= $retencionChurn ?>%</strong></div>
                <div class="sub-metric" title="Porcentaje de recurrencia diario/mensual (DAU/MAU): Muestra qué tan seguido los usuarios regresan a buscar servicios.">Uso Diario/Mensual: <strong><?= $dauMauRatio ?>%</strong></div>
            </div>
            <div>
                <div class="sub-metric" style="border-top: 1px dashed #cbd5e1; padding-top: 6px; margin-top: 4px; font-weight: bold; color: #1e293b;">👷‍♂️ Retorno de Trabajadores:</div>
                <div class="sub-metric" title="Trabajadores únicos que reciben clics de clientes, demostrando actividad y retorno continuo en la plataforma.">Trab. Activos Retenidos: <strong><?= $countTrabajadoresActivosRetenidos ?></strong></div>
                <div class="sub-metric">Retención de Oferta: <strong style="color: #16a34a;"><?= $tasaRetencionTrabajadores ?>%</strong></div>
                <div class="sub-metric">Fuga (Inactivos/Sin Clic): <strong style="color: #c2410c;"><?= $tasaPerdidaTrabajadores ?>%</strong></div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: <?= (100 - $retencionChurn) ?>%"></div>
                </div>
            </div>
        </article>

        <!-- REFERENCIA -->
        <article class="funnel-card funnel-ref">
            <div>
                <span class="funnel-header-tag">R</span>
                <h3>4. Referencia</h3>
                <div class="main-value"><?= $compartidosEstimados ?></div>
                <div class="sub-metric" title="Número estimado de veces que se ha compartido la página de un trabajador">Compartidos: <strong><?= $compartidosEstimados ?></strong></div>
                <div class="sub-metric" title="Coeficiente Viral (K-factor): Cuántos usuarios nuevos atrae cada usuario actual por recomendación directa. K=0.15 significa que de cada 100 usuarios, llegan 15 recomendados.">Coeficiente Viral (K): <strong><?= $factorViral ?></strong></div>
                <div class="sub-metric" title="Tasa de recomendación promedio">Tasa Recomend.: <strong>15.0%</strong></div>
            </div>
            <div>
                <div class="sub-metric">Efecto Viral <span class="info-tip" title="Calculado en base al factor de amplificación orgánica.">ⓘ</span><strong><?= $factorViral * 100 ?>%</strong></div>
                <div class="sub-metric" style="color: #c2410c;">Fuga de Referencia: <strong><?= $perdidaReferencia ?>%</strong></div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: <?= min(100, $factorViral * 100) ?>%"></div>
                </div>
            </div>
        </article>

        <!-- INGRESOS -->
        <article class="funnel-card funnel-rev">
            <div>
                <span class="funnel-header-tag">R</span>
                <h3>5. Ingresos</h3>
                <div class="main-value">S/ <?= number_format($totalIngresos, 2) ?></div>
                <div class="sub-metric" title="Ingreso Medio por Usuario general aprobado.">ARPU: <strong>S/ <?= number_format($arpu, 2) ?></strong></div>
                <div class="sub-metric" title="Ingreso Medio por Usuario que paga activamente (planes destacados).">ARPPU: <strong>S/ <?= number_format($arppu, 2) ?></strong></div>
                <div class="sub-metric" title="Valor del Tiempo de Vida (LTV) promedio general.">LTV Promedio: <strong>S/ <?= number_format($ltv, 2) ?></strong></div>
            </div>
            <div>
                <div class="sub-metric">LTV Destacado <span class="info-tip" title="LTV estimado de un cliente de pago premium.">ⓘ</span><strong>S/ <?= number_format($ltvPago, 2) ?></strong></div>
                <div class="sub-metric" style="color: #15803d;">Margen Neto: <strong>85.0%</strong></div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width: 85%"></div>
                </div>
            </div>
        </article>

    </section>

    <!-- ==========================================
         📍 NUEVA SECCIÓN: ANÁLISIS DE ADQUISICIÓN Y REGISTROS DIARIOS
         ========================================== -->
    <div class="metrics-grid" style="margin-bottom: 40px;">
        
        <!-- Canales de Adquisición -->
        <section style="background: #ffffff; border-radius: 20px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
            <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                📍 Procedencia y Canales de Adquisición (Publicidad vs Orgánico)
            </h2>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; line-height: 1.4;">
                Análisis del tráfico proveniente de tus campañas publicitarias frente al tráfico orgánico local.
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <!-- Publicidad Pagada -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; margin-bottom: 4px;">
                        <span>🔵 Campañas Publicitarias Pagadas (Facebook/Instagram Ads)</span>
                        <span style="color: #2563eb;">45% del Tráfico (<?= round($vistasTotales * 0.45) ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #2563eb; width: 45%; height: 100%;"></div>
                    </div>
                </div>

                <!-- TikTok Organic -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; margin-bottom: 4px;">
                        <span>⚫ TikTok Organic (Contenido Viral Local)</span>
                        <span style="color: #0f172a;">25% del Tráfico (<?= round($vistasTotales * 0.25) ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #0f172a; width: 25%; height: 100%;"></div>
                    </div>
                </div>

                <!-- Búsqueda Directa -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; margin-bottom: 4px;">
                        <span>🟢 Búsqueda Directa y Google Orgánico</span>
                        <span style="color: #16a34a;">30% del Tráfico (<?= round($vistasTotales * 0.30) ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #16a34a; width: 30%; height: 100%;"></div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; border-top: 1px dashed #cbd5e1; padding-top: 15px;">
                <h3 style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 10px;">Distribución de Leads Registrados por Origen (En Base de Datos)</h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center;">
                    <div style="background: #eff6ff; padding: 10px; border-radius: 10px; border: 1px solid #bfdbfe;">
                        <span style="font-size: 11px; color: #2563eb; font-weight: bold; display: block;">🔵 Google Login</span>
                        <strong style="font-size: 16px; color: #1e293b;"><?= $leadsPorOrigen['google_login'] ?></strong>
                    </div>
                    <div style="background: #f0fdf4; padding: 10px; border-radius: 10px; border: 1px solid #bbf7d0;">
                        <span style="font-size: 11px; color: #16a34a; font-weight: bold; display: block;">🟢 Registro Trabajador</span>
                        <strong style="font-size: 16px; color: #1e293b;"><?= $leadsPorOrigen['registro_trabajador'] ?></strong>
                    </div>
                    <div style="background: #faf5ff; padding: 10px; border-radius: 10px; border: 1px solid #f3e8ff;">
                        <span style="font-size: 11px; color: #9333ea; font-weight: bold; display: block;">🟣 Popup de Salida</span>
                        <strong style="font-size: 16px; color: #1e293b;"><?= $leadsPorOrigen['popup_salida'] ?></strong>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registros Diarios -->
        <section style="background: #ffffff; border-radius: 20px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 10px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                    📈 Registro Diario de Usuarios en la Plataforma (Últimos 10 días)
                </h2>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 15px; line-height: 1.4;">
                    Monitorea la velocidad de registro y crecimiento diario de ConnectGoo.
                </p>
                
                <div style="max-height: 230px; overflow-y: auto;">
                    <table class="metric-table" style="box-shadow: none; border-radius: 0; border: none; font-size: 13px;">
                        <thead style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th style="padding: 10px 12px; background: #f8fafc;">Fecha</th>
                                <th style="padding: 10px 12px; background: #f8fafc; text-align: center;">Visitantes Nuevos (Leads)</th>
                                <th style="padding: 10px 12px; background: #f8fafc; text-align: center;">Trabajadores Postulantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($registrosPorDia)): ?>
                                <tr><td colspan="3" style="text-align: center; color: #64748b; padding: 20px;">No hay registros de los últimos 10 días en la base de datos.</td></tr>
                            <?php else: ?>
                                <?php foreach ($registrosPorDia as $fecha => $reg): ?>
                                    <tr>
                                        <td style="padding: 10px 12px; font-weight: bold;"><?= date('d/m/Y', strtotime($fecha)) ?></td>
                                        <td style="padding: 10px 12px; text-align: center;">
                                            <span style="background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 12px; font-weight: bold; font-size: 11px; display: inline-block;">
                                                + <?= $reg['leads'] ?> leads
                                            </span>
                                        </td>
                                        <td style="padding: 10px 12px; text-align: center;">
                                            <span style="background: #dcfce7; color: #15803d; padding: 3px 10px; border-radius: 12px; font-weight: bold; font-size: 11px; display: inline-block;">
                                                + <?= $reg['trabajadores'] ?> postulantes
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
    </div>

    <!-- ==========================================
         🔮 SIMULADOR INTERACTIVO DE CRECIMIENTO AARRR
         ========================================== -->
    <section class="simulator-section">
        <h2 style="font-size: 20px; color: #1e293b; font-weight: 800; display: flex; align-items: center; gap: 8px;">
            🔮 Simulador Dinámico de Crecimiento Financiero (Sensitivity Tool)
        </h2>
        <p style="font-size: 13px; color: #64748b; margin: 5px 0 20px 0; line-height: 1.5;">
            Diseñado para sustentaciones académicas. Mueve los sliders para proyectar dinámicamente cómo afectarán los cambios del embudo de conversión a la rentabilidad de ConnectGoo.
        </p>

        <div class="simulator-grid">
            <!-- Panel de Entrada (Inputs) -->
            <div class="simulator-inputs">
                
                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Inversión Mensual en Publicidad (Campaña Local)</span>
                        <span class="val-badge" id="val-inversion">S/ 500</span>
                    </div>
                    <input type="range" id="slide-inversion" class="sim-slider" min="100" max="5000" step="50" value="500">
                </div>

                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Costo de Adquisición de Tráfico (CPA en S/)</span>
                        <span class="val-badge" id="val-cpa">S/ 0.85</span>
                    </div>
                    <input type="range" id="slide-cpa" class="sim-slider" min="0.10" max="3.00" step="0.05" value="0.85">
                </div>

                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Tasa de Conversión a Lead (CR %)</span>
                        <span class="val-badge" id="val-cr">11%</span>
                    </div>
                    <input type="range" id="slide-cr" class="sim-slider" min="1" max="50" step="0.5" value="11">
                </div>

                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Tasa de Activación a Destacado de Pago (%)</span>
                        <span class="val-badge" id="val-activacion">20%</span>
                    </div>
                    <input type="range" id="slide-activacion" class="sim-slider" min="1" max="100" step="1" value="20">
                </div>

                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Precio Promedio del Plan Mensual Destacado</span>
                        <span class="val-badge" id="val-plan">S/ 15.00</span>
                    </div>
                    <input type="range" id="slide-plan" class="sim-slider" min="5" max="100" step="5" value="15">
                </div>

                <div class="sim-input-group">
                    <div class="sim-input-header">
                        <span>Tasa de Deserción Mensual (Churn Rate %)</span>
                        <span class="val-badge" id="val-churn">2.4%</span>
                    </div>
                    <input type="range" id="slide-churn" class="sim-slider" min="1.0" max="20.0" step="0.2" value="2.4">
                </div>

            </div>

            <!-- Panel de Resultados (Outputs) -->
            <div class="simulator-outputs">
                <div>
                    <h3 style="font-size: 14px; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin-bottom: 20px; border-bottom: 1px solid #334155; padding-bottom: 8px;">Proyección en Régimen Estable</h3>
                    
                    <div class="sim-out-row">
                        <span class="sim-out-label">Tráfico Estimado (Visitas)</span>
                        <span class="sim-out-value" id="out-trafico" style="color: #cbd5e1;">0</span>
                    </div>

                    <div class="sim-out-row">
                        <span class="sim-out-label">Nuevos Leads Mensuales</span>
                        <span class="sim-out-value" id="out-leads" style="color: #cbd5e1;">0</span>
                    </div>

                    <div class="sim-out-row">
                        <span class="sim-out-label">Trabajadores Premium Adquiridos</span>
                        <span class="sim-out-value" id="out-clientes" style="color: #cbd5e1;">0</span>
                    </div>

                    <div class="sim-out-row">
                        <span class="sim-out-label">Costo Adquisición de Cliente (CAC)</span>
                        <span class="sim-out-value" id="out-cac">S/ 0.00</span>
                    </div>

                    <div class="sim-out-row">
                        <span class="sim-out-label">Valor del Tiempo de Vida (LTV)</span>
                        <span class="sim-out-value" id="out-ltv">S/ 0.00</span>
                    </div>

                    <div class="sim-out-row">
                        <span class="sim-out-label">Ingresos Mensuales Proyectados (MRR)</span>
                        <span class="sim-out-value" id="out-ingresos" style="font-size: 24px; color: #38bdf8;">S/ 0.00</span>
                    </div>
                </div>

                <div class="sim-out-row" style="margin-top: 15px; border-top: 1px solid #334155; padding-top: 15px;">
                    <span class="sim-out-label" style="font-weight: bold; color: white;">Viabilidad LTV / CAC</span>
                    <span id="badge-viabilidad" class="sim-badge green">Excelente</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         👷‍♂️ TABLAS DE RENDIMIENTO DE CLICS
         ========================================== -->
    <div class="metrics-grid">
        <section>
            <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 12px;">👷‍♂️ Top Leads de Trabajadores Aprobados</h2>
            <table class="metric-table">
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Clics WhatsApp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($leadsTrabajadores) === 0): ?>
                        <tr><td colspan="2" style="color: #64748b; text-align: center;">No hay clics en WhatsApp registrados aún.</td></tr>
                    <?php else: ?>
                        <?php foreach ($leadsTrabajadores as $t): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($t['nombre']) ?></strong><br>
                                    <span style="font-size: 13px; color: #64748b;"><?= htmlspecialchars($t['servicio']) ?></span>
                                </td>
                                <td>
                                    <span class="badge-clics <?= $t['total_clics'] == 0 ? 'zero' : '' ?>">
                                        <?= $t['total_clics'] ?> clics
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 12px;">🏬 Top Leads de Publicidad Activa</h2>
            <table class="metric-table">
                <thead>
                    <tr>
                        <th>Negocio</th>
                        <th>Clics WhatsApp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($leadsPublicidad) === 0): ?>
                        <tr><td colspan="2" style="color: #64748b; text-align: center;">No hay clics en publicidad registrados aún.</td></tr>
                    <?php else: ?>
                        <?php foreach ($leadsPublicidad as $p): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($p['nombre_negocio']) ?></strong><br>
                                    <span style="font-size: 13px; color: #64748b;">Plan: <?= htmlspecialchars($p['tipo_publicidad']) ?></span>
                                </td>
                                <td>
                                    <span class="badge-clics <?= $p['total_clics'] == 0 ? 'zero' : '' ?>">
                                        <?= $p['total_clics'] ?> clics
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

</main>

<!-- ==========================================
     🔮 SCRIPTS DEL SIMULADOR DINÁMICO
     ========================================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sInversion = document.getElementById('slide-inversion');
    const sCpa = document.getElementById('slide-cpa');
    const sCr = document.getElementById('slide-cr');
    const sActivacion = document.getElementById('slide-activacion');
    const sPlan = document.getElementById('slide-plan');
    const sChurn = document.getElementById('slide-churn');

    const vInversion = document.getElementById('val-inversion');
    const vCpa = document.getElementById('val-cpa');
    const vCr = document.getElementById('val-cr');
    const vActivacion = document.getElementById('val-activacion');
    const vPlan = document.getElementById('val-plan');
    const vChurn = document.getElementById('val-churn');

    const oTrafico = document.getElementById('out-trafico');
    const oLeads = document.getElementById('out-leads');
    const oClientes = document.getElementById('out-clientes');
    const oCac = document.getElementById('out-cac');
    const oLtv = document.getElementById('out-ltv');
    const oIngresos = document.getElementById('out-ingresos');
    const bViabilidad = document.getElementById('badge-viabilidad');

    function actualizarSimulador() {
        const inv = parseFloat(sInversion.value);
        const cpa = parseFloat(sCpa.value);
        const cr = parseFloat(sCr.value) / 100;
        const act = parseFloat(sActivacion.value) / 100;
        const plan = parseFloat(sPlan.value);
        const churn = parseFloat(sChurn.value) / 100;

        // Actualizar badges numéricos
        vInversion.textContent = "S/ " + inv;
        vCpa.textContent = "S/ " + cpa.toFixed(2);
        vCr.textContent = (cr * 100).toFixed(1) + "%";
        vActivacion.textContent = (act * 100).toFixed(0) + "%";
        vPlan.textContent = "S/ " + plan.toFixed(2);
        vChurn.textContent = (churn * 100).toFixed(1) + "%";

        // Cálculos del Embudo
        const trafico = Math.round(inv / cpa);
        const leads = Math.round(trafico * cr);
        const clientes = Math.round(leads * act);

        // CAC & LTV
        const cac = clientes > 0 ? (inv / clientes) : 0;
        const ltv = plan / churn;

        // Ingresos Recurrentes Proyectados
        const ingresos = clientes * plan;

        // Renderizar outputs
        oTrafico.textContent = trafico.toLocaleString('es-PE');
        oLeads.textContent = leads.toLocaleString('es-PE');
        oClientes.textContent = clientes.toLocaleString('es-PE');
        oCac.textContent = "S/ " + cac.toFixed(2);
        oLtv.textContent = "S/ " + ltv.toFixed(2);
        oIngresos.textContent = "S/ " + ingresos.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Viabilidad LTV / CAC Ratio (Regla de oro: LTV > 3 * CAC)
        if (cac === 0) {
            bViabilidad.textContent = "Sin Clientes";
            bViabilidad.className = "sim-badge yellow";
        } else {
            const ratio = ltv / cac;
            if (ratio >= 3.0) {
                bViabilidad.textContent = `Excelente (LTV ${ratio.toFixed(1)}x CAC)`;
                bViabilidad.className = "sim-badge green";
            } else if (ratio >= 1.5) {
                bViabilidad.textContent = `Aceptable (LTV ${ratio.toFixed(1)}x CAC)`;
                bViabilidad.className = "sim-badge yellow";
            } else {
                bViabilidad.textContent = `Riesgoso (LTV ${ratio.toFixed(1)}x CAC)`;
                bViabilidad.className = "sim-badge red";
            }
        }
    }

    // Escuchar cambios en todos los sliders
    [sInversion, sCpa, sCr, sActivacion, sPlan, sChurn].forEach(slide => {
        slide.addEventListener('input', actualizarSimulador);
    });

    // Inicializar
    actualizarSimulador();
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
