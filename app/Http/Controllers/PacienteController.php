<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado', 'activo');
        $genero = $request->input('genero');
        
        $pacientes = Paciente::with('tutor')
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

        return view('pacientes.index', compact('pacientes', 'search', 'estado', 'genero'));
    }

    public function create()
    {
        $tutores = Tutor::activos()->get();
        return view('pacientes.create', compact('tutores'));
    }

    public function store(Request $request)
    {
        $validator = $this->validarPaciente($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Normalizar datos antes de guardar
        $datosPaciente = $this->normalizarDatosPaciente($request->all());

        // Crear o encontrar tutor si se proporcionó información
        if ($request->filled('tutor_nombre')) {
            $tutor = $this->crearOEncontrarTutor($request);
            $datosPaciente['tutor_id'] = $tutor->id;
        }

        Paciente::create($datosPaciente);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente creado exitosamente');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load('tutor');
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        $paciente->load('tutor');
        $tutores = Tutor::activos()->get();
        return view('pacientes.edit', compact('paciente', 'tutores'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $validator = $this->validarPaciente($request, $paciente);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Normalizar datos antes de actualizar
        $datosPaciente = $this->normalizarDatosPaciente($request->all());

        // Gestionar tutor
        if ($request->filled('tutor_nombre')) {
            $tutor = $this->crearOEncontrarTutor($request);
            $datosPaciente['tutor_id'] = $tutor->id;
        } else {
            $datosPaciente['tutor_id'] = null;
        }

        $paciente->update($datosPaciente);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->estado = $paciente->estado === 'activo' ? 'inactivo' : 'activo';
        $paciente->save();

        $action = $paciente->estado === 'activo' ? 'reactivado' : 'desactivado';
        return redirect()->route('pacientes.index')
            ->with('success', "Paciente $action exitosamente");
    }

    /**
     * Validación centralizada para paciente
     */
    private function validarPaciente(Request $request, $paciente = null)
    {
        $rules = [
            'nombre' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'apellido_paterno' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'apellido_materno' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'CI' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pacientes')->ignore($paciente ? $paciente->id : null),
            ],
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'tutor_id' => 'nullable|exists:tutores,id',
            
            // Campos para nuevo tutor
            'tutor_nombre' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'tutor_apellido_paterno' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'tutor_apellido_materno' => 'required|string|max:100|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/',
            'tutor_CI' => 'required|string|max:20|unique:tutores,CI',
            'tutor_telefono' => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'tutor_direccion' => 'required|string|max:255',
            'tutor_parentesco' => 'required|string|max:50',
        ];

        $messages = [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'apellido_paterno.regex' => 'El apellido paterno solo puede contener letras y espacios',
            'apellido_materno.regex' => 'El apellido materno solo puede contener letras y espacios',
            'tutor_nombre.regex' => 'El nombre del tutor solo puede contener letras y espacios',
            'tutor_apellido_paterno.regex' => 'El apellido paterno del tutor solo puede contener letras y espacios',
            'tutor_apellido_materno.regex' => 'El apellido materno del tutor solo puede contener letras y espacios',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser futura',
            'tutor_CI.unique' => 'El CI del tutor ya está registrado en el sistema',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Normalizar datos del paciente
     */
    private function normalizarDatosPaciente($datos)
    {
        return [
            'nombre' => Str::title(trim($datos['nombre'])),
            'apellido_paterno' => Str::title(trim($datos['apellido_paterno'])),
            'apellido_materno' => Str::title(trim($datos['apellido_materno'])),
            'CI' => trim($datos['CI']),
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'genero' => $datos['genero'],
            'estado' => 'activo',
            'tutor_id' => $datos['tutor_id'] ?? null,
        ];
    }

    /**
     * Crear o encontrar tutor existente
     */
    private function crearOEncontrarTutor(Request $request)
    {
        // Buscar tutor por CI primero
        if ($request->filled('tutor_CI')) {
            $tutorExistente = Tutor::where('CI', trim($request->tutor_CI))->first();
            if ($tutorExistente) {
                return $tutorExistente;
            }
        }

        // Crear nuevo tutor
        return Tutor::create([
            'nombre' => Str::title(trim($request->tutor_nombre)),
            'apellido_paterno' => Str::title(trim($request->tutor_apellido_paterno)),
            'apellido_materno' => $request->filled('tutor_apellido_materno') ? Str::title(trim($request->tutor_apellido_materno)) : null,
            'CI' => $request->filled('tutor_CI') ? trim($request->tutor_CI) : null,
            'telefono' => $request->filled('tutor_telefono') ? trim($request->tutor_telefono) : null,
            'direccion' => $request->filled('tutor_direccion') ? trim($request->tutor_direccion) : null,
            'parentesco' => $request->filled('tutor_parentesco') ? trim($request->tutor_parentesco) : 'tutor legal',
            'estado' => 'activo',
        ]);
    }

    /**
     * API: Obtener tutores para select
     */
    public function getTutores(Request $request)
    {
        $search = $request->input('search');
        
        $tutores = Tutor::activos()
            ->when($search, function($query, $search) {
                $searchLower = strtolower($search);
                return $query->whereRaw('LOWER(nombre) LIKE ?', ["%{$searchLower}%"])
                            ->orWhereRaw('LOWER(apellido_paterno) LIKE ?', ["%{$searchLower}%"])
                            ->orWhereRaw('LOWER(apellido_materno) LIKE ?', ["%{$searchLower}%"])
                            ->orWhere('CI', 'LIKE', "%{$search}%");
            })
            ->orderBy('nombre')
            ->limit(10)
            ->get(['id', 'nombre', 'apellido_paterno', 'apellido_materno', 'CI']);

        return response()->json($tutores);
    }

    public function moleculasCaloricas()
    {
        return $this->hasMany(MoleculaCalorica::class);
    }
}