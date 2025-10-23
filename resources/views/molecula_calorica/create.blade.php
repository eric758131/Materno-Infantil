@extends('layouts.app')

@section('title', 'Crear Molécula Calórica')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear Nueva Molécula Calórica</h3>
                    <a href="{{ route('molecula_calorica.index') }}" class="btn btn-default float-right">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <form action="{{ route('molecula_calorica.store') }}" method="POST">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Información del Paciente -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Información del Paciente</h5>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Paciente:</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $paciente->nombre_completo ?? 'N/A' }}" readonly>
                                    <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Peso Más Reciente (kg):</label>
                                    <input type="text" class="form-control" 
                                           value="{{ number_format($ultimoPeso, 2) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de la Molécula Calórica -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Datos de la Molécula Calórica</h5>
                                <hr>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="peso_kg">Peso Actual (kg) *</label>
                                    <input type="number" step="0.01" min="0.1" max="500" 
                                           class="form-control @error('peso_kg') is-invalid @enderror" 
                                           id="peso_kg" name="peso_kg" 
                                           value="{{ old('peso_kg', $ultimoPeso) }}" required>
                                    @error('peso_kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado *</label>
                                    <select class="form-control @error('estado') is-invalid @enderror" 
                                            id="estado" name="estado" required>
                                        <option value="">Seleccionar Estado</option>
                                        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proteínas_g_kg">Proteínas (g/Kg) *</label>
                                    <input type="number" step="0.01" min="0" max="50" 
                                           class="form-control @error('proteínas_g_kg') is-invalid @enderror" 
                                           id="proteínas_g_kg" name="proteínas_g_kg" 
                                           value="{{ old('proteínas_g_kg') }}" required>
                                    @error('proteínas_g_kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="grasa_g_kg">Grasas (g/Kg) *</label>
                                    <input type="number" step="0.01" min="0" max="50" 
                                           class="form-control @error('grasa_g_kg') is-invalid @enderror" 
                                           id="grasa_g_kg" name="grasa_g_kg" 
                                           value="{{ old('grasa_g_kg') }}" required>
                                    @error('grasa_g_kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="carbohidratos_g_kg">Carbohidratos (g/Kg) *</label>
                                    <input type="number" step="0.01" min="0" max="50" 
                                           class="form-control @error('carbohidratos_g_kg') is-invalid @enderror" 
                                           id="carbohidratos_g_kg" name="carbohidratos_g_kg" 
                                           value="{{ old('carbohidratos_g_kg') }}" required>
                                    @error('carbohidratos_g_kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cálculos Automáticos (solo visual) -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Cálculos Estimados</h5>
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-bolt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Proteínas</span>
                                        <span class="info-box-number" id="kcal-proteinas">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-fire"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Grasas</span>
                                        <span class="info-box-number" id="kcal-grasas">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-wheat"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Carbohidratos</span>
                                        <span class="info-box-number" id="kcal-carbohidratos">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Kcal</span>
                                        <span class="info-box-number" id="kcal-totales">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Molécula Calórica
                        </button>
                        <a href="{{ route('molecula_calorica.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function calcularKilocalorias() {
        const peso = parseFloat(document.getElementById('peso_kg').value) || 0;
        const proteinas = parseFloat(document.getElementById('proteínas_g_kg').value) || 0;
        const grasas = parseFloat(document.getElementById('grasa_g_kg').value) || 0;
        const carbohidratos = parseFloat(document.getElementById('carbohidratos_g_kg').value) || 0;

        const kcalProteinas = proteinas * peso * 4;
        const kcalGrasas = grasas * peso * 9;
        const kcalCarbohidratos = carbohidratos * peso * 4;
        const kcalTotales = kcalProteinas + kcalGrasas + kcalCarbohidratos;

        document.getElementById('kcal-proteinas').textContent = kcalProteinas.toFixed(2);
        document.getElementById('kcal-grasas').textContent = kcalGrasas.toFixed(2);
        document.getElementById('kcal-carbohidratos').textContent = kcalCarbohidratos.toFixed(2);
        document.getElementById('kcal-totales').textContent = kcalTotales.toFixed(2);
    }

    // Calcular cuando cambien los inputs
    document.getElementById('peso_kg').addEventListener('input', calcularKilocalorias);
    document.getElementById('proteínas_g_kg').addEventListener('input', calcularKilocalorias);
    document.getElementById('grasa_g_kg').addEventListener('input', calcularKilocalorias);
    document.getElementById('carbohidratos_g_kg').addEventListener('input', calcularKilocalorias);

    // Calcular al cargar la página
    document.addEventListener('DOMContentLoaded', calcularKilocalorias);
</script>
@endsection