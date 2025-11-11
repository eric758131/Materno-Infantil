@extends('layouts.app')

@section('title', 'Ver Molécula Calórica')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-outline">
                <div class="card-header bg-gradient-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-eye mr-2"></i>Moléculas Calóricas de {{ $molecula->paciente->nombre_completo }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('moleculaCalorica.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
                        </a>
                        <a href="{{ route('moleculaCalorica.create.for.paciente', $molecula->paciente->id) }}" class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-plus mr-1"></i> Nueva Molécula
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">PACIENTE</span>
                                    <span class="info-box-number h4">{{ $molecula->paciente->nombre_completo }}</span>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <small><i class="fas fa-id-card mr-1"></i><strong>CI:</strong> {{ $molecula->paciente->CI }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small><i class="fas fa-venus-mars mr-1"></i><strong>Género:</strong> {{ ucfirst($molecula->paciente->genero) }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small><i class="fas fa-birthday-cake mr-1"></i><strong>Edad:</strong> {{ $molecula->paciente->fecha_nacimiento->age }} años</small>
                                        </div>
                                        <div class="col-md-3">
                                            <small><i class="fas fa-weight mr-1"></i><strong>Peso Actual:</strong> {{ number_format($molecula->peso_kg, 1) }} kg</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $todasMoleculas = $molecula->paciente->moleculasCaloricas()->orderBy('created_at', 'desc')->get();
                        $moleculaActiva = $molecula->paciente->moleculasCaloricas()->where('estado', 'activo')->first();
                    @endphp

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        <i class="fas fa-list mr-2"></i>Historial de Moléculas Calóricas ({{ $todasMoleculas->count() }})
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead class="thead-dark">
                                                <tr class="text-center">
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th>Kcal Totales</th>
                                                    <th>Proteínas (g/kg)</th>
                                                    <th>Grasas (%)</th>
                                                    <th>Distribución</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($todasMoleculas as $mol)
                                                <tr class="{{ $mol->id == $molecula->id ? 'table-active' : '' }}">
                                                    <td class="text-center">
                                                        <small>{{ $mol->created_at->format('d/m/Y H:i') }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-{{ $mol->estado == 'activo' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($mol->estado) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong>{{ number_format($mol->kilocalorias_totales, 0) }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($mol->proteinas_g_kg, 1) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($mol->porcentaje_grasas * 100, 0) }}%
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-primary" style="width: {{ $mol->porcentaje_proteinas * 100 }}%"></div>
                                                            <div class="progress-bar bg-warning" style="width: {{ $mol->porcentaje_grasas * 100 }}%"></div>
                                                            <div class="progress-bar bg-info" style="width: {{ $mol->porcentaje_carbohidratos * 100 }}%"></div>
                                                        </div>
                                                        <small class="text-muted">
                                                            P:{{ number_format($mol->porcentaje_proteinas * 100, 0) }}% 
                                                            G:{{ number_format($mol->porcentaje_grasas * 100, 0) }}% 
                                                            C:{{ number_format($mol->porcentaje_carbohidratos * 100, 0) }}%
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ route('moleculaCalorica.show', $mol->id) }}" 
                                                               class="btn btn-info" title="Ver detalle">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('moleculaCalorica.edit', $mol->id) }}" 
                                                               class="btn btn-warning" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('moleculaCalorica.destroy', $mol->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-{{ $mol->estado == 'activo' ? 'danger' : 'success' }}" 
                                                                        title="{{ $mol->estado == 'activo' ? 'Desactivar' : 'Activar' }}"
                                                                        onclick="return confirm('¿Está seguro de {{ $mol->estado == 'activo' ? 'desactivar' : 'activar' }} esta molécula calórica?')">
                                                                    <i class="fas fa-{{ $mol->estado == 'activo' ? 'ban' : 'check' }}"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($moleculaActiva)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-dark">
                                <div class="card-header bg-gradient-success">
                                    <h4 class="card-title mb-0 text-white">
                                        <i class="fas fa-chart-pie mr-2"></i>Molécula Calórica Activa
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="progress-group">
                                                <div class="progress-text">
                                                    <strong>Distribución de Macronutrientes</strong>
                                                    <span class="float-right"><b>100%</b></span>
                                                </div>
                                                <div class="progress mb-3" style="height: 35px;">
                                                    <div class="progress-bar bg-primary" 
                                                         style="width: {{ $moleculaActiva->porcentaje_proteinas * 100 }}%">
                                                        <strong>PROTEÍNAS {{ number_format($moleculaActiva->porcentaje_proteinas * 100, 0) }}%</strong>
                                                    </div>
                                                    <div class="progress-bar bg-warning" 
                                                         style="width: {{ $moleculaActiva->porcentaje_grasas * 100 }}%">
                                                        <strong>GRASAS {{ number_format($moleculaActiva->porcentaje_grasas * 100, 0) }}%</strong>
                                                    </div>
                                                    <div class="progress-bar bg-info" 
                                                         style="width: {{ $moleculaActiva->porcentaje_carbohidratos * 100 }}%">
                                                        <strong>CARBOHIDRATOS {{ number_format($moleculaActiva->porcentaje_carbohidratos * 100, 0) }}%</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-egg fa-2x mb-2"></i>
                                                    <h4>PROTEÍNAS</h4>
                                                    <h2>{{ number_format($moleculaActiva->porcentaje_proteinas * 100, 0) }}%</h2>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small>Kcal</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->kilocalorias_proteinas, 0) }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Gramos</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->getProteinasGAttribute(), 0) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-oil-can fa-2x mb-2"></i>
                                                    <h4>GRASAS</h4>
                                                    <h2>{{ number_format($moleculaActiva->porcentaje_grasas * 100, 0) }}%</h2>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small>Kcal</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->kilocalorias_grasas, 0) }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Gramos</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->getGrasasGAttribute(), 0) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card bg-info text-white">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-bread-slice fa-2x mb-2"></i>
                                                    <h4>CARBOHIDRATOS</h4>
                                                    <h2>{{ number_format($moleculaActiva->porcentaje_carbohidratos * 100, 0) }}%</h2>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small>Kcal</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->kilocalorias_carbohidratos, 0) }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>Gramos</small>
                                                            <div class="h5">{{ number_format($moleculaActiva->getCarbohidratosGAttribute(), 0) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="card bg-success text-white">
                                                <div class="card-body text-center">
                                                    <h3 class="mb-0">
                                                        <i class="fas fa-calculator mr-2"></i>
                                                        TOTAL: {{ number_format($moleculaActiva->kilocalorias_totales, 0) }} Kcal
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection