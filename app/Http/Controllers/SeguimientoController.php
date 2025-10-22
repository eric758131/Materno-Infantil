<?php

namespace App\Http\Controllers;

use App\Models\Seguimiento;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeguimientoController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::with(['seguimientos', 'tutor'])
            ->withCount(['seguimientos as seguimientos_count'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seguimientos.index', compact('pacientes'));
    }

    public function buscar(Request $request)
    {
        $query = Paciente::with(['seguimientos', 'tutor'])
            ->withCount(['seguimientos as seguimientos_count']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'ILIKE', "%{$search}%")
                ->orWhere('apellido_paterno', 'ILIKE', "%{$search}%")
                ->orWhere('apellido_materno', 'ILIKE', "%{$search}%")
                ->orWhere('CI', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pacientes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('seguimientos.index', compact('pacientes'));
    }

    public function create(Request $request)
    {
        $pacientes = Paciente::activos()->get();
        
        // Si viene paciente_id por parámetro, seleccionar ese paciente
        $pacienteSeleccionado = null;
        if ($request->has('paciente_id')) {
            $pacienteSeleccionado = Paciente::find($request->paciente_id);
        }
        
        return view('seguimientos.create', compact('pacientes', 'pacienteSeleccionado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'peso' => 'required|numeric|min:0.1|max:300',
            'talla' => 'required|numeric|min:30|max:250',
            'fecha_seguimiento' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:activo,inactivo'
        ], [
            'paciente_id.required' => 'El paciente es obligatorio',
            'peso.required' => 'El peso es obligatorio',
            'peso.numeric' => 'El peso debe ser un número válido',
            'peso.min' => 'El peso debe ser mayor a 0.1 kg',
            'peso.max' => 'El peso no puede exceder los 300 kg',
            'talla.required' => 'La talla es obligatoria',
            'talla.numeric' => 'La talla debe ser un número válido',
            'talla.min' => 'La talla debe ser mayor a 30 cm',
            'talla.max' => 'La talla no puede exceder los 250 cm',
            'fecha_seguimiento.required' => 'La fecha de seguimiento es obligatoria',
            'fecha_seguimiento.before_or_equal' => 'La fecha no puede ser futura',
            'estado.required' => 'El estado es obligatorio'
        ]);

        try {
            DB::beginTransaction();

            $validated['peso'] = round($validated['peso'], 2);
            $validated['talla'] = round($validated['talla'], 2);

            Seguimiento::create($validated);

            DB::commit();

            return redirect()->route('seguimientos.index')
                ->with('success', 'Seguimiento creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el seguimiento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        // Cargar el paciente con todos sus seguimientos
        $paciente = Paciente::with(['seguimientos' => function($query) {
            $query->orderBy('fecha_seguimiento', 'desc');
        }, 'tutor'])->findOrFail($id);

        return view('seguimientos.show', compact('paciente'));
    }

    public function edit(Seguimiento $seguimiento)
    {
        $pacientes = Paciente::activos()->get();
        return view('seguimientos.edit', compact('seguimiento', 'pacientes'));
    }

    public function update(Request $request, Seguimiento $seguimiento)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'peso' => 'required|numeric|min:0.1|max:300',
            'talla' => 'required|numeric|min:30|max:250',
            'fecha_seguimiento' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:activo,inactivo'
        ], [
            'paciente_id.required' => 'El paciente es obligatorio',
            'peso.required' => 'El peso es obligatorio',
            'peso.numeric' => 'El peso debe ser un número válido',
            'peso.min' => 'El peso debe ser mayor a 0.1 kg',
            'peso.max' => 'El peso no puede exceder los 300 kg',
            'talla.required' => 'La talla es obligatoria',
            'talla.numeric' => 'La talla debe ser un número válido',
            'talla.min' => 'La talla debe ser mayor a 30 cm',
            'talla.max' => 'La talla no puede exceder los 250 cm',
            'fecha_seguimiento.required' => 'La fecha de seguimiento es obligatoria',
            'fecha_seguimiento.before_or_equal' => 'La fecha no puede ser futura',
            'estado.required' => 'El estado es obligatorio'
        ]);

        try {
            DB::beginTransaction();

            $validated['peso'] = round($validated['peso'], 2);
            $validated['talla'] = round($validated['talla'], 2);

            $seguimiento->update($validated);

            DB::commit();

            return redirect()->route('seguimientos.index')
                ->with('success', 'Seguimiento actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el seguimiento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Seguimiento $seguimiento)
    {
        try {
            // En lugar de delete() usamos update para cambiar el estado
            $seguimiento->update(['estado' => 'inactivo']);
            
            return redirect()->route('seguimientos.index')
                ->with('success', 'Seguimiento desactivado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al desactivar el seguimiento: ' . $e->getMessage());
        }
    }

    public function activar(Seguimiento $seguimiento)
    {
        try {
            $seguimiento->update(['estado' => 'activo']);
            return redirect()->back()
                ->with('success', 'Seguimiento activado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al activar el seguimiento: ' . $e->getMessage());
        }
    }

    public function desactivar(Seguimiento $seguimiento)
    {
        try {
            $seguimiento->update(['estado' => 'inactivo']);
            return redirect()->back()
                ->with('success', 'Seguimiento desactivado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al desactivar el seguimiento: ' . $e->getMessage());
        }
    }

    
}