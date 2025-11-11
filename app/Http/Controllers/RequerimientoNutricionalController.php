<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Medida;
use App\Models\RequerimientoNutricional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RequerimientoNutricionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado', 'activo');
        $genero = $request->input('genero');
        
        $pacientes = Paciente::with(['tutor', 'medidas' => function($query) {
                $query->orderBy('fecha', 'desc')->limit(1);
            }])
            ->when($search, function($query, $search) {
                $searchLower = strtolower($search);
                return $query->where(function($q) use ($searchLower, $search) {
                    $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$searchLower}%"])
                    ->orWhereRaw('LOWER(apellido_paterno) LIKE ?', ["%{$searchLower}%"])
                    ->orWhereRaw('LOWER(apellido_materno) LIKE ?', ["%{$searchLower}%"])
                    ->orWhere('CI', 'LIKE', "%{$search}%")
                    ->orWhereHas('tutor', function($tutorQuery) use ($searchLower) {
                        $tutorQuery->whereRaw('LOWER(nombre) LIKE ?', ["%{$searchLower}%"])
                                    ->orWhereRaw('LOWER(apellido_paterno) LIKE ?', ["%{$searchLower}%"])
                                    ->orWhereRaw('LOWER(apellido_materno) LIKE ?', ["%{$searchLower}%"]);
                    });
                });
            })
            ->when($genero, function($query, $genero) {
                return $query->where('genero', $genero);
            })
            ->where('estado', $estado)
            ->orderBy('nombre')
            ->paginate(10);

        return view('requerimiento_nutricional.index', compact('pacientes', 'search', 'estado', 'genero'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pacienteId = $request->input('paciente_id');
        $paciente = null;
        $ultimaMedida = null;

        if ($pacienteId) {
            $paciente = Paciente::with(['medidas' => function($query) {
                $query->orderBy('fecha', 'desc')->limit(1);
            }])->findOrFail($pacienteId);

            $ultimaMedida = $paciente->medidas->first();
        }

        return view('requerimiento_nutricional.create', compact('paciente', 'ultimaMedida'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug temporal
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'No estás autenticado. Por favor inicia sesión.');
        }

        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'medida_id' => 'nullable|exists:medidas,id',
            'peso_kg_at' => 'required|numeric|min:0.1|max:500',
            'talla_cm_at' => 'required|numeric|min:1|max:300',
            'factor_actividad' => 'required|numeric|min:0.1|max:5',
            'factor_lesion' => 'required|numeric|min:0.1|max:5',
        ]);

        // Debug del usuario autenticado
        $userId = Auth::id();
        $userName = Auth::user()->name;
        
        // Calcular valores
        $geb = RequerimientoNutricional::calcularGEB(
            $validated['peso_kg_at'],
            $validated['talla_cm_at']
        );

        $get = RequerimientoNutricional::calcularGET(
            $geb,
            $validated['factor_actividad'],
            $validated['factor_lesion']
        );

        $kcalPorKg = RequerimientoNutricional::calcularKcalPorKg(
            $get,
            $validated['peso_kg_at']
        );

        // Crear el requerimiento nutricional
        $requerimiento = RequerimientoNutricional::create([
            'paciente_id' => $validated['paciente_id'],
            'medida_id' => $validated['medida_id'],
            'peso_kg_at' => $validated['peso_kg_at'],
            'talla_cm_at' => $validated['talla_cm_at'],
            'geb_kcal' => $geb,
            'factor_actividad' => $validated['factor_actividad'],
            'factor_lesion' => $validated['factor_lesion'],
            'get_kcal' => $get,
            'kcal_por_kg' => $kcalPorKg,
            'estado' => 'activo',
            'registrado_por' => $userId, // Usar la variable directamente
            'calculado_en' => now(),
        ]);

        // Debug de lo que se está guardando
        \Log::info('Requerimiento creado', [
            'user_id' => $userId,
            'user_name' => $userName,
            'requerimiento_id' => $requerimiento->id,
            'paciente_id' => $requerimiento->paciente_id
        ]);

        return redirect()->route('requerimiento_nutricional.index')
            ->with('success', 'Requerimiento nutricional calculado y guardado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequerimientoNutricional $requerimientoNutricional)
    {
        $requerimiento = $requerimientoNutricional->load(['paciente', 'medida', 'registradoPor']);
        return view('requerimiento_nutricional.show', compact('requerimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequerimientoNutricional $requerimientoNutricional)
    {
        $requerimiento = $requerimientoNutricional->load(['paciente', 'medida']);
        return view('requerimiento_nutricional.edit', compact('requerimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequerimientoNutricional $requerimientoNutricional)
    {
        $validated = $request->validate([
            'peso_kg_at' => 'required|numeric|min:0.1|max:500',
            'talla_cm_at' => 'required|numeric|min:1|max:300',
            'factor_actividad' => 'required|numeric|min:0.1|max:5',
            'factor_lesion' => 'required|numeric|min:0.1|max:5',
            'estado' => ['required', Rule::in(['activo', 'inactivo'])],
        ]);

        // Recalcular valores si cambian peso, talla o factores
        $geb = RequerimientoNutricional::calcularGEB(
            $validated['peso_kg_at'],
            $validated['talla_cm_at']
        );

        $get = RequerimientoNutricional::calcularGET(
            $geb,
            $validated['factor_actividad'],
            $validated['factor_lesion']
        );

        $kcalPorKg = RequerimientoNutricional::calcularKcalPorKg(
            $get,
            $validated['peso_kg_at']
        );

        // Actualizar el requerimiento
        $requerimientoNutricional->update([
            'peso_kg_at' => $validated['peso_kg_at'],
            'talla_cm_at' => $validated['talla_cm_at'],
            'geb_kcal' => $geb,
            'factor_actividad' => $validated['factor_actividad'],
            'factor_lesion' => $validated['factor_lesion'],
            'get_kcal' => $get,
            'kcal_por_kg' => $kcalPorKg,
            'estado' => $validated['estado'],
            'calculado_en' => now(), // Actualizar la fecha de cálculo
        ]);

        return redirect()->route('requerimiento_nutricional.index')
            ->with('success', 'Requerimiento nutricional actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequerimientoNutricional $requerimientoNutricional)
    {
        $requerimientoNutricional->delete();

        return redirect()->route('requerimiento_nutricional.index')
            ->with('success', 'Requerimiento nutricional eliminado exitosamente.');
    }

    /**
     * Cambiar estado del requerimiento
     */
    public function cambiarEstado(Request $request, RequerimientoNutricional $requerimientoNutricional)
    {
        $request->validate([
            'estado' => ['required', Rule::in(['activo', 'inactivo'])]
        ]);

        $requerimientoNutricional->update([
            'estado' => $request->estado
        ]);

        return redirect()->back()
            ->with('success', 'Estado del requerimiento actualizado exitosamente.');
    }

    /**
     * Obtener última medida del paciente para AJAX
     */
    public function getUltimaMedida($pacienteId)
    {
        $medida = Medida::where('paciente_id', $pacienteId)
            ->orderBy('fecha', 'desc')
            ->first();

        if ($medida) {
            return response()->json([
                'peso_kg' => $medida->peso_kg,
                'talla_cm' => $medida->talla_cm,
                'medida_id' => $medida->id,
                'fecha' => $medida->fecha
            ]);
        }

        return response()->json(null);
    }

    public function historial($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        $requerimientos = RequerimientoNutricional::where('paciente_id', $pacienteId)
            ->with(['registradoPor' => function($query) {
                $query->select('id', 'nombre', 'apellido_paterno', 'apellido_materno');
            }])
            ->orderBy('calculado_en', 'desc')
            ->paginate(10);

        return view('requerimiento_nutricional.historial', compact('paciente', 'requerimientos'));
    }
}