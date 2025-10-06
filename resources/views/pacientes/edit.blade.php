@extends('layouts.app')

@section('title', 'Editar Paciente')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Editar Paciente: {{ $paciente->nombre_completo }}
                        </h4>
                        <a href="{{ route('pacientes.index') }}" class="btn btn-dark btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pacientes.update', $paciente) }}" method="POST" id="pacienteForm" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Datos del Paciente -->
                        <div class="section-patient">
                            <h5 class="section-title">
                                <i class="fas fa-user me-2"></i>Datos del Paciente
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" id="nombre" 
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $paciente->nombre) }}" 
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el nombre.</div>
                                    @error('nombre')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="apellido_paterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" name="apellido_paterno" id="apellido_paterno" 
                                           class="form-control @error('apellido_paterno') is-invalid @enderror" 
                                           value="{{ old('apellido_paterno', $paciente->apellido_paterno) }}"
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el apellido paterno.</div>
                                    @error('apellido_paterno')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="apellido_materno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                                    <input type="text" name="apellido_materno" id="apellido_materno" 
                                           class="form-control @error('apellido_materno') is-invalid @enderror" 
                                           value="{{ old('apellido_materno', $paciente->apellido_materno) }}"
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el apellido materno.</div>
                                    @error('apellido_materno')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="CI" class="form-label">Cédula de Identidad <span class="text-danger">*</span></label>
                                    <input type="text" name="CI" id="CI" 
                                           class="form-control @error('CI') is-invalid @enderror" 
                                           value="{{ old('CI', $paciente->CI) }}"
                                           pattern="^[0-9]+$"
                                           maxlength="20"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten números en la cédula de identidad.</div>
                                    @error('CI')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                           class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                           value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    <div class="invalid-feedback">La fecha de nacimiento no puede ser futura.</div>
                                    @error('fecha_nacimiento')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="genero" class="form-label">Género <span class="text-danger">*</span></label>
                                    <select name="genero" id="genero" 
                                            class="form-select @error('genero') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="masculino" {{ old('genero', $paciente->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('genero', $paciente->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    @error('genero')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <!-- Datos del Tutor -->
                        <div class="section-tutor">
                            <h5 class="section-title">
                                <i class="fas fa-users me-2"></i>Datos del Tutor
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="tutor_nombre" class="form-label">Nombre del Tutor <span class="text-danger">*</span></label>
                                    <input type="text" name="tutor_nombre" id="tutor_nombre" 
                                           class="form-control @error('tutor_nombre') is-invalid @enderror" 
                                           value="{{ old('tutor_nombre', $paciente->tutor->nombre ?? '') }}"
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el nombre del tutor.</div>
                                    @error('tutor_nombre')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tutor_apellido_paterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" name="tutor_apellido_paterno" id="tutor_apellido_paterno" 
                                           class="form-control @error('tutor_apellido_paterno') is-invalid @enderror" 
                                           value="{{ old('tutor_apellido_paterno', $paciente->tutor->apellido_paterno ?? '') }}"
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el apellido paterno del tutor.</div>
                                    @error('tutor_apellido_paterno')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tutor_apellido_materno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                                    <input type="text" name="tutor_apellido_materno" id="tutor_apellido_materno" 
                                           class="form-control @error('tutor_apellido_materno') is-invalid @enderror" 
                                           value="{{ old('tutor_apellido_materno', $paciente->tutor->apellido_materno ?? '') }}"
                                           pattern="^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten letras y espacios en el apellido materno del tutor.</div>
                                    @error('tutor_apellido_materno')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tutor_CI" class="form-label">CI del Tutor <span class="text-danger">*</span></label>
                                    <input type="text" name="tutor_CI" id="tutor_CI" 
                                           class="form-control @error('tutor_CI') is-invalid @enderror" 
                                           value="{{ old('tutor_CI', $paciente->tutor->CI ?? '') }}"
                                           pattern="^[0-9]+$"
                                           maxlength="20"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten números en la cédula del tutor.</div>
                                    @error('tutor_CI')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tutor_telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" name="tutor_telefono" id="tutor_telefono" 
                                           class="form-control @error('tutor_telefono') is-invalid @enderror" 
                                           value="{{ old('tutor_telefono', $paciente->tutor->telefono ?? '') }}"
                                           pattern="^[0-9+\-\s]+$"
                                           maxlength="15"
                                           required>
                                    <div class="invalid-feedback">Solo se permiten números, espacios, guiones y el signo +.</div>
                                    @error('tutor_telefono')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tutor_parentesco" class="form-label">Parentesco <span class="text-danger">*</span></label>
                                    <select name="tutor_parentesco" id="tutor_parentesco" 
                                            class="form-select @error('tutor_parentesco') is-invalid @enderror" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="madre" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'madre' ? 'selected' : '' }}>Madre</option>
                                        <option value="padre" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'padre' ? 'selected' : '' }}>Padre</option>
                                        <option value="tutor legal" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'tutor legal' ? 'selected' : '' }}>Tutor Legal</option>
                                        <option value="abuelo" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'abuelo' ? 'selected' : '' }}>Abuelo</option>
                                        <option value="abuela" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'abuela' ? 'selected' : '' }}>Abuela</option>
                                        <option value="otro" {{ old('tutor_parentesco', $paciente->tutor->parentesco ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('tutor_parentesco')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="tutor_direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                                    <textarea name="tutor_direccion" id="tutor_direccion" 
                                              class="form-control @error('tutor_direccion') is-invalid @enderror" 
                                              rows="2"
                                              required>{{ old('tutor_direccion', $paciente->tutor->direccion ?? '') }}</textarea>
                                    @error('tutor_direccion')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-save me-2"></i>Actualizar Paciente
                                </button>
                                <a href="{{ route('pacientes.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pacientes.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/pacientes.js') }}"></script>
@endsection