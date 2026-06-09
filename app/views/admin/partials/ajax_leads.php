<?php
// app/views/admin/partials/ajax_leads.php
if (empty($leads)) {
    echo '<div class="request-card"><p style="text-align: center; color: #666;">No hay registros en esta categoría.</p></div>';
} else {
    foreach ($leads as $lead) {
        $email = htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8');
        $fecha = date('d/m/Y H:i', strtotime($lead['created_at']));
        $origen = htmlspecialchars($lead['origen'], ENT_QUOTES, 'UTF-8');
        
        $etiquetas = [
            'google_login' => 'Google Login',
            'registro_trabajador' => 'Trabajador'
        ];
        $etiqueta = $etiquetas[$lead['origen']] ?? $lead['origen'];
        
        echo '<div style="background:white; border:1px solid var(--border-color); border-radius:12px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 2px rgba(0,0,0,0.02);">';
        echo '    <div>';
        echo '        <strong style="font-size:15px; color:var(--text-main);">' . $email . '</strong>';
        echo '        <p style="margin:4px 0 0 0; font-size:13px; color:var(--text-muted);">Registrado el: ' . $fecha . '</p>';
        echo '    </div>';
        echo '    <span class="badge-origen ' . $origen . '">' . $etiqueta . '</span>';
        echo '</div>';
    }
}
