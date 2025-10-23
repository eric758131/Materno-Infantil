@extends('layouts.app')

@section('title', 'Moléculas Calóricas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Moléculas Calóricas</h3>
                    <div class="card-tools">
                        <a href="{{ route('molecula_calorica.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar Nueva Molécula Calórica
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Formulario de Búsqueda y Filtros -->
                    <form method="GET" action="{{ route('molecula_calorica.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar por nombre, apellido o CI..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="estado" class="form-control">
                                        <option value="">Todos los estados</option>
                                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de Moléculas Calóricas -->
                    @if($moleculasCaloricas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>CI</th>
                                    <th>Peso (kg)</th>
                                    <th>Kcal Totales</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moleculasCaloricas as $molecula)
                                <tr>
                                    <td>{{ $molecula->paciente->nombre_completo ?? 'N/A' }}</td>
                                    <td>{{ $molecula->paciente->CI ?? 'N/A' }}</td>
                                    <td>{{ number_format($molecula->peso_kg, 2) }}</td>
                                    <td>{{ number_format($molecula->kilocalorías_totales, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $molecula->estado == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($molecula->estado) }}
                                        </span>
                                    </td>
                                    <td>{{ $molecula->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <!-- BOTÓN CORREGIDO: Ver Historial Completo -->
                                            <a href="{{ route('molecula_calorica.show', $molecula->paciente_id) }}" 
                                               class="btn btn-info btn-sm" title="Ver Historial Completo">
                                                <i class="fas fa-history"></i> Historial
                                            </a>
                                            
                                            <!-- Botón para agregar nueva molécula para este paciente -->
                                            <a href="{{ route('molecula_calorica.create', ['paciente_id' => $molecula->paciente_id]) }}" 
                                               class="btn btn-success btn-sm" title="Agregar Nueva Molécula">
                                                <i class="fas fa-plus-circle"></i> Nueva
                                            </a>
                                            
                                            <!-- Botón para activar/desactivar -->
                                            <form action="{{ route('molecula_calorica.toggle_estado', $molecula->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-{{ $molecula->estado == 'activo' ? 'warning' : 'success' }} btn-sm"
                                                        title="{{ $molecula->estado == 'activo' ? 'Desactivar' : 'Activar' }}">
                                                    <i class="fas fa-{{ $molecula->estado == 'activo' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        <h5>No se encontraron moléculas calóricas</h5>
                        <p>No hay registros que coincidan con los criterios de búsqueda.</p>
                        <a href="{{ route('molecula_calorica.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar la Primera Molécula Calórica
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit del formulario cuando cambie el filtro de estado
    document.querySelector('select[name="estado"]').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endsection