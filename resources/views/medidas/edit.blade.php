@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-warning text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Medida Antropométrica
                    </h4>
                    <p class="mb-0 mt-1 small opacity-75">Modifique los datos de la evaluación</p>
                </div>

                <div class="card-body p-4">
                    <!-- Información del Paciente -->
                    <div class="alert alert-info border-0 bg-light-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x text-info me-3"></i>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-1">{{ $medida->paciente->nombre_completo }}</h5>
                                <div class="row small">
                                    <div class="col-md-3"><strong>CI:</strong> {{ $medida->paciente->CI }}</div>
                                    <div class="col-md-3">
                                        <strong>Género:</strong> 
                                        <span class="badge bg-{{ $medida->paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                            {{ ucfirst($medida->paciente->genero) }}
                                        </span>
                                    </div>
                                    <div class="col-md-3"><strong>Nacimiento:</strong> {{ $medida->paciente->fecha_nacimiento->format('d/m/Y') }}</div>
                                    <div class="col-md-3"><strong>Edad:</strong> {{ $medida->paciente->fecha_nacimiento->age }} años</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $evaluacion = $medida->evaluaciones->first();
                    @endphp

                    <form action="{{ route('medidas.update', $medida->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- SECCIÓN 1: DATOS BÁSICOS -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light-warning py-3">
                                <h5 class="mb-0 text-warning">
                                    <i class="fas fa-ruler-combined me-2"></i>1. Datos de Medición
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label for="fecha" class="form-label fw-semibold">Fecha de Medición *</label>
                                        <input type="date" class="form-control form-control-lg" id="fecha" name="fecha" 
                                               value="{{ old('fecha', $medida->fecha->format('Y-m-d')) }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="peso_kg" class="form-label fw-semibold">
                                            <i class="fas fa-weight me-1 text-primary"></i>Peso (kg) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="peso_kg" name="peso_kg" 
                                               step="0.01" min="0" value="{{ old('peso_kg', $medida->peso_kg) }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="talla_cm" class="form-label fw-semibold">
                                            <i class="fas fa-ruler-vertical me-1 text-success"></i>Talla (cm) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="talla_cm" name="talla_cm" 
                                               step="0.1" min="0" value="{{ old('talla_cm', $medida->talla_cm) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: MEDIDAS ANTROPOMÉTRICAS -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light-primary py-3">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-tape me-2"></i>2. Medidas Antropométricas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="pb_mm" class="form-label fw-semibold">
                                            <i class="fas fa-circle me-1 text-info"></i>Perímetro Braquial (mm) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="pb_mm" name="pb_mm" 
                                               step="0.1" min="0" value="{{ old('pb_mm', $medida->pb_mm) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="pct_mm" class="form-label fw-semibold">
                                            <i class="fas fa-grip-lines me-1 text-warning"></i>Pliegue Tricipital (mm) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="pct_mm" name="pct_mm" 
                                               step="0.1" min="0" value="{{ old('pct_mm', $medida->pct_mm) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 3: DIAGNÓSTICOS -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-gradient-warning text-white py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-stethoscope me-2"></i>3. Diagnósticos Nutricionales
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-primary">
                                            <i class="fas fa-weight me-1"></i>Diagnóstico IMC *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_imc" rows="3" required>{{ old('dx_z_imc', $evaluacion->dx_z_imc) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-success">
                                            <i class="fas fa-ruler-vertical me-1"></i>Diagnóstico Talla *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_talla" rows="3" required>{{ old('dx_z_talla', $evaluacion->dx_z_talla) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-info">
                                            <i class="fas fa-circle me-1"></i>Diagnóstico Perímetro Braquial *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_pb" rows="3" required>{{ old('dx_z_pb', $evaluacion->dx_z_pb) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-warning">
                                            <i class="fas fa-grip-lines me-1"></i>Diagnóstico Pliegue Tricipital *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_pct" rows="3" required>{{ old('dx_z_pct', $evaluacion->dx_z_pct) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-info">
                                            <i class="fas fa-circle-notch me-1"></i>Diagnóstico CMB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_cmb" rows="3" required>{{ old('dx_z_cmb', $evaluacion->dx_z_cmb) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-success">
                                            <i class="fas fa-square me-1"></i>Diagnóstico AMB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_amb" rows="3" required>{{ old('dx_z_amb', $evaluacion->dx_z_amb) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-warning">
                                            <i class="fas fa-square-full me-1"></i>Diagnóstico AGB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_agb" rows="3" required>{{ old('dx_z_agb', $evaluacion->dx_z_agb) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('medidas.show', $medida->id) }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i> Actualizar Evaluación
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