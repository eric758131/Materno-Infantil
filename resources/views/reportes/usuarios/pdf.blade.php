<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Usuarios</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #8e44ad; color: white; }
    </style>
</head>
<body>

<h2 style="text-align:center;">HOSPITAL MATERNO INFANTIL</h2>
<h3 style="text-align:center;">Reporte de Usuarios del Sistema</h3>

<p><b>Generado por:</b> {{ $generado_por->nombre }} {{ $generado_por->apellido_paterno }}</p>
<p><b>Fecha:</b> {{ $fecha_generado }}</p>

<table>
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>CI</th><th>Email</th><th>Teléfono</th><th>Rol</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($usuarios as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->nombre }} {{ $u->apellido_paterno }}</td>
            <td>{{ $u->ci }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->telefono }}</td>
            <td>{{ $u->rol }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
