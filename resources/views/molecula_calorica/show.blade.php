@extends('layouts.app')

@section('title', 'Historial de Moléculas Calóricas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Historial de Moléculas Calóricas - {{ $paciente->nombre_completo }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('molecula_calorica.create', ['paciente_id' => $paciente->id]) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar Nueva
                        </a>
                        <a href="{{ route('molecula_calorica.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Información del Paciente -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Paciente</span>
                                    <span class="info-box-number">{{ $paciente->nombre_completo }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">CI</span>
                                    <span class="info-box-number">{{ $paciente->CI }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Registros</span>
                                    <span class="info-box-number">{{ $paciente->moleculasCaloricas->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Moléculas Calóricas -->
                    @if($paciente->moleculasCaloricas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Peso (kg)</th>
                                    <th>Proteínas (g/Kg)</th>
                                    <th>Grasas (g/Kg)</th>
                                    <th>Carbohidratos (g/Kg)</th>
                                    <th>Kcal Proteínas</th>
                                    <th>Kcal Grasas</th>
                                    <th>Kcal Carbohidratos</th>
                                    <th>Kcal Totales</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paciente->moleculasCaloricas as $molecula)
                                <tr>
                                    <td>{{ $molecula->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ number_format($molecula->peso_kg, 2) }}</td>
                                    <td>{{ number_format($molecula->proteínas_g_kg, 2) }}</td>
                                    <td>{{ number_format($molecula->grasa_g_kg, 2) }}</td>
                                    <td>{{ number_format($molecula->carbohidratos_g_kg, 2) }}</td>
                                    <td>{{ number_format($molecula->kilocalorías_proteínas, 2) }}</td>
                                    <td>{{ number_format($molecula->kilocalorías_grasas, 2) }}</td>
                                    <td>{{ number_format($molecula->kilocalorías_carbohidratos, 2) }}</td>
                                    <td>
                                        <strong>{{ number_format($molecula->kilocalorías_totales, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $molecula->estado == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($molecula->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('molecula_calorica.edit', $molecula->id) }}" 
                                               class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('molecula_calorica.toggle_estado', $molecula->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-{{ $molecula->estado == 'activo' ? 'secondary' : 'success' }} btn-sm"
                                                        title="{{ $molecula->estado == 'activo' ? 'Desactivar' : 'Activar' }}">
                                                    <i class="fas fa-{{ $molecula->estado == 'activo' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('molecula_calorica.destroy', $molecula->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este registro?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
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
                    @else
                    <div class="alert alert-info text-center">
                        <h5>No hay moléculas calóricas registradas</h5>
                        <p>Este paciente no tiene registros de moléculas calóricas.</p>
                        <a href="{{ route('molecula_calorica.create', ['paciente_id' => $paciente->id]) }}" 
                           class="btn btn-primary">
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