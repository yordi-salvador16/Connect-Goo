<?php
require_once __DIR__ . '/layout/header.php';
?>

<div class="header-actions" style="margin-bottom: 25px;">
    <div>
        <h2 style="font-size: 22px; color: #1e293b; margin-bottom: 5px;">Registro de Versiones y Mejoras</h2>
        <p style="color: #64748b; font-size: 14px;">Historial detallado de actualizaciones, nuevas funcionalidades y correcciones del sistema ConnectGoo.</p>
    </div>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 16px; border: 1px solid #e2e8f0;">
    <div style="overflow-x: auto;">
        <table class="metric-table" style="width: 100%; border-collapse: collapse; margin: 0; box-shadow: none;">
            <thead>
                <tr>
                    <th style="padding: 18px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; width: 120px;">Versión</th>
                    <th style="padding: 18px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; width: 140px;">Fecha</th>
                    <th style="padding: 18px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">Estado</th>
                    <th style="padding: 18px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">Resumen de Cambios</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- v1.5.0 -->
                <tr style="background: #eff6ff;">
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #2563eb; color: white; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.5.0</span>
                        <div style="margin-top: 8px; font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase;">Actual</div>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top; color: #475569; font-weight: 500;">
                        02 Jun 2026
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">Estable</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Módulo Financiero y Simulación Académica</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Separación del embudo de ingresos reales y simulados.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Panel dinámico para configurar tarifas de simulación financiera.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Creación de la vista "Historial de Versiones".</li>
                            <li><i data-lucide="tool" style="width:14px;height:14px;color:#f59e0b;margin-right:6px;vertical-align:-2px;"></i> Corrección de permisos de seguridad de roles (Superadmin vs Admin).</li>
                        </ul>
                    </td>
                </tr>

                <!-- v1.4.0 -->
                <tr>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.4.0</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top; color: #475569; font-weight: 500;">
                        13 May 2026
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">Lanzada</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Pivote a Plataforma Turística y Trabajadores</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Modernización de interfaz móvil y rediseño minimalista.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Nuevo sistema de gestión de lugares turísticos.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Integración de Google Maps con visualización de recorridos.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Optimización de experiencia móvil "App-Like".</li>
                        </ul>
                    </td>
                </tr>

                <!-- v1.3.0 -->
                <tr>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.3.0</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top; color: #475569; font-weight: 500;">
                        10 May 2026
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">Lanzada</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Refactorización Arquitectónica</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Reestructuración completa a patrón Modelo-Vista-Controlador (MVC).</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Separación de lógica de negocio y presentación.</li>
                            <li><i data-lucide="tool" style="width:14px;height:14px;color:#f59e0b;margin-right:6px;vertical-align:-2px;"></i> Reparación de errores de configuración SSH y despliegue.</li>
                        </ul>
                    </td>
                </tr>

                <!-- v1.2.0 -->
                <tr>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.2.0</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top; color: #475569; font-weight: 500;">
                        05 May 2026
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">Lanzada</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Métricas y Analíticas Avanzadas</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Creación del primer panel de Métricas AARRR (Pirata).</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Funcionalidad de integración manual con Google Analytics 4.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Rastreabilidad de fuentes de adquisición (Facebook vs TikTok).</li>
                        </ul>
                    </td>
                </tr>

                <!-- v1.1.0 -->
                <tr>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.1.0</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top; color: #475569; font-weight: 500;">
                        28 Abr 2026
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">Lanzada</span>
                    </td>
                    <td style="padding: 20px; border-bottom: 1px solid #e2e8f0; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Autenticación y Captación</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Integración de Login con Google (Google OAuth).</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Diseño e implementación de Popup de "Exit Intent" para captar Leads.</li>
                            <li><i data-lucide="tool" style="width:14px;height:14px;color:#f59e0b;margin-right:6px;vertical-align:-2px;"></i> Solución a conflictos de zona horaria (Timezone) en registros.</li>
                        </ul>
                    </td>
                </tr>

                <!-- v1.0.0 -->
                <tr>
                    <td style="padding: 20px; vertical-align: top;">
                        <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: bold; font-size: 13px;">v1.0.0</span>
                    </td>
                    <td style="padding: 20px; vertical-align: top; color: #475569; font-weight: 500;">
                        15 Abr 2026
                    </td>
                    <td style="padding: 20px; vertical-align: top;">
                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">MVP Inicial</span>
                    </td>
                    <td style="padding: 20px; vertical-align: top;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 10px; font-size: 15px;">Lanzamiento del Producto Mínimo Viable (MVP)</strong>
                        <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 13px; display: flex; flex-direction: column; gap: 8px;">
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Primera versión del directorio de servicios en Tingo María.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Flujo básico de registro para electricistas, técnicos, etc.</li>
                            <li><i data-lucide="check-circle" style="width:14px;height:14px;color:#10b981;margin-right:6px;vertical-align:-2px;"></i> Creación del primer Panel de Administración (Gestión de Solicitudes).</li>
                        </ul>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
