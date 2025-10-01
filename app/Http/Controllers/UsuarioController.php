<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    private function normalizarDatos(array $data): array
    {
        return [
            'nombre' => ucwords(strtolower(trim($data['nombre'] ?? ''))),
            'apellido_paterno' => ucwords(strtolower(trim($data['apellido_paterno'] ?? ''))),
            'apellido_materno' => ucwords(strtolower(trim($data['apellido_materno'] ?? ''))),
            'ci' => preg_replace('/[^0-9]/', '', $data['ci'] ?? ''),
            'email' => strtolower(trim($data['email'] ?? '')),
            'direccion' => ucfirst(trim($data['direccion'] ?? '')),
            'telefono' => preg_replace('/[^0-9+]/', '', $data['telefono'] ?? ''),
            'genero' => $data['genero'] ?? null,
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            'estado' => 'activo' // Estado por defecto
        ];
    }

    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Búsqueda flexible por nombre, apellidos, email o CI
        if ($request->has('search') && $request->search != '') {
            $search = $this->normalizarBusqueda($request->search);
            $query->where(function($q) use ($search) {
                // Buscar en nombre completo (concatenado y normalizado)
                $q->whereRaw("LOWER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(nombre, ' ', apellido_paterno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(apellido_paterno, ' ', apellido_materno)) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(CONCAT(apellido_materno, ' ', apellido_paterno)) LIKE ?", ["%{$search}%"])
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('ci', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }
        
        $users = $query->latest()->get();
        
        return view('usuarios.index', compact('users'));
    }

    private function normalizarBusqueda(string $texto): string
    {
        // Convertir a minúsculas y quitar espacios extras
        $texto = strtolower(trim($texto));
        
        // Remover acentos y caracteres especiales
        $texto = $this->removerAcentos($texto);
        
        // Remover palabras comunes que no ayudan en la búsqueda
        $palabrasComunes = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'e', 'o', 'u', 'a', 'en', 'con', 'por', 'para'];
        $palabras = explode(' ', $texto);
        $palabrasFiltradas = array_diff($palabras, $palabrasComunes);
        
        return implode(' ', $palabrasFiltradas);
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

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_paterno' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_materno' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'ci' => [
                'required',
                'string',
                'min:5',
                'max:15',
                'regex:/^[0-9]+$/',
                'unique:users,ci'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'telefono' => [
                'required',
                'string',
                'min:8',
                'max:15',
                'regex:/^[0-9+]+$/',
                'unique:users,telefono'
            ],
            'password' => 'required|string|min:8|confirmed',
            'fecha_nacimiento' => 'required|date|before:-18 years',
            'direccion' => 'required|string|max:255',
            'genero' => 'required|in:masculino,femenino',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido_paterno.required' => 'El campo apellido paterno es obligatorio.',
            'apellido_paterno.regex' => 'El apellido paterno solo puede contener letras y espacios.',
            'apellido_materno.required' => 'El campo apellido materno es obligatorio.',
            'apellido_materno.regex' => 'El apellido materno solo puede contener letras y espacios.',
            'ci.required' => 'El campo cédula de identidad es obligatorio.',
            'ci.unique' => 'La cédula de identidad ya está registrada.',
            'ci.regex' => 'La cédula solo puede contener números.',
            'ci.min' => 'La cédula debe tener al menos 5 dígitos.',
            'ci.max' => 'La cédula no puede tener más de 15 dígitos.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'El email ya está registrado.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'telefono.regex' => 'El teléfono solo puede contener números y el signo +.',
            'telefono.min' => 'El teléfono debe tener al menos 8 caracteres.',
            'telefono.max' => 'El teléfono no puede tener más de 15 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'El usuario debe ser mayor de 18 años.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'genero.required' => 'El campo género es obligatorio.',
            'genero.in' => 'El género seleccionado no es válido.',
            'roles.required' => 'Debe asignar al menos un rol al usuario.',
            'roles.min' => 'Debe asignar al menos un rol al usuario.',
            'roles.*.exists' => 'El rol seleccionado no es válido.'
        ]);

        try {
            DB::beginTransaction();

            $normalizedData = $this->normalizarDatos($validated);
            $normalizedData['password'] = Hash::make($validated['password']);

            $user = User::create($normalizedData);
            $user->syncRoles($validated['roles']);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    

    public function show(User $usuario)
    {
        $usuario->load('roles');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        $usuario->load('roles');
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_paterno' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido_materno' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'ci' => [
                'required',
                'string',
                'min:5',
                'max:15',
                'regex:/^[0-9]+$/',
                Rule::unique('users')->ignore($usuario->id)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($usuario->id)
            ],
            'telefono' => [
                'required',
                'string',
                'min:8',
                'max:15',
                'regex:/^[0-9+]+$/',
                Rule::unique('users')->ignore($usuario->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'fecha_nacimiento' => 'required|date|before:-18 years',
            'direccion' => 'required|string|max:255',
            'genero' => 'required|in:masculino,femenino',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name'
        ]);

        try {
            DB::beginTransaction();

            $normalizedData = $this->normalizarDatos($validated);
            
            if (!empty($validated['password'])) {
                $normalizedData['password'] = Hash::make($validated['password']);
            } else {
                unset($normalizedData['password']);
            }

            $usuario->update($normalizedData);
            $usuario->syncRoles($validated['roles']);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $usuario)
    {
        // Validación 1: No se puede eliminar el propio usuario
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Validación 2: No se puede eliminar un SuperAdmin
        if ($usuario->hasRole('SuperAdmin')) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar un usuario con rol SuperAdmin.');
        }

        try {
            // Eliminación lógica
            $nuevoEstado = $usuario->estado == 'activo' ? 'inactivo' : 'activo';
            $usuario->update(['estado' => $nuevoEstado]);

            $mensaje = $nuevoEstado == 'inactivo' 
                ? 'Usuario desactivado correctamente.' 
                : 'Usuario reactivado correctamente.';

            return redirect()->route('usuarios.index')->with('success', $mensaje);
        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Error al cambiar el estado del usuario: ' . $e->getMessage());
        }
    }
}