@extends('layouts.app')

@section('title', 'Nueva Molécula Calórica')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-atom mr-2"></i>Crear Nueva Molécula Calórica
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('moleculaCalorica.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
                        </a>
                    </div>
                </div>

                <form action="{{ route('moleculaCalorica.store') }}" method="POST" id="moleculaCaloricaForm">
                    @csrf
                    
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="info-box bg-gradient-info">
                                    <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">PACIENTE SELECCIONADO</span>
                                        <span class="info-box-number h4">{{ $paciente->nombre_completo }}</span>
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <small><i class="fas fa-id-card mr-1"></i><strong>CI:</strong> {{ $paciente->CI }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small><i class="fas fa-venus-mars mr-1"></i><strong>Género:</strong> {{ ucfirst($paciente->genero) }}</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small><i class="fas fa-birthday-cake mr-1"></i><strong>Edad:</strong> {{ $paciente->fecha_nacimiento->age }} años</small>
                                            </div>
                                            <div class="col-md-3">
                                                <small><i class="fas fa-weight mr-1"></i><strong>Peso:</strong> {{ $medida ? number_format($medida->peso_kg, 1) : 'N/A' }} kg</small>
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
                                        @if($requerimiento)
                                            <h1 class="text-success mb-0">{{ number_format($requerimiento->get_kcal, 0) }}</h1>
                                            <small class="text-muted">Kilocalorías Totales</small>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-calculator mr-1"></i>
                                                    {{ number_format($requerimiento->kcal_por_kg, 1) }} kcal/kg
                                                </small>
                                            </div>
                                        @else
                                            <div class="text-danger">
                                                <i class="fas fa-times-circle fa-2x mb-2"></i>
                                                <p class="mb-0">Sin requerimiento</p>
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
                                                   value="{{ old('proteinas_g_kg', 1.2) }}"
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
                                                   value="{{ old('porcentaje_grasas', 25) }}"
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

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card card-dark">
                                    <div class="card-header bg-gradient-dark">
                                        <h3 class="card-title mb-0 text-white">
                                            <i class="fas fa-chart-pie mr-2"></i>Resultados de la Distribución
                                        </h3>
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
                                                        <div class="progress-bar bg-primary" id="progress_proteinas" 
                                                             style="width: 0%">
                                                            <strong id="text_proteinas">PROTEÍNAS 0%</strong>
                                                        </div>
                                                        <div class="progress-bar bg-warning" id="progress_grasas" 
                                                             style="width: 0%">
                                                            <strong id="text_grasas">GRASAS 0%</strong>
                                                        </div>
                                                        <div class="progress-bar bg-info" id="progress_carbohidratos" 
                                                             style="width: 0%">
                                                            <strong id="text_carbohidratos">CARBOHIDRATOS 0%</strong>
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
                                                        <h2 id="porcentaje_proteinas_display">0%</h2>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small>Kcal</small>
                                                                <div id="kcal_proteinas_display" class="h5">0</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small>Gramos</small>
                                                                <div id="gramos_proteinas_display" class="h5">0</div>
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
                                                        <h2 id="porcentaje_grasas_display">0%</h2>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small>Kcal</small>
                                                                <div id="kcal_grasas_display" class="h5">0</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small>Gramos</small>
                                                                <div id="gramos_grasas_display" class="h5">0</div>
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
                                                        <h2 id="porcentaje_carbos_display">0%</h2>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small>Kcal</small>
                                                                <div id="kcal_carbos_display" class="h5">0</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small>Gramos</small>
                                                                <div id="gramos_carbos_display" class="h5">0</div>
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
                                                            TOTAL: <span id="kcal_total_display">{{ number_format($requerimiento->get_kcal, 0) }}</span> Kcal
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-secondary text-white">
                                                        <h4 class="card-title mb-0">
                                                            <i class="fas fa-table mr-2"></i>Detalle Completo
                                                        </h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped table-hover">
                                                                <thead class="thead-dark">
                                                                    <tr class="text-center">
                                                                        <th>NUTRIENTE</th>
                                                                        <th>PORCENTAJE</th>
                                                                        <th>KILOCALORÍAS</th>
                                                                        <th>GRAMOS</th>
                                                                        <th>g/Kg</th>
                                                                        <th>Kcal/g</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="table-primary">
                                                                        <td class="text-center">
                                                                            <i class="fas fa-egg mr-2"></i><strong>PROTEÍNAS</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_porcentaje_proteinas">
                                                                            <span class="badge bg-primary">0%</span>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_kcal_proteinas">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gramos_proteinas">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gkg_proteinas">
                                                                            <span class="badge bg-light text-dark">0</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="badge bg-primary">4</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table-warning">
                                                                        <td class="text-center">
                                                                            <i class="fas fa-oil-can mr-2"></i><strong>GRASAS</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_porcentaje_grasas">
                                                                            <span class="badge bg-warning">0%</span>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_kcal_grasas">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gramos_grasas">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gkg_grasas">
                                                                            <span class="badge bg-light text-dark">0</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="badge bg-warning">9</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table-info">
                                                                        <td class="text-center">
                                                                            <i class="fas fa-bread-slice mr-2"></i><strong>CARBOHIDRATOS</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_porcentaje_carbos">
                                                                            <span class="badge bg-info">0%</span>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_kcal_carbos">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gramos_carbos">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gkg_carbos">
                                                                            <span class="badge bg-light text-dark">0</span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="badge bg-info">4</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table-success">
                                                                        <td class="text-center">
                                                                            <i class="fas fa-calculator mr-2"></i><strong>TOTAL</strong>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span class="badge bg-success">100%</span>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_kcal_total">
                                                                            <strong>{{ number_format($requerimiento->get_kcal, 0) }}</strong>
                                                                        </td>
                                                                        <td class="text-center" id="tabla_gramos_total">
                                                                            <strong>0</strong>
                                                                        </td>
                                                                        <td class="text-center">-</td>
                                                                        <td class="text-center">-</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                        <input type="hidden" name="medida_id" value="{{ $medida ? $medida->id : '' }}">
                        <input type="hidden" name="requerimiento_id" value="{{ $requerimiento ? $requerimiento->id : '' }}">
                        <input type="hidden" name="peso_kg" id="peso_kg" value="{{ $medida ? $medida->peso_kg : 0 }}">
                        <input type="hidden" name="talla_cm" id="talla_cm" value="{{ $medida ? $medida->talla_cm : 0 }}">
                        <input type="hidden" name="kilocalorias_totales" id="kilocalorias_totales" value="{{ $requerimiento ? $requerimiento->get_kcal : 0 }}">
                        
                        <input type="hidden" name="kilocalorias_proteinas" id="kilocalorias_proteinas" value="0">
                        <input type="hidden" name="kilocalorias_grasas" id="kilocalorias_grasas" value="0">
                        <input type="hidden" name="kilocalorias_carbohidratos" id="kilocalorias_carbohidratos" value="0">
                        <input type="hidden" name="porcentaje_proteinas" id="porcentaje_proteinas" value="0">
                        <input type="hidden" name="porcentaje_grasas" id="porcentaje_grasas_hidden" value="0">
                        <input type="hidden" name="porcentaje_carbohidratos" id="porcentaje_carbohidratos" value="0">
                    </div>

                    <div class="card-footer text-right bg-light">
                        <button type="submit" class="btn btn-success btn-lg mr-2" id="btn_guardar">
                            <i class="fas fa-save mr-2"></i>Guardar Molécula Calórica
                        </button>
                        <a href="{{ route('moleculaCalorica.index') }}" class="btn btn-secondary btn-lg">
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