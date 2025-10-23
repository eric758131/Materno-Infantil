@extends('layouts.app')

@section('title', 'Editar Molécula Calórica')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Molécula Calórica</h3>
                    <a href="{{ route('molecula_calorica.show', $moleculaCalorica->paciente_id) }}" 
                       class="btn btn-default float-right">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <form action="{{ route('molecula_calorica.update', $moleculaCalorica->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Información del Paciente -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5>Información del Paciente</h5>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Paciente:</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $moleculaCalorica->paciente->nombre_completo ?? 'N/A' }}" readonly>
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
                                    <label for="peso_kg">Peso (kg) *</label>
                                    <input type="number" step="0.01" min="0.1" max="500" 
                                           class="form-control @error('peso_kg') is-invalid @enderror" 
                                           id="peso_kg" name="peso_kg" 
                                           value="{{ old('peso_kg', $moleculaCalorica->peso_kg) }}" required>
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
                                        <option value="activo" {{ old('estado', $moleculaCalorica->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ old('estado', $moleculaCalorica->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                                           value="{{ old('proteínas_g_kg', $moleculaCalorica->proteínas_g_kg) }}" required>
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
                                           value="{{ old('grasa_g_kg', $moleculaCalorica->grasa_g_kg) }}" required>
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
                                           value="{{ old('carbohidratos_g_kg', $moleculaCalorica->carbohidratos_g_kg) }}" required>
                                    @error('carbohidratos_g_kg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cálculos Actuales -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Cálculos Actuales</h5>
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-bolt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Proteínas</span>
                                        <span class="info-box-number">{{ number_format($moleculaCalorica->kilocalorías_proteínas, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-fire"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Grasas</span>
                                        <span class="info-box-number">{{ number_format($moleculaCalorica->kilocalorías_grasas, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-wheat"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kcal Carbohidratos</span>
                                        <span class="info-box-number">{{ number_format($moleculaCalorica->kilocalorías_carbohidratos, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Kcal</span>
                                        <span class="info-box-number">{{ number_format($moleculaCalorica->kilocalorías_totales, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Molécula Calórica
                        </button>
                        <a href="{{ route('molecula_calorica.show', $moleculaCalorica->paciente_id) }}" 
                           class="btn btn-default">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection