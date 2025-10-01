@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-users me-2"></i>Gestión de Usuarios
                    </h4>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Usuario
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros Mejorados -->
                    <div class="row mb-4">
                        <div class="col-md-10">
                            <form action="{{ route('usuarios.index') }}" method="GET" class="row g-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control border-start-0" 
                                               placeholder="Buscar por nombre, apellidos, email, cédula..."
                                               value="{{ request('search') }}"
                                               id="searchInput">
                                        <button class="btn btn-outline-primary" type="submit" id="searchButton">
                                            Buscar
                                        </button>
                                        @if(request('search'))
                                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        @endif
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Puedes buscar por: nombre, apellidos, email o cédula. 
                                    </small>
                                </div>
                                <div class="col-md-3">
                                    <select name="estado" class="form-select" onchange="this.form.submit()">
                                        <option value="">Todos los estados</option>
                                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Alertas -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Indicador de búsqueda -->
                    @if(request('search'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-search me-2"></i>
                                <strong>Resultados de búsqueda para:</strong> "{{ request('search') }}"
                                @if(request('estado'))
                                <span class="ms-2">
                                    <strong>Estado:</strong> {{ request('estado') == 'activo' ? 'Activo' : 'Inactivo' }}
                                </span>
                                @endif
                            </div>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Tabla de usuarios -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>CI</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3">
                                                {{ substr($user->nombre, 0, 1) }}{{ substr($user->apellido_paterno, 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $user->nombre }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->ci }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-info me-1">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->telefono ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->estado == 'activo' ? 'success' : 'secondary' }}">
                                            <i class="fas fa-{{ $user->estado == 'activo' ? 'check' : 'pause' }} me-1"></i>
                                            {{ ucfirst($user->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('usuarios.show', $user) }}" class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($user->id !== auth()->id() && !$user->hasRole('SuperAdmin'))
                                                <form action="{{ route('usuarios.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn {{ $user->estado == 'activo' ? 'btn-outline-danger' : 'btn-success' }}" 
                                                            title="{{ $user->estado == 'activo' ? 'Desactivar' : 'Activar' }}"
                                                            onclick="return confirm('¿Está seguro de {{ $user->estado == 'activo' ? 'desactivar' : 'activar' }} este usuario?')">
                                                        <i class="fas {{ $user->estado == 'activo' ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-outline-secondary" disabled title="{{ $user->hasRole('SuperAdmin') ? 'No se puede modificar SuperAdmin' : 'No puedes modificar tu propio usuario' }}">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        @if(request('search'))
                                            <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No se encontraron usuarios que coincidan con tu búsqueda</p>
                                            <a href="{{ route('usuarios.index') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-redo me-1"></i> Ver todos los usuarios
                                            </a>
                                        @else
                                            <i class="fas fa-users fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">No se encontraron usuarios</p>
                                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i> Crear primer usuario
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Contador de resultados -->
                    <div class="mt-3 text-muted d-flex justify-content-between align-items-center">
                        <small>Mostrando {{ $users->count() }} usuario(s)</small>
                        @if(request('search') && $users->count() > 0)
                        <small>
                            <i class="fas fa-lightbulb me-1 text-warning"></i>
                            Búsqueda flexible activada
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
    font-weight: bold;
}

.btn-group-sm .btn {
    border-radius: 0.375rem;
    margin-right: 2px;
}

.btn-group-sm .btn:last-child {
    margin-right: 0;
}

.badge {
    font-size: 0.75em;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

#searchInput:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
// Opcional: Búsqueda en tiempo real con AJAX
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    
    // Opcional: Buscar al presionar Enter
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchButton.click();
            }
        });
    }
});
</script>
@endsection