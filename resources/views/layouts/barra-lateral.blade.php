<!-- Botón Hamburguesa (solo visible en móviles) -->
<button class="sidebar-toggle btn d-lg-none position-fixed bg-dark text-white rounded-circle m-3" style="width:40px;height:40px;z-index:1100">
    <i class="fas fa-bars"></i>
</button>

<!-- Barra Lateral -->
<aside class="sidebar bg-dark text-white shadow" style="width: var(--sidebar-width); min-height: 100vh; position: fixed; z-index: 1000;">
    <div class="sidebar-inner h-100 d-flex flex-column" style="overflow-y: auto;">
        <!-- Encabezado -->
        <div class="sidebar-header text-center py-4">
            <div class="hospital-logo mb-3">
                <i class="fas fa-hospital-alt fa-2x text-light"></i>
            </div>
            <h4 class="mb-0 fw-light">Hospital Materno Infantil</h4>
            <small class="text-muted">Gestión Hospitalaria</small>
            @if(session('nombre_completo'))
                <p>Bienvenido, {{ session('nombre_completo') }}!</p>
            @endif
        </div>

        {{-- Solo mostrar el botón si el usuario tiene rol admin o superadmin --}}
        @auth
            @if(auth()->user()->hasAnyRole(['Admin', 'SuperAdmin']))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" 
                href="{{ route('usuarios.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="nav-link-text">Gestión de Usuarios</span>
                    </div>
                </a>
            </li>
            @endif
        @endauth

        @auth
            @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin']))
                <li class="nav-item mb-1">
                       <a href="{{ route('pacientes.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                              <i class="fas fa-user-injured me-3"></i>
                         <span>Pacientes</span>
                      </a>
                 </li>
                @endif
        @endauth

        @auth
            @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin']))
                <li class="nav-item mb-1">
                    <a href="{{ route('medidas.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                        <i class="fas fa-ruler-combined me-3"></i>
                        <span>Medidas Antropométricas</span>
                    </a>
                </li>
            @endif
        @endauth

        

        @auth
            @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin']))
                <li class="nav-item mb-1">
                    <a href="{{ route('requerimiento_nutricional.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                        <i class="fas fa-atom me-3"></i>
                        <span>Requerimiento nutricional</span>
                    </a>
                </li>
            @endif
        @endauth

        @auth
            @if(auth()->user()->hasAnyRole(['Nutricionista', 'SuperAdmin']))
                <li class="nav-item mb-1">
                    <a href="{{ route('moleculaCalorica.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                        <span>Moléculas Calóricas</span>
                    </a>
                </li>
            @endif
        @endauth


        <li class="nav-item mb-1">
            <a href="{{ route('reportes.usuarios.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                <i class="fas fa-users me-3"></i>
                <span>Reporte de Usuarios</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('reportes.pacientes.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                <i class="fas fa-user-injured me-3"></i>
                <span>Reporte de Pacientes</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('reportes.oms-referencias.index') }}" class="nav-link d-flex align-items-center rounded p-2 bg-secondary">
                <i class="fas fa-user-injured me-3"></i>
                <span>Reporte de Referencias OMS</span>
            </a>
        </li>




        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
            </button>
        </form>


        <!-- Menú con scroll -->
        <div class="sidebar-menu-container" style="overflow-y: auto; flex-grow: 1; max-height: calc(100vh - 200px);">
            

        <!-- Pie -->
        <div class="sidebar-footer text-center py-3 border-top border-secondary mt-auto">
            
            <small class="text-muted d-block mt-2">v0.5.0</small>
        </div>


    </div>
</aside>

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
