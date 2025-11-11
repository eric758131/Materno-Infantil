<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequerimientoNutricional extends Model
{
    use HasFactory;

    protected $table = 'requerimientos_nutricionales';

    protected $fillable = [
        'paciente_id',
        'medida_id',
        'peso_kg_at',
        'talla_cm_at',
        'geb_kcal',
        'factor_actividad',
        'factor_lesion',
        'get_kcal',
        'kcal_por_kg',
        'estado',
        'registrado_por',
        'calculado_en'
    ];

    protected $casts = [
        'peso_kg_at' => 'decimal:2',
        'talla_cm_at' => 'decimal:2',
        'geb_kcal' => 'decimal:2',
        'factor_actividad' => 'decimal:2',
        'factor_lesion' => 'decimal:2',
        'get_kcal' => 'decimal:2',
        'kcal_por_kg' => 'decimal:2',
        'calculado_en' => 'datetime'
    ];

    /**
     * Relación con el paciente
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Relación con la medida
     */
    public function medida(): BelongsTo
    {
        return $this->belongsTo(Medida::class);
    }

    /**
     * Relación con el usuario que registró
     */

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Scope para requerimientos activos
     */
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para requerimientos inactivos
     */
    public function scopeInactivo($query)
    {
        return $query->where('estado', 'inactivo');
    }

    /**
     * Calcular GEB según la fórmula
     */
    public static function calcularGEB($peso, $talla): float
    {
        return ((0.035 * $peso) + (1.9484 * $talla)) + 837;
    }

    /**
     * Calcular GET
     */
    public static function calcularGET($geb, $factorActividad, $factorLesion): float
    {
        return $geb * $factorActividad * $factorLesion;
    }

    /**
     * Calcular Kcal por Kg
     */
    public static function calcularKcalPorKg($get, $peso): float
    {
        return $get / $peso;
    }

    // NUEVA: Relación con moléculas calóricas
    public function moleculasCaloricas(): HasMany
    {
        return $this->hasMany(MoleculaCalorica::class, 'requerimiento_id');
    }

    public function moleculaCaloricaActiva()
    {
        return $this->hasOne(MoleculaCalorica::class, 'requerimiento_id')->where('estado', 'activo');
    }
    
}