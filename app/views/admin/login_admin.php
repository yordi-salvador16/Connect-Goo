<?php
// app/views/admin/login_admin.php
// Variables esperadas: $error
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Seguro - ConnectGoo OS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cargamos estilos base y específicos -->
    <link rel="stylesheet" href="../assets/css/styles.css?v=3.0">
    <link rel="stylesheet" href="../assets/css/admin-login.css?v=2.0">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<main class="login-wrapper">

    <!-- LADO IZQUIERDO: Branding Premium -->
    <section class="login-brand-panel">
        <div class="brand-glass"></div>
        <div class="login-brand-logo" style="display: flex; align-items: center; gap: 10px;">
            <i data-lucide="shield-check" style="width:36px;height:36px;color:#fff; stroke-width: 2.5;"></i>
            <span style="font-weight: 900; letter-spacing: -1px; font-size: 32px; color: #fff;">ConnectGoo <span style="opacity: 0.7; font-weight: 500;">OS</span></span>
        </div>
        
        <div class="login-brand-text">
            <h2>El motor detrás de tu plataforma.</h2>
            <p>Gestiona profesionales, aprueba solicitudes y monitorea las métricas en tiempo real. Todo desde un solo lugar.</p>
        </div>
    </section>

    <!-- LADO DERECHO: Formulario Clean -->
    <section class="login-form-panel">
        <div class="login-form-inner">
            
            <a href="../index.php" class="btn-back-circle" title="Volver al portal">
                <i data-lucide="arrow-left"></i>
            </a>

            <div class="login-icon">
                <i data-lucide="shield-check" style="width:32px;height:32px;"></i>
            </div>

            <h1>¡Hola de nuevo!</h1>
            <p style="color:#64748b; font-size:15px; margin-bottom: 32px;">Ingresa tus credenciales para acceder a tu panel.</p>

            <?php if ($error): ?>
                <div class="error-box">
                    <i data-lucide="alert-circle" style="width:20px;height:20px;flex-shrink:0;"></i>
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login_admin.php">
                <label>Usuario</label>
                <input type="text" name="usuario" placeholder="Ej: admin_connect" required autofocus>

                <label>Contraseña maestra</label>
                <div style="position: relative;">
                    <input type="password" id="adminPassword" name="password" placeholder="••••••••" required style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                    <button type="button" onclick="togglePassword()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 0; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <i data-lucide="eye" id="eyeIcon" style="width:20px;height:20px;"></i>
                    </button>
                </div>

                <button type="submit" class="form-button">
                    Acceder al Panel
                    <i data-lucide="arrow-right" style="width:18px;height:18px;"></i>
                </button>
            </form>
            
        </div>
    </section>

</main>

<script>
    lucide.createIcons();
    function togglePassword() {
        const passInput = document.getElementById('adminPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }
</script>
</body>
</html>
