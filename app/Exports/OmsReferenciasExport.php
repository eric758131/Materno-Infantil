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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OmsReferenciasExport implements 
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
        return 'Referencias OMS';
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Género',
            'Edad (meses)',
            'Edad (años)',
            'IMC -1SD',
            'IMC Mediana',
            'IMC +1SD',
            'Talla -1SD (cm)',
            'Talla Mediana (cm)',
            'Talla +1SD (cm)',
            
        ];
    }

    public function collection()
    {
        $query = DB::table('oms_ref');

        foreach ($this->filters as $campo => $valor) {
            if (!$valor) continue;

            if ($campo === 'genero') {
                $query->where('genero', $valor);
            } elseif (in_array($campo, ['edad_desde', 'edad_hasta'])) {
                $campoDB = $campo === 'edad_desde' ? '>=' : '<=';
                $query->where('edad_meses', $campoDB, $valor);
            }
        }

        return $query->orderBy('genero')
                    ->orderBy('edad_meses')
                    ->get();
    }

    public function map($ref): array
    {
        $edadAnios = floor($ref->edad_meses / 12);
        $edadMesesResto = $ref->edad_meses % 12;
        $edadFormateada = $edadAnios > 0 
            ? "{$edadAnios} años, {$edadMesesResto} meses"  // CORRECCIÓN: $edadAnios en lugar de $edadAnños
            : "{$ref->edad_meses} meses";

        return [
            $ref->id,
            ucfirst($ref->genero),
            $ref->edad_meses,
            $edadFormateada,
            $this->formatearDecimal($ref->imc_menos_sd),
            $this->formatearDecimal($ref->imc_mediana),
            $this->formatearDecimal($ref->imc_mas_sd),
            $this->formatearDecimal($ref->talla_menos_sd_cm),
            $this->formatearDecimal($ref->talla_mediana_cm),
            $this->formatearDecimal($ref->talla_mas_sd_cm),
            $ref->updated_at ? \Carbon\Carbon::parse($ref->updated_at)->format('d/m/Y') : ''
        ];
    }

    private function formatearDecimal($valor)
    {
        return $valor ? number_format($valor, 2) : '';
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el encabezado de la tabla
        $styleArray = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2c3e50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        return [
            'A7:K7' => $styleArray,
            'A7:K1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
            ],
            'E:K' => [
                'numberFormat' => [
                    'formatCode' => NumberFormat::FORMAT_NUMBER_00
                ]
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

                // Título principal
                $sheet->mergeCells('A1:K1');
                $sheet->setCellValue('A1', 'ORGANIZACIÓN MUNDIAL DE LA SALUD (OMS)');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', 'PATRONES DE CRECIMIENTO INFANTIL');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('2980b9');

                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue('A3', 'Referencias de IMC y Talla para la Edad');
                $sheet->getStyle('A3')->getFont()->setSize(12);

                $sheet->mergeCells('A4:K4');
                $sheet->setCellValue('A4', 'Generado por: ' . $usuarioNombre);
                $sheet->getStyle('A4')->getFont()->setItalic(true);

                $sheet->mergeCells('A5:K5');
                $sheet->setCellValue('A5', 'Fecha: ' . now()->format('d/m/Y H:i:s'));

                $sheet->mergeCells('A6:K6');
                $sheet->setCellValue('A6', 'Valores de referencia para niños de 0 a 5 años');
                $sheet->getStyle('A6')->getFont()->setBold(true);

                // Centrar todo el encabezado
                $sheet->getStyle('A1:K6')->getAlignment()->setHorizontal('center');

                // Formato condicional para valores importantes
                $highestRow = $sheet->getHighestRow();
                $conditionalStyles = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditionalStyles->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS)
                    ->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_GREATERTHAN)
                    ->addCondition('0')
                    ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E8F5E8');

                $sheet->getStyle('E8:E' . $highestRow)->setConditionalStyles([$conditionalStyles]);

                // Auto filtro
                $sheet->setAutoFilter('A7:K7');

                // Congelar paneles (fila de encabezado)
                $sheet->freezePane('A8');
            }
        ];
    }
}