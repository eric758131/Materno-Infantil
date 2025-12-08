<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Materno Infantil</title>

    <!-- Bootstrap CSS (solo una vez) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/v4-shims.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

    <!-- Estilos personalizados -->
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #2d3748;
            --sidebar-text: #f7fafc;
            --sidebar-hover: #4a5568;
            --content-padding: 20px;
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: var(--content-padding);
            transition: all 0.3s ease;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        
    </style>
</head>
<body>
    <!-- Incluir barra lateral -->
    @include('layouts.barra-lateral')

    <!-- Contenido principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- JS: jQuery y Bootstrap (solo una vez) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS: Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- JS: DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    

    <!-- Scripts personalizados -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            
            if(sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
                });
            }

            if(sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.style.display = 'none';
                });
            }

            if (window.innerWidth < 992) {
                document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                        sidebarOverlay.style.display = 'none';
                    });
                });
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    if(sidebarOverlay) sidebarOverlay.style.display = 'none';
                }
            });
        });
    </script>
    @yield('scripts')
    @stack('scripts')

    

</body>
</html>
