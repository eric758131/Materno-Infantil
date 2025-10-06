<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

     protected $table = 'tutores';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'CI',
        'telefono',
        'direccion',
        'parentesco',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} " . ($this->apellido_materno ?? '');
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

    // Relación con pacientes
    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'tutor_id');
    }
}