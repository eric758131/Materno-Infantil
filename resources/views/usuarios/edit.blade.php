@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Usuario: {{ $usuario->nombre }} {{ $usuario->apellido_paterno }}
                    </h4>
                </div>

                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" id="userForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        
                        <!-- Información Personal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-id-card me-2"></i>Información Personal
                                </h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" 
                                       placeholder="Ej: Juan" required>
                                <div class="form-text">Solo letras y espacios</div>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="apellido_paterno" class="form-label">Apellido Paterno *</label>
                                <input type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" 
                                       id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" 
                                       placeholder="Ej: Pérez" required>
                                @error('apellido_paterno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="apellido_materno" class="form-label">Apellido Materno *</label>
                                <input type="text" class="form-control @error('apellido_materno') is-invalid @enderror" 
                                       id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" 
                                       placeholder="Ej: González" required>
                                @error('apellido_materno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ci" class="form-label">Cédula de Identidad *</label>
                                <input type="text" class="form-control @error('ci') is-invalid @enderror" 
                                       id="ci" name="ci" value="{{ old('ci', $usuario->ci) }}" 
                                       placeholder="Ej: 12345678" required>
                                <div class="form-text">Solo números, sin puntos ni guiones</div>
                                @error('ci')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       id="fecha_nacimiento" name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}"
                                       max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                                <div class="form-text">Debe ser mayor de 18 años</div>
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('genero', $usuario->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero', $usuario->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero', $usuario->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                    <option value="activo" {{ old('estado', $usuario->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $usuario->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-address-book me-2"></i>Información de Contacto
                                </h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $usuario->email) }}" 
                                       placeholder="Ej: juan@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" 
                                       placeholder="Ej: +59171234567">
                                <div class="form-text">Solo números y el signo +</div>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" name="direccion" rows="2" 
                                          placeholder="Ej: Av. Principal #123">{{ old('direccion', $usuario->direccion) }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Seguridad y Roles -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-shield-alt me-2"></i>Seguridad y Roles
                                </h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       placeholder="Dejar en blanco para mantener la actual">
                                <div class="form-text">Mínimo 8 caracteres</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirmar nueva contraseña">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Roles *</label>
                                @error('roles')
                                    <div class="alert alert-danger py-2">{{ $message }}</div>
                                @enderror
                                <div class="row">
                                    @foreach($roles as $role)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->name }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->name, old('roles', $usuario->roles->pluck('name')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                <span class="badge bg-{{ in_array($role->name, $usuario->roles->pluck('name')->toArray()) ? 'primary' : 'secondary' }}">
                                                    {{ $role->name }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-text">Seleccione al menos un rol</div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-info-circle me-2"></i>Información del Sistema
                                        </h6>
                                        <div class="row text-sm">
                                            <div class="col-md-4">
                                                <strong>Creado:</strong> 
                                                {{ $usuario->created_at->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Actualizado:</strong> 
                                                {{ $usuario->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-1"></i> Ver Detalles
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i> Actualizar Usuario
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real para campos de texto (solo letras)
    const textFields = ['nombre', 'apellido_paterno', 'apellido_materno'];
    textFields.forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            });
        }
    });

    // Validación para CI (solo números)
    const ciField = document.getElementById('ci');
    if (ciField) {
        ciField.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // Validación para teléfono
    const telefonoField = document.getElementById('telefono');
    if (telefonoField) {
        telefonoField.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    // Cambiar color de badges cuando se seleccionan roles
    const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
    roleCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const badge = this.parentElement.querySelector('.badge');
            if (this.checked) {
                badge.classList.remove('bg-secondary');
                badge.classList.add('bg-primary');
            } else {
                badge.classList.remove('bg-primary');
                badge.classList.add('bg-secondary');
            }
        });
    });
});
</script>
@endpush