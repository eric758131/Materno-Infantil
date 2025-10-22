@if($seguimientos->count() > 0)
<div class="timeline-container">
    <div class="timeline">
        @foreach($seguimientos->sortBy('fecha_seguimiento') as $seguimiento)
        <div class="timeline-item {{ $loop->iteration % 2 == 0 ? 'right' : 'left' }}">
            <div class="timeline-content card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-day text-primary"></i>
                        {{ $seguimiento->fecha_seguimiento->format('d/m/Y') }}
                    </h6>
                    <span class="badge badge-{{ $seguimiento->estado == 'activo' ? 'success' : 'secondary' }}">
                        {{ $seguimiento->estado }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <small class="text-muted">Peso</small>
                            <div class="h5 text-primary">{{ $seguimiento->peso }} kg</div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">Talla</small>
                            <div class="h5 text-info">{{ $seguimiento->talla }} cm</div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">IMC</small>
                            <div class="h5 
                                @if($seguimiento->imc < 18.5) text-warning
                                @elseif($seguimiento->imc < 25) text-success
                                @elseif($seguimiento->imc < 30) text-warning
                                @else text-danger
                                @endif">
                                {{ $seguimiento->imc ?? '-' }}
                            </div>
                        </div>
                    </div>
                    
                    @if($seguimiento->imc)
                    <div class="mt-2">
                        <small class="text-muted">Clasificación:</small>
                        <span class="badge 
                            @if($seguimiento->imc < 18.5) badge-warning
                            @elseif($seguimiento->imc < 25) badge-success
                            @elseif($seguimiento->imc < 30) badge-warning
                            @else badge-danger
                            @endif">
                            {{ $seguimiento->clasificacion_imc }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <small class="text-muted">
                        Registrado el {{ $seguimiento->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.timeline-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

.timeline-container::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: #e9ecef;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -3px;
}

.timeline-item {
    padding: 10px 40px;
    position: relative;
    width: 50%;
    box-sizing: border-box;
}

.timeline-item::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: #007bff;
    border: 4px solid #ffffff;
    border-radius: 50%;
    top: 15px;
    z-index: 1;
}

.left { left: 0; }
.right { left: 50%; }

.left::after { right: -10px; }
.right::after { left: -10px; }

.timeline-content {
    padding: 0;
    background-color: white;
    position: relative;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

@media screen and (max-width: 768px) {
    .timeline-container::after { left: 31px; }
    .timeline-item { width: 100%; padding-left: 70px; padding-right: 25px; }
    .timeline-item::after { left: 21px; }
    .right { left: 0%; }
}
</style>
@else
<div class="text-center text-muted py-5">
    <i class="fas fa-chart-line fa-3x mb-3"></i>
    <p>No hay datos de seguimiento para mostrar</p>
</div>
@endif