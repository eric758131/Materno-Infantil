@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Lista de Pacientes</h1>
            <p class="text-muted">Seleccione un paciente para registrar nuevas medidas o ver evaluaciones existentes</p>
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
                        <button type="submit" class="btn btn-primary w-100 me-2">Filtrar</button>
                        <a href="{{ route('medidas.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
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
                                <th>Edad</th>
                                <th>Última Medida</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientes as $paciente)
                                @php
                                    $ultimaMedida = $paciente->medidas()->latest()->first();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $paciente->CI }}</strong>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $paciente->nombre_completo }}</div>
                                        @if($ultimaMedida)
                                            <small class="text-muted">
                                                Última evaluación: {{ $ultimaMedida->fecha->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                            {{ ucfirst($paciente->genero) }}
                                        </span>
                                    </td>
                                    <td>{{ $paciente->fecha_nacimiento->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $paciente->fecha_nacimiento->age }} años
                                        </span>
                                    </td>
                                    <td>
                                        @if($ultimaMedida)
                                            <span class="badge bg-light text-dark">
                                                {{ $ultimaMedida->fecha->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sin medidas</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Botón para nueva medida -->
                                            <a href="{{ route('medidas.create', $paciente) }}" 
                                               class="btn btn-success btn-sm" 
                                               data-bs-toggle="tooltip" 
                                               title="Registrar nueva medida">
                                               <i class="fas fa-plus"></i>
                                               <span class="d-none d-md-inline"> Nueva</span>
                                            </a>

                                            <!-- Botón para ver evaluaciones existentes -->
                                            @if($ultimaMedida)
                                                <a href="{{ route('medidas.show', $ultimaMedida->id) }}" 
                                                   class="btn btn-primary btn-sm"
                                                   data-bs-toggle="tooltip"
                                                   title="Ver última evaluación">
                                                   <i class="fas fa-chart-line"></i>
                                                   <span class="d-none d-md-inline"> Evaluar</span>
                                                </a>
                                            @else
                                                <button class="btn btn-outline-secondary btn-sm" disabled
                                                        data-bs-toggle="tooltip" 
                                                        title="No hay medidas registradas">
                                                    <i class="fas fa-chart-line"></i>
                                                    <span class="d-none d-md-inline"> Evaluar</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $pacientes->firstItem() }} - {{ $pacientes->lastItem() }} de {{ $pacientes->total() }} pacientes
                    </div>
                    <div>
                        {{ $pacientes->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4>No se encontraron pacientes</h4>
                    <p class="text-muted mb-4">No hay pacientes que coincidan con los criterios de búsqueda.</p>
                    <a href="{{ route('medidas.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-2"></i>Ver todos los pacientes
                    </a>
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
        font-weight: 600;
    }
    .badge {
        font-size: 0.75em;
    }
    .btn-group .btn {
        border-radius: 0.375rem;
        margin-right: 0.25rem;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush