<?php

namespace App\Http\Controllers;

use App\Models\MoleculaCalorica;
use App\Models\Paciente;
use App\Models\Medida;
use Illuminate\Http\Request;

class MoleculaCaloricaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MoleculaCalorica::with(['paciente' => function($query) {
            $query->select('id', 'nombre', 'apellido_paterno', 'apellido_materno', 'CI');
        }]);

        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filtro por estado
        if ($request->has('estado') && in_array($request->estado, ['activo', 'inactivo'])) {
            if ($request->estado === 'activo') {
                $query->activos();
            } else {
                $query->inactivos();
            }
        }

        // Obtener la molécula más reciente por paciente
        $moleculasCaloricas = $query->latest()->get()
            ->unique('paciente_id')
            ->values();

        return view('molecula_calorica.index', compact('moleculasCaloricas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pacienteId = $request->paciente_id;
        
        if (!$pacienteId) {
            return redirect()->route('molecula_calorica.index')
                ->with('error', 'Debe seleccionar un paciente');
        }

        $paciente = Paciente::with(['medidas' => function($query) {
            $query->latest()->take(1);
        }])->findOrFail($pacienteId);

        $ultimoPeso = $paciente->medidas->first()?->peso_kg ?? 0;

        return view('molecula_calorica.create', compact('paciente', 'ultimoPeso'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'peso_kg' => 'required|numeric|min:0.1|max:500',
            'proteínas_g_kg' => 'required|numeric|min:0|max:50',
            'grasa_g_kg' => 'required|numeric|min:0|max:50',
            'carbohidratos_g_kg' => 'required|numeric|min:0|max:50',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $moleculaCalorica = new MoleculaCalorica($validated);
        
        // Calcular kilocalorías
        $moleculaCalorica->calcularKilocalorias();
        
        $moleculaCalorica->save();

        return redirect()->route('molecula_calorica.index')
            ->with('success', 'Molécula calórica creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paciente = Paciente::with(['moleculasCaloricas' => function($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('molecula_calorica.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $moleculaCalorica = MoleculaCalorica::with('paciente')->findOrFail($id);
        return view('molecula_calorica.edit', compact('moleculaCalorica'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $moleculaCalorica = MoleculaCalorica::findOrFail($id);

        $validated = $request->validate([
            'peso_kg' => 'required|numeric|min:0.1|max:500',
            'proteínas_g_kg' => 'required|numeric|min:0|max:50',
            'grasa_g_kg' => 'required|numeric|min:0|max:50',
            'carbohidratos_g_kg' => 'required|numeric|min:0|max:50',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $moleculaCalorica->fill($validated);
        
        // Recalcular kilocalorías
        $moleculaCalorica->calcularKilocalorias();
        
        $moleculaCalorica->save();

        return redirect()->route('molecula_calorica.show', $moleculaCalorica->paciente_id)
            ->with('success', 'Molécula calórica actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $moleculaCalorica = MoleculaCalorica::findOrFail($id);
        $pacienteId = $moleculaCalorica->paciente_id;
        $moleculaCalorica->delete();

        return redirect()->route('molecula_calorica.show', $pacienteId)
            ->with('success', 'Molécula calórica eliminada exitosamente');
    }

    /**
     * Toggle the estado of the specified resource.
     */
    public function toggleEstado($id)
    {
        $moleculaCalorica = MoleculaCalorica::findOrFail($id);
        
        $moleculaCalorica->estado = $moleculaCalorica->estado === 'activo' ? 'inactivo' : 'activo';
        $moleculaCalorica->save();

        return redirect()->back()
            ->with('success', 'Estado actualizado exitosamente');
    }
}