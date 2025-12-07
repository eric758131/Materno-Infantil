@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- ENCABEZADO --}}
    @if(Route::has('dashboard'))
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Referencias Frisancho</li>
        </ol>
    </nav>
    @endif

    {{-- CABECERA --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 fw-bold text-primary">
                <i class="fas fa-ruler-combined me-2"></i>Referencias Antropométricas Frisancho
            </h1>
            <p class="text-muted mb-0">Patrones de referencia para evaluación nutricional por antropometría</p>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-4 border-end">
                            <div class="text-primary fw-bold fs-4">{{ $estadisticas['total'] }}</div>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4 border-end">
                            <div class="text-info fw-bold fs-4">{{ $estadisticas['masculino'] }}</div>
                            <small class="text-muted">Masculino</small>
                        </div>
                        <div class="col-4">
                            <div class="text-pink fw-bold fs-4">{{ $estadisticas['femenino'] }}</div>
                            <small class="text-muted">Femenino</small>
                        </div>
                    </div>
                    <div class="row text-center mt-2">
                        <div class="col-12">
                            <small class="text-muted">Edad: {{ $estadisticas['edad_min'] }} - {{ $estadisticas['edad_max'] }} años</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RESUMEN DE PARÁMETROS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3 bg-primary bg-opacity-10">
                    <div class="text-primary fw-bold">PB</div>
                    <small class="text-muted">Pliegue Bicipital</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3 bg-success bg-opacity-10">
                    <div class="text-success fw-bold">PCT</div>
                    <small class="text-muted">Pliegue Tricipital</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3 bg-danger bg-opacity-10">
                    <div class="text-danger fw-bold">CMB</div>
                    <small class="text-muted">Circunferencia Muslo Brazo</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3 bg-purple bg-opacity-10">
                    <div class="text-purple fw-bold">AMB</div>
                    <small class="text-muted">Área Muscular del Brazo</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-3 bg-warning bg-opacity-10">
                    <div class="text-warning fw-bold">AGB</div>
                    <small class="text-muted">Área Grasa del Brazo</small>
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
                    <label class="form-label small text-uppercase text-muted">Edad Desde (años)</label>
                    <input type="number" min="0" class="form-control form-control-sm" name="edad_desde" 
                           value="{{ request('edad_desde') }}" placeholder="0">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-uppercase text-muted">Edad Hasta (años)</label>
                    <input type="number" min="0" class="form-control form-control-sm" name="edad_hasta" 
                           value="{{ request('edad_hasta') }}" placeholder="{{ $estadisticas['edad_max'] ?? '' }}">
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
                    @if(Route::has('reportes.frisancho.export.excel'))
                    <li>
                        <a href="{{ route('reportes.frisancho.export.excel', request()->query()) }}" 
                           class="dropdown-item">
                            <i class="fas fa-file-excel text-success me-2"></i>Excel (.xlsx)
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('reportes.frisancho.export.pdf'))
                    <li>
                        <a href="{{ route('reportes.frisancho.export.pdf', request()->query()) }}" 
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
                <i class="fas fa-table text-primary me-2"></i>Tabla de Referencias Frisancho
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Género</th>
                        <th>Edad (años)</th>
                        
                        {{-- PLIEGUE BICIPITAL --}}
                        <th colspan="3" class="text-center bg-primary bg-opacity-10 border-primary">
                            <div class="text-primary fw-bold">PB (mm)</div>
                            <div class="small">Pliegue Bicipital</div>
                        </th>
                        
                        {{-- PLIEGUE CUTÁNEO TRICIPITAL --}}
                        <th colspan="3" class="text-center bg-success bg-opacity-10 border-success">
                            <div class="text-success fw-bold">PCT (mm)</div>
                            <div class="small">Pliegue Tricipital</div>
                        </th>
                        
                        {{-- CIRCUNFERENCIA MUSLO BRAZO --}}
                        <th colspan="3" class="text-center bg-danger bg-opacity-10 border-danger">
                            <div class="text-danger fw-bold">CMB (cm)</div>
                            <div class="small">Circunf. Muslo Brazo</div>
                        </th>
                        
                        {{-- ÁREA MUSCULAR BRAZO --}}
                        <th colspan="3" class="text-center bg-purple bg-opacity-10 border-purple">
                            <div class="text-purple fw-bold">AMB (cm²)</div>
                            <div class="small">Área Muscular Brazo</div>
                        </th>
                        
                        {{-- ÁREA GRASA BRAZO --}}
                        <th colspan="3" class="text-center bg-warning bg-opacity-10 border-warning">
                            <div class="text-warning fw-bold">AGB (cm²)</div>
                            <div class="small">Área Grasa Brazo</div>
                        </th>
                        
                        <th width="80">Detalles</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                        {{-- PB --}}
                        <th class="text-center small bg-primary text-white">-1SD</th>
                        <th class="text-center small bg-primary text-white">Mediana</th>
                        <th class="text-center small bg-primary text-white">+1SD</th>
                        
                        {{-- PCT --}}
                        <th class="text-center small bg-success text-white">-1SD</th>
                        <th class="text-center small bg-success text-white">Mediana</th>
                        <th class="text-center small bg-success text-white">+1SD</th>
                        
                        {{-- CMB --}}
                        <th class="text-center small bg-danger text-white">-1SD</th>
                        <th class="text-center small bg-danger text-white">Mediana</th>
                        <th class="text-center small bg-danger text-white">+1SD</th>
                        
                        {{-- AMB --}}
                        <th class="text-center small bg-purple text-white">-1SD</th>
                        <th class="text-center small bg-purple text-white">Mediana</th>
                        <th class="text-center small bg-purple text-white">+1SD</th>
                        
                        {{-- AGB --}}
                        <th class="text-center small bg-warning text-white">-1SD</th>
                        <th class="text-center small bg-warning text-white">Mediana</th>
                        <th class="text-center small bg-warning text-white">+1SD</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referencias as $ref)
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
                        <td><strong>{{ $ref->edad_anios }}</strong></td>
                        
                        {{-- PLIEGUE BICIPITAL --}}
                        <td class="text-center bg-primary bg-opacity-10">
                            <code>{{ number_format($ref->pb_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-primary bg-opacity-10">
                            <strong>{{ number_format($ref->pb_dato, 2) }}</strong>
                        </td>
                        <td class="text-center bg-primary bg-opacity-10">
                            <code>{{ number_format($ref->pb_mas_sd, 2) }}</code>
                        </td>
                        
                        {{-- PLIEGUE CUTÁNEO TRICIPITAL --}}
                        <td class="text-center bg-success bg-opacity-10">
                            <code>{{ number_format($ref->pct_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-success bg-opacity-10">
                            <strong>{{ number_format($ref->pct_dato, 2) }}</strong>
                        </td>
                        <td class="text-center bg-success bg-opacity-10">
                            <code>{{ number_format($ref->pct_mas_sd, 2) }}</code>
                        </td>
                        
                        {{-- CIRCUNFERENCIA MUSLO BRAZO --}}
                        <td class="text-center bg-danger bg-opacity-10">
                            <code>{{ number_format($ref->cmb_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-danger bg-opacity-10">
                            <strong>{{ number_format($ref->cmb_dato, 2) }}</strong>
                        </td>
                        <td class="text-center bg-danger bg-opacity-10">
                            <code>{{ number_format($ref->cmb_mas_sd, 2) }}</code>
                        </td>
                        
                        {{-- ÁREA MUSCULAR BRAZO --}}
                        <td class="text-center bg-purple bg-opacity-10">
                            <code>{{ number_format($ref->amb_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-purple bg-opacity-10">
                            <strong>{{ number_format($ref->amb_dato, 2) }}</strong>
                        </td>
                        <td class="text-center bg-purple bg-opacity-10">
                            <code>{{ number_format($ref->amb_mas_sd, 2) }}</code>
                        </td>
                        
                        {{-- ÁREA GRASA BRAZO --}}
                        <td class="text-center bg-warning bg-opacity-10">
                            <code>{{ number_format($ref->agb_menos_sd, 2) }}</code>
                        </td>
                        <td class="text-center bg-warning bg-opacity-10">
                            <strong>{{ number_format($ref->agb_dato, 2) }}</strong>
                        </td>
                        <td class="text-center bg-warning bg-opacity-10">
                            <code>{{ number_format($ref->agb_mas_sd, 2) }}</code>
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
                        <td colspan="20" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-ruler-combined fa-3x mb-3"></i>
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
                <h5 class="modal-title">Detalle de Referencia Frisancho</h5>
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
.bg-purple { background-color: #9b59b6; }
.text-purple { color: #9b59b6; }
.table th { font-weight: 600; font-size: 0.85rem; }
.bg-opacity-10 { --bs-bg-opacity: 0.1; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Función para mostrar detalles en modal
function mostrarDetalle(referencia) {
    const percentilMenosSD = "16°";
    const percentilMediana = "50°";
    const percentilMasSD = "84°";
    
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
                        <th>Edad:</th>
                        <td><strong>${referencia.edad_anios}</strong> años</td>
                    </tr>
                    <tr>
                        <th>Etapa:</th>
                        <td>
                            ${referencia.edad_anios < 2 ? 'Lactante' : 
                              referencia.edad_anios < 6 ? 'Preescolar' :
                              referencia.edad_anios < 12 ? 'Escolar' :
                              referencia.edad_anios < 18 ? 'Adolescente' : 'Adulto joven'}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted mb-3">Interpretación</h6>
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Referencia Frisancho para antropometría:</strong><br>
                        • <strong>-1SD (${percentilMenosSD}):</strong> Límite inferior normal<br>
                        • <strong>Mediana (${percentilMediana}):</strong> Valor de referencia estándar<br>
                        • <strong>+1SD (${percentilMasSD}):</strong> Límite superior normal<br>
                        <em>Valores basados en estándares antropométricos latinoamericanos.</em>
                    </small>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <h6 class="text-uppercase text-muted mb-3">Valores Antropométricos Detallados</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Parámetro</th>
                                <th>Unidad</th>
                                <th>-1SD (${percentilMenosSD})</th>
                                <th>Mediana (${percentilMediana})</th>
                                <th>+1SD (${percentilMasSD})</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-primary">
                                <td><strong>Pliegue Bicipital (PB)</strong></td>
                                <td>mm</td>
                                <td class="text-center">${parseFloat(referencia.pb_menos_sd).toFixed(2)}</td>
                                <td class="text-center"><strong>${parseFloat(referencia.pb_dato).toFixed(2)}</strong></td>
                                <td class="text-center">${parseFloat(referencia.pb_mas_sd).toFixed(2)}</td>
                            </tr>
                            <tr class="table-success">
                                <td><strong>Pliegue Tricipital (PCT)</strong></td>
                                <td>mm</td>
                                <td class="text-center">${parseFloat(referencia.pct_menos_sd).toFixed(2)}</td>
                                <td class="text-center"><strong>${parseFloat(referencia.pct_dato).toFixed(2)}</strong></td>
                                <td class="text-center">${parseFloat(referencia.pct_mas_sd).toFixed(2)}</td>
                            </tr>
                            <tr class="table-danger">
                                <td><strong>Circunf. Muslo Brazo (CMB)</strong></td>
                                <td>cm</td>
                                <td class="text-center">${parseFloat(referencia.cmb_menos_sd).toFixed(2)}</td>
                                <td class="text-center"><strong>${parseFloat(referencia.cmb_dato).toFixed(2)}</strong></td>
                                <td class="text-center">${parseFloat(referencia.cmb_mas_sd).toFixed(2)}</td>
                            </tr>
                            <tr class="table-purple">
                                <td><strong>Área Muscular Brazo (AMB)</strong></td>
                                <td>cm²</td>
                                <td class="text-center">${parseFloat(referencia.amb_menos_sd).toFixed(2)}</td>
                                <td class="text-center"><strong>${parseFloat(referencia.amb_dato).toFixed(2)}</strong></td>
                                <td class="text-center">${parseFloat(referencia.amb_mas_sd).toFixed(2)}</td>
                            </tr>
                            <tr class="table-warning">
                                <td><strong>Área Grasa Brazo (AGB)</strong></td>
                                <td>cm²</td>
                                <td class="text-center">${parseFloat(referencia.agb_menos_sd).toFixed(2)}</td>
                                <td class="text-center"><strong>${parseFloat(referencia.agb_dato).toFixed(2)}</strong></td>
                                <td class="text-center">${parseFloat(referencia.agb_mas_sd).toFixed(2)}</td>
                            </tr>
                        </tbody>
                    </table>
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