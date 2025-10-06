@extends('layouts.app')

@section('title', 'Detalles del Paciente')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user me-2"></i>Detalles del Paciente
                        </h4>
                        <div>
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <a href="{{ route('pacientes.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Información del Paciente -->
                    <div class="section-patient mb-4">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-user me-2"></i>Datos del Paciente
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Nombre Completo</label>
                                <p class="form-control-static">{{ $paciente->nombre_completo }}</p>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Cédula de Identidad</label>
                                <p class="form-control-static">{{ $paciente->CI }}</p>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Fecha de Nacimiento</label>
                                <p class="form-control-static">
                                    {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">({{ $paciente->fecha_nacimiento->age }} años)</small>
                                </p>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Género</label>
                                <p class="form-control-static">
                                    <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : 'pink' }}">
                                        {{ ucfirst($paciente->genero) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Estado</label>
                                <p class="form-control-static">
                                    <span class="badge bg-{{ $paciente->estado == 'activo' ? 'success' : 'danger' }}">
                                        {{ ucfirst($paciente->estado) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Fecha de Registro</label>
                                <p class="form-control-static">
                                    {{ $paciente->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold text-primary">Última Actualización</label>
                                <p class="form-control-static">
                                    {{ $paciente->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <!-- Información del Tutor -->
                    <div class="section-tutor">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-users me-2"></i>Datos del Tutor
                        </h5>

                        @if($paciente->tutor)
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Nombre Completo</label>
                                    <p class="form-control-static">{{ $paciente->tutor->nombre_completo }}</p>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Cédula de Identidad</label>
                                    <p class="form-control-static">{{ $paciente->tutor->CI }}</p>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Parentesco</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-success">
                                            {{ ucfirst($paciente->tutor->parentesco) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Teléfono</label>
                                    <p class="form-control-static">
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        {{ $paciente->tutor->telefono }}
                                    </p>
                                </div>
                                
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold text-success">Dirección</label>
                                    <p class="form-control-static">
                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                        {{ $paciente->tutor->direccion }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Estado del Tutor</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-{{ $paciente->tutor->estado == 'activo' ? 'success' : 'danger' }}">
                                            {{ ucfirst($paciente->tutor->estado) }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-success">Fecha de Registro</label>
                                    <p class="form-control-static">
                                        {{ $paciente->tutor->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No se ha asignado un tutor para este paciente.
                            </div>
                        @endif
                    </div>

                    <!-- Acciones -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <form action="{{ route('pacientes.estado', $paciente) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-{{ $paciente->estado == 'activo' ? 'danger' : 'success' }}"
                                            onclick="return confirm('¿Estás seguro de {{ $paciente->estado == 'activo' ? 'desactivar' : 'activar' }} este paciente?')">
                                        <i class="fas fa-{{ $paciente->estado == 'activo' ? 'times' : 'check' }} me-2"></i>
                                        {{ $paciente->estado == 'activo' ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-list me-2"></i>Ver Todos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pacientes.css') }}">
<style>
.form-control-static {
    padding: 0.5rem 0;
    margin-bottom: 0;
    font-size: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.badge.bg-pink {
    background-color: #e83e8c !important;
    color: white;
}

.btn-group .btn {
    margin-right: 0.5rem;
    border-radius: 8px;
}
</style>
@endsection