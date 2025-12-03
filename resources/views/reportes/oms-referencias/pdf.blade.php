<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Referencias OMS - Patrones de Crecimiento</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 10px; 
            margin: 15px;
        }
        h1, h2, h3, h4 { margin: 0; padding: 0; }
        h1 { color: #2c3e50; font-size: 18px; text-align: center; }
        h2 { color: #2980b9; font-size: 14px; text-align: center; margin-bottom: 5px; }
        h3 { font-size: 12px; color: #7f8c8d; text-align: center; margin-bottom: 10px; }
        
        .header { 
            margin-bottom: 20px;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
        }
        
        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .info-item {
            text-align: center;
            flex: 1;
        }
        
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .info-label {
            font-size: 9px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 4px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .col-grupo { background-color: #f8f9fa; font-weight: bold; }
        .col-imc-minus { background-color: #f8d7da; }
        .col-imc-median { background-color: #d4edda; }
        .col-imc-plus { background-color: #fff3cd; }
        .col-talla-minus { background-color: #f8d7da; }
        .col-talla-median { background-color: #d4edda; }
        .col-talla-plus { background-color: #fff3cd; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #7f8c8d;
            text-align: center;
        }
        
        .page-break { page-break-before: always; }
        
        .summary {
            margin: 10px 0;
            padding: 8px;
            background: #e8f4f8;
            border-radius: 3px;
            font-size: 9px;
        }
        
        .summary-item {
            display: inline-block;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ORGANIZACIÓN MUNDIAL DE LA SALUD</h1>
        <h2>PATRONES DE CRECIMIENTO INFANTIL</h2>
        <h3>Referencias de IMC y Talla para la Edad (0-5 años)</h3>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-value">{{ $estadisticas['total'] }}</div>
                <div class="info-label">Total Referencias</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ $estadisticas['masculino'] }}</div>
                <div class="info-label">Masculino</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ $estadisticas['femenino'] }}</div>
                <div class="info-label">Femenino</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ number_format($estadisticas['imc_promedio_mediana'], 2) }}</div>
                <div class="info-label">IMC Promedio</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ number_format($estadisticas['talla_promedio_mediana'], 1) }}</div>
                <div class="info-label">Talla Promedio (cm)</div>
            </div>
        </div>
        
        <div class="summary">
            <div class="summary-item">
                <strong>Generado por:</strong> {{ $generado_por->nombre }} {{ $generado_por->apellido_paterno }}
            </div>
            <div class="summary-item">
                <strong>Fecha:</strong> {{ $fecha_generado }}
            </div>
            <div class="summary-item">
                <strong>Registros:</strong> {{ count($referencias) }}
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Género</th>
                <th rowspan="2">Edad (meses)</th>
                <th rowspan="2">Edad</th>
                <th colspan="3">IMC (kg/m²)</th>
                <th colspan="3">Talla para la Edad (cm)</th>
            </tr>
            <tr>
                <th class="col-imc-minus">-1SD</th>
                <th class="col-imc-median">Mediana</th>
                <th class="col-imc-plus">+1SD</th>
                <th class="col-talla-minus">-1SD</th>
                <th class="col-talla-median">Mediana</th>
                <th class="col-talla-plus">+1SD</th>
            </tr>
        </thead>
        <tbody>
            @php
                $generoActual = null;
                $rowCount = 0;
            @endphp
            
            @foreach ($referencias as $index => $ref)
            @php
                $edadAnios = floor($ref->edad_meses / 12);
                $edadMesesResto = $ref->edad_meses % 12;
                $edadFormateada = $edadAnios > 0 
                    ? "{$edadAnios}a {$edadMesesResto}m" 
                    : "{$ref->edad_meses}m";
                
                // Agrupar por género
                if ($generoActual !== $ref->genero) {
                    $generoActual = $ref->genero;
                    $rowCount = 0;
                }
                $rowCount++;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="col-grupo text-center">
                    @if($ref->genero == 'masculino')
                        👦 M
                    @else
                        👧 F
                    @endif
                </td>
                <td class="text-center"><strong>{{ $ref->edad_meses }}</strong></td>
                <td class="text-center">{{ $edadFormateada }}</td>
                
                {{-- IMC --}}
                <td class="col-imc-minus">{{ number_format($ref->imc_menos_sd, 2) }}</td>
                <td class="col-imc-median text-bold">{{ number_format($ref->imc_mediana, 2) }}</td>
                <td class="col-imc-plus">{{ number_format($ref->imc_mas_sd, 2) }}</td>
                
                {{-- TALLA --}}
                <td class="col-talla-minus">{{ number_format($ref->talla_menos_sd_cm, 1) }}</td>
                <td class="col-talla-median text-bold">{{ number_format($ref->talla_mediana_cm, 1) }}</td>
                <td class="col-talla-plus">{{ number_format($ref->talla_mas_sd_cm, 1) }}</td>
            </tr>
            
            {{-- Agregar separador cada 12 meses (1 año) --}}
            @if($rowCount % 12 == 0)
            <tr style="background-color: #f8f9fa;">
                <td colspan="10" class="text-center" style="padding: 2px; font-size: 8px;">
                    <em>{{ floor($rowCount/12) }} año(s) completado(s)</em>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i:s') }} | 
        Página 1 de 1 | 
        Fuente: Organización Mundial de la Salud (OMS)
    </div>
    
    @if(count($referencias) > 0)
    <div class="page-break"></div>
    
    <div class="header">
        <h2>RESUMEN ESTADÍSTICO</h2>
    </div>
    
    <h3>Distribución por Edad</h3>
    <table style="width: 80%; margin: 0 auto;">
        <tr>
            <th>Rango de Edad</th>
            <th>Cantidad</th>
            <th>Porcentaje</th>
        </tr>
        <tr>
            <td>0-12 meses</td>
            <td class="text-center">{{ $estadisticas['edad_0_12'] }}</td>
            <td class="text-center">{{ number_format(($estadisticas['edad_0_12'] / $estadisticas['total']) * 100, 1) }}%</td>
        </tr>
        <tr>
            <td>13-24 meses</td>
            <td class="text-center">{{ $estadisticas['edad_13_24'] }}</td>
            <td class="text-center">{{ number_format(($estadisticas['edad_13_24'] / $estadisticas['total']) * 100, 1) }}%</td>
        </tr>
        <tr>
            <td>25-36 meses</td>
            <td class="text-center">{{ $estadisticas['edad_25_36'] }}</td>
            <td class="text-center">{{ number_format(($estadisticas['edad_25_36'] / $estadisticas['total']) * 100, 1) }}%</td>
        </tr>
        <tr>
            <td>37-48 meses</td>
            <td class="text-center">{{ $estadisticas['edad_37_48'] }}</td>
            <td class="text-center">{{ number_format(($estadisticas['edad_37_48'] / $estadisticas['total']) * 100, 1) }}%</td>
        </tr>
        <tr>
            <td>49-60 meses</td>
            <td class="text-center">{{ $estadisticas['edad_49_60'] }}</td>
            <td class="text-center">{{ number_format(($estadisticas['edad_49_60'] / $estadisticas['total']) * 100, 1) }}%</td>
        </tr>
    </table>
    
    <h3>Rangos de Valores</h3>
    <table style="width: 80%; margin: 0 auto;">
        <tr>
            <th>Indicador</th>
            <th>Mínimo</th>
            <th>Máximo</th>
            <th>Promedio</th>
        </tr>
        <tr>
            <td>IMC Mediana</td>
            <td class="text-center">{{ number_format($estadisticas['imc_min_mediana'], 2) }}</td>
            <td class="text-center">{{ number_format($estadisticas['imc_max_mediana'], 2) }}</td>
            <td class="text-center">{{ number_format($estadisticas['imc_promedio_mediana'], 2) }}</td>
        </tr>
        <tr>
            <td>Talla Mediana (cm)</td>
            <td class="text-center">{{ number_format($estadisticas['talla_min_mediana'], 1) }}</td>
            <td class="text-center">{{ number_format($estadisticas['talla_max_mediana'], 1) }}</td>
            <td class="text-center">{{ number_format($estadisticas['talla_promedio_mediana'], 1) }}</td>
        </tr>
    </table>
    
    <div class="summary" style="margin-top: 20px;">
        <h4>Interpretación de los Datos</h4>
        <p style="font-size: 9px; line-height: 1.4;">
            <strong>Desviación Estándar (SD):</strong> Indica qué tan lejos está un valor del promedio.<br>
            <strong>-1SD:</strong> Límite inferior del rango normal de crecimiento.<br>
            <strong>Mediana:</strong> Valor que divide la distribución en dos partes iguales (percentil 50).<br>
            <strong>+1SD:</strong> Límite superior del rango normal de crecimiento.<br>
            <em>Nota: Estos valores son referencias internacionales establecidas por la OMS para monitorear el crecimiento infantil.</em>
        </p>
    </div>
    @endif
</body>
</html>