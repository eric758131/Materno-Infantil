<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\MoleculaCalorica;
use App\Models\RequerimientoNutricional;
use App\Models\Medida;
use Illuminate\Http\Request;

class MoleculaCaloricaController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::query();
        
        // Búsqueda flexible por nombre, apellidos o CI
        if ($request->has('search') && $request->search != '') {
            $search = $this->normalizarBusqueda($request->search);
            $query->where(function($q) use ($search) {
                // Buscar en nombre completo (concatenado y normalizado)
                $q->whereRaw("LOWER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(nombre, ' ', apellido_paterno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(apellido_paterno, ' ', apellido_materno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(apellido_materno, ' ', apellido_paterno)) LIKE ?", ["%{$search}%"])
                ->orWhere('nombre', 'ILIKE', "%{$search}%")  // ILIKE para PostgreSQL (case-insensitive)
                ->orWhere('apellido_paterno', 'ILIKE', "%{$search}%")
                ->orWhere('apellido_materno', 'ILIKE', "%{$search}%")
                ->orWhere('CI', 'ILIKE', "%{$search}%");
            });
        }
        
        $pacientes = $query->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
             ->paginate(10);

        return view('moleculaCalorica.index', compact('pacientes'));
    }

    private function normalizarBusqueda(string $texto): string
    {
        // Convertir a minúsculas y quitar espacios extras
        $texto = strtolower(trim($texto));
        
        // Remover acentos y caracteres especiales
        $texto = $this->removerAcentos($texto);
        
        return $texto;
    }

    private function removerAcentos(string $texto): string
    {
        $acentos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
            'ñ' => 'n', 'Ñ' => 'n',
            'ü' => 'u', 'Ü' => 'u'
        ];
        
        return strtr($texto, $acentos);
    }

    public function create($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        
        $requerimiento = $paciente->requerimientosNutricionales()
            ->where('estado', 'activo')
            ->latest()
            ->first();

        if (!$requerimiento) {
            return redirect()->route('moleculaCalorica.index')
                ->with('error', 'El paciente no tiene un requerimiento nutricional activo.');
        }

        $medida = $paciente->medidas()->latest()->first();

        return view('moleculaCalorica.create', compact('paciente', 'requerimiento', 'medida'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'proteinas_g_kg' => 'required|numeric|min:0.1|max:5',
            'porcentaje_grasas' => 'required|numeric|min:0.05|max:0.6',
            'requerimiento_id' => 'required|exists:requerimientos_nutricionales,id',
            'medida_id' => 'nullable|exists:medidas,id',
            'peso_kg' => 'required|numeric|min:1',
            'talla_cm' => 'required|numeric|min:1',
            'kilocalorias_totales' => 'required|numeric|min:1',
        ]);

        try {
            $molecula = new MoleculaCalorica();
            $molecula->paciente_id = $validated['paciente_id'];
            $molecula->requerimiento_id = $validated['requerimiento_id'];
            $molecula->medida_id = $validated['medida_id'];
            $molecula->peso_kg = $validated['peso_kg'];
            $molecula->talla_cm = $validated['talla_cm'];
            $molecula->kilocalorias_totales = $validated['kilocalorias_totales'];
            $molecula->registrado_por = auth()->id();
            
            $molecula->calcularMoleculaCalorica(
                $validated['proteinas_g_kg'],
                $validated['porcentaje_grasas']
            );

            $molecula->save();

            return redirect()->route('moleculaCalorica.index')
                ->with('success', 'Molécula calórica calculada y guardada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al calcular la molécula calórica: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $molecula = MoleculaCalorica::with(['paciente', 'requerimiento', 'medida', 'registradoPor'])
            ->findOrFail($id);

        return view('moleculaCalorica.show', compact('molecula'));
    }

    public function edit($id)
    {
        $molecula = MoleculaCalorica::with(['paciente', 'requerimiento', 'medida'])
            ->findOrFail($id);

        $ultimoRequerimiento = $molecula->paciente->requerimientosNutricionales()
            ->where('estado', 'activo')
            ->latest()
            ->first();

        $ultimaMedida = $molecula->paciente->medidas()
            ->latest()
            ->first();

        return view('moleculaCalorica.edit', compact('molecula', 'ultimoRequerimiento', 'ultimaMedida'));
    }

    public function update(Request $request, $id)
    {
        $molecula = MoleculaCalorica::findOrFail($id);

        $validated = $request->validate([
            'proteinas_g_kg' => 'required|numeric|min:0.1|max:5',
            'porcentaje_grasas' => 'required|numeric|min:0.05|max:0.6',
            'requerimiento_id' => 'required|exists:requerimientos_nutricionales,id',
            'medida_id' => 'nullable|exists:medidas,id',
            'peso_kg' => 'required|numeric|min:1',
            'talla_cm' => 'required|numeric|min:1',
            'kilocalorias_totales' => 'required|numeric|min:1',
        ]);

        try {
            $molecula->requerimiento_id = $validated['requerimiento_id'];
            $molecula->medida_id = $validated['medida_id'];
            $molecula->peso_kg = $validated['peso_kg'];
            $molecula->talla_cm = $validated['talla_cm'];
            $molecula->kilocalorias_totales = $validated['kilocalorias_totales'];
            
            $molecula->calcularMoleculaCalorica(
                $validated['proteinas_g_kg'],
                $validated['porcentaje_grasas']
            );

            $molecula->save();

            return redirect()->route('moleculaCalorica.index')
                ->with('success', 'Molécula calórica actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la molécula calórica: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(MoleculaCalorica $moleculaCalorica)
    {
        $moleculaCalorica->estado = $moleculaCalorica->estado === 'activo' ? 'inactivo' : 'activo';
        $moleculaCalorica->save();

        $action = $moleculaCalorica->estado === 'activo' ? 'reactivada' : 'desactivada';
        return redirect()->route('moleculaCalorica.index')
            ->with('success', "Molécula calórica $action exitosamente");
    }
}