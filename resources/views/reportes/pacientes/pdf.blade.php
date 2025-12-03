<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pacientes</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 11px; 
            margin: 20px;
        }
        h1, h2, h3 { margin: 0; padding: 0; }
        h1 { color: #2c3e50; font-size: 22px; }
        h2 { color: #8e44ad; font-size: 16px; margin-bottom: 10px; }
        h3 { font-size: 12px; color: #7f8c8d; margin-bottom: 20px; }
        
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #8e44ad;
            padding-bottom: 15px;
        }
        
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #8e44ad;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-activo { background-color: #28a745; color: white; }
        .badge-inactivo { background-color: #dc3545; color: white; }
        .badge-masculino { background-color: #3498db; color: white; }
        .badge-femenino { background-color: #e83e8c; color: white; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .page-break { page-break-before: always; }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOSPITAL MATERNO INFANTIL</h1>
        <h2>Reporte de Pacientes</h2>
        <h3>Generado: {{ $fecha_generado }}</h3>
    </div>
    
    <div class="info">
        <strong>Generado por:</strong> {{ $generado_por->nombre }} {{ $generado_por->apellido_paterno }}<br>
        <strong>Total de registros:</strong> {{ count($pacientes) }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Paciente</th>
                <th>CI</th>
                <th>Fecha Nac.</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Tutor</th>
                <th>Parentesco</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $index => $p)
            @php
                $edad = $p->fecha_nacimiento ? \Carbon\Carbon::parse($p->fecha_nacimiento)->age : '';
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $p->nombre }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}
                </td>
                <td>{{ $p->CI }}</td>
                <td>
                    @if($p->fecha_nacimiento)
                        {{ \Carbon\Carbon::parse($p->fecha_nacimiento)->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td class="text-center">{{ $edad }} @if($edad) años @endif</td>
                <td class="text-center">
                    <span class="badge badge-{{ $p->genero }}">
                        {{ ucfirst($p->genero) }}
                    </span>
                </td>
                <td>
                    @if($p->tutor_nombre)
                        {{ $p->tutor_nombre }} {{ $p->tutor_apellido_paterno }}
                        <br><small>CI: {{ $p->tutor_ci }}</small>
                    @else
                        Sin tutor
                    @endif
                </td>
                <td>{{ $p->parentesco ?? 'N/A' }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $p->estado }}">
                        {{ ucfirst($p->estado) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer text-center">
        Generado el {{ now()->format('d/m/Y H:i:s') }} | Página 1 de 1
    </div>
</body>
</html>