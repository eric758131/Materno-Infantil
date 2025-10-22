<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'medida_id',          // FK a medidas.id
        'oms_ref_id',         // FK a oms_ref.id
        'frisancho_ref_id',   // FK a frisancho_ref.id
        'registrado_por',     // FK a users.id (puede ser NULL)
        'imc',
        'peso_ideal',
        'dif_peso',
        'cmb_mm',
        'amb_mm2',
        'agb_mm2',
        'z_imc',  'dx_z_imc',
        'z_talla','dx_z_talla',
        'z_pb',   'dx_z_pb',
        'z_pct',  'dx_z_pct',
        'z_cmb',  'dx_z_cmb',
        'z_amb',  'dx_z_amb',
        'z_agb',  'dx_z_agb',
    ];

    // Relaciones
    public function medida()
    {
        return $this->belongsTo(Medida::class, 'medida_id');
    }

    public function omsRef()
    {
        return $this->belongsTo(OmsRef::class, 'oms_ref_id');
    }

    public function frisanchoRef()
    {
        return $this->belongsTo(FrisanchoRef::class, 'frisancho_ref_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
