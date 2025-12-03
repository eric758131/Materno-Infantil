<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Historial de Evaluaciones Antropométricas</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 {
            color: #2c5aa0;
            margin: 0;
            font-size: 16px;
        }
        .header .subtitle {
            color: #666;
            font-size: 12px;
        }
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 6px;
            border-left: 4px solid #2c5aa0;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -8px;
        }
        .col-6 {
            flex: 0 0 50%;
            padding: 0 8px;
            box-sizing: border-box;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-primary { background-color: #cce5ff; color: #004085; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
        }
        .evaluacion-section {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            page-break-inside: avoid;
        }
        .evaluacion-header {
            background-color: #e9ecef;
            padding: 8px;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        .valor-destacado {
            font-weight: bold;
            color: #2c5aa0;
        }
        .diagnostico-box {
            border: 1px solid #e9ecef;
            padding: 6px;
            margin-bottom: 6px;
            border-radius: 3px;
            background-color: #f8f9fa;
            font-size: 9px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HISTORIAL DE EVALUACIONES ANTROPOMÉTRICAS</h1>
        <div class="subtitle">Sistema de Evaluación Nutricional</div>
    </div>

    <!-- Información del Paciente -->
    <div class="section">
        <div class="section-title">INFORMACIÓN DEL PACIENTE</div>
        <div class="row">
            <div class="col-6">
                <strong>Nombre:</strong> {{ $paciente->nombre_completo }}<br>
                <strong>CI:</strong> {{ $paciente->CI }}<br>
                <strong>Género:</strong> 
                <span class="badge badge-{{ $paciente->genero == 'masculino' ? 'primary' : 'success' }}">
                    {{ ucfirst($paciente->genero) }}
                </span>
            </div>
            <div class="col-6">
                <strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nacimiento->format('d/m/Y') }}<br>
                <strong>Total de Evaluaciones:</strong> {{ $medidas->count() }}<br>
                <strong>Generado el:</strong> {{ $fechaGeneracion }}
            </div>
        </div>
    </div>

    <!-- Resumen de Evaluaciones -->
    <div class="section">
        <div class="section-title">RESUMEN DE EVALUACIONES</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Edad</th>
                    <th>Peso (kg)</th>
                    <th>Talla (cm)</th>
                    <th>IMC</th>
                    <th>Z-Score IMC</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medidas as $medida)
                @php $evaluacion = $medida->evaluaciones->first(); @endphp
                <tr>
                    <td>{{ $medida->fecha->format('d/m/Y') }}</td>
                    <td>{{ $medida->edad_meses }} meses</td>
                    <td class="valor-destacado">{{ number_format($medida->peso_kg, 1) }}</td>
                    <td>{{ number_format($medida->talla_cm, 1) }}</td>
                    <td class="valor-destacado">
                        @if($evaluacion)
                            {{ number_format($evaluacion->imc, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($evaluacion)
                            {{ number_format($evaluacion->z_imc, 3) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $medida->estado == 'Activo' ? 'success' : 'secondary' }}">
                            {{ $medida->estado }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Evaluaciones Detalladas -->
    <div class="section">
        <div class="section-title">EVALUACIONES DETALLADAS</div>
        
        @foreach($medidas as $index => $medida)
        @php $evaluacion = $medida->evaluaciones->first(); @endphp
        
        @if($index > 0)
            <div class="page-break"></div>
        @endif

        <div class="evaluacion-section">
            <div class="evaluacion-header">
                <strong>EVALUACIÓN #{{ $index + 1 }} - {{ $medida->fecha->format('d/m/Y') }}</strong>
                <span class="badge badge-{{ $medida->estado == 'Activo' ? 'success' : 'secondary' }} float-right">
                    {{ $medida->estado }}
                </span>
            </div>

            <div class="row mb-2">
                <div class="col-6">
                    <strong>Edad:</strong> {{ $medida->edad_meses }} meses ({{ floor($medida->edad_meses/12) }} años)<br>
                    <strong>Registrado por:</strong> {{ $evaluacion->usuario->nombre_completo ?? 'N/A' }}
                </div>
                <div class="col-6">
                    <strong>Peso Ideal:</strong> 
                    @if($evaluacion)
                        {{ number_format($evaluacion->peso_ideal, 2) }} kg
                    @else
                        -
                    @endif
                    <br>
                    <strong>Diferencia Peso:</strong> 
                    @if($evaluacion)
                        {{ number_format($evaluacion->dif_peso, 2) }} kg
                    @else
                        -
                    @endif
                </div>
            </div>

            @if($evaluacion)
            <div class="row">
                <!-- Medidas Antropométricas -->
                <div class="col-6">
                    <div class="section-title" style="font-size: 11px;">MEDIDAS ANTROPOMÉTRICAS</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Parámetro</th>
                                <th>Valor</th>
                                <th>Z-Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Peso (kg)</td>
                                <td class="valor-destacado">{{ number_format($medida->peso_kg, 2) }}</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Talla (cm)</td>
                                <td class="valor-destacado">{{ number_format($medida->talla_cm, 2) }}</td>
                                <td>{{ number_format($evaluacion->z_talla, 3) }}</td>
                            </tr>
                            <tr>
                                <td>IMC</td>
                                <td class="valor-destacado">{{ number_format($evaluacion->imc, 2) }}</td>
                                <td>{{ number_format($evaluacion->z_imc, 3) }}</td>
                            </tr>
                            <tr>
                                <td>PB (mm)</td>
                                <td class="valor-destacado">{{ number_format($medida->pb_mm, 1) }}</td>
                                <td>{{ number_format($evaluacion->z_pb, 3) }}</td>
                            </tr>
                            <tr>
                                <td>PCT (mm)</td>
                                <td class="valor-destacado">{{ number_format($medida->pct_mm, 1) }}</td>
                                <td>{{ number_format($evaluacion->z_pct, 3) }}</td>
                            </tr>
                            <tr>
                                <td>CMB (mm)</td>
                                <td class="valor-destacado">{{ number_format($evaluacion->cmb_mm, 1) }}</td>
                                <td>{{ number_format($evaluacion->z_cmb, 3) }}</td>
                            </tr>
                            <tr>
                                <td>AMB (mm²)</td>
                                <td class="valor-destacado">{{ number_format($evaluacion->amb_mm2, 1) }}</td>
                                <td>{{ number_format($evaluacion->z_amb, 3) }}</td>
                            </tr>
                            <tr>
                                <td>AGB (mm²)</td>
                                <td class="valor-destacado">{{ number_format($evaluacion->agb_mm2, 1) }}</td>
                                <td>{{ number_format($evaluacion->z_agb, 3) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Diagnósticos -->
                <div class="col-6">
                    <div class="section-title" style="font-size: 11px;">DIAGNÓSTICOS</div>
                    <div class="diagnostico-box">
                        <strong>IMC:</strong><br>
                        {{ $evaluacion->dx_z_imc }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>Talla:</strong><br>
                        {{ $evaluacion->dx_z_talla }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>Pliegue Bicipital:</strong><br>
                        {{ $evaluacion->dx_z_pb }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>Pliegue Tricipital:</strong><br>
                        {{ $evaluacion->dx_z_pct }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>CMB:</strong><br>
                        {{ $evaluacion->dx_z_cmb }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>AMB:</strong><br>
                        {{ $evaluacion->dx_z_amb }}
                    </div>
                    <div class="diagnostico-box">
                        <strong>AGB:</strong><br>
                        {{ $evaluacion->dx_z_agb }}
                    </div>
                </div>
            </div>
            @else
            <div class="text-center" style="color: #dc3545; padding: 20px;">
                <strong>EVALUACIÓN NO DISPONIBLE</strong>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="footer">
        <div class="row">
            <div class="col-6">
                Generado el: {{ $fechaGeneracion }}
            </div>
            <div class="col-6 text-right">
                Página <span class="page-number"></span>
            </div>
        </div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 9;
            $font = $fontMetrics->getFont("sans-serif");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 25;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>