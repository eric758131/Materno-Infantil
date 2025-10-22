<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrisanchoRef extends Model
{
    use HasFactory;

    protected $table = 'frisancho_ref';

    protected $fillable = [
        'genero',          
        'edad_anios',
        'pb_menos_sd', 'pb_dato', 'pb_mas_sd',
        'pct_menos_sd', 'pct_dato', 'pct_mas_sd',
        'cmb_menos_sd', 'cmb_dato', 'cmb_mas_sd',
        'amb_menos_sd', 'amb_dato', 'amb_mas_sd',
        'agb_menos_sd', 'agb_dato', 'agb_mas_sd',
    ];

    // Relaciones
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'frisancho_ref_id');
    }
}
