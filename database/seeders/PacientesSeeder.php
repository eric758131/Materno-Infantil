<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use App\Models\Tutor;
use Carbon\Carbon;

class PacientesSeeder extends Seeder
{
    public function run()
    {
        // Crear tutores
        $tutores = [
            [
                'nombre' => 'Maria',
                'apellido_paterno' => 'Lopez',
                'apellido_materno' => 'Perez',
                'CI' => '900001',
                'telefono' => '70111111',
                'direccion' => 'Zona Central',
                'parentesco' => 'madre',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Juan',
                'apellido_paterno' => 'Gomez',
                'apellido_materno' => 'Rojas',
                'CI' => '900002',
                'telefono' => '70222222',
                'direccion' => 'Zona Norte',
                'parentesco' => 'padre',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Ana',
                'apellido_paterno' => 'Quispe',
                'apellido_materno' => 'Mamani',
                'CI' => '900003',
                'telefono' => '70333333',
                'direccion' => 'Zona Sur',
                'parentesco' => 'madre',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Luis',
                'apellido_paterno' => 'Torrez',
                'apellido_materno' => 'Flores',
                'CI' => '900004',
                'telefono' => '70444444',
                'direccion' => 'Villa Copacabana',
                'parentesco' => 'padre',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Carmen',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'Choque',
                'CI' => '900005',
                'telefono' => '70555555',
                'direccion' => 'Zona Este',
                'parentesco' => 'tutor legal',
                'estado' => 'activo',
            ],
        ];

        foreach ($tutores as $tutor) {
            Tutor::create($tutor);
        }

        $tutoresIds = Tutor::pluck('id')->toArray();

        // Crear pacientes (5 a 19 años)
        $pacientes = [
            ['Carlos','Perez','Lopez','500001','masculino', 5],
            ['Lucia','Gomez','Rojas','500002','femenino', 6],
            ['Miguel','Quispe','Mamani','500003','masculino', 8],
            ['Sofia','Torrez','Flores','500004','femenino', 9],
            ['Andres','Vargas','Choque','500005','masculino', 11],
            ['Valeria','Lopez','Perez','500006','femenino', 13],
            ['Diego','Gomez','Rojas','500007','masculino', 15],
            ['Camila','Quispe','Mamani','500008','femenino', 16],
            ['Javier','Torrez','Flores','500009','masculino', 18],
            ['Daniela','Vargas','Choque','500010','femenino', 19],
        ];

        foreach ($pacientes as $p) {
            Paciente::create([
                'nombre' => $p[0],
                'apellido_paterno' => $p[1],
                'apellido_materno' => $p[2],
                'CI' => $p[3],
                'fecha_nacimiento' => Carbon::now()->subYears($p[5])->format('Y-m-d'),
                'genero' => $p[4],
                'estado' => 'activo',
                'tutor_id' => $tutoresIds[array_rand($tutoresIds)],
            ]);
        }
    }
}
