<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoleculaCalorica extends Model
{
    use HasFactory;

    protected $table = 'molecula_calorica';

    protected $fillable = [
        'paciente_id',
        'medida_id',
        'requerimiento_id',
        'peso_kg',
        'talla_cm',
        'kilocalorias_totales',
        'proteinas_g_kg',
        'grasas_g_kg', 
        'carbohidratos_g_kg',
        'kilocalorias_proteinas',
        'kilocalorias_grasas',
        'kilocalorias_carbohidratos',
        'porcentaje_proteinas',
        'porcentaje_grasas',
        'porcentaje_carbohidratos',
        'registrado_por',
        'estado'
    ];

    protected $casts = [
        'peso_kg' => 'decimal:2',
        'talla_cm' => 'decimal:2',
        'kilocalorias_totales' => 'decimal:2',
        'proteinas_g_kg' => 'decimal:2',
        'grasas_g_kg' => 'decimal:2',
        'carbohidratos_g_kg' => 'decimal:2',
        'kilocalorias_proteinas' => 'decimal:2',
        'kilocalorias_grasas' => 'decimal:2',
        'kilocalorias_carbohidratos' => 'decimal:2',
        'porcentaje_proteinas' => 'decimal:2',
        'porcentaje_grasas' => 'decimal:2',
        'porcentaje_carbohidratos' => 'decimal:2',
    ];

    // Relaciones
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medida(): BelongsTo
    {
        return $this->belongsTo(Medida::class, 'medida_id');
    }

    public function requerimiento(): BelongsTo
    {
        return $this->belongsTo(RequerimientoNutricional::class, 'requerimiento_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Calcula toda la molécula calórica según las fórmulas especificadas
     * 
     * @param float $proteinasGkg Dato manual 1: gramos de proteína por kg
     * @param float $porcentajeGrasas Dato manual 2: porcentaje de grasas (0.25 para 25%)
     */
    public function calcularMoleculaCalorica(float $proteinasGkg, float $porcentajeGrasas): void
    {
        $peso = $this->peso_kg;
        $kcalTotales = $this->kilocalorias_totales;

        // 1. Proteínas (gramos)
        $proteinasG = $proteinasGkg * $peso;

        // 2. Kilocalorías de proteínas
        $kcalProteinas = $proteinasG * 4;

        // 3. Porcentaje de proteínas
        $porcentajeProteina = $kcalProteinas / $kcalTotales;

        // 4. Kilocalorías de grasa
        $kcalGrasas = $kcalTotales * $porcentajeGrasas;

        // 5. Gramos de grasa
        $grasasG = $kcalGrasas / 9;

        // 6. Porcentaje de carbohidratos
        $porcentajeCarbohidratos = 1 - ($porcentajeProteina + $porcentajeGrasas);

        // 7. Kilocalorías de carbohidratos
        $kcalCarbohidratos = $kcalTotales * $porcentajeCarbohidratos;

        // 8. Gramos de carbohidratos
        $carbohidratosG = $kcalCarbohidratos / 4;

        // Actualizar atributos del modelo
        $this->proteinas_g_kg = $proteinasGkg;
        $this->porcentaje_grasas = $porcentajeGrasas;
        $this->kilocalorias_proteinas = $kcalProteinas;
        $this->kilocalorias_grasas = $kcalGrasas;
        $this->kilocalorias_carbohidratos = $kcalCarbohidratos;
        $this->porcentaje_proteinas = $porcentajeProteina;
        $this->porcentaje_carbohidratos = $porcentajeCarbohidratos;
        
        // Los campos grasas_g_kg y carbohidratos_g_kg no se usan en tus fórmulas
        // pero los llenamos por si los necesitas
        $this->grasas_g_kg = $grasasG / $peso;
        $this->carbohidratos_g_kg = $carbohidratosG / $peso;
    }

    // Métodos de acceso para facilitar el uso
    public function getProteinasGAttribute(): float
    {
        return $this->proteinas_g_kg * $this->peso_kg;
    }

    public function getGrasasGAttribute(): float
    {
        return $this->kilocalorias_grasas / 9;
    }

    public function getCarbohidratosGAttribute(): float
    {
        return $this->kilocalorias_carbohidratos / 4;
    }

    // Validar que los porcentajes sumen 100%
    public function validarPorcentajes(): bool
    {
        $suma = $this->porcentaje_proteinas + $this->porcentaje_grasas + $this->porcentaje_carbohidratos;
        return abs($suma - 1.0) < 0.01; // Tolerancia de 0.01 por decimales
    }

    // Scope para registros activos
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }

    // Scope para el último registro activo de un paciente
    public function scopeUltimoActivo($query, $pacienteId)
    {
        return $query->where('paciente_id', $pacienteId)
                    ->where('estado', 'activo')
                    ->latest()
                    ->limit(1);
    }
}