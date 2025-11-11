@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1>Calcular Requerimiento Nutricional</h1>
            <p class="text-muted">Complete los datos para calcular el requerimiento nutricional</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('requerimiento_nutricional.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Pacientes
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Información del Paciente -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-primary">
                        <h5 class="alert-heading">
                            <i class="fas fa-user"></i> Paciente Seleccionado
                        </h5>
                        <strong>Nombre:</strong> {{ $paciente->nombre_completo }}<br>
                        <strong>CI:</strong> {{ $paciente->CI }}<br>
                        <strong>Género:</strong> {{ ucfirst($paciente->genero) }}<br>
                        <strong>Fecha Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <form action="{{ route('requerimiento_nutricional.store') }}" method="POST">
                @csrf
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                <!-- Información de la última medida -->
                @if($ultimaMedida)
                <div class="alert alert-info mb-4">
                    <h5><i class="fas fa-info-circle"></i> Última Medida Registrada</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Fecha:</strong> {{ $ultimaMedida->fecha->format('d/m/Y') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Peso:</strong> {{ number_format($ultimaMedida->peso_kg, 2) }} kg
                        </div>
                        <div class="col-md-3">
                            <strong>Talla:</strong> {{ number_format($ultimaMedida->talla_cm, 2) }} cm
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="usarUltimaMedida" class="btn btn-sm btn-primary">
                                <i class="fas fa-check"></i> Usar estos valores
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle"></i> No se encontraron medidas registradas para este paciente.
                </div>
                @endif

                <div class="row">
                    <!-- Datos Antropométricos -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="card-title mb-0">Datos Antropométricos</h4>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="medida_id" id="medida_id" value="{{ $ultimaMedida->id ?? '' }}">

                                <div class="form-group mb-3">
                                    <label for="peso_kg_at" class="form-label">Peso (kg) *</label>
                                    <input type="number" name="peso_kg_at" id="peso_kg_at" 
                                           class="form-control" step="0.01" min="0.1" max="500"
                                           value="{{ old('peso_kg_at', $ultimaMedida->peso_kg ?? '') }}" required>
                                    @error('peso_kg_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="talla_cm_at" class="form-label">Talla (cm) *</label>
                                    <input type="number" name="talla_cm_at" id="talla_cm_at" 
                                           class="form-control" step="0.01" min="1" max="300"
                                           value="{{ old('talla_cm_at', $ultimaMedida->talla_cm ?? '') }}" required>
                                    @error('talla_cm_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Factores de Cálculo -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h4 class="card-title mb-0">Factores de Cálculo</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="factor_actividad" class="form-label">Factor de Actividad *</label>
                                    <select name="factor_actividad" id="factor_actividad" class="form-control" required>
                                        <option value="">Seleccione factor</option>
                                        <option value="1.2" {{ old('factor_actividad') == '1.2' ? 'selected' : '' }}>1.2 - Reposo en cama</option>
                                        <option value="1.3" {{ old('factor_actividad') == '1.3' ? 'selected' : '' }}>1.3 - Actividad leve</option>
                                        <option value="1.5" {{ old('factor_actividad') == '1.5' ? 'selected' : '' }}>1.5 - Actividad moderada</option>
                                        <option value="1.7" {{ old('factor_actividad') == '1.7' ? 'selected' : '' }}>1.7 - Actividad intensa</option>
                                    </select>
                                    @error('factor_actividad')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="factor_lesion" class="form-label">Factor de Lesión *</label>
                                    <select name="factor_lesion" id="factor_lesion" class="form-control" required>
                                        <option value="">Seleccione factor</option>
                                        <option value="1.0" {{ old('factor_lesion') == '1.0' ? 'selected' : '' }}>1.0 - Sin lesión</option>
                                        <option value="1.2" {{ old('factor_lesion') == '1.2' ? 'selected' : '' }}>1.2 - Cirugía menor</option>
                                        <option value="1.3" {{ old('factor_lesion') == '1.3' ? 'selected' : '' }}>1.3 - Fractura</option>
                                        <option value="1.5" {{ old('factor_lesion') == '1.5' ? 'selected' : '' }}>1.5 - Sepsis</option>
                                        <option value="1.6" {{ old('factor_lesion') == '1.6' ? 'selected' : '' }}>1.6 - Trauma múltiple</option>
                                        <option value="1.8" {{ old('factor_lesion') == '1.8' ? 'selected' : '' }}>1.8 - Quemaduras graves</option>
                                    </select>
                                    @error('factor_lesion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resultados del Cálculo (Preview) -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h4 class="card-title mb-0">Resultados del Cálculo</h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h5>GEB</h5>
                                            <h3 id="geb_resultado" class="text-primary">0.00</h3>
                                            <small class="text-muted">kcal/día</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h5>GET</h5>
                                            <h3 id="get_resultado" class="text-success">0.00</h3>
                                            <small class="text-muted">kcal/día</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h5>Kcal/kg</h5>
                                            <h3 id="kcal_kg_resultado" class="text-warning">0.00</h3>
                                            <small class="text-muted">kcal por kg</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h5>Estado</h5>
                                            <span class="badge badge-success">Activo</span>
                                            <p class="mt-2 mb-0"><small>Se creará como activo</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-calculator"></i> Calcular y Guardar
                        </button>
                        <a href="{{ route('requerimiento_nutricional.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Usar última medida
    @if($ultimaMedida)
    $('#usarUltimaMedida').click(function() {
        $('#peso_kg_at').val({{ $ultimaMedida->peso_kg }});
        $('#talla_cm_at').val({{ $ultimaMedida->talla_cm }});
        $('#medida_id').val({{ $ultimaMedida->id }});
        calcularResultados();
    });
    @endif

    // Calcular resultados en tiempo real
    function calcularResultados() {
        const peso = parseFloat($('#peso_kg_at').val()) || 0;
        const talla = parseFloat($('#talla_cm_at').val()) || 0;
        const factorActividad = parseFloat($('#factor_actividad').val()) || 0;
        const factorLesion = parseFloat($('#factor_lesion').val()) || 0;

        if (peso > 0 && talla > 0 && factorActividad > 0 && factorLesion > 0) {
            // Fórmula: GEB = ((0.035 * peso) + (1.9484 * talla)) + 837
            const geb = ((0.035 * peso) + (1.9484 * talla)) + 837;
            // GET = GEB * factorActividad * factorLesion
            const get = geb * factorActividad * factorLesion;
            // Kcal por kg = GET / peso
            const kcalPorKg = get / peso;

            $('#geb_resultado').text(geb.toFixed(2));
            $('#get_resultado').text(get.toFixed(2));
            $('#kcal_kg_resultado').text(kcalPorKg.toFixed(2));
        }
    }

    // Event listeners para cálculo en tiempo real
    $('#peso_kg_at, #talla_cm_at, #factor_actividad, #factor_lesion').on('input change', calcularResultados);

    // Calcular al cargar la página si hay valores
    calcularResultados();
});
</script>
@endsection