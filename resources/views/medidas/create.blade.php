@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-calculator me-2"></i>Calculadora de Evaluación Antropométrica
                    </h4>
                    <p class="mb-0 mt-1 small opacity-75">Complete los datos del paciente para calcular los indicadores nutricionales</p>
                </div>

                <div class="card-body p-4">
                    <!-- Información del Paciente -->
                    <div class="alert alert-info border-0 bg-light-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x text-info me-3"></i>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-1">{{ $paciente->nombre_completo }}</h5>
                                <div class="row small">
                                    <div class="col-md-3"><strong>CI:</strong> {{ $paciente->CI }}</div>
                                    <div class="col-md-3">
                                        <strong>Género:</strong> 
                                        <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                            {{ ucfirst($paciente->genero) }}
                                        </span>
                                    </div>
                                    <div class="col-md-3"><strong>Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}</div>
                                    <div class="col-md-3"><strong>Edad:</strong> {{ $paciente->fecha_nacimiento->age }} años</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Usuario que Registra -->
                    <div class="alert alert-secondary border-0 bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-md fa-2x text-secondary me-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Registro por</h6>
                                <div class="row small">
                                    <div class="col-md-6">
                                        <strong>Nutricionista:</strong> {{ Auth::user()->name }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Fecha de registro:</strong> {{ now()->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Medidas -->
                    <form id="medidaForm" action="{{ route('medidas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                        <!-- SECCIÓN 1: DATOS BÁSICOS -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light-warning py-3">
                                <h5 class="mb-0 text-warning">
                                    <i class="fas fa-ruler-combined me-2"></i>1. Datos de Medición
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <label for="fecha" class="form-label fw-semibold">Fecha de Medición *</label>
                                        <input type="date" class="form-control form-control-lg" id="fecha" name="fecha" 
                                               value="{{ old('fecha', date('Y-m-d')) }}" required>
                                        <div class="invalid-feedback" id="fechaError"></div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="peso_kg" class="form-label fw-semibold">
                                            <i class="fas fa-weight me-1 text-primary"></i>Peso (kg) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="peso_kg" name="peso_kg" 
                                               step="0.01" min="0" value="{{ old('peso_kg') }}" required>
                                        <div class="invalid-feedback" id="pesoError"></div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="talla_cm" class="form-label fw-semibold">
                                            <i class="fas fa-ruler-vertical me-1 text-success"></i>Talla (cm) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="talla_cm" name="talla_cm" 
                                               step="0.1" min="0" value="{{ old('talla_cm') }}" required>
                                        <div class="invalid-feedback" id="tallaError"></div>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-lg btn-gradient-info w-100 py-3" id="calcularBtn">
                                            <i class="fas fa-bolt me-2"></i>Calcular Evaluación
                                        </button>
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
                                               step="0.1" min="0" value="{{ old('pb_mm') }}" required>
                                        <div class="invalid-feedback" id="pbError"></div>
                                        <small class="text-muted">Circunferencia del brazo</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="pct_mm" class="form-label fw-semibold">
                                            <i class="fas fa-grip-lines me-1 text-warning"></i>Pliegue Tricipital (mm) *
                                        </label>
                                        <input type="number" class="form-control form-control-lg" id="pct_mm" name="pct_mm" 
                                               step="0.1" min="0" value="{{ old('pct_mm') }}" required>
                                        <div class="invalid-feedback" id="pctError"></div>
                                        <small class="text-muted">Espesor del pliegue cutáneo tricipital</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 3: RESULTADOS CALCULADOS -->
                        <div class="card mb-4 border-0 shadow-sm" id="resultadosCard">
                            <div class="card-header bg-light-success py-3">
                                <h5 class="mb-0 text-success">
                                    <i class="fas fa-chart-bar me-2"></i>3. Resultados Calculados
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Loading -->
                                <div id="loadingSection" class="text-center py-5 d-none">
                                    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                                        <span class="visually-hidden">Calculando...</span>
                                    </div>
                                    <h5 class="mt-3 text-primary">Calculando evaluación...</h5>
                                    <p class="text-muted">Estamos procesando los datos antropométricos</p>
                                </div>

                                <!-- Resultados -->
                                <div id="resultadosSection" class="d-none">
                                    <!-- Medidas Básicas con Z-Scores -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-ruler-combined me-2"></i>Medidas Básicas y Z-Scores
                                            </h6>
                                        </div>
                                        
                                        <!-- Peso y Talla -->
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 bg-light h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-weight text-primary me-2"></i>
                                                                <strong class="text-primary">Peso</strong>
                                                            </div>
                                                            <h4 class="text-primary mb-0" id="pesoDisplay">- kg</h4>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-primary text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zPesoDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 bg-light h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-ruler-vertical text-success me-2"></i>
                                                                <strong class="text-success">Talla</strong>
                                                            </div>
                                                            <h4 class="text-success mb-0" id="tallaDisplay">- cm</h4>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-success text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zTallaDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- IMC -->
                                        <div class="col-12 mb-4">
                                            <div class="card border-0 bg-gradient-primary text-white">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-calculator fa-lg me-2"></i>
                                                                <strong>Índice de Masa Corporal (IMC)</strong>
                                                            </div>
                                                            <h2 class="mb-0" id="resultadoImc">-</h2>
                                                            <small>kg/m²</small>
                                                        </div>
                                                        <div class="col-md-4 text-end">
                                                            <div class="bg-white text-primary rounded p-3">
                                                                <small class="text-primary d-block">Z-Score IMC</small>
                                                                <h3 class="text-primary mb-0" id="zImcDisplay">-</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pliegues y Perímetros -->
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 bg-light-info h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-circle text-info me-2"></i>
                                                                <strong class="text-info">Perímetro Braquial</strong>
                                                            </div>
                                                            <h4 class="text-info mb-0" id="pbDisplay">- mm</h4>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-info text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zPbDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 bg-light-warning h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-grip-lines text-warning me-2"></i>
                                                                <strong class="text-warning">Pliegue Tricipital</strong>
                                                            </div>
                                                            <h4 class="text-warning mb-0" id="pctDisplay">- mm</h4>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-warning text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zPctDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Medidas Derivadas con Z-Scores -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-calculator me-2"></i>Medidas Derivadas y Z-Scores
                                            </h6>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-light-success h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-circle-notch text-success me-2"></i>
                                                                <strong class="text-success">CMB</strong>
                                                            </div>
                                                            <h4 class="text-success mb-0" id="resultadoCmb">-</h4>
                                                            <small class="text-muted">Circunferencia Muscular Braquial</small>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-success text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zCmbDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-light-primary h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-square text-primary me-2"></i>
                                                                <strong class="text-primary">AMB</strong>
                                                            </div>
                                                            <h4 class="text-primary mb-0" id="resultadoAmb">-</h4>
                                                            <small class="text-muted">Área Muscular Braquial</small>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-primary text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zAmbDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-light-warning h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-8">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-square-full text-warning me-2"></i>
                                                                <strong class="text-warning">AGB</strong>
                                                            </div>
                                                            <h4 class="text-warning mb-0" id="resultadoAgb">-</h4>
                                                            <small class="text-muted">Área Grasa Braquial</small>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <div class="bg-warning text-white rounded p-2">
                                                                <small class="d-block">Z-Score</small>
                                                                <strong id="zAgbDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Resumen de Indicadores -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="fas fa-clipboard-list me-2"></i>Resumen de Indicadores
                                                    </h6>
                                                    <div class="row text-center">
                                                        <div class="col-md-3">
                                                            <div class="p-2">
                                                                <small class="text-muted d-block">Peso Ideal</small>
                                                                <strong class="text-primary" id="pesoIdealDisplay">- kg</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-2">
                                                                <small class="text-muted d-block">Diferencia Peso</small>
                                                                <strong class="text-info" id="difPesoDisplay">- kg</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-2">
                                                                <small class="text-muted d-block">Edad en Medición</small>
                                                                <strong class="text-success" id="edadMesesDisplay">- meses</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="p-2">
                                                                <small class="text-muted d-block">Referencia</small>
                                                                <strong class="text-warning" id="referenciaDisplay">-</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mensaje Inicial -->
                                <div id="inicioSection" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-calculator fa-4x opacity-25"></i>
                                    </div>
                                    <h5 class="text-muted">Esperando datos para calcular</h5>
                                    <p class="text-muted">Complete los datos de medición y haga clic en "Calcular Evaluación"</p>
                                </div>

                                <!-- Mensaje de Error -->
                                <div id="errorSection" class="alert alert-danger d-none border-0">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                        <div>
                                            <h5 class="alert-heading mb-1">Error en el cálculo</h5>
                                            <span id="errorMessage" class="mb-0"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN 4: DIAGNÓSTICOS -->
                        <div class="card mb-4 border-0 shadow-sm" id="diagnosticosCard">
                            <div class="card-header bg-gradient-warning text-white py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-stethoscope me-2"></i>4. Diagnósticos Nutricionales
                                </h5>
                                <p class="mb-0 mt-1 small opacity-75">Complete los diagnósticos basados en los resultados calculados</p>
                            </div>
                            <div class="card-body">
                                <div class="row g-3" id="diagnosticosSection">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-primary">
                                            <i class="fas fa-weight me-1"></i>Diagnóstico IMC *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_imc" rows="3" placeholder="Ej: Estado nutricional normal según IMC..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-success">
                                            <i class="fas fa-ruler-vertical me-1"></i>Diagnóstico Talla *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_talla" rows="3" placeholder="Ej: Talla adecuada para la edad..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-info">
                                            <i class="fas fa-circle me-1"></i>Diagnóstico Perímetro Braquial *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_pb" rows="3" placeholder="Ej: Perímetro braquial dentro de parámetros normales..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-warning">
                                            <i class="fas fa-grip-lines me-1"></i>Diagnóstico Pliegue Tricipital *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_pct" rows="3" placeholder="Ej: Reserva de grasa subcutánea adecuada..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-info">
                                            <i class="fas fa-circle-notch me-1"></i>Diagnóstico CMB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_cmb" rows="3" placeholder="Ej: Masa muscular braquial conservada..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-success">
                                            <i class="fas fa-square me-1"></i>Diagnóstico AMB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_amb" rows="3" placeholder="Ej: Área muscular dentro de lo esperado..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-warning">
                                            <i class="fas fa-square-full me-1"></i>Diagnóstico AGB *
                                        </label>
                                        <textarea class="form-control dx-field" name="dx_z_agb" rows="3" placeholder="Ej: Área grasa braquial adecuada..." required></textarea>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-lg btn-gradient-success w-100 py-3" id="guardarBtn" disabled>
                                            <i class="fas fa-save me-2"></i>Guardar Evaluación Completa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('medidas.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                                    </a>
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

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%) !important;
}

.bg-light-primary {
    background-color: rgba(102, 126, 234, 0.1) !important;
    border-left: 4px solid #667eea !important;
}

.bg-light-info {
    background-color: rgba(79, 172, 254, 0.1) !important;
    border-left: 4px solid #4facfe !important;
}

.bg-light-success {
    background-color: rgba(67, 233, 123, 0.1) !important;
    border-left: 4px solid #43e97b !important;
}

.bg-light-warning {
    background-color: rgba(250, 112, 154, 0.1) !important;
    border-left: 4px solid #fa709a !important;
}

.btn-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border: none;
    color: white;
    font-weight: 600;
}

.btn-gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border: none;
    color: white;
    font-weight: 600;
}

