<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    use HasFactory;

    protected $table = 'medidas';

    protected $fillable = [
        'paciente_id',       // FK a pacientes.id
        'fecha',
        'edad_meses',
        'peso_kg',
        'talla_cm',
        'pb_mm',
        'pct_mm',
        'estado',            // 'Activo' o 'Inactivo' (restricción CHECK)
    ];
     protected $casts = [
        'fecha' => 'date',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'medida_id');
    }
}
