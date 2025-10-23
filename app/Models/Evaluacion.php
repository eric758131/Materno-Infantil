<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;


    protected $table = 'evaluaciones';

    protected $fillable = [
        'medida_id',
        'oms_ref_id', 
        'frisancho_ref_id',
        'imc',
        'peso_ideal',
        'dif_peso',
        'cmb_mm',
        'amb_mm2',
        'agb_mm2',
        // Z-scores
        'z_imc',
        'dx_z_imc',
        'z_talla', 
        'dx_z_talla',
        'z_pb',
        'dx_z_pb',
        'z_pct',
        'dx_z_pct',
        'z_cmb',
        'dx_z_cmb',
        'z_amb',
        'dx_z_amb',
        'z_agb',
        'dx_z_agb',
        'registrado_por'
    ];

    protected $casts = [
        'imc' => 'decimal:2',
        'peso_ideal' => 'decimal:2',
        'dif_peso' => 'decimal:2',
        'cmb_mm' => 'decimal:2',
        'amb_mm2' => 'decimal:2',
        'agb_mm2' => 'decimal:2',
        'z_imc' => 'decimal:2',
        'z_talla' => 'decimal:2',
        'z_pb' => 'decimal:2',
        'z_pct' => 'decimal:2',
        'z_cmb' => 'decimal:2',
        'z_amb' => 'decimal:2',
        'z_agb' => 'decimal:2',
    ];

    // Relaciones
    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function omsRef()
    {
        return $this->belongsTo(OmsRef::class);
    }

    public function frisanchoRef()
    {
        return $this->belongsTo(FrisanchoRef::class);
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}