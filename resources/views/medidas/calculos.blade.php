@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-calculator me-2"></i>Cálculos Detallados
                        </h4>
                        <div>
                            <a href="{{ route('medidas.show', $medida->id) }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Volver a Resultados
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información del Paciente -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Datos del Paciente</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> {{ $medida->paciente->nombre_completo }}</p>
                                    <p><strong>CI:</strong> {{ $medida->paciente->CI }}</p>
                                    <p><strong>Género:</strong> 
                                        <span class="badge bg-{{ $medida->paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                                            {{ ucfirst($medida->paciente->genero) }}
                                        </span>
                                    </p>
                                    <p><strong>Fecha Nacimiento:</strong> {{ \Carbon\Carbon::parse($medida->paciente->fecha_nacimiento)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Datos de Medición</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Fecha Medición:</strong> {{ \Carbon\Carbon::parse($medida->fecha)->format('d/m/Y') }}</p>
                                    <p><strong>Edad:</strong> {{ $medida->edad_meses }} meses</p>
                                    <p><strong>Peso:</strong> {{ $medida->peso_kg }} kg</p>
                                    <p><strong>Talla:</strong> {{ $medida->talla_cm }} cm</p>
                                    <p><strong>PB:</strong> {{ $medida->pb_mm }} mm</p>
                                    <p><strong>PCT:</strong> {{ $medida->pct_mm }} mm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($evaluacion && count($calculos) > 0)
                        <!-- 1. CÁLCULO DE IMC -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">1. Cálculo del Índice de Masa Corporal (IMC)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Fórmula General:</strong> IMC = peso (kg) / [talla (m)]²</p>
                                        <p><strong>Fórmula con Datos:</strong> IMC = {{ $calculos['imc']['peso_kg'] }} / [{{ $calculos['imc']['talla_metros'] }}]²</p>
                                        <p><strong>Desarrollo:</strong></p>
                                        <ul>
                                            <li>Convertir talla a metros: {{ $calculos['imc']['talla_cm'] }} cm ÷ 100 = {{ $calculos['imc']['talla_metros'] }} m</li>
                                            <li>Calcular talla al cuadrado: [{{ $calculos['imc']['talla_metros'] }}]² = {{ number_format($calculos['imc']['talla_metros'] * $calculos['imc']['talla_metros'], 4) }} m²</li>
                                            <li>Dividir peso entre talla²: {{ $calculos['imc']['peso_kg'] }} ÷ {{ number_format($calculos['imc']['talla_metros'] * $calculos['imc']['talla_metros'], 4) }}</li>
                                        </ul>
                                        <p><strong>Resultado Final:</strong> {{ number_format($calculos['imc']['resultado'], 2) }} kg/m²</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-secondary">
                                            <strong>Resumen del Cálculo:</strong><br>
                                            <code>
                                                IMC = peso / (talla × talla)<br>
                                                IMC = {{ $calculos['imc']['peso_kg'] }} / ({{ $calculos['imc']['talla_metros'] }} × {{ $calculos['imc']['talla_metros'] }})<br>
                                                IMC = {{ $calculos['imc']['peso_kg'] }} / {{ number_format($calculos['imc']['talla_metros'] * $calculos['imc']['talla_metros'], 4) }}<br>
                                                IMC = {{ number_format($calculos['imc']['resultado'], 2) }}
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. CÁLCULO DE MEDIDAS DERIVADAS -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">2. Cálculo de Medidas Antropométricas Derivadas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- CMB -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Circunferencia Muscular Braquial (CMB)</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Fórmula General:</strong> CMB = PB - (π × PCT)</p>
                                                <p><strong>Fórmula con Datos:</strong> CMB = {{ $calculos['cmb']['pb_mm'] }} - (3.1416 × {{ $calculos['cmb']['pct_mm'] }})</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Calcular π × PCT: 3.1416 × {{ $calculos['cmb']['pct_mm'] }} = {{ number_format(3.1416 * $calculos['cmb']['pct_mm'], 2) }}</li>
                                                    <li>Restar de PB: {{ $calculos['cmb']['pb_mm'] }} - {{ number_format(3.1416 * $calculos['cmb']['pct_mm'], 2) }}</li>
                                                </ul>
                                                <p><strong>Resultado Final:</strong> {{ number_format($calculos['cmb']['resultado'], 1) }} mm</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- AMB -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Área Muscular Braquial (AMB)</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Fórmula General:</strong> AMB = (CMB² / 4π) - 100</p>
                                                <p><strong>Fórmula con Datos:</strong> AMB = ({{ number_format($calculos['cmb']['resultado'], 1) }}² / 12.57) - 100</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Calcular CMB²: {{ number_format($calculos['cmb']['resultado'], 1) }} × {{ number_format($calculos['cmb']['resultado'], 1) }} = {{ number_format($calculos['cmb']['resultado'] * $calculos['cmb']['resultado'], 2) }}</li>
                                                    <li>Dividir entre 4π (12.57): {{ number_format($calculos['cmb']['resultado'] * $calculos['cmb']['resultado'], 2) }} ÷ 12.57 = {{ number_format(($calculos['cmb']['resultado'] * $calculos['cmb']['resultado']) / 12.57, 2) }}</li>
                                                    <li>Restar 100: {{ number_format(($calculos['cmb']['resultado'] * $calculos['cmb']['resultado']) / 12.57, 2) }} - 100</li>
                                                </ul>
                                                <p><strong>Resultado Final:</strong> {{ number_format($calculos['amb']['resultado'], 1) }} mm²</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- AGB -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Área Grasa Braquial (AGB)</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Fórmula General:</strong> AGB = (PB² / 4π) - (AMB + 100)</p>
                                                <p><strong>Fórmula con Datos:</strong> AGB = ({{ $calculos['agb']['pb_mm'] }}² / 12.57) - ({{ number_format($calculos['amb']['resultado'], 1) }} + 100)</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Calcular PB²: {{ $calculos['agb']['pb_mm'] }} × {{ $calculos['agb']['pb_mm'] }} = {{ number_format($calculos['agb']['pb_mm'] * $calculos['agb']['pb_mm'], 2) }}</li>
                                                    <li>Dividir entre 4π (12.57): {{ number_format($calculos['agb']['pb_mm'] * $calculos['agb']['pb_mm'], 2) }} ÷ 12.57 = {{ number_format(($calculos['agb']['pb_mm'] * $calculos['agb']['pb_mm']) / 12.57, 2) }}</li>
                                                    <li>Calcular AMB + 100: {{ number_format($calculos['amb']['resultado'], 1) }} + 100 = {{ number_format($calculos['amb']['resultado'] + 100, 1) }}</li>
                                                    <li>Restar: {{ number_format(($calculos['agb']['pb_mm'] * $calculos['agb']['pb_mm']) / 12.57, 2) }} - {{ number_format($calculos['amb']['resultado'] + 100, 1) }}</li>
                                                </ul>
                                                <p><strong>Resultado Final:</strong> {{ number_format($calculos['agb']['resultado'], 1) }} mm²</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. CÁLCULO DE Z-SCORES OMS -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0">3. Cálculo de Z-Scores (Referencia OMS)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Z-Score IMC</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Valor del Paciente:</strong> {{ number_format($calculos['imc']['resultado'], 2) }}</p>
                                                <p><strong>Valores de Referencia OMS:</strong></p>
                                                <ul>
                                                    <li>Mediana: {{ $calculos['z_imc']['mediana'] }}</li>
                                                    <li>+1 SD: {{ $calculos['z_imc']['mas_sd'] }}</li>
                                                    <li>-1 SD: {{ $calculos['z_imc']['menos_sd'] }}</li>
                                                </ul>
                                                <p><strong>Fórmula General:</strong> 
                                                    @if($calculos['z_imc']['es_mayor'])
                                                        Z = (valor - mediana) / (+1SD - mediana)
                                                    @else
                                                        Z = (valor - mediana) / (mediana - (-1SD))
                                                    @endif
                                                </p>
                                                <p><strong>Fórmula con Datos:</strong> {{ $calculos['z_imc']['formula'] }}</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Diferencia: {{ $calculos['z_imc']['valor'] }} - {{ $calculos['z_imc']['mediana'] }} = {{ $calculos['z_imc']['diferencia'] }}</li>
                                                    <li>Denominador: {{ $calculos['z_imc']['denominador'] }}</li>
                                                    <li>División: {{ $calculos['z_imc']['diferencia'] }} ÷ {{ $calculos['z_imc']['denominador'] }}</li>
                                                </ul>
                                                <p><strong>Resultado Final:</strong> {{ number_format($calculos['z_imc']['resultado'], 3) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Z-Score Talla</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Valor del Paciente:</strong> {{ $medida->talla_cm }} cm</p>
                                                <p><strong>Valores de Referencia OMS:</strong></p>
                                                <ul>
                                                    <li>Mediana: {{ $calculos['z_talla']['mediana'] }} cm</li>
                                                    <li>+1 SD: {{ $calculos['z_talla']['mas_sd'] }} cm</li>
                                                    <li>-1 SD: {{ $calculos['z_talla']['menos_sd'] }} cm</li>
                                                </ul>
                                                <p><strong>Fórmula General:</strong> 
                                                    @if($calculos['z_talla']['es_mayor'])
                                                        Z = (valor - mediana) / (+1SD - mediana)
                                                    @else
                                                        Z = (valor - mediana) / (mediana - (-1SD))
                                                    @endif
                                                </p>
                                                <p><strong>Fórmula con Datos:</strong> {{ $calculos['z_talla']['formula'] }}</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Diferencia: {{ $calculos['z_talla']['valor'] }} - {{ $calculos['z_talla']['mediana'] }} = {{ $calculos['z_talla']['diferencia'] }}</li>
                                                    <li>Denominador: {{ $calculos['z_talla']['denominador'] }}</li>
                                                    <li>División: {{ $calculos['z_talla']['diferencia'] }} ÷ {{ $calculos['z_talla']['denominador'] }}</li>
                                                </ul>
                                                <p><strong>Resultado Final:</strong> {{ number_format($calculos['z_talla']['resultado'], 3) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Peso Ideal -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <strong>Peso Ideal y Diferencia de Peso</strong>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Fórmula General:</strong> Peso Ideal = IMC_mediana × [talla (m)]²</p>
                                                <p><strong>Fórmula con Datos:</strong> Peso Ideal = {{ $calculos['peso_ideal']['imc_mediana'] }} × [{{ $calculos['imc']['talla_metros'] }}]²</p>
                                                <p><strong>Desarrollo:</strong></p>
                                                <ul>
                                                    <li>Talla al cuadrado: [{{ $calculos['imc']['talla_metros'] }}]² = {{ number_format($calculos['peso_ideal']['talla_metros_cuadrado'], 4) }} m²</li>
                                                    <li>Multiplicar por IMC mediana: {{ $calculos['peso_ideal']['imc_mediana'] }} × {{ number_format($calculos['peso_ideal']['talla_metros_cuadrado'], 4) }}</li>
                                                </ul>
                                                <p><strong>Peso Ideal:</strong> {{ number_format($calculos['peso_ideal']['resultado'], 2) }} kg</p>
                                                <p><strong>Fórmula Diferencia:</strong> Diferencia = Peso Actual - Peso Ideal</p>
                                                <p><strong>Fórmula con Datos:</strong> Diferencia = {{ $medida->peso_kg }} - {{ number_format($calculos['peso_ideal']['resultado'], 2) }}</p>
                                                <p><strong>Diferencia de Peso:</strong> {{ number_format($medida->peso_kg - $calculos['peso_ideal']['resultado'], 2) }} kg</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. CÁLCULO DE Z-SCORES FRISANCHO -->
                        <div class="card mb-4">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">4. Cálculo de Z-Scores (Referencia Frisancho)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach(['z_pb' => 'Circunferencia Braquial', 'z_pct' => 'Pliegue Tricipital', 'z_cmb' => 'CMB', 'z_amb' => 'AMB', 'z_agb' => 'AGB'] as $key => $nombre)
                                        @if(isset($calculos[$key]))
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <strong>Z-Score {{ $nombre }}</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <p><strong>Valor del Paciente:</strong> 
                                                            @if($key == 'z_pb') {{ $medida->pb_mm }} mm
                                                            @elseif($key == 'z_pct') {{ $medida->pct_mm }} mm
                                                            @elseif($key == 'z_cmb') {{ number_format($calculos['cmb']['resultado'], 1) }} mm
                                                            @elseif($key == 'z_amb') {{ number_format($calculos['amb']['resultado'], 1) }} mm²
                                                            @elseif($key == 'z_agb') {{ number_format($calculos['agb']['resultado'], 1) }} mm²
                                                            @endif
                                                        </p>
                                                        <p><strong>Valores de Referencia Frisancho:</strong></p>
                                                        <ul>
                                                            <li>Mediana: {{ $calculos[$key]['mediana'] }}</li>
                                                            <li>+1 SD: {{ $calculos[$key]['mas_sd'] }}</li>
                                                            <li>-1 SD: {{ $calculos[$key]['menos_sd'] }}</li>
                                                        </ul>
                                                        <p><strong>Fórmula General:</strong> 
                                                            @if($calculos[$key]['es_mayor'])
                                                                Z = (valor - mediana) / (+1SD - mediana)
                                                            @else
                                                                Z = (valor - mediana) / (mediana - (-1SD))
                                                            @endif
                                                        </p>
                                                        <p><strong>Fórmula con Datos:</strong> {{ $calculos[$key]['formula'] }}</p>
                                                        <p><strong>Desarrollo:</strong></p>
                                                        <ul>
                                                            <li>Diferencia: {{ $calculos[$key]['valor'] }} - {{ $calculos[$key]['mediana'] }} = {{ $calculos[$key]['diferencia'] }}</li>
                                                            <li>Denominador: {{ $calculos[$key]['denominador'] }}</li>
                                                            <li>División: {{ $calculos[$key]['diferencia'] }} ÷ {{ $calculos[$key]['denominador'] }}</li>
                                                        </ul>
                                                        <p><strong>Resultado Final:</strong> {{ number_format($calculos[$key]['resultado'], 3) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h4>No se encontraron cálculos para esta medida</h4>
                            <p class="mb-0">La evaluación no pudo ser calculada correctamente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1rem;
}
.card-header {
    font-weight: 600;
}
.alert-secondary {
    background-color: #f8f9fa;
    border-color: #6c757d;
}
code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-family: 'Courier New', monospace;
}
</style>
@endpush