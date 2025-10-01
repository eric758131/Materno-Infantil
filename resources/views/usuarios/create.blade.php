@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Crear Nuevo Usuario
                    </h4>
                </div>

                <form action="{{ route('usuarios.store') }}" method="POST" id="userForm">
                    @csrf
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
                                       id="nombre" name="nombre" value="{{ old('nombre') }}" 
                                       placeholder="Ej: Juan" required maxlength="100">
                                <div class="form-text">Solo letras y espacios</div>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="apellido_paterno" class="form-label">Apellido Paterno *</label>
                                <input type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" 
                                       id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno') }}" 
                                       placeholder="Ej: Pérez" required maxlength="100">
                                @error('apellido_paterno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="apellido_materno" class="form-label">Apellido Materno *</label>
                                <input type="text" class="form-control @error('apellido_materno') is-invalid @enderror" 
                                       id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno') }}" 
                                       placeholder="Ej: González" required maxlength="100">
                                @error('apellido_materno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ci" class="form-label">Cédula de Identidad *</label>
                                <input type="text" class="form-control @error('ci') is-invalid @enderror" 
                                       id="ci" name="ci" value="{{ old('ci') }}" 
                                       placeholder="Ej: 12345678" required minlength="5" maxlength="15">
                                <div class="form-text">Solo números, sin puntos ni guiones</div>
                                @error('ci')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                                <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                                       max="{{ date('Y-m-d', strtotime('-18 years')) }}" required>
                                <div class="form-text">Debe ser mayor de 18 años</div>
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label">Género *</label>
                                <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('genero')
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
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Ej: juan@example.com" required maxlength="255">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" name="telefono" value="{{ old('telefono') }}" 
                                       placeholder="Ej: +59171234567" required minlength="8" maxlength="15">
                                <div class="form-text">Solo números y el signo +</div>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="direccion" class="form-label">Dirección *</label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" name="direccion" rows="2" 
                                          placeholder="Ej: Av. Principal #123" required maxlength="255">{{ old('direccion') }}</textarea>
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
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required minlength="8">
                                <div class="form-text">Mínimo 8 caracteres</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required minlength="8">
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
                                            <input class="form-check-input role-checkbox" type="checkbox" 
                                                   name="roles[]" value="{{ $role->name }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                <span class="badge bg-secondary">{{ $role->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-text">Puede seleccionar uno o varios roles</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Guardar Usuario
                            </button>
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
    const form = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitBtn');
    const roleCheckboxes = document.querySelectorAll('.role-checkbox');

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

    // Validación antes de enviar el formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        // Verificar que todos los campos requeridos estén llenos
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Verificar que al menos un rol esté seleccionado
        const selectedRoles = Array.from(roleCheckboxes).filter(checkbox => checkbox.checked);
        if (selectedRoles.length === 0) {
            isValid = false;
            // Agregar clase de error al contenedor de roles
            const rolesContainer = document.querySelector('.role-checkbox').closest('.col-12');
            rolesContainer.classList.add('border', 'border-danger', 'rounded', 'p-3');
        } else {
            const rolesContainer = document.querySelector('.role-checkbox').closest('.col-12');
            rolesContainer.classList.remove('border', 'border-danger', 'rounded', 'p-3');
        }

        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos y seleccione al menos un rol.');
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
        }
    });

    // Feedback visual para roles
    roleCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const selectedRoles = Array.from(roleCheckboxes).filter(cb => cb.checked);
            const rolesContainer = this.closest('.col-12');
            
            if (selectedRoles.length > 0) {
                rolesContainer.classList.remove('border', 'border-danger', 'rounded', 'p-3');
            }
        });
    });
});
</script>
@endpush