.card {
    border-radius: 15px;
}

.form-control-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.dx-field {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    resize: vertical;
}

.dx-field:focus {
    border-color: #fa709a;
    box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.25);
}

.dx-field.is-valid {
    border-color: #43e97b;
    background-color: rgba(67, 233, 123, 0.05);
}

.dx-field.is-invalid {
    border-color: #fa709a;
    background-color: rgba(250, 112, 154, 0.05);
}

#diagnosticosCard, #diagnosticosSection {
    display: none;
}

.spinner-grow {
    animation-duration: 1.2s;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('medidaForm');
    const calcularBtn = document.getElementById('calcularBtn');
    const guardarBtn = document.getElementById('guardarBtn');
    const loadingSection = document.getElementById('loadingSection');
    const resultadosSection = document.getElementById('resultadosSection');
    const inicioSection = document.getElementById('inicioSection');
    const errorSection = document.getElementById('errorSection');
    const errorMessage = document.getElementById('errorMessage');
    const diagnosticosCard = document.getElementById('diagnosticosCard');
    const diagnosticosSection = document.getElementById('diagnosticosSection');
    const dxFields = document.querySelectorAll('.dx-field');

    // Elementos de resultados
    const pesoDisplay = document.getElementById('pesoDisplay');
    const tallaDisplay = document.getElementById('tallaDisplay');
    const resultadoImc = document.getElementById('resultadoImc');
    const resultadoCmb = document.getElementById('resultadoCmb');
    const resultadoAmb = document.getElementById('resultadoAmb');
    const resultadoAgb = document.getElementById('resultadoAgb');
    const pbDisplay = document.getElementById('pbDisplay');
    const pctDisplay = document.getElementById('pctDisplay');
    const zImcDisplay = document.getElementById('zImcDisplay');
    const zTallaDisplay = document.getElementById('zTallaDisplay');
    const zPbDisplay = document.getElementById('zPbDisplay');
    const zPctDisplay = document.getElementById('zPctDisplay');
    const zCmbDisplay = document.getElementById('zCmbDisplay');
    const zAmbDisplay = document.getElementById('zAmbDisplay');
    const zAgbDisplay = document.getElementById('zAgbDisplay');
    const pesoIdealDisplay = document.getElementById('pesoIdealDisplay');
    const difPesoDisplay = document.getElementById('difPesoDisplay');
    const edadMesesDisplay = document.getElementById('edadMesesDisplay');
    const referenciaDisplay = document.getElementById('referenciaDisplay');

    // Ocultar secciones inicialmente
    diagnosticosCard.style.display = 'none';
    diagnosticosSection.style.display = 'none';

    function showError(message) {
        errorMessage.textContent = message;
        errorSection.classList.remove('d-none');
        loadingSection.classList.add('d-none');
        inicioSection.classList.add('d-none');
        resultadosSection.classList.add('d-none');
        diagnosticosCard.style.display = 'none';
        diagnosticosSection.style.display = 'none';
    }

    function hideError() {
        errorSection.classList.add('d-none');
    }

    function validateBasicData() {
        let isValid = true;
        const inputs = ['fecha', 'peso_kg', 'talla_cm', 'pb_mm', 'pct_mm'];
        
        inputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            const errorElement = document.getElementById(inputId + 'Error');
            
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

        // Validación de fecha
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

    function validateDiagnostics() {
        let allFilled = true;
        
        dxFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });
        
        guardarBtn.disabled = !allFilled;
        return allFilled;
    }

    // Calcular evaluación
    calcularBtn.addEventListener('click', function() {
        if (!validateBasicData()) {
            showAlert('Por favor, complete todos los campos correctamente.', 'danger');
            return;
        }

        // Ocultar secciones
        hideError();
        loadingSection.classList.remove('d-none');
        resultadosSection.classList.add('d-none');
        inicioSection.classList.add('d-none');
        diagnosticosCard.style.display = 'none';
        diagnosticosSection.style.display = 'none';

        // Preparar datos
        const formData = new FormData();
        formData.append('paciente_id', '{{ $paciente->id }}');
        formData.append('fecha', document.getElementById('fecha').value);
        formData.append('peso_kg', document.getElementById('peso_kg').value);
        formData.append('talla_cm', document.getElementById('talla_cm').value);
        formData.append('pb_mm', document.getElementById('pb_mm').value);
        formData.append('pct_mm', document.getElementById('pct_mm').value);

        // Hacer petición
        fetch('{{ route("medidas.calcular-preview") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            loadingSection.classList.add('d-none');
            
            if (data.success) {
                // Mostrar resultados
                mostrarResultados(data.calculos);
                resultadosSection.classList.remove('d-none');
                diagnosticosCard.style.display = 'block';
                diagnosticosSection.style.display = 'block';
                hideError();
                
                // Scroll a resultados
                document.getElementById('resultadosCard').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            } else {
                showError(data.error || 'Error al calcular la evaluación');
            }
        })
        .catch(error => {
            loadingSection.classList.add('d-none');
            showError('Error de conexión: ' + error.message);
        });
    });

    function mostrarResultados(calculos) {
        console.log('Mostrando resultados:', calculos);
        
        // Mostrar valores básicos
        pesoDisplay.textContent = document.getElementById('peso_kg').value + ' kg';
        tallaDisplay.textContent = document.getElementById('talla_cm').value + ' cm';
        pbDisplay.textContent = document.getElementById('pb_mm').value + ' mm';
        pctDisplay.textContent = document.getElementById('pct_mm').value + ' mm';
        
        // Mostrar medidas derivadas
        resultadoImc.textContent = calculos.imc;
        resultadoCmb.textContent = calculos.cmb_mm;
        resultadoAmb.textContent = calculos.amb_mm2;
        resultadoAgb.textContent = calculos.agb_mm2;
        
        // Mostrar Z-Scores al lado de cada medida
        zImcDisplay.textContent = calculos.z_scores.imc;
        zTallaDisplay.textContent = calculos.z_scores.talla;
        zPbDisplay.textContent = calculos.z_scores.pb;
        zPctDisplay.textContent = calculos.z_scores.pct;
        zCmbDisplay.textContent = calculos.z_scores.cmb;
        zAmbDisplay.textContent = calculos.z_scores.amb;
        zAgbDisplay.textContent = calculos.z_scores.agb;
        
        // Mostrar resumen
        pesoIdealDisplay.textContent = calculos.peso_ideal + ' kg';
        difPesoDisplay.textContent = calculos.dif_peso + ' kg';
        edadMesesDisplay.textContent = calculos.edad_meses + ' meses';
        referenciaDisplay.textContent = calculos.edad_anios + ' años';
    }

    // Validación de diagnósticos en tiempo real
    dxFields.forEach(field => {
        field.addEventListener('input', validateDiagnostics);
    });

    // Validación al enviar formulario
    form.addEventListener('submit', function(e) {
        if (!validateDiagnostics()) {
            e.preventDefault();
            showAlert('Por favor, complete todos los diagnósticos antes de guardar.', 'warning');
            diagnosticosCard.scrollIntoView({ behavior: 'smooth' });
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
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endpush