@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Lista de Pacientes</h1>
            <p class="text-muted">Seleccione un paciente para registrar nuevas medidas</p>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('medidas.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Buscar paciente</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nombre, apellido o CI...">
                    </div>
                    <div class="col-md-4">
                        <label for="genero" class="form-label">Género</label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="">Todos</option>
                            <option value="masculino" {{ request('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ request('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de pacientes -->
    <div class="card">
        <div class="card-body">
            @if($pacientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>CI</th>
                                <th>Nombre Completo</th>
                                <th>Género</th>
                                <th>Fecha Nacimiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientes as $paciente)
                                <tr>
                                    <td>{{ $paciente->CI }}</td>
                                    <td>{{ $paciente->nombre_completo }}</td>
                                    <td>
                                        <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                            {{ ucfirst($paciente->genero) }}
                                        </span>
                                    </td>
                                    <td>{{ $paciente->fecha_nacimiento->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('medidas.create', $paciente) }}" 
                                           class="btn btn-success btn-sm">
                                           <i class="fas fa-plus"></i> Nueva Medida
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pacientes->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h4>No se encontraron pacientes</h4>
                    <p class="text-muted">No hay pacientes que coincidan con los criterios de búsqueda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .badge {
        font-size: 0.8em;
    }
</style>
@endpush