@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Medida
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Funcionalidad en desarrollo</strong>
                        <p class="mb-0 mt-2">La edición de medidas estará disponible próximamente.</p>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="{{ route('medidas.show', $medida->id ?? 1) }}" class="btn btn-primary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Resultados
                        </a>
                        <a href="{{ route('medidas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-1"></i> Ver Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection