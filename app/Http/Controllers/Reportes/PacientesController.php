<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\PacientesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class PacientesController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtros
        $filters = $request->only([
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'CI',
            'genero',
            'estado',
            'tutor_nombre',
            'tutor_ci',
            'fecha_nacimiento_desde',
            'fecha_nacimiento_hasta',
            'created_desde',
            'created_hasta',
            'parentesco',
            'q',
        ]);

        // Construcción de consulta principal
        $query = DB::table('pacientes as p')
            ->leftJoin('tutores as t', 'p.tutor_id', '=', 't.id')
            ->select(
                'p.*',
                't.nombre as tutor_nombre',
                't.apellido_paterno as tutor_apellido_paterno',
                't.apellido_materno as tutor_apellido_materno',
                't.CI as tutor_ci',
                't.telefono as tutor_telefono',
                't.direccion as tutor_direccion',
                't.parentesco'
            );

        // FILTROS
        foreach ($filters as $campo => $valor) {
            if (!$valor) continue;

            switch ($campo) {
                case 'nombre':
                case 'apellido_paterno':
                case 'apellido_materno':
                case 'CI':
                case 'genero':
                case 'estado':
                    $query->where("p.$campo", 'ilike', "%$valor%");
                    break;

                case 'tutor_nombre':
                    $query->where(function ($q) use ($valor) {
                        $q->where('t.nombre', 'ilike', "%$valor%")
                        ->orWhere('t.apellido_paterno', 'ilike', "%$valor%");
                    });
                    break;

                case 'tutor_ci':
                    $query->where('t.CI', 'ilike', "%$valor%");
                    break;

                case 'parentesco':
                    $query->where('t.parentesco', $valor);
                    break;

                case 'fecha_nacimiento_desde':
                    $query->whereDate('p.fecha_nacimiento', '>=', $valor);
                    break;

                case 'fecha_nacimiento_hasta':
                    $query->whereDate('p.fecha_nacimiento', '<=', $valor);
                    break;

                case 'created_desde':
                    $query->whereDate('p.created_at', '>=', $valor);
                    break;

                case 'created_hasta':
                    $query->whereDate('p.created_at', '<=', $valor);
                    break;

                case 'q':
                    $query->where(function ($q) use ($valor) {
                        $q->where('p.nombre', 'ilike', "%$valor%")
                            ->orWhere('p.apellido_paterno', 'ilike', "%$valor%")
                            ->orWhere('p.apellido_materno', 'ilike', "%$valor%")
                            ->orWhere('p.CI', 'ilike', "%$valor%")
                            ->orWhere('t.nombre', 'ilike', "%$valor%")
                            ->orWhere('t.CI', 'ilike', "%$valor%");
                    });
                    break;
            }
        }

        // Obtener parentescos únicos para el filtro
        $parentescos = DB::table('tutores')->select('parentesco')->distinct()->get();

        // Obtener resultados paginados
        $pacientes = $query->orderBy('p.apellido_paterno')->paginate(20)->withQueryString();

        // Obtener TODOS los pacientes sin paginación para estadísticas
        $queryEstadisticas = DB::table('pacientes as p')
            ->leftJoin('tutores as t', 'p.tutor_id', '=', 't.id')
            ->select('p.*', 't.parentesco');

        // Aplicar mismos filtros a estadísticas
        foreach ($filters as $campo => $valor) {
            if (!$valor) continue;
            
            if (in_array($campo, ['nombre', 'apellido_paterno', 'apellido_materno', 'CI', 'genero', 'estado'])) {
                $queryEstadisticas->where("p.$campo", 'ilike', "%$valor%");
            }
        }

        $todosPacientes = $queryEstadisticas->get();

        // Calcular estadísticas para gráficos
        $datosGraficos = [
            'masculino' => $todosPacientes->where('genero', 'masculino')->count(),
            'femenino' => $todosPacientes->where('genero', 'femenino')->count(),
            'activos' => $todosPacientes->where('estado', 'activo')->count(),
            'inactivos' => $todosPacientes->where('estado', 'inactivo')->count(),
            'edades_0_19' => [0, 0, 0, 0], // 0-4, 5-9, 10-14, 15-19
            'parentescos' => []
        ];

        // Calcular distribución por edades (0-19 años)
        foreach ($todosPacientes as $paciente) {
            if ($paciente->fecha_nacimiento) {
                $edad = \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age;
                
                if ($edad <= 4) {
                    $datosGraficos['edades_0_19'][0]++;
                } elseif ($edad <= 9) {
                    $datosGraficos['edades_0_19'][1]++;
                } elseif ($edad <= 14) {
                    $datosGraficos['edades_0_19'][2]++;
                } elseif ($edad <= 19) {
                    $datosGraficos['edades_0_19'][3]++;
                }
            }
        }

        // Calcular distribución por parentesco
        $parentescosCount = $todosPacientes->whereNotNull('parentesco')
            ->groupBy('parentesco')
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();
        
        $datosGraficos['parentescos'] = $parentescosCount;

        // Estadísticas adicionales para la vista
        $pacientesActivos = $todosPacientes->where('estado', 'activo')->count();
        $pacientesSinTutor = $todosPacientes->whereNull('tutor_id')->count();

        return view('reportes.pacientes.index', compact(
            'pacientes', 
            'parentescos', 
            'filters',
            'datosGraficos',
            'pacientesActivos',
            'pacientesSinTutor'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PacientesExport($request->all()),
            'Reporte_Pacientes_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = DB::table('pacientes as p')
            ->leftJoin('tutores as t', 'p.tutor_id', '=', 't.id')
            ->select(
                'p.*',
                't.nombre as tutor_nombre',
                't.apellido_paterno as tutor_apellido_paterno',
                't.apellido_materno as tutor_apellido_materno',
                't.CI as tutor_ci',
                't.telefono as tutor_telefono',
                't.parentesco'
            );

        // Aplicar mismos filtros
        foreach ($request->all() as $campo => $valor) {
            if (!$valor) continue;

            if (in_array($campo, ['nombre', 'apellido_paterno', 'apellido_materno', 'CI', 'genero', 'estado'])) {
                $query->where("p.$campo", 'ilike', "%$valor%");
            }
        }

        $pacientes = $query->orderBy('p.apellido_paterno')->get();

        // Calcular estadísticas para el PDF
        $estadisticas = [
            'total' => $pacientes->count(),
            'activos' => $pacientes->where('estado', 'activo')->count(),
            'masculino' => $pacientes->where('genero', 'masculino')->count(),
            'femenino' => $pacientes->where('genero', 'femenino')->count(),
            'con_tutor' => $pacientes->whereNotNull('tutor_id')->count(),
            'sin_tutor' => $pacientes->whereNull('tutor_id')->count(),
        ];

        $pdf = Pdf::loadView('reportes.pacientes.pdf', [
            'pacientes' => $pacientes,
            'estadisticas' => $estadisticas,
            'generado_por' => Auth::user(),
            'fecha_generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->stream('Reporte_Pacientes_' . now()->format('Ymd_His') . '.pdf');
    }
}