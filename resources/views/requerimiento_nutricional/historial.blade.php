@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Historial de Requerimientos - {{ $paciente->nombre_completo }}</h1>
            <p class="text-muted">Historial de cálculos de requerimientos nutricionales</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('requerimiento_nutricional.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Pacientes
            </a>
            <a href="{{ route('requerimiento_nutricional.create', ['paciente_id' => $paciente->id]) }}" 
               class="btn btn-primary">
                <i class="fas fa-calculator"></i> Nuevo Cálculo
            </a>
        </div>
    </div>

    <!-- Resumen del Paciente -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>CI:</strong> {{ $paciente->CI }}
                        </div>
                        <div class="col-md-3">
                            <strong>Género:</strong> {{ ucfirst($paciente->genero) }}
                        </div>
                        <div class="col-md-3">
                            <strong>Fecha Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total Requerimientos:</strong> {{ $requerimientos->total() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($requerimientos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha Cálculo</th>
                                <th>Peso (kg)</th>
                                <th>Talla (cm)</th>
                                <th>GEB (kcal)</th>
                                <th>GET (kcal)</th>
                                <th>Kcal/kg</th>
                                <th>Estado</th>
                                <th>Registrado por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requerimientos as $requerimiento)
                                <tr>
                                    <td>
                                        <strong>{{ $requerimiento->calculado_en->format('d/m/Y H:i') }}</strong>
                                        @if($requerimiento->estado == 'activo')
                                            <span class="badge bg-success ms-1">ACTUAL</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($requerimiento->peso_kg_at, 2) }}</td>
                                    <td>{{ number_format($requerimiento->talla_cm_at, 2) }}</td>
                                    <td>{{ number_format($requerimiento->geb_kcal, 2) }}</td>
                                    <td>{{ number_format($requerimiento->get_kcal, 2) }}</td>
                                    <td>{{ number_format($requerimiento->kcal_por_kg, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $requerimiento->estado == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($requerimiento->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($requerimiento->registradoPor)
                                            {{ $requerimiento->registradoPor->nombre_completo }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('requerimiento_nutricional.show', $requerimiento) }}" 
                                               class="btn btn-info" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('requerimiento_nutricional.edit', $requerimiento) }}" 
                                               class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Botón Activar/Desactivar -->
                                            @if($requerimiento->estado == 'activo')
                                                <form action="{{ route('requerimiento_nutricional.cambiar-estado', $requerimiento) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="inactivo">
                                                    <button type="submit" class="btn btn-secondary" 
                                                            title="Desactivar"
                                                            onclick="return confirm('¿Desactivar este requerimiento?')">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('requerimiento_nutricional.cambiar-estado', $requerimiento) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="activo">
                                                    <button type="submit" class="btn btn-success" 
                                                            title="Activar"
                                                            onclick="return confirm('¿Activar este requerimiento?')">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Botón Eliminar -->
                                            <form action="{{ route('requerimiento_nutricional.destroy', $requerimiento) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este requerimiento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                        Mostrando {{ $requerimientos->firstItem() }} - {{ $requerimientos->lastItem() }} de {{ $requerimientos->total() }} registros
                    </div>
                    <div>
                        {{ $requerimientos->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calculator fa-3x text-muted mb-3"></i>
                    <h4>No hay requerimientos registrados</h4>
                    <p class="text-muted">Este paciente no tiene cálculos de requerimientos nutricionales.</p>
                    <a href="{{ route('requerimiento_nutricional.create', ['paciente_id' => $paciente->id]) }}" 
                       class="btn btn-primary">
                       <i class="fas fa-calculator"></i> Calcular Primer Requerimiento
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Requerimiento Activo Actual -->
    @php
        $requerimientoActivo = $requerimientos->firstWhere('estado', 'activo');
    @endphp
    @if($requerimientoActivo)
    <div class="card mt-4 border-success">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-check-circle"></i> Requerimiento Activo Actual
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <h6>GET Diario</h6>
                    <h3 class="text-success">{{ number_format($requerimientoActivo->get_kcal, 2) }} kcal</h3>
                </div>
                <div class="col-md-3">
                    <h6>Kcal por Kg</h6>
                    <h3 class="text-primary">{{ number_format($requerimientoActivo->kcal_por_kg, 2) }} kcal/kg</h3>
                </div>
                <div class="col-md-3">
                    <h6>Peso de Referencia</h6>
                    <h3 class="text-info">{{ number_format($requerimientoActivo->peso_kg_at, 2) }} kg</h3>
                </div>
                <div class="col-md-3">
                    <h6>Calculado el</h6>
                    <h3 class="text-warning">{{ $requerimientoActivo->calculado_en->format('d/m/Y') }}</h3>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.7em;
    }
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
</style>
@endpush