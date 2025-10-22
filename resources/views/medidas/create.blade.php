@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-ruler-combined me-2"></i>Nueva Medida
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Información del Paciente -->
                    <div class="alert alert-info">
                        <h5 class="alert-heading">Datos del Paciente</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nombre:</strong> {{ $paciente->nombre_completo }}
                            </div>
                            <div class="col-md-3">
                                <strong>CI:</strong> {{ $paciente->CI }}
                            </div>
                            <div class="col-md-3">
                                <strong>Género:</strong> 
                                <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                    {{ ucfirst($paciente->genero) }}
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Fecha Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Edad:</strong> {{ $paciente->fecha_nacimiento->age }} años
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Medidas -->
                    <form id="medidaForm" action="{{ route('medidas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha de Medición *</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" 
                                       value="{{ old('fecha', date('Y-m-d')) }}" required>
                                <div class="invalid-feedback" id="fechaError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="peso_kg" class="form-label">Peso (kg) *</label>
                                <input type="number" class="form-control" id="peso_kg" name="peso_kg" 
                                       step="0.01" min="0" value="{{ old('peso_kg') }}" required>
                                <div class="invalid-feedback" id="pesoError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="talla_cm" class="form-label">Talla (cm) *</label>
                                <input type="number" class="form-control" id="talla_cm" name="talla_cm" 
                                       step="0.1" min="0" value="{{ old('talla_cm') }}" required>
                                <div class="invalid-feedback" id="tallaError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="pb_mm" class="form-label">Perimetro Braqueal (mm) *</label>
                                <input type="number" class="form-control" id="pb_mm" name="pb_mm" 
                                       step="0.1" min="0" value="{{ old('pb_mm') }}" required>
                                <div class="invalid-feedback" id="pbError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="pct_mm" class="form-label">Pliegue Tricipital (mm) *</label>
                                <input type="number" class="form-control" id="pct_mm" name="pct_mm" 
                                       step="0.1" min="0" value="{{ old('pct_mm') }}" required>
                                <div class="invalid-feedback" id="pctError"></div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('medidas.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-1"></i> Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-calculator me-1"></i> Calcular Evaluación
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('medidaForm');
    const submitBtn = document.getElementById('submitBtn');
    const inputs = form.querySelectorAll('input[required]');

    function validateForm() {
        let isValid = true;
        
        inputs.forEach(input => {
            const errorElement = document.getElementById(input.name + 'Error');
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                errorElement.textContent = 'Este campo es obligatorio';
                isValid = false;
            } else if (input.type === 'number' && parseFloat(input.value) <= 0) {
                input.classList.add('is-invalid');
                errorElement.textContent = 'El valor debe ser mayor a 0';
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        });

        // Validación adicional para fecha
        const fechaInput = document.getElementById('fecha');
        if (fechaInput.value) {
            const selectedDate = new Date(fechaInput.value);
            const today = new Date();
            if (selectedDate > today) {
                fechaInput.classList.add('is-invalid');
                document.getElementById('fechaError').textContent = 'La fecha no puede ser futura';
                isValid = false;
            }
        }

        return isValid;
    }

    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', validateForm);
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // Validación al enviar
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            showAlert('Por favor, complete todos los campos correctamente.', 'danger');
        }
    });

    function showAlert(message, type) {
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
@endpush