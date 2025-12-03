@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- ENCABEZADO --}}
    @if(Route::has('dashboard'))
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte de Pacientes</li>
        </ol>
    </nav>
    @endif

    {{-- CABECERA --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 fw-bold text-primary">
                <i class="fas fa-user-injured me-2"></i>Reporte de Pacientes
            </h1>
            <p class="text-muted mb-0">Gestión y análisis de pacientes registrados</p>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <div class="text-primary fw-bold fs-4">{{ $pacientes->total() }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4 border-end">
                            <div class="text-success fw-bold fs-4">
                                {{ $pacientesActivos }}
                            </div>
                            <small class="text-muted">Activos</small>
                        </div>
                        <div class="col-4">
                            <div class="text-warning fw-bold fs-4">
                                {{ $pacientesSinTutor }}
                            </div>
                            <small class="text-muted">Sin Tutor</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter text-primary me-2"></i>Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body pt-3">
            <form method="GET" class="row g-3">
                {{-- FILA 1: DATOS DEL PACIENTE --}}
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Nombre</label>
                    <input type="text" class="form-control form-control-sm" name="nombre" 
                           value="{{ request('nombre') }}" placeholder="Ej: Juan">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Apellido Paterno</label>
                    <input type="text" class="form-control form-control-sm" name="apellido_paterno" 
                           value="{{ request('apellido_paterno') }}" placeholder="Ej: Pérez">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Cédula</label>
                    <input type="text" class="form-control form-control-sm" name="CI" 
                           value="{{ request('CI') }}" placeholder="Ej: 12345678">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Género</label>
                    <select name="genero" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="masculino" {{ request('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ request('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                
                {{-- FILA 2: DATOS DEL TUTOR --}}
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Nombre Tutor</label>
                    <input type="text" class="form-control form-control-sm" name="tutor_nombre" 
                           value="{{ request('tutor_nombre') }}" placeholder="Ej: María">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">CI Tutor</label>
                    <input type="text" class="form-control form-control-sm" name="tutor_ci" 
                           value="{{ request('tutor_ci') }}" placeholder="Ej: 87654321">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Parentesco</label>
                    <select name="parentesco" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach($parentescos as $parentesco)
                            <option value="{{ $parentesco->parentesco }}" 
                                {{ request('parentesco') == $parentesco->parentesco ? 'selected' : '' }}>
                                {{ ucfirst($parentesco->parentesco) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Estado</label>
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                
                {{-- FILA 3: FECHAS --}}
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Fecha Nac. Desde</label>
                    <input type="date" name="fecha_nacimiento_desde" class="form-control form-control-sm" 
                           value="{{ request('fecha_nacimiento_desde') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Fecha Nac. Hasta</label>
                    <input type="date" name="fecha_nacimiento_hasta" class="form-control form-control-sm" 
                           value="{{ request('fecha_nacimiento_hasta') }}">
                </div>
                
                <div class="col-md-6 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary px-4">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary px-4">
                        <i class="fas fa-redo me-1"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- BARRA DE ACCIONES --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i>Exportar
                </button>
                <ul class="dropdown-menu">
                    @if(Route::has('reportes.pacientes.export.excel'))
                    <li>
                        <a href="{{ route('reportes.pacientes.export.excel', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-excel text-success me-2"></i>Excel (.xlsx)
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('reportes.pacientes.export.pdf'))
                    <li>
                        <a href="{{ route('reportes.pacientes.export.pdf', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-pdf text-danger me-2"></i>PDF (.pdf)
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="text-muted small">
            Mostrando <span class="fw-bold">{{ $pacientes->count() }}</span> de 
            <span class="fw-bold">{{ $pacientes->total() }}</span> registros
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-list-alt text-primary me-2"></i>Lista de Pacientes
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>CI</th>
                        <th>Fecha Nacimiento</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Tutor</th>
                        <th>Parentesco</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pacientes as $p)
                    @php
                        $fechaNac = $p->fecha_nacimiento ? \Carbon\Carbon::parse($p->fecha_nacimiento) : null;
                        $edad = $fechaNac ? $fechaNac->age : '';
                        // Limitar edad a máximo 19 años para mostrar
                        $edadDisplay = $edad <= 19 ? $edad . ' años' : '19+ años';
                    @endphp
                    <tr>
                        <td class="text-muted">
                            {{ ($pacientes->currentPage() - 1) * $pacientes->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $p->nombre }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}</div>
                        </td>
                        <td><code>{{ $p->CI }}</code></td>
                        <td>
                            @if($p->fecha_nacimiento)
                                {{ \Carbon\Carbon::parse($p->fecha_nacimiento)->format('d/m/Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $edadDisplay }}</td>
                        <td>
                            @if($p->genero == 'masculino')
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-mars me-1"></i>Masculino
                                </span>
                            @else
                                <span class="badge bg-pink bg-opacity-10 text-pink">
                                    <i class="fas fa-venus me-1"></i>Femenino
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($p->tutor_nombre)
                                {{ $p->tutor_nombre }} {{ $p->tutor_apellido_paterno }}
                                <div class="small text-muted">CI: {{ $p->tutor_ci }}</div>
                            @else
                                <span class="text-muted">Sin tutor</span>
                            @endif
                        </td>
                        <td>{{ $p->parentesco ?? 'N/A' }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $p->estado == 'activo' ? 'success' : 'danger' }}">
                                {{ ucfirst($p->estado) }}
                            </span>
                        </td>
                        <td>
                            @if(Route::has('pacientes.show'))
                            <a href="{{ route('pacientes.show', $p->id) }}" 
                               class="btn btn-sm btn-outline-primary"
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-user-injured fa-3x mb-3"></i>
                                <h5>No se encontraron pacientes</h5>
                                <p>Intenta modificar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pacientes->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Página {{ $pacientes->currentPage() }} de {{ $pacientes->lastPage() }}
                </div>
                <div>
                    {{ $pacientes->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- GRÁFICOS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <canvas id="grafGenero" height="200"></canvas>
                    <h6 class="mt-3 mb-0">Distribución por Género</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <canvas id="grafEdades" height="200"></canvas>
                    <h6 class="mt-3 mb-0">Distribución por Edad (0-19 años)</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <canvas id="grafEstado" height="200"></canvas>
                    <h6 class="mt-3 mb-0">Distribución por Estado</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <canvas id="grafParentesco" height="200"></canvas>
                    <h6 class="mt-3 mb-0">Parentesco de Tutores</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.bg-pink { background-color: #e83e8c; }
.text-pink { color: #e83e8c; }
.table th { font-weight: 600; font-size: 0.85rem; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para gráficos
    const datosGraficos = @json($datosGraficos);
    
    // Gráfico por género
    if (document.getElementById('grafGenero')) {
        new Chart(document.getElementById('grafGenero'), {
            type: 'doughnut',
            data: {
                labels: ['Masculino', 'Femenino'],
                datasets: [{
                    data: [datosGraficos.masculino, datosGraficos.femenino],
                    backgroundColor: ['#3498db', '#e83e8c'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
    
    // Gráfico por edades (0-19 años)
    if (document.getElementById('grafEdades')) {
        const edadesData = datosGraficos.edades_0_19;
        new Chart(document.getElementById('grafEdades'), {
            type: 'bar',
            data: {
                labels: ['0-4', '5-9', '10-14', '15-19'],
                datasets: [{
                    label: 'Pacientes',
                    data: edadesData,
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.7)',
                        'rgba(46, 204, 113, 0.7)',
                        'rgba(155, 89, 182, 0.7)',
                        'rgba(241, 196, 15, 0.7)'
                    ],
                    borderColor: [
                        '#3498db',
                        '#2ecc71',
                        '#9b59b6',
                        '#f1c40f'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
    
    // Gráfico por estado
    if (document.getElementById('grafEstado')) {
        new Chart(document.getElementById('grafEstado'), {
            type: 'pie',
            data: {
                labels: ['Activo', 'Inactivo'],
                datasets: [{
                    data: [datosGraficos.activos, datosGraficos.inactivos],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
    
    // Gráfico por parentesco
    if (document.getElementById('grafParentesco') && datosGraficos.parentescos) {
        const parentescos = datosGraficos.parentescos;
        const labels = Object.keys(parentescos);
        const values = Object.values(parentescos);
        
        new Chart(document.getElementById('grafParentesco'), {
            type: 'polarArea',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
});
</script>
@endsection