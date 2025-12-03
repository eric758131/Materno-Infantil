@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- ENCABEZADO --}}
    @if(Route::has('dashboard'))
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Referencias OMS</li>
        </ol>
    </nav>
    @endif

    {{-- CABECERA --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 fw-bold text-primary">
                <i class="fas fa-chart-line me-2"></i>Patrones de Crecimiento OMS
            </h1>
            <p class="text-muted mb-0">Referencias de IMC y Talla según la Organización Mundial de la Salud</p>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <div class="text-primary fw-bold fs-4">{{ $datosGraficos['total'] }}</div>
                            <small class="text-muted">Registros</small>
                        </div>
                        <div class="col-4 border-end">
                            <div class="text-info fw-bold fs-4">{{ $datosGraficos['masculino'] }}</div>
                            <small class="text-muted">Masculino</small>
                        </div>
                        <div class="col-4">
                            <div class="text-pink fw-bold fs-4">{{ $datosGraficos['femenino'] }}</div>
                            <small class="text-muted">Femenino</small>
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
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Género</label>
                    <select name="genero" class="form-select form-select-sm">
                        <option value="">Ambos géneros</option>
                        <option value="masculino" {{ request('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ request('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Edad Desde (meses)</label>
                    <input type="number" min="0" max="228" class="form-control form-control-sm" name="edad_desde" 
                        value="{{ request('edad_desde') }}" placeholder="0 meses">
                    <small class="text-muted">Mín: 0 meses (recién nacido)</small>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Edad Hasta (meses)</label>
                    <input type="number" min="0" max="228" class="form-control form-control-sm" name="edad_hasta" 
                        value="{{ request('edad_hasta', 228) }}" placeholder="228 meses">
                    <small class="text-muted">Máx: 228 meses (19 años)</small>
                </div>
                
                <div class="col-md-3 d-flex align-items-end gap-2">
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
                    <i class="fas fa-download me-1"></i>Exportar Tabla
                </button>
                <ul class="dropdown-menu">
                    @if(Route::has('reportes.oms-referencias.export.excel'))
                    <li>
                        <a href="{{ route('reportes.oms-referencias.export.excel', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-excel text-success me-2"></i>Excel (.xlsx)
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('reportes.oms-referencias.export.pdf'))
                    <li>
                        <a href="{{ route('reportes.oms-referencias.export.pdf', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-pdf text-danger me-2"></i>PDF (.pdf)
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="text-muted small">
            Mostrando <span class="fw-bold">{{ $referencias->count() }}</span> de 
            <span class="fw-bold">{{ $referencias->total() }}</span> referencias
        </div>
    </div>

    {{-- TABLA DE REFERENCIAS --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-table text-primary me-2"></i>Tabla de Referencias OMS
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Género</th>
                        <th>Edad (meses)</th>
                        <th>Edad (años)</th>
                        <th class="text-center" colspan="3">IMC (kg/m²)</th>
                        <th class="text-center" colspan="3">Talla (cm)</th>
                        <th width="80">Acciones</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center small bg-danger text-white">-1SD</th>
                        <th class="text-center small bg-success text-white">Mediana</th>
                        <th class="text-center small bg-warning text-white">+1SD</th>
                        <th class="text-center small bg-danger text-white">-1SD</th>
                        <th class="text-center small bg-success text-white">Mediana</th>
                        <th class="text-center small bg-warning text-white">+1SD</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referencias as $ref)
                    @php
                        $edadAnios = floor($ref->edad_meses / 12);
                        $edadMesesResto = $ref->edad_meses % 12;
                        $edadFormateada = $edadAnios > 0 
                            ? "{$edadAnios} años, {$edadMesesResto} meses" 
                            : "{$ref->edad_meses} meses";
                    @endphp
                    <tr>
                        <td class="text-muted">{{ ($referencias->currentPage() - 1) * $referencias->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($ref->genero == 'masculino')
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-mars me-1"></i>Masculino
                                </span>
                            @else
                                <span class="badge bg-pink bg-opacity-10 text-pink">
                                    <i class="fas fa-venus me-1"></i>Femenino
                                </span>
                            @endif
                        </td>
                        <td><strong>{{ $ref->edad_meses }}</strong></td>
                        <td class="small">{{ $edadFormateada }}</td>
                        
                        {{-- IMC --}}
                        <td class="text-center bg-danger bg-opacity-10">
                            <code>{{ number_format($ref->imc_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-success bg-opacity-10">
                            <strong>{{ number_format($ref->imc_mediana, 2) }}</strong>
                        </td>
                        <td class="text-center bg-warning bg-opacity-10">
                            <code>{{ number_format($ref->imc_mas_sd, 2) }}</code>
                        </td>
                        
                        {{-- TALLA --}}
                        <td class="text-center bg-danger bg-opacity-10">
                            <code>{{ number_format($ref->talla_menos_sd_cm, 2) }}</code>
                        </td>
                        <td class="text-center bg-success bg-opacity-10">
                            <strong>{{ number_format($ref->talla_mediana_cm, 2) }}</strong>
                        </td>
                        <td class="text-center bg-warning bg-opacity-10">
                            <code>{{ number_format($ref->talla_mas_sd_cm, 2) }}</code>
                        </td>
                        
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-info" 
                                    data-bs-toggle="tooltip" 
                                    title="Ver detalles"
                                    onclick="mostrarDetalle({{ json_encode($ref) }})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-chart-line fa-3x mb-3"></i>
                                <h5>No se encontraron referencias</h5>
                                <p>No hay datos registrados en el sistema</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($referencias->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Página {{ $referencias->currentPage() }} de {{ $referencias->lastPage() }}
                </div>
                <div>
                    {{ $referencias->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- MODAL PARA DETALLES --}}
<div class="modal fade" id="modalDetalle" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Referencia OMS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleContenido">
                <!-- Contenido dinámico -->
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
.bg-opacity-10 { --bs-bg-opacity: 0.1; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de los gráficos pasados desde el controlador
    const datos = @json($datosGraficos);
    
    console.log('Datos para gráficos:', datos); // Para depuración
    
    // Gráfico 1: Distribución por Género
    if (document.getElementById('grafGenero')) {
        const ctx = document.getElementById('grafGenero').getContext('2d');
        
        // Solo mostrar si hay datos
        if (datos.masculino > 0 || datos.femenino > 0) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Masculino', 'Femenino'],
                    datasets: [{
                        data: [datos.masculino, datos.femenino],
                        backgroundColor: ['#3498db', '#e83e8c'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Mostrar mensaje si no hay datos
            ctx.fillStyle = '#6c757d';
            ctx.font = '14px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('No hay datos', 100, 100);
        }
    }
    
    // Gráfico 2: Distribución por Edad
    if (document.getElementById('grafEdades')) {
        const ctx = document.getElementById('grafEdades').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['0-12m', '13-24m', '25-36m', '37-48m', '49-60m'],
                datasets: [{
                    label: 'Cantidad de Referencias',
                    data: [
                        datos.edad_0_12,
                        datos.edad_13_24,
                        datos.edad_25_36,
                        datos.edad_37_48,
                        datos.edad_49_60
                    ],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.7)',
                        'rgba(46, 204, 113, 0.7)',
                        'rgba(155, 89, 182, 0.7)',
                        'rgba(241, 196, 15, 0.7)',
                        'rgba(231, 76, 60, 0.7)'
                    ],
                    borderColor: [
                        '#3498db',
                        '#2ecc71',
                        '#9b59b6',
                        '#f1c40f',
                        '#e74c3c'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
    
    // Gráfico 3: Tendencia IMC por Edad
    if (document.getElementById('grafTendenciaIMC')) {
        const ctx = document.getElementById('grafTendenciaIMC').getContext('2d');
        const labels = ['0m', '6m', '12m', '18m', '24m', '30m', '36m', '42m', '48m', '54m', '60m'];
        
        // Filtrar datos nulos o cero
        const imcMasculino = datos.tendencias_imc_masculino.map(val => val || 0);
        const imcFemenino = datos.tendencias_imc_femenino.map(val => val || 0);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Masculino',
                        data: imcMasculino,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Femenino',
                        data: imcFemenino,
                        borderColor: '#e83e8c',
                        backgroundColor: 'rgba(232, 62, 140, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'IMC (kg/m²)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Edad (meses)'
                        }
                    }
                }
            }
        });
    }
    
    // Gráfico 4: Tendencia Talla por Edad
    if (document.getElementById('grafTendenciaTalla')) {
        const ctx = document.getElementById('grafTendenciaTalla').getContext('2d');
        const labels = ['0m', '6m', '12m', '18m', '24m', '30m', '36m', '42m', '48m', '54m', '60m'];
        
        // Filtrar datos nulos o cero
        const tallaMasculino = datos.tendencias_talla_masculino.map(val => val || 0);
        const tallaFemenino = datos.tendencias_talla_femenino.map(val => val || 0);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Masculino',
                        data: tallaMasculino,
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Femenino',
                        data: tallaFemenino,
                        borderColor: '#9b59b6',
                        backgroundColor: 'rgba(155, 89, 182, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Talla (cm)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Edad (meses)'
                        }
                    }
                }
            }
        });
    }
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Función para mostrar detalles en modal
function mostrarDetalle(referencia) {
    const edadAnios = Math.floor(referencia.edad_meses / 12);
    const edadMesesResto = referencia.edad_meses % 12;
    const edadFormateada = edadAnios > 0 
        ? `${edadAnios} años, ${edadMesesResto} meses` 
        : `${referencia.edad_meses} meses`;
    
    const contenido = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted mb-3">Información General</h6>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Género:</th>
                        <td>${referencia.genero === 'masculino' ? '👦 Masculino' : '👧 Femenino'}</td>
                    </tr>
                    <tr>
                        <th>Edad en meses:</th>
                        <td><strong>${referencia.edad_meses}</strong> meses</td>
                    </tr>
                    <tr>
                        <th>Edad formateada:</th>
                        <td>${edadFormateada}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted mb-3">Rangos de IMC</h6>
                <table class="table table-sm">
                    <tr class="table-danger">
                        <th>-1 Desviación Estándar:</th>
                        <td class="text-end"><strong>${parseFloat(referencia.imc_menos_sd).toFixed(2)}</strong> kg/m²</td>
                    </tr>
                    <tr class="table-success">
                        <th>Mediana (50%):</th>
                        <td class="text-end"><strong>${parseFloat(referencia.imc_mediana).toFixed(2)}</strong> kg/m²</td>
                    </tr>
                    <tr class="table-warning">
                        <th>+1 Desviación Estándar:</th>
                        <td class="text-end"><strong>${parseFloat(referencia.imc_mas_sd).toFixed(2)}</strong> kg/m²</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted mb-3">Rangos de Talla</h6>
                <table class="table table-sm">
                    <tr class="table-danger">
                        <th>-1 Desviación Estándar:</th>
                        <td class="text-end"><strong>${parseFloat(referencia.talla_menos_sd_cm).toFixed(1)}</strong> cm</td>
                    </tr>
                    <tr class="table-success">
                        <th>Mediana (50%):</th>
                        <td class="text-end"><strong>${parseFloat(referencia.talla_mediana_cm).toFixed(1)}</strong> cm</td>
                    </tr>
                    <tr class="table-warning">
                        <th>+1 Desviación Estándar:</th>
                        <td class="text-end"><strong>${parseFloat(referencia.talla_mas_sd_cm).toFixed(1)}</strong> cm</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted mb-3">Interpretación</h6>
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Valores de referencia según OMS:</strong><br>
                        • <strong>-1SD:</strong> Límite inferior del rango normal<br>
                        • <strong>Mediana:</strong> Valor esperado para la edad<br>
                        • <strong>+1SD:</strong> Límite superior del rango normal
                    </small>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detalleContenido').innerHTML = contenido;
    const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
    modal.show();
}
</script>
@endsection