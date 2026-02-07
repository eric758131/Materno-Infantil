@extends('layouts.app')

@section('title', 'Moléculas Calóricas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Moléculas Calóricas</h1>
            <p class="text-muted">Seleccione un paciente para calcular su molécula calórica</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Pacientes
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- AGREGAR ESTA SECCIÓN DE BÚSQUEDA --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('moleculaCalorica.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Buscar paciente por nombre, apellido o CI (ignora acentos y mayúsculas)" 
                               value="{{ old('search', request('search')) }}"
                               autocomplete="off">
                        @if(request('search'))
                            <a href="{{ route('moleculaCalorica.index') }}" 
                               class="btn btn-outline-secondary"
                               title="Limpiar búsqueda">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
            
            @if(request('search'))
                <div class="mt-3">
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle"></i>
                        Resultados para: "{{ request('search') }}"
                        @if($pacientes->count() > 0)
                            - {{ $pacientes->total() }} paciente(s) encontrado(s)
                        @else
                            - No se encontraron pacientes
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
    {{-- FIN DE SECCIÓN DE BÚSQUEDA --}}

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">
                <i class="fas fa-users"></i> Lista de Pacientes
                @if(request('search'))
                    <span class="badge bg-light text-primary ms-2">Búsqueda activa</span>
                @endif
            </h4>
        </div>
        <div class="card-body">
            @if($pacientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Paciente</th>
                                <th>CI</th>
                                <th>Edad</th>
                                <th>Género</th>
                                <th>Última Medida</th>
                                <th>GET Activo</th>
                                <th>Moléculas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientes as $paciente)
                                @php
                                    $ultimaMedida = $paciente->medidas()->latest()->first();
                                    $requerimientoActivo = $paciente->requerimientosNutricionales()
                                        ->where('estado', 'activo')
                                        ->latest()
                                        ->first();
                                    $moleculasActivas = $paciente->moleculasCaloricas()
                                        ->where('estado', 'activo')
                                        ->get();
                                    $totalMoleculas = $paciente->moleculasCaloricas()->count();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $paciente->nombre_completo }}</strong>
                                    </td>
                                    <td>{{ $paciente->CI }}</td>
                                    <td>
                                        {{ $paciente->fecha_nacimiento->age }} años
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst($paciente->genero) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($ultimaMedida)
                                            <small>
                                                {{ number_format($ultimaMedida->peso_kg, 1) }} kg / 
                                                {{ number_format($ultimaMedida->talla_cm, 1) }} cm
                                                <br>
                                                <span class="text-muted">
                                                    {{ $ultimaMedida->fecha->format('d/m/Y') }}
                                                </span>
                                            </small>
                                        @else
                                            <span class="text-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Sin medidas
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($requerimientoActivo)
                                            <span class="badge bg-success">
                                                {{ number_format($requerimientoActivo->get_kcal, 0) }} kcal
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> No tiene
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($totalMoleculas > 0)
                                            <span class="badge bg-primary">{{ $moleculasActivas->count() }} activas</span>
                                            <br>
                                            <small class="text-muted">Total: {{ $totalMoleculas }}</small>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($requerimientoActivo)
                                                <a href="{{ route('moleculaCalorica.create.for.paciente', $paciente->id) }}" 
                                                   class="btn btn-primary btn-sm"
                                                   title="Calcular molécula calórica">
                                                    <i class="fas fa-calculator"></i> Calcular
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled
                                                        title="Primero debe calcular el requerimiento nutricional">
                                                    <i class="fas fa-calculator"></i> Calcular
                                                </button>
                                            @endif

                                            @if($totalMoleculas > 0)
                                                <a href="{{ route('moleculaCalorica.show', $paciente->moleculasCaloricas()->latest()->first()->id) }}" 
                                                   class="btn btn-info btn-sm"
                                                   title="Ver moléculas">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- AGREGAR PAGINACIÓN --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Mostrando {{ $pacientes->firstItem() }} - {{ $pacientes->lastItem() }} de {{ $pacientes->total() }} pacientes
                    </div>
                    <nav aria-label="Paginación de pacientes">
                        {{ $pacientes->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                {{-- FIN DE PAGINACIÓN --}}
                
            @else
                <div class="text-center py-5">
                    @if(request('search'))
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No se encontraron pacientes</h4>
                        <p class="text-muted">No hay resultados para "{{ request('search') }}"</p>
                        <a href="{{ route('moleculaCalorica.index') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i> Ver todos los pacientes
                        </a>
                    @else
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No hay pacientes registrados</h4>
                        <p class="text-muted">No se han encontrado pacientes en el sistema.</p>
                        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Registrar Primer Paciente
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection