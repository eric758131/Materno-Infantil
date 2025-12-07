<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Referencias Antropométricas Frisancho</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 9px; 
            margin: 10px;
        }
        h1, h2, h3, h4 { margin: 0; padding: 0; }
        h1 { color: #2c3e50; font-size: 16px; text-align: center; }
        h2 { color: #34495e; font-size: 12px; text-align: center; margin-bottom: 5px; }
        h3 { font-size: 10px; color: #7f8c8d; text-align: center; margin-bottom: 8px; }
        
        .header { 
            margin-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
        }
        
        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .info-item {
            text-align: center;
            flex: 1;
        }
        
        .info-value {
            font-size: 10px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .info-label {
            font-size: 7px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 8px;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            padding: 4px 2px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 7px;
        }
        
        td {
            padding: 3px 2px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .col-grupo { 
            background-color: #f8f9fa; 
            font-weight: bold; 
            font-size: 7px;
        }
        
        .col-pb-minus { background-color: #d6eaf8; }
        .col-pb-median { background-color: #3498db; color: white; }
        .col-pb-plus { background-color: #85c1e9; }
        
        .col-pct-minus { background-color: #d5f4e6; }
        .col-pct-median { background-color: #2ecc71; color: white; }
        .col-pct-plus { background-color: #82e0aa; }
        
        .col-cmb-minus { background-color: #fadbd8; }
        .col-cmb-median { background-color: #e74c3c; color: white; }
        .col-cmb-plus { background-color: #f1948a; }
        
        .col-amb-minus { background-color: #e8daef; }
        .col-amb-median { background-color: #9b59b6; color: white; }
        .col-amb-plus { background-color: #c39bd3; }
        
        .col-agb-minus { background-color: #fef9e7; }
        .col-agb-median { background-color: #f1c40f; color: white; }
        .col-agb-plus { background-color: #f7dc6f; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        .footer {
            margin-top: 15px;
            padding-top: 6px;
            border-top: 1px solid #ddd;
            font-size: 7px;
            color: #7f8c8d;
            text-align: center;
        }
        
        .page-break { page-break-before: always; }
        
        .group-header {
            background-color: #ecf0f1;
            font-weight: bold;
            text-align: center;
            padding: 2px;
            font-size: 7px;
        }
        
        .param-header {
            font-weight: bold;
            background-color: #34495e;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REFERENCIAS ANTROPOMÉTRICAS FRISANCHO</h1>
        <h2>TABLAS DE PLIEGUES CUTÁNEOS, CIRCUNFERENCIAS Y ÁREAS DEL BRAZO</h2>
        <h3>Patrones de referencia para evaluación nutricional</h3>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-value">{{ $estadisticas['total'] }}</div>
                <div class="info-label">Total Registros</div>
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
                <div class="info-value">{{ $fecha_generado }}</div>
                <div class="info-label">Fecha Generación</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ $generado_por->nombre }} {{ $generado_por->apellido_paterno }}</div>
                <div class="info-label">Generado por</div>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Género</th>
                <th rowspan="2">Edad (años)</th>
                
                <th colspan="3" class="param-header">PLIEGUE BICIPITAL (mm)</th>
                <th colspan="3" class="param-header">PLIEGUE TRICIPITAL (mm)</th>
                <th colspan="3" class="param-header">CIRCUNF. MUSLO BRAZO (cm)</th>
                <th colspan="3" class="param-header">ÁREA MUSCULAR BRAZO (cm²)</th>
                <th colspan="3" class="param-header">ÁREA GRASA BRAZO (cm²)</th>
            </tr>
            <tr>
                <!-- PB -->
                <th class="col-pb-minus">-1SD</th>
                <th class="col-pb-median">Mediana</th>
                <th class="col-pb-plus">+1SD</th>
                
                <!-- PCT -->
                <th class="col-pct-minus">-1SD</th>
                <th class="col-pct-median">Mediana</th>
                <th class="col-pct-plus">+1SD</th>
                
                <!-- CMB -->
                <th class="col-cmb-minus">-1SD</th>
                <th class="col-cmb-median">Mediana</th>
                <th class="col-cmb-plus">+1SD</th>
                
                <!-- AMB -->
                <th class="col-amb-minus">-1SD</th>
                <th class="col-amb-median">Mediana</th>
                <th class="col-amb-plus">+1SD</th>
                
                <!-- AGB -->
                <th class="col-agb-minus">-1SD</th>
                <th class="col-agb-median">Mediana</th>
                <th class="col-agb-plus">+1SD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($referencias as $index => $ref)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="col-grupo text-center">
                    @if($ref->genero == 'masculino')
                        M
                    @else
                        F
                    @endif
                </td>
                <td class="text-center text-bold">{{ $ref->edad_anios }}</td>
                
                <!-- PB -->
                <td class="col-pb-minus">{{ number_format($ref->pb_menos_sd, 2) }}</td>
                <td class="col-pb-median text-bold">{{ number_format($ref->pb_dato, 2) }}</td>
                <td class="col-pb-plus">{{ number_format($ref->pb_mas_sd, 2) }}</td>
                
                <!-- PCT -->
                <td class="col-pct-minus">{{ number_format($ref->pct_menos_sd, 2) }}</td>
                <td class="col-pct-median text-bold">{{ number_format($ref->pct_dato, 2) }}</td>
                <td class="col-pct-plus">{{ number_format($ref->pct_mas_sd, 2) }}</td>
                
                <!-- CMB -->
                <td class="col-cmb-minus">{{ number_format($ref->cmb_menos_sd, 2) }}</td>
                <td class="col-cmb-median text-bold">{{ number_format($ref->cmb_dato, 2) }}</td>
                <td class="col-cmb-plus">{{ number_format($ref->cmb_mas_sd, 2) }}</td>
                
                <!-- AMB -->
                <td class="col-amb-minus">{{ number_format($ref->amb_menos_sd, 2) }}</td>
                <td class="col-amb-median text-bold">{{ number_format($ref->amb_dato, 2) }}</td>
                <td class="col-amb-plus">{{ number_format($ref->amb_mas_sd, 2) }}</td>
                
                <!-- AGB -->
                <td class="col-agb-minus">{{ number_format($ref->agb_menos_sd, 2) }}</td>
                <td class="col-agb-median text-bold">{{ number_format($ref->agb_dato, 2) }}</td>
                <td class="col-agb-plus">{{ number_format($ref->agb_mas_sd, 2) }}</td>
            </tr>
            
            <!-- Separador cada 5 años -->
            @if(($index + 1) % 5 == 0 && $index + 1 < count($referencias))
            <tr style="background-color: #f8f9fa;">
                <td colspan="19" class="text-center" style="padding: 1px; font-size: 7px;">
                    <em>--- {{ floor(($index + 1)/5) }} grupos de 5 años ---</em>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i:s') }} | 
        Página 1 de 1 | 
        Fuente: Referencias Antropométricas Frisancho - Estándares Latinoamericanos
    </div>
    
    @if(count($referencias) > 0)
    <div class="page-break"></div>
    
    <div class="header">
        <h2>LEGENDA Y EXPLICACIÓN DE PARÁMETROS</h2>
    </div>
    
    <div style="font-size: 8px; line-height: 1.4;">
        <h3>PARÁMETROS ANTROPOMÉTRICOS</h3>
        
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <th width="30%">Parámetro</th>
                <th width="15%">Sigla</th>
                <th width="15%">Unidad</th>
                <th width="40%">Descripción</th>
            </tr>
            <tr>
                <td><strong>Pliegue Bicipital</strong></td>
                <td>PB</td>
                <td>mm</td>
                <td>Espesor del pliegue cutáneo en la región bicipital del brazo</td>
            </tr>
            <tr>
                <td><strong>Pliegue Tricipital</strong></td>
                <td>PCT</td>
                <td>mm</td>
                <td>Espesor del pliegue cutáneo en la región tricipital del brazo</td>
            </tr>
            <tr>
                <td><strong>Circunferencia Muslo Brazo</strong></td>
                <td>CMB</td>
                <td>cm</td>
                <td>Circunferencia del brazo tomada en el punto medio entre acromion y olécranon</td>
            </tr>
            <tr>
                <td><strong>Área Muscular Brazo</strong></td>
                <td>AMB</td>
                <td>cm²</td>
                <td>Área muscular del brazo calculada a partir de CMB y PCT</td>
            </tr>
            <tr>
                <td><strong>Área Grasa Brazo</strong></td>
                <td>AGB</td>
                <td>cm²</td>
                <td>Área grasa del brazo calculada a partir de CMB y PCT</td>
            </tr>
        </table>
        
        <h3>INTERPRETACIÓN DE DESVIACIONES ESTÁNDAR</h3>
        <table style="width: 100%;">
            <tr>
                <th width="20%">Rango</th>
                <th width="15%">Percentil</th>
                <th width="65%">Interpretación Nutricional</th>
            </tr>
            <tr>
                <td><strong>&lt; -2SD</strong></td>
                <td>&lt; 2.3°</td>
                <td>Desnutrición severa / Bajo peso severo</td>
            </tr>
            <tr>
                <td><strong>-2SD a -1SD</strong></td>
                <td>2.3° - 16°</td>
                <td>Riesgo de desnutrición / Bajo peso moderado</td>
            </tr>
            <tr>
                <td><strong>-1SD a +1SD</strong></td>
                <td>16° - 84°</td>
                <td>Estado nutricional normal</td>
            </tr>
            <tr>
                <td><strong>+1SD a +2SD</strong></td>
                <td>84° - 97.7°</td>
                <td>Riesgo de sobrepeso</td>
            </tr>
            <tr>
                <td><strong>&gt; +2SD</strong></td>
                <td>&gt; 97.7°</td>
                <td>Sobrepeso / Obesidad</td>
            </tr>
        </table>
        
        <div style="margin-top: 10px; padding: 8px; background: #f8f9fa; border-radius: 3px;">
            <p style="margin: 0; font-size: 8px;">
                <strong>Nota:</strong> Estas referencias están basadas en estándares antropométricos latinoamericanos 
                (Frisancho, A.R.). Los valores de -1SD, mediana y +1SD corresponden aproximadamente a los percentiles 
                16, 50 y 84 respectivamente, en una distribución normal.
            </p>
        </div>
    </div>
    @endif
</body>
</html>