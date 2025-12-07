<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\FrisanchoExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class FrisanchoController extends Controller
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

        // Construcción de consulta
        $query = DB::table('frisancho_ref');

        // FILTROS
        foreach ($filters as $campo => $valor) {
            if (!$valor) continue;

            switch ($campo) {
                case 'genero':
                    $query->where('genero', $valor);
                    break;

                case 'edad_desde':
                    $query->where('edad_anios', '>=', $valor);
                    break;

                case 'edad_hasta':
                    $query->where('edad_anios', '<=', $valor);
                    break;

                case 'q':
                    $query->where(function ($q) use ($valor) {
                        $q->where('genero', 'ilike', "%$valor%");
                    });
                    break;
            }
        }

        // Obtener estadísticas básicas
        $estadisticas = [
            'total' => $query->count(),
            'masculino' => $query->clone()->where('genero', 'masculino')->count(),
            'femenino' => $query->clone()->where('genero', 'femenino')->count(),
            'edad_min' => $query->clone()->min('edad_anios'),
            'edad_max' => $query->clone()->max('edad_anios'),
        ];

        // Obtener resultados paginados
        $referencias = $query->orderBy('genero')
                            ->orderBy('edad_anios')
                            ->paginate(20)
                            ->withQueryString();

        return view('reportes.frisancho.index', compact(
            'referencias', 
            'filters',
            'estadisticas'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new FrisanchoExport($request->all()),
            'Referencias_Frisancho_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = DB::table('frisancho_ref');

        // Aplicar filtros
        foreach ($request->all() as $campo => $valor) {
            if (!$valor) continue;

            if ($campo === 'genero') {
                $query->where('genero', $valor);
            } elseif (in_array($campo, ['edad_desde', 'edad_hasta'])) {
                $campoDB = $campo === 'edad_desde' ? '>=' : '<=';
                $query->where('edad_anios', $campoDB, $valor);
            }
        }

        $referencias = $query->orderBy('genero')
                            ->orderBy('edad_anios')
                            ->get();

        $estadisticas = [
            'total' => $referencias->count(),
            'masculino' => $referencias->where('genero', 'masculino')->count(),
            'femenino' => $referencias->where('genero', 'femenino')->count(),
        ];

        $pdf = Pdf::loadView('reportes.frisancho.pdf', [
            'referencias' => $referencias,
            'estadisticas' => $estadisticas,
            'generado_por' => Auth::user(),
            'fecha_generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->stream('Referencias_Frisancho_' . now()->format('Ymd_His') . '.pdf');
    }
}