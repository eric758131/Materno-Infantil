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
                                    <td>{{ $requerimiento->calculado_en->format('d/m/Y H:i') }}</td>
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
                                        <div class="btn-group">
                                            <a href="{{ route('requerimiento_nutricional.show', $requerimiento) }}" 
                                               class="btn btn-info btn-sm" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('requerimiento_nutricional.edit', $requerimiento) }}" 
                                               class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $requerimientos->links() }}
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
</div>
@endsection