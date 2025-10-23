<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoleculaCalorica extends Model
{
    use HasFactory;

    protected $table = 'molecula_calorica';

    protected $fillable = [
        'paciente_id',
        'peso_kg',
        'proteínas_g_kg',
        'grasa_g_kg',
        'carbohidratos_g_kg',
        'kilocalorías_totales',
        'kilocalorías_proteínas',
        'kilocalorías_grasas',
        'kilocalorías_carbohidratos',
        'estado'
    ];

    protected $casts = [
        'peso_kg' => 'decimal:2',
        'proteínas_g_kg' => 'decimal:2',
        'grasa_g_kg' => 'decimal:2',
        'carbohidratos_g_kg' => 'decimal:2',
        'kilocalorías_totales' => 'decimal:2',
        'kilocalorías_proteínas' => 'decimal:2',
        'kilocalorías_grasas' => 'decimal:2',
        'kilocalorías_carbohidratos' => 'decimal:2',
    ];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Scopes para filtros
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('paciente', function ($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('apellido_paterno', 'like', "%{$search}%")
              ->orWhere('apellido_materno', 'like', "%{$search}%")
              ->orWhere('CI', 'like', "%{$search}%");
        });
    }

    // Método para calcular kilocalorías
    public function calcularKilocalorias()
    {
        $this->kilocalorías_proteínas = $this->proteínas_g_kg * $this->peso_kg * 4;
        $this->kilocalorías_grasas = $this->grasa_g_kg * $this->peso_kg * 9;
        $this->kilocalorías_carbohidratos = $this->carbohidratos_g_kg * $this->peso_kg * 4;
        $this->kilocalorías_totales = $this->kilocalorías_proteínas + $this->kilocalorías_grasas + $this->kilocalorías_carbohidratos;
    }
}