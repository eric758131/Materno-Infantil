@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- ENCABEZADO CON BREADCRUMB (OPCIONAL) --}}
    @if(Route::has('dashboard'))
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte de Usuarios</li>
        </ol>
    </nav>
    @endif

    {{-- CABECERA CON TÍTULO Y CONTADORES --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 fw-bold text-primary">
                <i class="fas fa-users me-2"></i>Reporte de Usuarios del Sistema
            </h1>
            <p class="text-muted mb-0">Gestión y análisis de usuarios registrados en la plataforma</p>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <div class="text-primary fw-bold fs-4">{{ $usuarios->total() }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4 border-end">
                            <div class="text-success fw-bold fs-4">
                                {{ $usuarios->where('estado', 'activo')->count() }}
                            </div>
                            <small class="text-muted">Activos</small>
                        </div>
                        <div class="col-4">
                            <div class="text-danger fw-bold fs-4">
                                {{ $usuarios->where('estado', 'inactivo')->count() }}
                            </div>
                            <small class="text-muted">Inactivos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PANEL DE FILTROS MEJORADO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter text-primary me-2"></i>Filtros de Búsqueda
            </h5>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
                <i class="fas fa-chevron-down me-1"></i>
                <span class="collapse-show">Ocultar</span>
                <span class="collapse-hide d-none">Mostrar</span>
            </button>
        </div>
        
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body pt-3">
                <form method="GET" id="filtrosForm" class="row g-3">
                    
                    {{-- FILA 1: DATOS PERSONALES --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Nombre</label>
                        <input type="text" class="form-control form-control-sm" name="nombre" 
                               value="{{ request('nombre') }}" placeholder="Ej: Juan">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Apellido Paterno</label>
                        <input type="text" class="form-control form-control-sm" name="apellido_paterno" 
                               value="{{ request('apellido_paterno') }}" placeholder="Ej: Pérez">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Cédula de Identidad</label>
                        <input type="text" class="form-control form-control-sm" name="ci" 
                               value="{{ request('ci') }}" placeholder="Ej: 12345678">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Correo Electrónico</label>
                        <input type="email" class="form-control form-control-sm" name="email" 
                               value="{{ request('email') }}" placeholder="Ej: usuario@email.com">
                    </div>
                    
                    {{-- FILA 2: FILTROS PRINCIPALES --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Género</label>
                        <select name="genero" class="form-select form-select-sm">
                            <option value="">Todos los géneros</option>
                            <option value="masculino" {{ request('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ request('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Estado</label>
                        <select name="estado" class="form-select form-select-sm">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Rol</label>
                        <select name="rol" class="form-select form-select-sm">
                            <option value="">Todos los roles</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->name }}" {{ request('rol') == $rol->name ? 'selected' : '' }}>
                                    {{ ucfirst($rol->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Teléfono</label>
                        <input type="text" class="form-control form-control-sm" name="telefono" 
                               value="{{ request('telefono') }}" placeholder="Ej: 77712345">
                    </div>
                    
                    {{-- FILA 3: FECHAS Y BOTONES --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha de Registro Desde</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            <input type="date" name="created_desde" class="form-control" 
                                   value="{{ request('created_desde') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-uppercase text-muted">Fecha de Registro Hasta</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="far fa-calendar"></i></span>
                            <input type="date" name="created_hasta" class="form-control" 
                                   value="{{ request('created_hasta') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-sm btn-primary px-4">
                            <i class="fas fa-search me-1"></i>Aplicar Filtros
                        </button>
                        {{-- Usar la ruta actual sin parámetros --}}
                        <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary px-4">
                            <i class="fas fa-redo me-1"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- BARRA DE ACCIONES --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i>Exportar Datos
                </button>
                <ul class="dropdown-menu">
                    {{-- Verificar si las rutas de exportación existen --}}
                    @if(Route::has('reportes.usuarios.export.excel'))
                    <li>
                        <a href="{{ route('reportes.usuarios.export.excel', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-excel text-success me-2"></i>Excel (.xlsx)
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('reportes.usuarios.export.pdf'))
                    <li>
                        <a href="{{ route('reportes.usuarios.export.pdf', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-pdf text-danger me-2"></i>PDF (.pdf)
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('reportes.usuarios.export.csv'))
                    <li>
                        <a href="{{ route('reportes.usuarios.export.csv', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-csv text-info me-2"></i>CSV (.csv)
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary" id="toggleColumnas">
                    <i class="fas fa-columns me-1"></i>Columnas
                </button>
                <button type="button" class="btn btn-outline-primary" id="toggleGraficas">
                    <i class="fas fa-chart-bar me-1"></i>Gráficas
                </button>
            </div>
        </div>
        
        <div class="text-muted small">
            Mostrando <span class="fw-bold">{{ $usuarios->count() }}</span> de 
            <span class="fw-bold">{{ $usuarios->total() }}</span> registros
        </div>
    </div>

    {{-- TABLA CON FILTROS DE COLUMNAS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-alt text-primary me-2"></i>Lista de Usuarios
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input toggle-col" type="checkbox" id="colEstado" data-column="6" checked>
                        <label class="form-check-label small" for="colEstado">Estado</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input toggle-col" type="checkbox" id="colRol" data-column="9" checked>
                        <label class="form-check-label small" for="colRol">Rol</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input toggle-col" type="checkbox" id="colFechas" data-column="10" checked>
                        <label class="form-check-label small" for="colFechas">Fechas</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="tablaUsuarios">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>Nombre Completo</th>
                        <th>CI</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th class="col-estado">Género</th>
                        <th class="col-estado">Estado</th>
                        <th>Fecha Nacimiento</th>
                        <th class="col-rol">Rol</th>
                        <th class="col-fechas">Creado</th>
                        <th class="col-fechas">Actualizado</th>
                        <th width="100" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $u)
                    <tr>
                        <td class="text-muted fw-semibold">
                            {{ ($usuarios->currentPage() - 1) * $usuarios->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $u->nombre }} {{ $u->apellido_paterno }} {{ $u->apellido_materno }}</div>
                            
                        </td>
                        <td><code>{{ $u->ci }}</code></td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->telefono ?? 'N/A' }}</td>
                        <td class="small">{{ Str::limit($u->direccion, 30) }}</td>
                        <td class="col-estado">
                            @if($u->genero == 'masculino')
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-mars me-1"></i>Masculino
                                </span>
                            @else
                                <span class="badge bg-pink bg-opacity-10 text-pink">
                                    <i class="fas fa-venus me-1"></i>Femenino
                                </span>
                            @endif
                        </td>
                        <td class="col-estado">
                            <span class="badge rounded-pill bg-{{ $u->estado == 'activo' ? 'success' : 'danger' }}">
                                {{ ucfirst($u->estado) }}
                            </span>
                        </td>
                        <td>
                            @if($u->fecha_nacimiento)
                                {{ \Carbon\Carbon::parse($u->fecha_nacimiento)->format('d/m/Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="col-rol">
                            <span class="badge bg-secondary">{{ $u->rol }}</span>
                        </td>
                        <td class="col-fechas small text-muted">
                            {{ \Carbon\Carbon::parse($u->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="col-fechas small text-muted">
                            {{ \Carbon\Carbon::parse($u->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center">
                            {{-- Ajustar según tus rutas --}}
                            @if(Route::has('usuarios.show'))
                            <a href="{{ route('usuarios.show', $u->id) }}" 
                               class="btn btn-sm btn-outline-primary"
                               data-bs-toggle="tooltip" 
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            @else
                            <button class="btn btn-sm btn-outline-primary disabled" title="No disponible">
                                <i class="fas fa-eye"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <h5>No se encontraron usuarios</h5>
                                <p>Intenta modificar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($usuarios->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Página {{ $usuarios->currentPage() }} de {{ $usuarios->lastPage() }}
                </div>
                <div>
                    {{ $usuarios->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- SECCIÓN DE GRÁFICAS --}}
    <div class="row g-4 mb-5" id="graficasSection">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>Estadísticas y Análisis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 h-100">
                                <div class="card-body text-center">
                                    <canvas id="grafEstado" height="200"></canvas>
                                    <h6 class="mt-3 mb-0">Distribución por Estado</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 h-100">
                                <div class="card-body text-center">
                                    <canvas id="grafGenero" height="200"></canvas>
                                    <h6 class="mt-3 mb-0">Distribución por Género</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card border-0 h-100">
                                <div class="card-body">
                                    <canvas id="grafRoles" height="200"></canvas>
                                    <h6 class="mt-3 mb-0 text-center">Usuarios por Rol</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0">
                                <div class="card-body">
                                    <canvas id="grafRegistro" height="100"></canvas>
                                    <h6 class="mt-3 mb-0 text-center">Registro de Usuarios por Mes</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
:root {
    --bs-pink: #e83e8c;
}

.bg-pink {
    background-color: var(--bs-pink);
}

.text-pink {
    color: var(--bs-pink);
}

.table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    padding: 0.75rem;
}

.card {
    border-radius: 0.5rem;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 1rem;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.input-group-text {
    background-color: #f8f9fa;
}

.badge.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

/* Animaciones */
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const usuarios = @json($usuarios->items());
    
    // Inicializar tooltips de Bootstrap
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Toggle de columnas
    document.querySelectorAll('.toggle-col').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const columnClass = this.id.replace('col', 'col-').toLowerCase();
            
            document.querySelectorAll(`.${columnClass}`).forEach(el => {
                el.style.display = this.checked ? '' : 'none';
            });
            
            // Guardar preferencia en localStorage
            localStorage.setItem(`col_${columnClass}`, this.checked);
        });
        
        // Cargar preferencias guardadas
        const colClass = checkbox.id.replace('col', 'col-').toLowerCase();
        const savedState = localStorage.getItem(`col_${colClass}`);
        if (savedState !== null) {
            checkbox.checked = savedState === 'true';
            checkbox.dispatchEvent(new Event('change'));
        }
    });
    
    // Toggle de gráficas
    const toggleGraficasBtn = document.getElementById('toggleGraficas');
    if (toggleGraficasBtn) {
        toggleGraficasBtn.addEventListener('click', function() {
            const graficasSection = document.getElementById('graficasSection');
            if (graficasSection) {
                const isHidden = graficasSection.style.display === 'none';
                graficasSection.style.display = isHidden ? '' : 'none';
                this.querySelector('i').className = isHidden ? 'fas fa-chart-bar me-1' : 'fas fa-eye me-1';
                localStorage.setItem('graficas_visibles', isHidden);
            }
        });
        
        // Inicializar estado de gráficas
        const graficasVisibles = localStorage.getItem('graficas_visibles') !== 'false';
        const graficasSection = document.getElementById('graficasSection');
        if (graficasSection && !graficasVisibles) {
            graficasSection.style.display = 'none';
            toggleGraficasBtn.querySelector('i').className = 'fas fa-eye me-1';
        }
    }
    
    // Toggle de filtros collapse
    const filtrosCollapse = document.getElementById('filtrosCollapse');
    const collapseBtn = document.querySelector('[data-bs-target="#filtrosCollapse"]');
    
    if (filtrosCollapse && collapseBtn) {
        // Configurar evento para cambio de estado
        filtrosCollapse.addEventListener('show.bs.collapse', function() {
            const labels = collapseBtn.querySelectorAll('span');
            labels[0].classList.add('d-none');
            labels[1].classList.remove('d-none');
            collapseBtn.querySelector('i').className = 'fas fa-chevron-up me-1';
        });
        
        filtrosCollapse.addEventListener('hide.bs.collapse', function() {
            const labels = collapseBtn.querySelectorAll('span');
            labels[0].classList.remove('d-none');
            labels[1].classList.add('d-none');
            collapseBtn.querySelector('i').className = 'fas fa-chevron-down me-1';
        });
        
        // Inicializar labels correctamente
        collapseBtn.querySelectorAll('span')[0].classList.remove('collapse-show');
        collapseBtn.querySelectorAll('span')[0].classList.remove('collapse-hide');
        collapseBtn.querySelectorAll('span')[1].classList.add('d-none');
    }
    
    // Crear gráficas si hay usuarios
    if (usuarios.length > 0) {
        // Gráfico por estado (Doughnut)
        const ctxEstado = document.getElementById('grafEstado');
        if (ctxEstado) {
            new Chart(ctxEstado, {
                type: "doughnut",
                data: {
                    labels: ["Activo", "Inactivo"],
                    datasets: [{
                        data: [
                            usuarios.filter(u => u.estado == "activo").length,
                            usuarios.filter(u => u.estado == "inactivo").length,
                        ],
                        backgroundColor: ["#28a745", "#dc3545"],
                        borderWidth: 2,
                        borderColor: "#fff"
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        // Gráfico por género (Pie)
        const ctxGenero = document.getElementById('grafGenero');
        if (ctxGenero) {
            new Chart(ctxGenero, {
                type: "pie",
                data: {
                    labels: ["Masculino", "Femenino"],
                    datasets: [{
                        data: [
                            usuarios.filter(u => u.genero == "masculino").length,
                            usuarios.filter(u => u.genero == "femenino").length,
                        ],
                        backgroundColor: ["#3498db", "#e83e8c"]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        // Gráfico por rol (Bar)
        const ctxRoles = document.getElementById('grafRoles');
        if (ctxRoles) {
            const rolesUnicos = [...new Set(usuarios.map(u => u.rol))].filter(r => r);
            const coloresRoles = ['#6f42c1', '#20c997', '#fd7e14', '#17a2b8', '#ffc107', '#6610f2'];
            
            new Chart(ctxRoles, {
                type: "bar",
                data: {
                    labels: rolesUnicos.map(r => r.charAt(0).toUpperCase() + r.slice(1)),
                    datasets: [{
                        label: "Cantidad de Usuarios",
                        data: rolesUnicos.map(r => usuarios.filter(u => u.rol == r).length),
                        backgroundColor: coloresRoles.slice(0, rolesUnicos.length),
                        borderColor: coloresRoles.slice(0, rolesUnicos.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
        
        // Gráfico de registro por mes (Line)
        const ctxRegistro = document.getElementById('grafRegistro');
        if (ctxRegistro) {
            const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            const registrosPorMes = new Array(12).fill(0);
            
            usuarios.forEach(u => {
                if (u.created_at) {
                    const fecha = new Date(u.created_at);
                    const mes = fecha.getMonth();
                    registrosPorMes[mes]++;
                }
            });
            
            new Chart(ctxRegistro, {
                type: "line",
                data: {
                    labels: meses,
                    datasets: [{
                        label: "Registros",
                        data: registrosPorMes,
                        borderColor: "#2980b9",
                        backgroundColor: "rgba(41, 128, 185, 0.1)",
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
});
</script>
@endsection