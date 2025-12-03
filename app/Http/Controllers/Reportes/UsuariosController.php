<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Exports\UsuariosExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtros
        $filters = $request->only([
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'ci',
            'email',
            'telefono',
            'direccion',
            'genero',
            'estado',
            'rol',
            'fecha_nacimiento_desde',
            'fecha_nacimiento_hasta',
            'created_desde',
            'created_hasta',
            'q',
        ]);

        // Obtener roles de Spatie
        $roles = Role::orderBy('name')->get();

        // Construcción de consulta
        $query = DB::table('users as u')
            ->leftJoin('model_has_roles as mr', 'mr.model_id', '=', 'u.id')
            ->leftJoin('roles as r', 'r.id', '=', 'mr.role_id')
            ->select(
                'u.*',
                DB::raw("r.name as rol")
            );

        // FILTROS
        foreach ($filters as $campo => $valor) {
            if (!$valor) continue;

            switch ($campo) {

                case 'nombre':
                case 'apellido_paterno':
                case 'apellido_materno':
                case 'ci':
                case 'email':
                case 'telefono':
                case 'direccion':
                case 'genero':
                case 'estado':
                    $query->where("u.$campo", 'ilike', "%$valor%");
                    break;

                case 'rol':
                    $query->where('r.name', $valor);
                    break;

                case 'fecha_nacimiento_desde':
                    $query->whereDate('u.fecha_nacimiento', '>=', $valor);
                    break;

                case 'fecha_nacimiento_hasta':
                    $query->whereDate('u.fecha_nacimiento', '<=', $valor);
                    break;

                case 'created_desde':
                    $query->whereDate('u.created_at', '>=', $valor);
                    break;

                case 'created_hasta':
                    $query->whereDate('u.created_at', '<=', $valor);
                    break;

                case 'q':
                    $query->where(function ($q) use ($valor) {
                        $q->where('u.nombre', 'ilike', "%$valor%")
                            ->orWhere('u.apellido_paterno', 'ilike', "%$valor%")
                            ->orWhere('u.apellido_materno', 'ilike', "%$valor%")
                            ->orWhere('u.email', 'ilike', "%$valor%")
                            ->orWhere('u.ci', 'ilike', "%$valor%");
                    });
                    break;
            }
        }

        // Obtener resultados paginados
        $usuarios = $query->orderBy('u.apellido_paterno')->paginate(20)->withQueryString();

        return view('reportes.usuarios.index', compact('usuarios', 'roles', 'filters'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new UsuariosExport($request->all()),
            'Reporte_Usuarios_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = DB::table('users as u')
            ->leftJoin('model_has_roles as mr', 'mr.model_id', '=', 'u.id')
            ->leftJoin('roles as r', 'r.id', '=', 'mr.role_id')
            ->select('u.*', 'r.name as rol');

        // aplicar mismo filtrado
        foreach ($request->all() as $campo => $valor) {
            if (!$valor) continue;

            switch ($campo) {
                case 'rol':
                    $query->where('r.name', $valor);
                    break;

                default:
                    if (in_array($campo, ['nombre','apellido_paterno','apellido_materno','ci','email','telefono','direccion','genero','estado'])) {
                        $query->where("u.$campo", 'ilike', "%$valor%");
                    }
                    break;
            }
        }

        $usuarios = $query->get();

        $pdf = Pdf::loadView('reportes.usuarios.pdf', [
            'usuarios' => $usuarios,
            'generado_por' => Auth::user(),
            'fecha_generado' => now()->format('d/m/Y H:i:s'),
        ]);

        return $pdf->stream();
    }
}
