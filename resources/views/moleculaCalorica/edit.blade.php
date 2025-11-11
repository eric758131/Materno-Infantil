@extends('layouts.app')

@section('title', 'Editar Molécula Calórica')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning card-outline">
                <div class="card-header bg-gradient-warning text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>Editar Molécula Calórica
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('moleculaCalorica.show', $molecula->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver al Detalle
                        </a>
                    </div>
                </div>

                <form action="{{ route('moleculaCalorica.update', $molecula->id) }}" method="POST" id="moleculaCaloricaForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="info-box bg-gradient-info">
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
                                                <small><i class="fas fa-weight mr-1"></i><strong>Peso Actual:</strong> {{ $ultimaMedida ? number_format($ultimaMedida->peso_kg, 1) : number_format($molecula->peso_kg, 1) }} kg</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-fire mr-1"></i>Energía Total</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($ultimoRequerimiento)
                                            <h1 class="text-success mb-0">{{ number_format($ultimoRequerimiento->get_kcal, 0) }}</h1>
                                            <small class="text-muted">Kilocalorías Totales (GET Actual)</small>
                                        @else
                                            <div class="text-danger">
                                                <i class="fas fa-times-circle fa-2x mb-2"></i>
                                                <p class="mb-0">Sin requerimiento activo</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-egg mr-1"></i>Proteínas</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            <label class="h5 text-primary">Gramos por Kg</label>
                                            <input type="number" class="form-control form-control-lg text-center" id="proteinas_g_kg" 
                                                   name="proteinas_g_kg" step="0.1" min="0.5" max="3" required
                                                   value="{{ old('proteinas_g_kg', $molecula->proteinas_g_kg) }}"
                                                   oninput="calcularMolecula()">
                                            <small class="text-muted">Ej: 1.2, 1.5, 2.0</small>
                                        </div>
                                        <div id="proteinas_info" class="mt-2">
                                            <small class="text-muted">Total: <strong id="proteinas_total">0 g</strong></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-oil-can mr-1"></i>Grasas</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            <label class="h5 text-warning">Porcentaje del Total</label>
                                            <input type="number" class="form-control form-control-lg text-center" id="porcentaje_grasas" 
                                                   name="porcentaje_grasas" step="1" min="15" max="40" required
                                                   value="{{ old('porcentaje_grasas', $molecula->porcentaje_grasas * 100) }}"
                                                   oninput="calcularMolecula()">
                                            <small class="text-muted">Ej: 20, 25, 30 %</small>
                                        </div>
                                        <div id="grasas_info" class="mt-2">
                                            <small class="text-muted">Total: <strong id="grasas_total">0 g</strong></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- El resto del contenido es IDÉNTICO al create.blade.php -->
                        <!-- Solo copia desde "Resultados" hasta el final del create -->

                    </div>

                    <div class="card-footer text-right bg-light">
                        <button type="submit" class="btn btn-success btn-lg mr-2" id="btn_guardar">
                            <i class="fas fa-save mr-2"></i>Actualizar Molécula Calórica
                        </button>
                        <a href="{{ route('moleculaCalorica.show', $molecula->id) }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let pesoActual = {{ $medida ? $medida->peso_kg : 0 }};
let kcalTotales = {{ $requerimiento ? $requerimiento->get_kcal : 0 }};

function calcularMolecula() {
    const proteinasGkg = parseFloat(document.getElementById('proteinas_g_kg').value) || 0;
    const porcentajeGrasas = parseFloat(document.getElementById('porcentaje_grasas').value) || 0;
    
    if (proteinasGkg > 0 && porcentajeGrasas > 0 && pesoActual > 0 && kcalTotales > 0) {
        const porcentajeGrasasDecimal = porcentajeGrasas / 100;

        const proteinasG = proteinasGkg * pesoActual;
        const kcalProteinas = proteinasG * 4;
        const porcentajeProteina = (kcalProteinas / kcalTotales) * 100;
        const kcalGrasas = kcalTotales * porcentajeGrasasDecimal;
        const grasasG = kcalGrasas / 9;
        const porcentajeCarbohidratos = Math.max(0, 100 - (porcentajeProteina + porcentajeGrasas));
        const kcalCarbohidratos = (porcentajeCarbohidratos / 100) * kcalTotales;
        const carbohidratosG = kcalCarbohidratos / 4;
        const gramosKgProteinas = pesoActual > 0 ? proteinasG / pesoActual : 0;
        const gramosKgGrasas = pesoActual > 0 ? grasasG / pesoActual : 0;
        const gramosKgCarbohidratos = pesoActual > 0 ? carbohidratosG / pesoActual : 0;
        const gramosTotal = proteinasG + grasasG + carbohidratosG;

        document.getElementById('progress_proteinas').style.width = porcentajeProteina + '%';
        document.getElementById('progress_grasas').style.width = porcentajeGrasas + '%';
        document.getElementById('progress_carbohidratos').style.width = porcentajeCarbohidratos + '%';
        
        document.getElementById('text_proteinas').textContent = `PROTEÍNAS ${porcentajeProteina.toFixed(0)}%`;
        document.getElementById('text_grasas').textContent = `GRASAS ${porcentajeGrasas.toFixed(0)}%`;
        document.getElementById('text_carbohidratos').textContent = `CARBOHIDRATOS ${porcentajeCarbohidratos.toFixed(0)}%`;

        document.getElementById('porcentaje_proteinas_display').textContent = porcentajeProteina.toFixed(0) + '%';
        document.getElementById('kcal_proteinas_display').textContent = kcalProteinas.toFixed(0);
        document.getElementById('gramos_proteinas_display').textContent = proteinasG.toFixed(0);
        document.getElementById('proteinas_total').textContent = proteinasG.toFixed(0) + ' g';

        document.getElementById('porcentaje_grasas_display').textContent = porcentajeGrasas.toFixed(0) + '%';
        document.getElementById('kcal_grasas_display').textContent = kcalGrasas.toFixed(0);
        document.getElementById('gramos_grasas_display').textContent = grasasG.toFixed(0);
        document.getElementById('grasas_total').textContent = grasasG.toFixed(0) + ' g';

        document.getElementById('porcentaje_carbos_display').textContent = porcentajeCarbohidratos.toFixed(0) + '%';
        document.getElementById('kcal_carbos_display').textContent = kcalCarbohidratos.toFixed(0);
        document.getElementById('gramos_carbos_display').textContent = carbohidratosG.toFixed(0);

        document.getElementById('tabla_porcentaje_proteinas').innerHTML = `<span class="badge bg-primary">${porcentajeProteina.toFixed(1)}%</span>`;
        document.getElementById('tabla_kcal_proteinas').innerHTML = `<strong>${kcalProteinas.toFixed(0)}</strong>`;
        document.getElementById('tabla_gramos_proteinas').innerHTML = `<strong>${proteinasG.toFixed(1)}</strong>`;
        document.getElementById('tabla_gkg_proteinas').innerHTML = `<span class="badge bg-light text-dark">${gramosKgProteinas.toFixed(2)}</span>`;

        document.getElementById('tabla_porcentaje_grasas').innerHTML = `<span class="badge bg-warning">${porcentajeGrasas.toFixed(1)}%</span>`;
        document.getElementById('tabla_kcal_grasas').innerHTML = `<strong>${kcalGrasas.toFixed(0)}</strong>`;
        document.getElementById('tabla_gramos_grasas').innerHTML = `<strong>${grasasG.toFixed(1)}</strong>`;
        document.getElementById('tabla_gkg_grasas').innerHTML = `<span class="badge bg-light text-dark">${gramosKgGrasas.toFixed(2)}</span>`;

        document.getElementById('tabla_porcentaje_carbos').innerHTML = `<span class="badge bg-info">${porcentajeCarbohidratos.toFixed(1)}%</span>`;
        document.getElementById('tabla_kcal_carbos').innerHTML = `<strong>${kcalCarbohidratos.toFixed(0)}</strong>`;
        document.getElementById('tabla_gramos_carbos').innerHTML = `<strong>${carbohidratosG.toFixed(1)}</strong>`;
        document.getElementById('tabla_gkg_carbos').innerHTML = `<span class="badge bg-light text-dark">${gramosKgCarbohidratos.toFixed(2)}</span>`;

        document.getElementById('tabla_gramos_total').innerHTML = `<strong>${gramosTotal.toFixed(1)}</strong>`;

        document.getElementById('kilocalorias_proteinas').value = kcalProteinas;
        document.getElementById('kilocalorias_grasas').value = kcalGrasas;
        document.getElementById('kilocalorias_carbohidratos').value = kcalCarbohidratos;
        document.getElementById('porcentaje_proteinas').value = porcentajeProteina / 100;
        document.getElementById('porcentaje_grasas_hidden').value = porcentajeGrasas / 100;
        document.getElementById('porcentaje_carbohidratos').value = porcentajeCarbohidratos / 100;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    calcularMolecula();
});
</script>
@endsection