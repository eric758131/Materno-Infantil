@extends('layouts.app')

@section('title', 'Gestión de Pacientes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Lista de Pacientes</h3>
                        <a href="{{ route('pacientes.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nuevo Paciente
                        </a>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="card-body border-bottom">
                    <form action="{{ route('pacientes.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Buscar por nombre, apellido o CI..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="genero" class="form-select">
                                <option value="">Todos los géneros</option>
                                <option value="masculino" {{ request('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ request('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ request('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="estado" class="form-select">
                                <option value="activo" {{ request('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activos</option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-refresh"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Tabla de pacientes -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>CI</th>
                                    <th>Nombre Completo</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Género</th>
                                    <th>Tutor</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pacientes as $paciente)
                                    <tr>
                                        <td class="fw-bold">{{ $paciente->CI }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $paciente->nombre_completo }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">
                                                ({{ $paciente->fecha_nacimiento->age }} años)
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $generoColors = [
                                                    'masculino' => 'primary',
                                                    'femenino' => 'pink',
                                                    'otro' => 'secondary'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $generoColors[$paciente->genero] ?? 'secondary' }}">
                                                {{ ucfirst($paciente->genero) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($paciente->tutor)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $paciente->tutor->nombre_completo }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $paciente->tutor->parentesco }} • {{ $paciente->tutor->CI }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Sin tutor</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $paciente->estado == 'activo' ? 'success' : 'danger' }}">
                                                {{ ucfirst($paciente->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pacientes.show', $paciente) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pacientes.edit', $paciente) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('pacientes.estado', $paciente) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-{{ $paciente->estado == 'activo' ? 'danger' : 'success' }} btn-sm"
                                                            title="{{ $paciente->estado == 'activo' ? 'Desactivar' : 'Activar' }}"
                                                            onclick="return confirm('¿Estás seguro de {{ $paciente->estado == 'activo' ? 'desactivar' : 'activar' }} este paciente?')">
                                                        <i class="fas fa-{{ $paciente->estado == 'activo' ? 'times' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-search fa-2x mb-3"></i>
                                                <h5>No se encontraron pacientes</h5>
                                                <p>No hay pacientes que coincidan con los criterios de búsqueda.</p>
                                                @if(request()->hasAny(['search', 'genero', 'estado']))
                                                    <a href="{{ route('pacientes.index') }}" class="btn btn-primary">
                                                        Ver todos los pacientes
                                                    </a>
                                                @else
                                                    <a href="{{ route('pacientes.create') }}" class="btn btn-success">
                                                        <i class="fas fa-plus"></i> Crear primer paciente
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                @if($pacientes->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Mostrando {{ $pacientes->firstItem() }} - {{ $pacientes->lastItem() }} de {{ $pacientes->total() }} registros
                            </div>
                            <div>
                                {{ $pacientes->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge.bg-pink {
        background-color: #e83e8c !important;
        color: white;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }
</style>
@endsection

@section('scripts')
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Entendido'
        });
    </script>
@endif
@endsection