<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario Eric
        $usuario = User::create([
            'nombre' => 'Eric Mauricio',
            'apellido_paterno' => 'Luna',
            'apellido_materno' => 'Pinto',
            'ci' => '13279782',
            'email' => 'eric@gmail.com',
            'password' => Hash::make('12345678'),
            'fecha_nacimiento' => '2005-07-08',
            'direccion' => 'Bajo Llojeta',
            'telefono' => '75813102',
            'genero' => 'Masculino',
            'estado' => 'activo',
        ]);

        // Crear roles de ejemplo si no existen
        $roles = ['SuperAdmin','Admin', 'Nutricionista'];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // Asignar todos los roles al usuario
        $usuario->syncRoles($roles);
    }
}
