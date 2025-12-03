<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\OmsReferenciasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class OmsReferenciasController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtros
        $filters = $request->only([
            'genero',
            'edad_desde',
            'edad_hasta',
            'q',
        ]);

        // Construcción de consulta para estadísticas (SIN paginación)
        $queryEstadisticas = DB::table('oms_ref');

        // Construcción de consulta para tabla (CON paginación)
        $queryTabla = DB::table('oms_ref');

        // APLICAR FILTROS A AMBAS CONSULTAS
        foreach ($filters as $campo => $valor) {
            if (!$valor) continue;

            switch ($campo) {
                case 'genero':
                    $queryEstadisticas->where('genero', $valor);
                    $queryTabla->where('genero', $valor);
                    break;

                case 'edad_desde':
                    $queryEstadisticas->where('edad_meses', '>=', $valor);
                    $queryTabla->where('edad_meses', '>=', $valor);
                    break;

                case 'edad_hasta':
                    $queryEstadisticas->where('edad_meses', '<=', $valor);
                    $queryTabla->where('edad_meses', '<=', $valor);
                    break;

                case 'q':
                    $queryEstadisticas->where(function ($q) use ($valor) {
                        $q->where('genero', 'ilike', "%$valor%");
                    });
                    $queryTabla->where(function ($q) use ($valor) {
                        $q->where('genero', 'ilike', "%$valor%");
                    });
                    break;
            }
        }

        // OBTENER DATOS PARA GRÁFICOS (SIN PAGINACIÓN)
        $todosRegistros = $queryEstadisticas->orderBy('genero')
                                            ->orderBy('edad_meses')
                                            ->get();

        // OBTENER DATOS PARA TABLA (CON PAGINACIÓN)
        $referencias = $queryTabla->orderBy('genero')
                                ->orderBy('edad_meses')
                                ->paginate(30)
                                ->withQueryString();

        // CALCULAR ESTADÍSTICAS PARA GRÁFICOS
        $datosGraficos = $this->calcularEstadisticas($todosRegistros);

        return view('reportes.oms-referencias.index', compact(
            'referencias', 
            'filters',
            'datosGraficos'
        ));
    }

    private function calcularEstadisticas($registros)
    {
        // Si no hay registros, retornar datos vacíos
        if ($registros->isEmpty()) {
            return [
                'total' => 0,
                'masculino' => 0,
                'femenino' => 0,
                'edad_0_12' => 0,
                'edad_13_24' => 0,
                'edad_25_36' => 0,
                'edad_37_48' => 0,
                'edad_49_60' => 0,
                'imc_promedio_mediana' => 0,
                'imc_min_mediana' => 0,
                'imc_max_mediana' => 0,
                'talla_promedio_mediana' => 0,
                'talla_min_mediana' => 0,
                'talla_max_mediana' => 0,
                'tendencias_imc_masculino' => array_fill(0, 11, 0),
                'tendencias_imc_femenino' => array_fill(0, 11, 0),
                'tendencias_talla_masculino' => array_fill(0, 11, 0),
                'tendencias_talla_femenino' => array_fill(0, 11, 0),
            ];
        }

        $estadisticas = [
            'total' => $registros->count(),
            'masculino' => $registros->where('genero', 'masculino')->count(),
            'femenino' => $registros->where('genero', 'femenino')->count(),
            
            // Distribución por rangos de edad (en meses)
            'edad_0_12' => $registros->where('edad_meses', '<=', 12)->count(),
            'edad_13_24' => $registros->whereBetween('edad_meses', [13, 24])->count(),
            'edad_25_36' => $registros->whereBetween('edad_meses', [25, 36])->count(),
            'edad_37_48' => $registros->whereBetween('edad_meses', [37, 48])->count(),
            'edad_49_60' => $registros->whereBetween('edad_meses', [49, 60])->count(),
            
            // Estadísticas de IMC
            'imc_promedio_mediana' => $registros->avg('imc_mediana'),
            'imc_min_mediana' => $registros->min('imc_mediana'),
            'imc_max_mediana' => $registros->max('imc_mediana'),
            
            // Estadísticas de Talla
            'talla_promedio_mediana' => $registros->avg('talla_mediana_cm'),
            'talla_min_mediana' => $registros->min('talla_mediana_cm'),
            'talla_max_mediana' => $registros->max('talla_mediana_cm'),
            
            // Datos para gráficos de tendencia
            'tendencias_imc_masculino' => [],
            'tendencias_imc_femenino' => [],
            'tendencias_talla_masculino' => [],
            'tendencias_talla_femenino' => [],
        ];

        // Calcular tendencias por género (cada 6 meses hasta 60 meses)
        $mesesTendencia = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60];
        
        foreach ($mesesTendencia as $mes) {
            $refMasculino = $registros->where('genero', 'masculino')
                                    ->where('edad_meses', $mes)
                                    ->first();
            
            $refFemenino = $registros->where('genero', 'femenino')
                                    ->where('edad_meses', $mes)
                                    ->first();
            
            $estadisticas['tendencias_imc_masculino'][] = $refMasculino ? $refMasculino->imc_mediana : 0;
            $estadisticas['tendencias_imc_femenino'][] = $refFemenino ? $refFemenino->imc_mediana : 0;
            $estadisticas['tendencias_talla_masculino'][] = $refMasculino ? $refMasculino->talla_mediana_cm : 0;
            $estadisticas['tendencias_talla_femenino'][] = $refFemenino ? $refFemenino->talla_mediana_cm : 0;
        }

        return $estadisticas;
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new OmsReferenciasExport($request->all()),
            'Referencias_OMS_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = DB::table('oms_ref');

        // Aplicar filtros
        foreach ($request->all() as $campo => $valor) {
            if (!$valor) continue;

            if ($campo === 'genero') {
                $query->where('genero', $valor);
            } elseif (in_array($campo, ['edad_desde', 'edad_hasta'])) {
                $campoDB = $campo === 'edad_desde' ? '>=' : '<=';
                $query->where('edad_meses', $campoDB, $valor);
            }
        }

        $referencias = $query->orderBy('genero')
                            ->orderBy('edad_meses')
                            ->get();

        $estadisticas = $this->calcularEstadisticas($referencias);

        $pdf = Pdf::loadView('reportes.oms-referencias.pdf', [
            'referencias' => $referencias,
            'estadisticas' => $estadisticas,
            'generado_por' => Auth::user(),
            'fecha_generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->stream('Referencias_OMS_' . now()->format('Ymd_His') . '.pdf');
    }
}