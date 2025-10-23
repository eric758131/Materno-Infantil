<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Medida;
use App\Models\OmsRef;
use App\Models\FrisanchoRef;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedidaController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::query();
        
        // Filtros de búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_paterno', 'LIKE', "%{$search}%")
                  ->orWhere('apellido_materno', 'LIKE', "%{$search}%")
                  ->orWhere('CI', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('genero') && $request->genero != '') {
            $query->where('genero', $request->genero);
        }
        
        $pacientes = $query->orderBy('apellido_paterno')
                          ->orderBy('apellido_materno')
                          ->orderBy('nombre')
                          ->paginate(15);

        return view('medidas.index', compact('pacientes'));
    }

    public function create(Paciente $paciente)
    {
        return view('medidas.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            // Obtener paciente y datos
            $paciente = Paciente::findOrFail($request->paciente_id);
            
            // Calcular edad en meses (REDONDEAR A ENTERO)
            $fechaNacimiento = Carbon::parse($paciente->fecha_nacimiento);
            $fechaMedida = Carbon::parse($request->fecha);
            $edadMeses = (int) round($fechaNacimiento->diffInMonths($fechaMedida)); // Redondear a entero
            $edadAnios = floor($edadMeses / 12);

            // Crear la medida
            $medida = Medida::create([
                'paciente_id' => $request->paciente_id,
                'fecha' => $request->fecha,
                'edad_meses' => $edadMeses, // Ahora es entero
                'peso_kg' => $request->peso_kg,
                'talla_cm' => $request->talla_cm,
                'pb_mm' => $request->pb_mm,
                'pct_mm' => $request->pct_mm,
                'estado' => 'Activo'
            ]);

            // Calcular medidas derivadas
            $tallaMetros = $request->talla_cm / 100;
            $imc = $request->peso_kg / ($tallaMetros * $tallaMetros);
            $cmb = $request->pb_mm - (3.1416 * $request->pct_mm);
            $amb = (($cmb * $cmb) / 12.57) - 100;
            $agb = (($request->pb_mm * $request->pb_mm) / 12.57) - ($amb + 100);

            // Buscar referencia OMS
            $omsRef = OmsRef::where('genero', $paciente->genero)
                        ->where('edad_meses', $edadMeses) // Ahora coincide con entero
                        ->first();

            if (!$omsRef) {
                throw new \Exception("No se encontró referencia OMS para género {$paciente->genero} y edad {$edadMeses} meses");
            }

            // Calcular z-scores OMS
            $z_imc = $this->calcularZScore($imc, $omsRef->imc_mediana, $omsRef->imc_mas_sd, $omsRef->imc_menos_sd);
            $z_talla = $this->calcularZScore($request->talla_cm, $omsRef->talla_mediana_cm, $omsRef->talla_mas_sd_cm, $omsRef->talla_menos_sd_cm);
            
            $pesoIdeal = $omsRef->imc_mediana * ($tallaMetros * $tallaMetros);
            $difPeso = $request->peso_kg - $pesoIdeal;

            // Buscar referencia Frisancho
            $frisanchoRef = FrisanchoRef::where('genero', $paciente->genero)
                                    ->where('edad_anios', $edadAnios)
                                    ->first();

            if (!$frisanchoRef) {
                throw new \Exception("No se encontró referencia Frisancho para género {$paciente->genero} y edad {$edadAnios} años");
            }

            // Calcular z-scores Frisancho
            $z_pb = $this->calcularZScore($request->pb_mm, $frisanchoRef->pb_dato, $frisanchoRef->pb_mas_sd, $frisanchoRef->pb_menos_sd);
            $z_pct = $this->calcularZScore($request->pct_mm, $frisanchoRef->pct_dato, $frisanchoRef->pct_mas_sd, $frisanchoRef->pct_menos_sd);
            $z_cmb = $this->calcularZScore($cmb, $frisanchoRef->cmb_dato, $frisanchoRef->cmb_mas_sd, $frisanchoRef->cmb_menos_sd);
            $z_amb = $this->calcularZScore($amb, $frisanchoRef->amb_dato, $frisanchoRef->amb_mas_sd, $frisanchoRef->amb_menos_sd);
            $z_agb = $this->calcularZScore($agb, $frisanchoRef->agb_dato, $frisanchoRef->agb_mas_sd, $frisanchoRef->agb_menos_sd);

            // Crear evaluación
            $evaluacion = Evaluacion::create([
                'medida_id' => $medida->id,
                'oms_ref_id' => $omsRef->id,
                'frisancho_ref_id' => $frisanchoRef->id,
                'registrado_por' => auth()->id(),
                'imc' => $imc,
                'peso_ideal' => $pesoIdeal,
                'dif_peso' => $difPeso,
                'cmb_mm' => $cmb,
                'amb_mm2' => $amb,
                'agb_mm2' => $agb,
                'z_imc' => $z_imc,
                'z_talla' => $z_talla,
                'z_pb' => $z_pb,
                'z_pct' => $z_pct,
                'z_cmb' => $z_cmb,
                'z_amb' => $z_amb,
                'z_agb' => $z_agb,
                'dx_z_imc' => '',
                'dx_z_talla' => '',
                'dx_z_pb' => '',
                'dx_z_pct' => '',
                'dx_z_cmb' => '',
                'dx_z_amb' => '',
                'dx_z_agb' => '',
            ]);

            return redirect()->route('medidas.show', $medida->id)
                        ->with('success', 'Evaluación creada exitosamente. Complete los diagnósticos.');
        });
    }

    public function show(Medida $medida)
    {
        $medida->load(['paciente', 'evaluaciones.omsRef', 'evaluaciones.frisanchoRef']);
        return view('medidas.show', compact('medida'));
    }

    private function calcularZScore($valor, $mediana, $mas_sd, $menos_sd)
    {
        if ($valor >= $mediana) {
            return ($valor - $mediana) / ($mas_sd - $mediana);
        } else {
            return ($valor - $mediana) / ($mediana - $menos_sd);
        }
    }

    public function calculos(Medida $medida)
    {
        $medida->load([
            'paciente', 
            'evaluaciones.omsRef', 
            'evaluaciones.frisanchoRef'
        ]);
        
        $evaluacion = $medida->evaluaciones->first();
        
        // Calcular valores paso a paso para mostrar
        $calculos = [];
        
        if ($evaluacion) {
            // 1. Cálculo de IMC
            $tallaMetros = $medida->talla_cm / 100;
            $calculos['imc'] = [
                'peso_kg' => $medida->peso_kg,
                'talla_cm' => $medida->talla_cm,
                'talla_metros' => $tallaMetros,
                'formula' => 'peso_kg / (talla_metros)²',
                'resultado' => $medida->peso_kg / ($tallaMetros * $tallaMetros)
            ];
            
            // 2. Cálculo de CMB
            $calculos['cmb'] = [
                'pb_mm' => $medida->pb_mm,
                'pct_mm' => $medida->pct_mm,
                'formula' => 'PB - (3.1416 × PCT)',
                'resultado' => $medida->pb_mm - (3.1416 * $medida->pct_mm)
            ];
            
            // 3. Cálculo de AMB
            $cmb = $calculos['cmb']['resultado'];
            $calculos['amb'] = [
                'cmb' => $cmb,
                'formula' => '(CMB² / 12.57) - 100',
                'resultado' => (($cmb * $cmb) / 12.57) - 100
            ];
            
            // 4. Cálculo de AGB
            $calculos['agb'] = [
                'pb_mm' => $medida->pb_mm,
                'amb' => $calculos['amb']['resultado'],
                'formula' => '(PB² / 12.57) - (AMB + 100)',
                'resultado' => (($medida->pb_mm * $medida->pb_mm) / 12.57) - ($calculos['amb']['resultado'] + 100)
            ];
            
            // 5. Cálculo de Z-Scores OMS
            if ($evaluacion->omsRef) {
                $calculos['z_imc'] = $this->calcularZScoreDetallado(
                    $calculos['imc']['resultado'],
                    $evaluacion->omsRef->imc_mediana,
                    $evaluacion->omsRef->imc_mas_sd,
                    $evaluacion->omsRef->imc_menos_sd,
                    'IMC'
                );
                
                $calculos['z_talla'] = $this->calcularZScoreDetallado(
                    $medida->talla_cm,
                    $evaluacion->omsRef->talla_mediana_cm,
                    $evaluacion->omsRef->talla_mas_sd_cm,
                    $evaluacion->omsRef->talla_menos_sd_cm,
                    'Talla'
                );
                
                // Peso ideal
                $calculos['peso_ideal'] = [
                    'imc_mediana' => $evaluacion->omsRef->imc_mediana,
                    'talla_metros_cuadrado' => $tallaMetros * $tallaMetros,
                    'formula' => 'IMC_mediana × (talla_metros)²',
                    'resultado' => $evaluacion->omsRef->imc_mediana * ($tallaMetros * $tallaMetros)
                ];
            }
            
            // 6. Cálculo de Z-Scores Frisancho
            if ($evaluacion->frisanchoRef) {
                $calculos['z_pb'] = $this->calcularZScoreDetallado(
                    $medida->pb_mm,
                    $evaluacion->frisanchoRef->pb_dato,
                    $evaluacion->frisanchoRef->pb_mas_sd,
                    $evaluacion->frisanchoRef->pb_menos_sd,
                    'Pliegue Bicipital'
                );
                
                $calculos['z_pct'] = $this->calcularZScoreDetallado(
                    $medida->pct_mm,
                    $evaluacion->frisanchoRef->pct_dato,
                    $evaluacion->frisanchoRef->pct_mas_sd,
                    $evaluacion->frisanchoRef->pct_menos_sd,
                    'Pliegue Tricipital'
                );
                
                $calculos['z_cmb'] = $this->calcularZScoreDetallado(
                    $calculos['cmb']['resultado'],
                    $evaluacion->frisanchoRef->cmb_dato,
                    $evaluacion->frisanchoRef->cmb_mas_sd,
                    $evaluacion->frisanchoRef->cmb_menos_sd,
                    'CMB'
                );
                
                $calculos['z_amb'] = $this->calcularZScoreDetallado(
                    $calculos['amb']['resultado'],
                    $evaluacion->frisanchoRef->amb_dato,
                    $evaluacion->frisanchoRef->amb_mas_sd,
                    $evaluacion->frisanchoRef->amb_menos_sd,
                    'AMB'
                );
                
                $calculos['z_agb'] = $this->calcularZScoreDetallado(
                    $calculos['agb']['resultado'],
                    $evaluacion->frisanchoRef->agb_dato,
                    $evaluacion->frisanchoRef->agb_mas_sd,
                    $evaluacion->frisanchoRef->agb_menos_sd,
                    'AGB'
                );
            }
        }
        
        return view('medidas.calculos', compact('medida', 'evaluacion', 'calculos'));
    }

    private function calcularZScoreDetallado($valor, $mediana, $mas_sd, $menos_sd, $nombre)
    {
        $esMayor = $valor >= $mediana;
        $diferencia = $valor - $mediana;
        
        if ($esMayor) {
            $denominador = $mas_sd - $mediana;
            $formula = "({$valor} - {$mediana}) / ({$mas_sd} - {$mediana})";
        } else {
            $denominador = $mediana - $menos_sd;
            $formula = "({$valor} - {$mediana}) / ({$mediana} - {$menos_sd})";
        }
        
        $resultado = $diferencia / $denominador;
        
        return [
            'valor' => $valor,
            'mediana' => $mediana,
            'mas_sd' => $mas_sd,
            'menos_sd' => $menos_sd,
            'es_mayor' => $esMayor,
            'diferencia' => $diferencia,
            'denominador' => $denominador,
            'formula' => $formula,
            'resultado' => $resultado,
            'nombre' => $nombre
        ];
    }
}