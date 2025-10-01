@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user me-2"></i>Detalles del Usuario
                        </h4>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Header con Avatar -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <div class="avatar-lg bg-primary rounded-circle text-white d-inline-flex align-items-center justify-content-center mb-3">
                                {{ substr($usuario->nombre, 0, 1) }}{{ substr($usuario->apellido_paterno, 0, 1) }}
                            </div>
                            <h3 class="mb-1">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</h3>
                            <p class="text-muted">{{ $usuario->email }}</p>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                @foreach($usuario->roles as $role)
                                    <span class="badge bg-info fs-6">{{ $role->name }}</span>
                                @endforeach
                            </div>
                            <span class="badge bg-{{ $usuario->estado == 'activo' ? 'success' : 'danger' }} fs-6">
                                <i class="fas fa-{{ $usuario->estado == 'activo' ? 'check' : 'times' }} me-1"></i>
                                {{ ucfirst($usuario->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Información Personal -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h5 class="mb-0 text-primary">
                                        <i class="fas fa-id-card me-2"></i>Información Personal
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Cédula:</dt>
                                        <dd class="col-sm-8">{{ $usuario->ci }}</dd>

                                        <dt class="col-sm-4">Fecha Nac.:</dt>
                                        <dd class="col-sm-8">
                                            {{ $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                            @if($usuario->fecha_nacimiento)
                                                <br><small class="text-muted">({{ \Carbon\Carbon::parse($usuario->fecha_nacimiento)->age }} años)</small>
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">Género:</dt>
                                        <dd class="col-sm-8">
                                            @if($usuario->genero)
                                                <span class="text-capitalize">{{ $usuario->genero }}</span>
                                            @else
                                                N/A
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">Estado:</dt>
                                        <dd class="col-sm-8">
                                            <span class="badge bg-{{ $usuario->estado == 'activo' ? 'success' : 'danger' }}">
                                                {{ ucfirst($usuario->estado) }}
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h5 class="mb-0 text-primary">
                                        <i class="fas fa-address-book me-2"></i>Contacto
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Email:</dt>
                                        <dd class="col-sm-8">
                                            <a href="mailto:{{ $usuario->email }}" class="text-decoration-none">
                                                {{ $usuario->email }}
                                            </a>
                                        </dd>

                                        <dt class="col-sm-4">Teléfono:</dt>
                                        <dd class="col-sm-8">
                                            @if($usuario->telefono)
                                                <a href="tel:{{ $usuario->telefono }}" class="text-decoration-none">
                                                    {{ $usuario->telefono }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">Dirección:</dt>
                                        <dd class="col-sm-8">
                                            @if($usuario->direccion)
                                                {{ $usuario->direccion }}
                                            @else
                                                N/A
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">Registro:</dt>
                                        <dd class="col-sm-8">
                                            <small class="text-muted">
                                                {{ $usuario->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Última actualización: {{ $usuario->updated_at->format('d/m/Y H:i') }}
                        </small>
                        <div class="btn-group">
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-1"></i> Lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection