<?php
// app/views/admin/layout/footer.php
?>
        </div> <!-- Fin de admin-content -->
    </main> <!-- Fin de admin-main -->

    <script>
        // Inicializar iconos
        lucide.createIcons();

        // Toggle para menú móvil
        const toggleBtn = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');

        if(toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }
    </script>
</body>
</html>
