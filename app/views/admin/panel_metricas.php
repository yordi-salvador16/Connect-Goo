<?php
$pageTitle = 'Métricas AARRR';
$pageBreadcrumb = 'Reportes > Métricas AARRR';
require_once __DIR__ . '/layout/header.php';
?>

<link rel="stylesheet" href="../assets/css/funnel-premium.css?v=1.0">

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
            <?= $isFase1 
                ? 'Ingresa los datos de tu sustentación para la Fase 1. Estos datos se guardarán independientemente y no afectarán a tus métricas actuales.' 
                : 'Ingresa los datos de tu flujo de GA4 para sincronizar las visitas únicas y actualizar en tiempo real el embudo AARRR.' ?>
        </p>

        <?php if ($mensajeGA): ?>
            <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i> <?= htmlspecialchars($mensajeGA) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="panel_metricas.php" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <input type="hidden" name="action" value="update_ga">
            <input type="hidden" name="fase" value="<?= $isFase1 ? '1' : '2' ?>">
            
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Usuarios Activos (GA4)</label>
                <input type="number" name="usuarios_activos" value="<?= intval($gaData['usuarios_activos']) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Vistas de Página (Total)</label>
                <input type="number" name="vistas" value="<?= intval($gaData['vistas']) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;"><i data-lucide="video" style="width:14px;height:14px;vertical-align:-2px;"></i> Tráfico TikTok</label>
                <input type="number" name="trafico_tiktok" value="<?= intval($gaData['trafico_tiktok'] ?? 0) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;"><i data-lucide="facebook" style="width:14px;height:14px;vertical-align:-2px;"></i> Tráfico Facebook</label>
                <input type="number" name="trafico_facebook" value="<?= intval($gaData['trafico_facebook'] ?? 0) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>

            <?php if ($isFase1): ?>
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Leads Registrados</label>
                <input type="number" name="fase1_leads" value="<?= intval($gaData['fase1_leads'] ?? 0) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>
            
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Trabajadores Aprobados</label>
                <input type="number" name="fase1_trabajadores" value="<?= intval($gaData['fase1_trabajadores'] ?? 0) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>
            
            <div>
                <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Clics a WhatsApp</label>
                <input type="number" name="fase1_clics" value="<?= intval($gaData['fase1_clics'] ?? 0) ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #1e293b;">
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-primary" style="padding: 10px 22px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; height: 42px; background: <?= $isFase1 ? '#f59e0b' : '#10b981' ?>; color: white; grid-column: 1 / -1; max-width: 250px; margin: 0 auto; display: block;">
                Guardar Datos <?= $isFase1 ? 'Fase 1' : '' ?>
            </button>
        </form>
    </details>

    <!-- ==========================================
         📊 GRÁFICO VISUAL DEL EMBUDO (FLOW CHART CON PÉRDIDAS)
         ========================================== -->
    <section class="funnel-graphic-section" style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow-md);">
        <h2 style="font-size: 20px; color: #1e293b; margin-bottom: 25px; text-align: center; font-weight: 800;">Visualización Gráfica de Conversión</h2>
        <div class="funnel-flow" style="max-width: 700px; margin: 0 auto; display: flex; flex-direction: column; align-items: center;">
            
            <!-- Adquisición -->
            <div class="premium-funnel-card step-1">
                <div class="funnel-card-content">
                    <div class="funnel-step-label"><i data-lucide="globe" style="width:20px; height:20px;"></i> 1. Adquisición (Visitas)</div>
                    <div class="funnel-step-value"><?= $vistasTotales ?></div>
                </div>
                
                <!-- Traffic Distribution Bar -->
                <?php if ($vistasTotales > 0): ?>
                <div class="traffic-distribution" style="margin-top: 15px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Desglose de Tráfico</div>
                    <div class="traffic-bar" style="display: flex; height: 8px; border-radius: 4px; overflow: hidden; background: #e2e8f0;">
                        <?php if($pctTiktok > 0): ?><div style="width: <?= $pctTiktok ?>%; background: #00f2fe;" title="TikTok: <?= $pctTiktok ?>%"></div><?php endif; ?>
                        <?php if($pctFacebook > 0): ?><div style="width: <?= $pctFacebook ?>%; background: #1877f2;" title="Facebook: <?= $pctFacebook ?>%"></div><?php endif; ?>
                        <?php if($pctOtros > 0): ?><div style="width: <?= $pctOtros ?>%; background: #94a3b8;" title="Otros: <?= $pctOtros ?>%"></div><?php endif; ?>
                    </div>
                    <div class="traffic-legend" style="display: flex; gap: 10px; margin-top: 8px; font-size: 11px; font-weight: 600;">
                        <span style="color: #475569;"><span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#00f2fe; margin-right:4px;"></span>TikTok (<?= $pctTiktok ?>%)</span>
                        <span style="color: #475569;"><span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#1877f2; margin-right:4px;"></span>Facebook (<?= $pctFacebook ?>%)</span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="funnel-connector">
                <svg width="24" height="40" viewBox="0 0 24 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 0V40M12 40L6 34M12 40L18 34" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="connector-stats">
                    <span class="conv-badge">Conversión: <?= $conversionVistasALeads ?>%</span>
                    <span class="loss-badge">Fuga: <?= $perdidaAdquisicion ?>%</span>
                </div>
            </div>

            <!-- Leads Registrados -->
            <div class="premium-funnel-card step-2">
                <div class="funnel-card-content">
                    <div class="funnel-step-label"><i data-lucide="zap" style="width:20px; height:20px;"></i> 2. Leads (Interés)</div>
                    <div class="funnel-step-value"><?= $countLeads ?></div>
                </div>
            </div>

            <div class="funnel-connector">
                <svg width="24" height="40" viewBox="0 0 24 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 0V40M12 40L6 34M12 40L18 34" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="connector-stats">
                    <span class="conv-badge">Conversión: <?= $conversionLeadATrabajador ?>%</span>
                    <span class="loss-badge">Fuga: <?= $perdidaLeadATrabajador ?>%</span>
                </div>
            </div>

            <!-- Trabajadores Registrados -->
            <div class="premium-funnel-card step-3">
                <div class="funnel-card-content">
                    <div class="funnel-step-label"><i data-lucide="briefcase" style="width:20px; height:20px;"></i> 3. Postulantes</div>
                    <div class="funnel-step-value"><?= $countTrabajadoresTotal ?></div>
                </div>
            </div>

            <div class="funnel-connector">
                <svg width="24" height="40" viewBox="0 0 24 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 0V40M12 40L6 34M12 40L18 34" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="connector-stats">
                    <span class="conv-badge">Aprobación: <?= $conversionActivacion ?>%</span>
                    <span class="loss-badge">Rechazo: <?= $perdidaActivacion ?>%</span>
                </div>
            </div>

            <!-- Trabajadores Aprobados / Activos -->
            <div class="premium-funnel-card step-4">
                <div class="funnel-card-content">
                    <div class="funnel-step-label"><i data-lucide="check-circle-2" style="width:20px; height:20px;"></i> 4. Trabajadores Aprobados</div>
                    <div class="funnel-step-value"><?= $countTrabajadoresAprobados ?></div>
                </div>
            </div>

            <div class="funnel-connector">
                <svg width="24" height="40" viewBox="0 0 24 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 0V40M12 40L6 34M12 40L18 34" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="connector-stats">
                    <span class="conv-badge">Retención (Interacciones): <?= $countTrabajadoresActivosRetenidos ?> usuarios activos</span>
                    <span class="loss-badge">Churn Rate: <?= $retencionChurn ?>%</span>
                </div>
            </div>

            <!-- Ingresos -->
            <div class="premium-funnel-card step-5">
                <div class="funnel-card-content">
                    <div class="funnel-step-label"><i data-lucide="dollar-sign" style="width:20px; height:20px;"></i> 5. Monetización Total</div>
                    <div class="funnel-step-value">S/ <?= number_format($totalIngresos, 2) ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         📊 EMBUDO PIRATA AARRR (TARJETAS DETALLADAS CON FUGAS)
         ========================================== -->
    
    <div style="display: flex; gap: 15px; margin-bottom: 30px; justify-content: center; flex-wrap: wrap;">
        <a href="panel_metricas.php?fase=1" class="btn-fase <?= (isset($_GET['fase']) && $_GET['fase'] === '1') ? 'active' : '' ?>">
            <i data-lucide="history" style="width: 18px; height: 18px;"></i> Fase 1: Lanzamiento MVP
        </a>
        <a href="panel_metricas.php" class="btn-fase <?= (!isset($_GET['fase']) || $_GET['fase'] !== '1') ? 'active' : '' ?>">
            <i data-lucide="rocket" style="width: 18px; height: 18px;"></i> Fase 2: Tracción Actual
        </a>
    </div>
    <style>
        .btn-fase { display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 700; color: #64748b; background: #f8fafc; transition: all 0.3s; border: 2px solid #e2e8f0; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .btn-fase.active { background: #ecfdf5; color: #059669; border-color: #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15); }
        .btn-fase:hover:not(.active) { background: #e2e8f0; color: #475569; border-color: #cbd5e1; }
    </style>

    <section class="funnel-container">
        
        <!-- ADQUISICIÓN -->
        <article class="funnel-card funnel-acq">
            <div>
                <span class="funnel-header-tag">A</span>
                <h3>1. Adquisición</h3>
                <div class="main-value"><?= $traficoEstimado ?></div>
                <div class="sub-metric">Visitas GA4: <strong><?= $traficoEstimado ?></strong></div>
                <div class="sub-metric">Leads Registrados: <strong><?= $countLeads ?></strong></div>
                <div class="sub-metric" style="background:#ecfdf5; padding:6px; border-radius:6px; margin:4px 0; border:1px solid #d1fae5;">🚀 Instalaciones PWA: <strong style="color:#059669; font-size:16px;"><?= isset($countPWA) ? $countPWA : 0 ?></strong></div>
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
         📍 NUEVA SECCIÓN: SIMULACIÓN DE INGRESOS (ACADÉMICO)
         ========================================== -->
    <section style="background: #ffffff; border-radius: 20px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.02); margin-bottom: 40px;">
        <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="calculator" style="color:#10b981;"></i> Desglose de Simulación de Ingresos (Académico)
        </h2>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 20px; line-height: 1.4;">
            Tabla demostrativa del flujo de ingresos mensuales simulados si se estuviera cobrando por los planes de los trabajadores y la publicidad.
        </p>

        <?php if (isset($mensajeSim) && $mensajeSim): ?>
            <div style="margin-bottom: 15px; padding: 10px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; color: #065f46; font-size: 13px; font-weight: bold; text-align: center;">
                <?= htmlspecialchars($mensajeSim) ?>
            </div>
        <?php endif; ?>

        <details style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 15px; margin-bottom: 20px;">
            <summary style="font-weight: 700; color: #475569; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px;">
                <i data-lucide="edit-3" style="width: 16px; height: 16px;"></i> Ajustar Tarifas Simuladas
            </summary>
            <form method="POST" action="panel_metricas.php" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; align-items: end; margin-top: 15px;">
                <input type="hidden" name="action" value="update_simulacion">
                
                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Precio Plan Básico (S/)</label>
                    <input type="number" step="0.01" name="precio_basico" value="<?= floatval($simData['precio_basico'] ?? 15) ?>" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
                </div>

                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Precio Plan Estándar (S/)</label>
                    <input type="number" step="0.01" name="precio_estandar" value="<?= floatval($simData['precio_estandar'] ?? 30) ?>" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
                </div>

                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Precio Plan Premium (S/)</label>
                    <input type="number" step="0.01" name="precio_premium" value="<?= floatval($simData['precio_premium'] ?? 50) ?>" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
                </div>

                <div>
                    <label style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Precio Publicidad (S/)</label>
                    <input type="number" step="0.01" name="precio_publicidad" value="<?= floatval($simData['precio_publicidad'] ?? 40) ?>" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
                </div>

                <button type="submit" class="btn-primary" style="padding: 8px 15px; border-radius: 6px; font-weight: 700; cursor: pointer; border: none; height: 35px; background: #3b82f6; color: white; font-size: 13px;">Guardar Precios</button>
            </form>
        </details>

        <div style="overflow-x: auto;">
            <table class="metric-table" style="box-shadow: none; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 14px; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 12px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">Plan / Servicio</th>
                        <th style="padding: 12px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: center;">Cuota (Simulada)</th>
                        <th style="padding: 12px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: center;">Cantidad</th>
                        <th style="padding: 12px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: right;">Subtotal Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($desgloseSimulacion) && empty($cantidadPublicidad)): ?>
                        <tr><td colspan="4" style="text-align: center; color: #64748b; padding: 20px;">No hay datos para simular.</td></tr>
                    <?php else: ?>
                        <?php foreach ($desgloseSimulacion as $ds): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #334155;">Plan <?= htmlspecialchars($ds['plan']) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #64748b;">S/ <?= number_format($ds['precio'], 2) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 12px;">
                                        <?= $ds['cantidad'] ?> usuarios
                                    </span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #10b981;">S/ <?= number_format($ds['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <!-- Publicidad -->
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #334155;">Publicidad en Banners</td>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #64748b;">S/ <?= number_format(floatval($simData['precio_publicidad'] ?? 40), 2) ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                <span style="background: #fdf4ff; color: #a21caf; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 12px;">
                                    <?= $cantidadPublicidad ?? 0 ?> banners
                                </span>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: 700; color: #10b981;">S/ <?= number_format($ingresosPublicidadSimulados ?? 0, 2) ?></td>
                        </tr>
                        
                        <!-- Total -->
                        <tr style="background: #f8fafc;">
                            <td colspan="3" style="padding: 12px; text-align: right; font-weight: 800; color: #1e293b;">Total Ingresos Mensuales Estimados:</td>
                            <td style="padding: 12px; text-align: right; font-weight: 900; color: #059669; font-size: 16px;">S/ <?= number_format($totalIngresosSimulados, 2) ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
                        <span style="color: #2563eb;"><?= $pctFacebook ?>% del Tráfico (<?= $facebookViews ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #2563eb; width: <?= $pctFacebook ?>%; height: 100%;"></div>
                    </div>
                </div>

                <!-- TikTok Organic -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; margin-bottom: 4px;">
                        <span>⚫ TikTok Organic (Contenido Viral Local)</span>
                        <span style="color: #0f172a;"><?= $pctTiktok ?>% del Tráfico (<?= $tiktokViews ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #0f172a; width: <?= $pctTiktok ?>%; height: 100%;"></div>
                    </div>
                </div>

                <!-- Búsqueda Directa -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; margin-bottom: 4px;">
                        <span>🟢 Búsqueda Directa y Otros</span>
                        <span style="color: #16a34a;"><?= $pctOtros ?>% del Tráfico (<?= max(0, $vistasTotales - $facebookViews - $tiktokViews) ?> visitas)</span>
                    </div>
                    <div style="background: #e2e8f0; height: 8px; border-radius: 10px; overflow: hidden;">
                        <div style="background: #16a34a; width: <?= $pctOtros ?>%; height: 100%;"></div>
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

    </div>

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

<?php require_once __DIR__ . '/layout/footer.php'; ?>

