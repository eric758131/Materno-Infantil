@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Resultados de Evaluación
                    </h4>
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
                            <p><strong>Estado:</strong> 
                                <span class="badge bg-{{ $medida->estado == 'Activo' ? 'success' : 'secondary' }}">
                                    {{ $medida->estado }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($medida->evaluaciones->count() > 0)
                        @php $evaluacion = $medida->evaluaciones->first(); @endphp
                        
                        <form id="evaluacionForm" action="#" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Columna Izquierda - Resultados Calculados (solo lectura) -->
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
                                                    <label class="form-label"><strong>Perimeto Braqueal (mm)</strong></label>
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

                                <!-- Columna Derecha - Diagnósticos (editables) -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-warning">
                                            <h6 class="mb-0">Diagnósticos</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="dx_z_imc" class="form-label"><strong>Diagnóstico IMC *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_imc" name="dx_z_imc" 
                                                              rows="2" required>{{ old('dx_z_imc', $evaluacion->dx_z_imc) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_talla" class="form-label"><strong>Diagnóstico Talla *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_talla" name="dx_z_talla" 
                                                              rows="2" required>{{ old('dx_z_talla', $evaluacion->dx_z_talla) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_pb" class="form-label"><strong>Diagnóstico Pliegue Bicipital *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_pb" name="dx_z_pb" 
                                                              rows="2" required>{{ old('dx_z_pb', $evaluacion->dx_z_pb) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_pct" class="form-label"><strong>Diagnóstico Pliegue Tricipital *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_pct" name="dx_z_pct" 
                                                              rows="2" required>{{ old('dx_z_pct', $evaluacion->dx_z_pct) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_cmb" class="form-label"><strong>Diagnóstico CMB *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_cmb" name="dx_z_cmb" 
                                                              rows="2" required>{{ old('dx_z_cmb', $evaluacion->dx_z_cmb) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_amb" class="form-label"><strong>Diagnóstico AMB *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_amb" name="dx_z_amb" 
                                                              rows="2" required>{{ old('dx_z_amb', $evaluacion->dx_z_amb) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="dx_z_agb" class="form-label"><strong>Diagnóstico AGB *</strong></label>
                                                    <textarea class="form-control dx-field" id="dx_z_agb" name="dx_z_agb" 
                                                              rows="2" required>{{ old('dx_z_agb', $evaluacion->dx_z_agb) }}</textarea>
                                                    <div class="invalid-feedback">Este diagnóstico es obligatorio</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('medidas.index') }}" class="btn btn-secondary me-md-2">
                                            <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                                        </a>
                                        <a href="{{ route('medidas.calculos', $medida->id) }}" class="btn btn-info me-md-2">
                                            <i class="fas fa-calculator me-1"></i> Ver Cálculos
                                        </a>
                                        <button type="submit" class="btn btn-success" id="saveBtn" disabled>
                                            <i class="fas fa-save me-1"></i> Guardar Evaluación
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('evaluacionForm');
    const saveBtn = document.getElementById('saveBtn');
    const dxFields = document.querySelectorAll('.dx-field');
    
    function validateDiagnostics() {
        let allFilled = true;
        
        dxFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });
        
        saveBtn.disabled = !allFilled;
        return allFilled;
    }
    
    // Validación en tiempo real
    dxFields.forEach(field => {
        field.addEventListener('input', validateDiagnostics);
        field.addEventListener('blur', validateDiagnostics);
    });
    
    // Validación inicial
    validateDiagnostics();
    
    // Manejo del envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateDiagnostics()) {
            // Aquí iría la lógica para guardar los diagnósticos
            showAlert('Diagnósticos guardados correctamente.', 'success');
            // En un caso real, harías una petición AJAX o submit normal
            // form.submit();
        } else {
            showAlert('Por favor, complete todos los diagnósticos antes de guardar.', 'danger');
        }
    });
    
    function showAlert(message, type) {
        // Remover alertas existentes
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        form.prepend(alertDiv);
    }
});
</script>

@push('styles')
<style>
.dx-field {
    transition: all 0.3s ease;
}
.dx-field.is-valid {
    border-color: #198754;
    background-color: #f8fff9;
}
.dx-field.is-invalid {
    border-color: #dc3545;
    background-color: #fff8f8;
}
.form-label strong {
    color: #495057;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
@endpush