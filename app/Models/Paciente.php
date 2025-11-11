<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'CI',
        'fecha_nacimiento',
        'genero',
        'estado',
        'tutor_id' 
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function estaActivo()
    {
        return $this->estado === 'activo';
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

     public function medidas()
    {
        return $this->hasMany(Medida::class, 'paciente_id');
    }

    // Acceso directo a evaluaciones a través de medidas
    public function evaluaciones()
    {
        return $this->hasManyThrough(
            Evaluacion::class,   // modelo destino
            Medida::class,       // modelo intermedio
            'paciente_id',       // FK en medidas -> pacientes
            'medida_id',         // FK en evaluaciones -> medidas
            'id',                // PK en pacientes
            'id'                 // PK en medidas
        );
    }

    public function requerimientosNutricionales()
    {
        return $this->hasMany(RequerimientoNutricional::class);
    }


    public function moleculasCaloricas(): HasMany
    {
        return $this->hasMany(MoleculaCalorica::class);
    }

    public function ultimaMoleculaCaloricaActiva()
    {
        return $this->hasOne(MoleculaCalorica::class)->where('estado', 'activo')->latest();
    }







}