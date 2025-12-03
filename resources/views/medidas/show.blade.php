@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Resultados de Evaluación
                    </h4>
                    <div>
                        <span class="badge bg-{{ $medida->estado == 'Activo' ? 'light' : 'secondary' }} text-dark me-2">
                            Estado: {{ $medida->estado }}
                        </span>
                        <button class="btn btn-sm btn-outline-light me-2" onclick="toggleEstado()">
                            <i class="fas fa-power-off me-1"></i>
                            {{ $medida->estado == 'Activo' ? 'Desactivar' : 'Activar' }}
                        </button>
                        <a href="{{ route('medidas.edit', $medida->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información del Paciente y Medida -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Datos del Paciente</h5>
                            <p><strong>Nombre:</strong> {{ $medida->paciente->nombre_completo }}</p>
                            <p><strong>CI:</strong> {{ $medida->paciente->CI }}</p>
                            <p><strong>Género:</strong> 
                                <span class="badge bg-{{ $medida->paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                    {{ ucfirst($medida->paciente->genero) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Datos de la Medida</h5>
                            <p><strong>Fecha:</strong> {{ $medida->fecha->format('d/m/Y') }}</p>
                            <p><strong>Edad:</strong> {{ $medida->edad_meses }} meses ({{ floor($medida->edad_meses/12) }} años)</p>
                            <p><strong>Registrado por:</strong> {{ $medida->evaluaciones->first()->usuario->nombre_completo ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($medida->evaluaciones->count() > 0)
                        @php $evaluacion = $medida->evaluaciones->first(); @endphp
                        
                        <div class="row">
                            <!-- Columna Izquierda - Resultados Calculados -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Resultados Calculados</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label"><strong>IMC</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->imc, 2) }}" readonly>
                                                <small class="form-text text-muted">Índice de Masa Corporal</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score IMC</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_imc, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score Talla</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_talla, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Perímetro Braquial (mm)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($medida->pb_mm, 1) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score PB</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_pb, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Pliegue Tricipital (mm)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($medida->pct_mm, 1) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score PCT</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_pct, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>CMB (mm)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->cmb_mm, 1) }}" readonly>
                                                <small class="form-text text-muted">Circunferencia Muscular Braquial</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score CMB</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_cmb, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>AMB (mm²)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->amb_mm2, 1) }}" readonly>
                                                <small class="form-text text-muted">Área Muscular Braquial</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score AMB</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_amb, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>AGB (mm²)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->agb_mm2, 1) }}" readonly>
                                                <small class="form-text text-muted">Área Grasa Braquial</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Z-Score AGB</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->z_agb, 3) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Peso Ideal (kg)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->peso_ideal, 2) }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Diferencia Peso (kg)</strong></label>
                                                <input type="text" class="form-control" value="{{ number_format($evaluacion->dif_peso, 2) }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Derecha - Diagnósticos -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-warning">
                                        <h6 class="mb-0">Diagnósticos</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico IMC</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_imc }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico Talla</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_talla }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico Pliegue Bicipital</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_pb }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico Pliegue Tricipital</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_pct }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico CMB</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_cmb }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico AMB</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_amb }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label"><strong>Diagnóstico AGB</strong></label>
                                                <textarea class="form-control" rows="2" readonly>{{ $evaluacion->dx_z_agb }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Historial de Medidas -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-history me-2"></i>Historial de Medidas del Paciente
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($medidasPaciente->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Edad</th>
                                                            <th>Peso (kg)</th>
                                                            <th>Talla (cm)</th>
                                                            <th>PB (mm)</th>
                                                            <th>PCT (mm)</th>
                                                            <th>IMC</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($medidasPaciente as $medidaItem)
                                                            <tr class="{{ $medidaItem->id == $medida->id ? 'table-active' : '' }}">
                                                                <td>{{ $medidaItem->fecha->format('d/m/Y') }}</td>
                                                                <td>{{ $medidaItem->edad_meses }} meses</td>
                                                                <td>{{ number_format($medidaItem->peso_kg, 1) }}</td>
                                                                <td>{{ number_format($medidaItem->talla_cm, 1) }}</td>
                                                                <td>{{ number_format($medidaItem->pb_mm, 1) }}</td>
                                                                <td>{{ number_format($medidaItem->pct_mm, 1) }}</td>
                                                                <td>
                                                                    @if($medidaItem->evaluaciones->count() > 0)
                                                                        {{ number_format($medidaItem->evaluaciones->first()->imc, 2) }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-{{ $medidaItem->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                                        {{ $medidaItem->estado }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group btn-group-sm">
                                                                        <a href="{{ route('medidas.show', $medidaItem->id) }}" 
                                                                           class="btn btn-outline-primary">
                                                                           <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('medidas.calculos', $medidaItem->id) }}" 
                                                                           class="btn btn-outline-info">
                                                                           <i class="fas fa-calculator"></i>
                                                                        </a>
                                                                        <a href="{{ route('medidas.edit', $medidaItem->id) }}" 
                                                                           class="btn btn-outline-warning">
                                                                           <i class="fas fa-edit"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted text-center mb-0">No hay más medidas registradas para este paciente.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('pacientes.download-pdf', $medida->paciente->id) }}" class="btn btn-danger me-md-2">
                                        <i class="fas fa-file-pdf me-1"></i> Descargar Historial PDF
                                    </a>
                                    <a href="{{ route('medidas.create', $medida->paciente) }}" class="btn btn-success me-md-2">
                                        <i class="fas fa-plus me-1"></i> Nueva Medida
                                    </a>
                                    <a href="{{ route('medidas.calculos', $medida->id) }}" class="btn btn-info me-md-2">
                                        <i class="fas fa-calculator me-1"></i> Ver Cálculos Detallados
                                    </a>
                                    <a href="{{ route('medidas.edit', $medida->id) }}" class="btn btn-warning me-md-2">
                                        <i class="fas fa-edit me-1"></i> Editar Medida
                                    </a>
                                    <a href="{{ route('medidas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h4>No se encontraron evaluaciones para esta medida</h4>
                            <p class="mb-0">La evaluación no pudo ser calculada correctamente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleEstado() {
    if (!confirm('¿Está seguro de que desea cambiar el estado de esta medida?')) {
        return;
    }

    const nuevoEstado = '{{ $medida->estado }}' === 'Activo' ? 'Inactivo' : 'Activo';
    
    fetch('{{ route("medidas.toggle-estado", $medida->id) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            estado: nuevoEstado
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al cambiar el estado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}
</script>
@endpush

@push('styles')
<style>
.table-active {
    background-color: #e3f2fd !important;
    font-weight: 600;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush