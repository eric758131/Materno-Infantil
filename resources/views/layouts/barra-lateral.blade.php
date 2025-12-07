<!-- Botón Hamburguesa (solo visible en móviles) -->
<button class="sidebar-toggle btn d-lg-none position-fixed bg-dark text-white rounded-circle m-3" style="width:40px;height:40px;z-index:1100">
    <i class="fas fa-bars"></i>
</button>

<!-- Barra Lateral -->
<aside class="sidebar bg-gradient-primary text-white shadow-lg" style="width: 280px; min-height: 100vh; position: fixed; z-index: 1000;">
    <div class="sidebar-inner h-100 d-flex flex-column">
        <!-- Encabezado mejorado -->
        <div class="sidebar-header text-center py-4 border-bottom border-light border-opacity-10">
            <div class="hospital-logo mb-3">
                <i class="fas fa-hospital-alt fa-3x text-light" style="filter: drop-shadow(0 0 8px rgba(255,255,255,0.3));"></i>
            </div>
            <h4 class="mb-1 fw-semibold">Hospital Materno Infantil</h4>
            <small class="text-light opacity-75">Gestión Hospitalaria Inteligente</small>
            
            @if(session('nombre_completo'))
                <div class="user-welcome mt-3 px-3 py-2 bg-light bg-opacity-10 rounded-pill">
                    <i class="fas fa-user-circle me-2"></i>
                    <small class="fw-medium">{{ Str::limit(session('nombre_completo'), 20) }}</small>
                </div>
            @endif
        </div>

        <!-- Menú de navegación -->
        <div class="sidebar-menu-container flex-grow-1 py-3" style="overflow-y: auto; max-height: calc(100vh - 200px);">
            <ul class="nav flex-column px-2">
                <!-- Gestión de Usuarios (Admin/SuperAdmin) -->
                @auth
                    @if(auth()->user()->hasAnyRole(['Admin', 'SuperAdmin']))
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('usuarios.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-info' : 'hover-bg' }}" 
                           href="{{ route('usuarios.index') }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-users fa-fw"></i>
                            </div>
                            <span class="nav-link-text fw-medium">Gestión de Usuarios</span>
                            @if(request()->routeIs('usuarios.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>
                    @endif
                @endauth

                <!-- Sección Nutricionista/SuperAdmin -->
                @auth
                    @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin']))
                    <!-- Pacientes -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('pacientes.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('pacientes.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-success' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-user-injured fa-fw"></i>
                            </div>
                            <span class="fw-medium">Pacientes</span>
                            @if(request()->routeIs('pacientes.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Medidas Antropométricas -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('medidas.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('medidas.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-warning' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-ruler-combined fa-fw"></i>
                            </div>
                            <span class="fw-medium">Medidas Antropométricas</span>
                            @if(request()->routeIs('medidas.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Requerimiento nutricional -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('requerimiento_nutricional.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('requerimiento_nutricional.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-primary' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-atom fa-fw"></i>
                            </div>
                            <span class="fw-medium">Requerimiento Nutricional</span>
                            @if(request()->routeIs('requerimiento_nutricional.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Moléculas Calóricas -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('moleculaCalorica.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('moleculaCalorica.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-danger' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-fire fa-fw"></i>
                            </div>
                            <span class="fw-medium">Moléculas Calóricas</span>
                            @if(request()->routeIs('moleculaCalorica.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Separador de sección -->
                    <li class="nav-item my-3">
                        <div class="border-top border-light border-opacity-25 pt-2">
                            <small class="text-light opacity-50 fw-bold text-uppercase px-3">Reportes</small>
                        </div>
                    </li>

                    <!-- Reporte de Usuarios -->
                    @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin', 'Admin']))
                    <li class="nav-item mb-2">
                        <a href="{{ route('reportes.usuarios.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('reportes.usuarios.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-info' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-chart-bar fa-fw"></i>
                            </div>
                            <span class="fw-medium">Reporte de Usuarios</span>
                            @if(request()->routeIs('reportes.usuarios.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>
                    @endif

                    <!-- Reporte de Pacientes -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('reportes.pacientes.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('reportes.pacientes.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-success' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-chart-line fa-fw"></i>
                            </div>
                            <span class="fw-medium">Reporte de Pacientes</span>
                            @if(request()->routeIs('reportes.pacientes.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Reporte de Referencias OMS -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('reportes.oms-referencias.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('reportes.oms-referencias.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-warning' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-globe-americas fa-fw"></i>
                            </div>
                            <span class="fw-medium">Referencias OMS</span>
                            @if(request()->routeIs('reportes.oms-referencias.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>

                    <!-- Reporte de Frisancho -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('reportes.frisancho.index') }}" 
                           class="nav-link d-flex align-items-center rounded-3 p-3 {{ request()->routeIs('reportes.frisancho.*') ? 'active bg-light bg-opacity-10 border-start border-3 border-primary' : 'hover-bg' }}">
                            <div class="nav-link-icon me-3">
                                <i class="fas fa-weight-scale fa-fw"></i>
                            </div>
                            <span class="fw-medium">Reporte Frisancho</span>
                            @if(request()->routeIs('reportes.frisancho.*'))
                                <span class="ms-auto"><i class="fas fa-chevron-right fa-xs"></i></span>
                            @endif
                        </a>
                    </li>
                    @endif
                @endauth
            </ul>
        </div>

        <!-- Pie de página mejorado - Botón de cerrar sesión más arriba -->
        <div class="sidebar-footer mt-auto border-top border-light border-opacity-10 pt-3">
            <!-- Botón de cerrar sesión -->
            <div class="px-3 mb-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-lg w-100 d-flex align-items-center justify-content-center py-2 px-3 rounded-3">
                        <i class="fas fa-sign-out-alt me-2 fs-5"></i> 
                        <span class="fw-medium">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
            
            <!-- Información de versión y copyright -->
            <div class="text-center py-3 bg-dark bg-opacity-25 mt-2">
                
                <small class="text-light opacity-50">© 2024 Hospital Materno Infantil</small>
            </div>
        </div>
    </div>
</aside>

<!-- Estilos adicionales para mejorar la apariencia -->
<style>
    :root {
        --sidebar-width: 280px;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --hover-transition: all 0.3s ease;
    }

    .bg-gradient-primary {
        background: var(--primary-gradient);
    }

    .sidebar {
        transition: var(--hover-transition);
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .hover-bg {
        transition: var(--hover-transition);
    }

    .hover-bg:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        transform: translateX(5px);
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        transition: var(--hover-transition);
    }

    .nav-link:hover {
        color: white !important;
    }

    .nav-link.active {
        color: white !important;
        font-weight: 600;
    }

    .user-welcome {
        transition: var(--hover-transition);
        backdrop-filter: blur(10px);
    }

    .user-welcome:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 260px;
            transform: translateX(-100%);
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
    }

    @media (max-width: 576px) {
        .sidebar {
            width: 100%;
        }
    }
    /* Asegurar que el botón tenga suficiente espacio */
    .sidebar-footer {
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
    
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    /* Ajustar el contenedor del menú para dejar espacio al botón */
    .sidebar-menu-container {
        max-height: calc(100vh - 280px) !important;
    }

</style>

<!-- Overlay para móviles -->
<div class="sidebar-overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 999; display: none;"></div>

<!-- Estilos específicos de la barra lateral -->
<style>
    .sidebar {
        transform: translateX(-100%);
        transition: all 0.3s ease;
    }

    .sidebar.active {
        transform: translateX(0);
    }

    @media (min-width: 992px) {
        .sidebar {
            transform: translateX(0);
        }
        .sidebar-toggle {
            display: none !important;
        }
    }

    .sidebar .nav-link {
        color: var(--sidebar-text);
        transition: all 0.2s;
    }

    .sidebar .nav-link:hover {
        background-color: var(--sidebar-hover);
    }

    .sidebar .nav-link.active {
        background-color: var(--sidebar-hover);
        color: white;
    }

    .sidebar-header {
        border-bottom: 1px solid var(--sidebar-hover);
    }

    .hospital-logo {
        transition: transform 0.3s;
    }

    .hospital-logo:hover {
        transform: scale(1.1);
    }

    /* Asegurar que el contenedor del menú tenga un scroll cuando sea necesario */
    .sidebar-menu-container {
        overflow-y: auto;
        flex-grow: 1;
        max-height: calc(100vh - 200px); /* Deja espacio para el encabezado y pie */
    }
</style>
