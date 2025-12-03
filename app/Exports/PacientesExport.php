<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithHeadings, WithMapping, WithStyles,
    WithTitle, ShouldAutoSize, WithEvents, WithCustomStartCell
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class PacientesExport implements 
    FromCollection, WithHeadings, WithMapping, WithStyles,
    WithTitle, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Pacientes';
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombres',
            'Apellido Paterno',
            'Apellido Materno',
            'CI',
            'Fecha Nacimiento',
            'Edad',
            'Género',
            'Estado',
            'Tutor',
            'Parentesco',
            'CI Tutor',
            'Teléfono Tutor',
            'Registrado'
        ];
    }

    public function collection()
    {
        $query = DB::table('pacientes as p')
            ->leftJoin('tutores as t', 'p.tutor_id', '=', 't.id')
            ->select(
                'p.*',
                't.nombre as tutor_nombre',
                't.apellido_paterno as tutor_apellido_paterno',
                't.apellido_materno as tutor_apellido_materno',
                't.CI as tutor_ci',
                't.telefono as tutor_telefono',
                't.parentesco'
            );

        foreach ($this->filters as $campo => $valor) {
            if (!$valor) continue;

            if (in_array($campo, [
                'nombre', 'apellido_paterno', 'apellido_materno', 'CI',
                'genero', 'estado'
            ])) {
                $query->where("p.$campo", 'ilike', "%$valor%");
            }

            if ($campo === 'parentesco') {
                $query->where('t.parentesco', $valor);
            }
        }

        return $query->orderBy('p.apellido_paterno')->get();
    }

    public function map($paciente): array
    {
        $fechaNacimiento = $paciente->fecha_nacimiento ? Carbon::parse($paciente->fecha_nacimiento) : null;
        $edad = $fechaNacimiento ? $fechaNacimiento->age . ' años' : '';
        
        return [
            $paciente->id,
            $paciente->nombre,
            $paciente->apellido_paterno,
            $paciente->apellido_materno,
            $paciente->CI,
            $paciente->fecha_nacimiento ? Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : '',
            $edad,
            ucfirst($paciente->genero),
            ucfirst($paciente->estado),
            $paciente->tutor_nombre 
                ? $paciente->tutor_nombre . ' ' . $paciente->tutor_apellido_paterno . ' ' . ($paciente->tutor_apellido_materno ?? '')
                : 'Sin tutor',
            $paciente->parentesco ?? '',
            $paciente->tutor_ci ?? '',
            $paciente->tutor_telefono ?? '',
            $paciente->created_at ? Carbon::parse($paciente->created_at)->format('d/m/Y') : ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A7:N7' => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '8e44ad']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Usuario logueado
                $user = Auth::user();
                $usuarioNombre = $user->nombre . ' ' . $user->apellido_paterno;

                // Encabezado
                $sheet->mergeCells('A1:N1');
                $sheet->setCellValue('A1', 'HOSPITAL MATERNO INFANTIL');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);

                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2', 'Reporte de Pacientes');
                $sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);

                $sheet->mergeCells('A3:N3');
                $sheet->setCellValue('A3', 'Generado por: ' . $usuarioNombre);
                $sheet->getStyle('A3')->getFont()->setItalic(true);

                $sheet->mergeCells('A4:N4');
                $sheet->setCellValue('A4', 'Fecha: ' . now()->format('d/m/Y H:i:s'));

                $sheet->mergeCells('A5:N5');
                $sheet->setCellValue('A5', 'Total de registros: ' . $sheet->getHighestRow() - 7);

                $sheet->getStyle('A1:N5')->getAlignment()->setHorizontal('center');

                // Auto filtro
                $sheet->setAutoFilter('A7:N7');
            }
        ];
    }
}