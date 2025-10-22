<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmsRef extends Model
{
    use HasFactory;

    protected $table = 'oms_ref';

    protected $fillable = [
        'genero',      
        'edad_meses',
        'imc_menos_sd',
        'imc_mediana',
        'imc_mas_sd',
        'talla_menos_sd_cm',
        'talla_mediana_cm',
        'talla_mas_sd_cm',
    ];

    // Relaciones
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'oms_ref_id');
    }
}
