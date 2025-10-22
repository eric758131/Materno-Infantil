@extends('layouts.app')

@section('title', 'Historial de Seguimientos - ' . $paciente->nombre_completo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Información del Paciente -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-user text-primary"></i>
                        Información del Paciente
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">CI:</th>
                            <td>{{ $paciente->CI }}</td>
                        </tr>
                        <tr>
                            <th>Nombre Completo:</th>
                            <td>{{ $paciente->nombre_completo }}</td>
                        </tr>
                        <tr>
                            <th>Fecha Nacimiento:</th>
                            <td>
                                @if($paciente->fecha_nacimiento)
                                    {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">
                                        ({{ $paciente->fecha_nacimiento->age }} años)
                                    </small>
                                @else
                                    <span class="text-muted">No especificada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Edad:</th>
                            <td>
                                @if($paciente->fecha_nacimiento)
                                    <span class="fw-bold text-primary">{{ $paciente->fecha_nacimiento->age }} años</span>
                                @else
                                    <span class="text-muted">No especificada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Género:</th>
                            <td>
                                <span class="badge bg-{{ $paciente->genero == 'masculino' ? 'primary' : ($paciente->genero == 'femenino' ? 'pink' : 'secondary') }}">
                                    {{ ucfirst($paciente->genero) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge bg-{{ $paciente->estado == 'activo' ? 'success' : 'danger' }}">
                                    {{ ucfirst($paciente->estado) }}
                                </span>
                            </td>
                        </tr>
                        @if($paciente->tutor)
                        <tr>
                            <th>Tutor:</th>
                            <td>
                                <strong>{{ $paciente->tutor->nombre_completo }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $paciente->tutor->parentesco }} • CI: {{ $paciente->tutor->CI }}
                                </small>
                            </td>
                        </tr>
                        @endif
                    </table>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('seguimientos.create', ['paciente_id' => $paciente->id]) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Nuevo Seguimiento
                        </a>
                        <a href="{{ route('seguimientos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Lista
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-info"></i>
                        Resumen de Seguimientos
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $totalSeguimientos = $paciente->seguimientos->count();
                        $activos = $paciente->seguimientos->where('estado', 'activo')->count();
                        $inactivos = $paciente->seguimientos->where('estado', 'inactivo')->count();
                        $ultimoSeguimiento = $paciente->seguimientos->sortByDesc('fecha_seguimiento')->first();
                        $primerSeguimiento = $paciente->seguimientos->sortBy('fecha_seguimiento')->first();
                    @endphp
                    
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 text-primary mb-1">{{ $totalSeguimientos }}</div>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 text-success mb-1">{{ $activos }}</div>
                                <small class="text-muted">Activos</small>
                            </div>
                        </div>
                    </div>
                    
                    @if($primerSeguimiento && $ultimoSeguimiento)
                    <div class="mt-3">
                        <small class="text-muted">Período:</small>
                        <div class="fw-bold">
                            {{ $primerSeguimiento->fecha_seguimiento->format('d/m/Y') }} - 
                            {{ $ultimoSeguimiento->fecha_seguimiento->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Historial Completo de Seguimientos -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-history text-danger"></i>
                        Historial Completo de Seguimientos
                    </h4>
                    <span class="badge bg-primary">{{ $paciente->seguimientos->count() }} registros</span>
                </div>

                <div class="card-body p-0">
                    @if($paciente->seguimientos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Peso (kg)</th>
                                        <th>Talla (cm)</th>
                                        <th>IMC</th>
                                        <th>Clasificación</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paciente->seguimientos->sortByDesc('fecha_seguimiento') as $seguimiento)
                                        <tr class="{{ $seguimiento->estado == 'inactivo' ? 'table-secondary' : '' }}">
                                            <td class="fw-bold">
                                                {{ $seguimiento->fecha_seguimiento->format('d/m/Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $seguimiento->created_at->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="{{ $seguimiento->estado == 'inactivo' ? 'text-muted' : 'fw-bold' }}">
                                                    {{ $seguimiento->peso }}
                                                </span>
                                                @php
                                                    $pesoAnterior = $paciente->seguimientos
                                                        ->where('fecha_seguimiento', '<', $seguimiento->fecha_seguimiento)
                                                        ->sortByDesc('fecha_seguimiento')
                                                        ->first();
                                                @endphp
                                                @if($pesoAnterior)
                                                    @php
                                                        $diferenciaPeso = $seguimiento->peso - $pesoAnterior->peso;
                                                        $iconoPeso = $diferenciaPeso > 0 ? 'arrow-up text-danger' : ($diferenciaPeso < 0 ? 'arrow-down text-success' : 'minus text-muted');
                                                    @endphp
                                                    <br>
                                                    <small class="text-{{ $diferenciaPeso > 0 ? 'danger' : ($diferenciaPeso < 0 ? 'success' : 'muted') }}">
                                                        <i class="fas fa-{{ $iconoPeso }}"></i>
                                                        {{ $diferenciaPeso > 0 ? '+' : '' }}{{ number_format($diferenciaPeso, 2) }} kg
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="{{ $seguimiento->estado == 'inactivo' ? 'text-muted' : 'fw-bold' }}">
                                                    {{ $seguimiento->talla }}
                                                </span>
                                                @if($pesoAnterior)
                                                    @php
                                                        $diferenciaTalla = $seguimiento->talla - $pesoAnterior->talla;
                                                        $iconoTalla = $diferenciaTalla > 0 ? 'arrow-up text-success' : ($diferenciaTalla < 0 ? 'arrow-down text-warning' : 'minus text-muted');
                                                    @endphp
                                                    <br>
                                                    <small class="text-{{ $diferenciaTalla > 0 ? 'success' : ($diferenciaTalla < 0 ? 'warning' : 'muted') }}">
                                                        <i class="fas fa-{{ $iconoTalla }}"></i>
                                                        {{ $diferenciaTalla > 0 ? '+' : '' }}{{ number_format($diferenciaTalla, 2) }} cm
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($seguimiento->imc)
                                                    <span class="badge 
                                                        @if($seguimiento->imc < 18.5) bg-warning
                                                        @elseif($seguimiento->imc < 25) bg-success
                                                        @elseif($seguimiento->imc < 30) bg-warning
                                                        @else bg-danger
                                                        @endif {{ $seguimiento->estado == 'inactivo' ? 'opacity-50' : '' }}">
                                                        {{ $seguimiento->imc }}
                                                    </span>
                                                    @if($pesoAnterior && $pesoAnterior->imc)
                                                        @php
                                                            $diferenciaImc = $seguimiento->imc - $pesoAnterior->imc;
                                                            $iconoImc = $diferenciaImc > 0 ? 'arrow-up text-danger' : ($diferenciaImc < 0 ? 'arrow-down text-success' : 'minus text-muted');
                                                        @endphp
                                                        <br>
                                                        <small class="text-{{ $diferenciaImc > 0 ? 'danger' : ($diferenciaImc < 0 ? 'success' : 'muted') }}">
                                                            <i class="fas fa-{{ $iconoImc }}"></i>
                                                            {{ $diferenciaImc > 0 ? '+' : '' }}{{ number_format($diferenciaImc, 2) }}
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="{{ $seguimiento->estado == 'inactivo' ? 'text-muted' : '' }}">
                                                    {{ $seguimiento->clasificacion_imc ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $seguimiento->estado == 'activo' ? 'success' : 'secondary' }}">
                                                    {{ $seguimiento->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('seguimientos.edit', $seguimiento) }}" 
                                                       class="btn btn-warning" title="Editar seguimiento">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    @if($seguimiento->estado == 'activo')
                                                        <form action="{{ route('seguimientos.desactivar', $seguimiento) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-secondary" 
                                                                    title="Desactivar" onclick="return confirm('¿Desactivar este seguimiento?')">
                                                                <i class="fas fa-pause"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('seguimientos.activar', $seguimiento) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" 
                                                                    title="Activar" onclick="return confirm('¿Activar este seguimiento?')">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('seguimientos.destroy', $seguimiento) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                title="Eliminar" onclick="return confirm('¿Eliminar permanentemente este seguimiento?')">
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
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                <h5>No hay seguimientos registrados</h5>
                                <p>Este paciente no tiene seguimientos médicos registrados.</p>
                                <a href="{{ route('seguimientos.create', ['paciente_id' => $paciente->id]) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Crear Primer Seguimiento
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gráfico de Evolución -->
            @if($paciente->seguimientos->count() > 1)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line text-success"></i>
                        Evolución del Peso y Talla
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-center text-primary">Evolución del Peso (kg)</h6>
                            <div class="progress" style="height: 20px;">
                                @php
                                    $pesos = $paciente->seguimientos->sortBy('fecha_seguimiento');
                                    $primerPeso = $pesos->first()->peso;
                                    $ultimoPeso = $pesos->last()->peso;
                                    $diferenciaTotalPeso = $ultimoPeso - $primerPeso;
                                    $porcentajePeso = $primerPeso != 0 ? ($diferenciaTotalPeso / $primerPeso * 100) : 0;
                                @endphp
                                <div class="progress-bar bg-{{ $diferenciaTotalPeso > 0 ? 'danger' : 'success' }}" 
                                     style="width: {{ min(abs($porcentajePeso), 100) }}%">
                                    {{ $diferenciaTotalPeso > 0 ? '+' : '' }}{{ number_format($diferenciaTotalPeso, 1) }} kg
                                    @if($primerPeso != 0)
                                    ({{ number_format($porcentajePeso, 1) }}%)
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Inicio: {{ $primerPeso }} kg</small>
                                <small>Actual: {{ $ultimoPeso }} kg</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-center text-info">Evolución de la Talla (cm)</h6>
                            <div class="progress" style="height: 20px;">
                                @php
                                    $tallas = $paciente->seguimientos->sortBy('fecha_seguimiento');
                                    $primerTalla = $tallas->first()->talla;
                                    $ultimoTalla = $tallas->last()->talla;
                                    $diferenciaTotalTalla = $ultimoTalla - $primerTalla;
                                    $porcentajeTalla = $primerTalla != 0 ? ($diferenciaTotalTalla / $primerTalla * 100) : 0;
                                @endphp
                                <div class="progress-bar bg-{{ $diferenciaTotalTalla > 0 ? 'success' : 'warning' }}" 
                                     style="width: {{ min(abs($porcentajeTalla), 100) }}%">
                                    {{ $diferenciaTotalTalla > 0 ? '+' : '' }}{{ number_format($diferenciaTotalTalla, 1) }} cm
                                    @if($primerTalla != 0)
                                    ({{ number_format($porcentajeTalla, 1) }}%)
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Inicio: {{ $primerTalla }} cm</small>
                                <small>Actual: {{ $ultimoTalla }} cm</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

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