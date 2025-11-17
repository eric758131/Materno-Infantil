@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Detalle de Requerimiento Nutricional</h1>
            <p class="text-muted">Información completa del cálculo de requerimientos</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('requerimiento_nutricional.historial', $requerimiento->paciente_id) }}" 
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Historial
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información del Paciente -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> Información del Paciente
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $requerimiento->paciente->nombre_completo }}</p>
                    <p><strong>CI:</strong> {{ $requerimiento->paciente->CI }}</p>
                    <p><strong>Género:</strong> {{ ucfirst($requerimiento->paciente->genero) }}</p>
                    <p><strong>Fecha Nacimiento:</strong> 
                        {{ $requerimiento->paciente->fecha_nacimiento->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Datos del Cálculo -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator"></i> Datos del Cálculo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Peso:</strong> {{ number_format($requerimiento->peso_kg_at, 2) }} kg</p>
                            <p><strong>Talla:</strong> {{ number_format($requerimiento->talla_cm_at, 2) }} cm</p>
                            <p><strong>Factor Actividad:</strong> {{ $requerimiento->factor_actividad }}</p>
                            <p><strong>Factor Lesión:</strong> {{ $requerimiento->factor_lesion }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>GEB:</strong> {{ number_format($requerimiento->geb_kcal, 2) }} kcal/día</p>
                            <p><strong>GET:</strong> {{ number_format($requerimiento->get_kcal, 2) }} kcal/día</p>
                            <p><strong>Kcal por Kg:</strong> {{ number_format($requerimiento->kcal_por_kg, 2) }} kcal/kg</p>
                            <p><strong>Estado:</strong> 
                                <span class="badge bg-{{ $requerimiento->estado == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($requerimiento->estado) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Información Adicional
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Calculado el:</strong> {{ $requerimiento->calculado_en->format('d/m/Y H:i') }}</p>
                    <p><strong>Registrado por:</strong> 
                        {{ $requerimiento->registradoPor->nombre_completo ?? 'N/A' }}</p>
                    @if($requerimiento->medida)
                        <p><strong>Medida asociada:</strong> 
                            {{ $requerimiento->medida->fecha->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs"></i> Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('requerimiento_nutricional.edit', $requerimiento) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Requerimiento
                        </a>
                        
                        @if($requerimiento->estado == 'activo')
                            <form action="{{ route('requerimiento_nutricional.cambiar-estado', $requerimiento) }}" 
                                  method="POST" class="d-grid">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="inactivo">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-pause"></i> Desactivar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('requerimiento_nutricional.cambiar-estado', $requerimiento) }}" 
                                  method="POST" class="d-grid">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="activo">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-play"></i> Activar
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('requerimiento_nutricional.destroy', $requerimiento) }}" 
                              method="POST" class="d-grid" 
                              onsubmit="return confirm('¿Está seguro de eliminar este requerimiento?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection