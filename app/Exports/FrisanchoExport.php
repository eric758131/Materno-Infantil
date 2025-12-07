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

class FrisanchoExport implements 
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
        return 'Referencias Frisancho';
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
            'Edad (años)',
            // Pliegue Bicipital
            'PB -1SD (mm)',
            'PB Mediana (mm)',
            'PB +1SD (mm)',
            // Pliegue Cutáneo Tricipital
            'PCT -1SD (mm)',
            'PCT Mediana (mm)',
            'PCT +1SD (mm)',
            // Circunferencia Muslo Brazo
            'CMB -1SD (cm)',
            'CMB Mediana (cm)',
            'CMB +1SD (cm)',
            // Área Muscular Brazo
            'AMB -1SD (cm²)',
            'AMB Mediana (cm²)',
            'AMB +1SD (cm²)',
            // Área Grasa Brazo
            'AGB -1SD (cm²)',
            'AGB Mediana (cm²)',
            'AGB +1SD (cm²)',
            'Actualizado'
        ];
    }

    public function collection()
    {
        $query = DB::table('frisancho_ref');

        foreach ($this->filters as $campo => $valor) {
            if (!$valor) continue;

            if ($campo === 'genero') {
                $query->where('genero', $valor);
            } elseif (in_array($campo, ['edad_desde', 'edad_hasta'])) {
                $campoDB = $campo === 'edad_desde' ? '>=' : '<=';
                $query->where('edad_anios', $campoDB, $valor);
            }
        }

        return $query->orderBy('genero')
                    ->orderBy('edad_anios')
                    ->get();
    }

    public function map($ref): array
    {
        return [
            $ref->id,
            ucfirst($ref->genero),
            $ref->edad_anios,
            // Pliegue Bicipital
            $this->formatearDecimal($ref->pb_menos_sd),
            $this->formatearDecimal($ref->pb_dato),
            $this->formatearDecimal($ref->pb_mas_sd),
            // Pliegue Cutáneo Tricipital
            $this->formatearDecimal($ref->pct_menos_sd),
            $this->formatearDecimal($ref->pct_dato),
            $this->formatearDecimal($ref->pct_mas_sd),
            // Circunferencia Muslo Brazo
            $this->formatearDecimal($ref->cmb_menos_sd),
            $this->formatearDecimal($ref->cmb_dato),
            $this->formatearDecimal($ref->cmb_mas_sd),
            // Área Muscular Brazo
            $this->formatearDecimal($ref->amb_menos_sd),
            $this->formatearDecimal($ref->amb_dato),
            $this->formatearDecimal($ref->amb_mas_sd),
            // Área Grasa Brazo
            $this->formatearDecimal($ref->agb_menos_sd),
            $this->formatearDecimal($ref->agb_dato),
            $this->formatearDecimal($ref->agb_mas_sd),
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

        // Estilos para grupos de columnas
        $groupStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ecf0f1']],
        ];

        return [
            // Encabezado principal
            'A7:T7' => $styleArray,
            
            // Bordes para toda la tabla
            'A7:T1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
            ],
            
            // Formato numérico para valores
            'D:T' => [
                'numberFormat' => [
                    'formatCode' => NumberFormat::FORMAT_NUMBER_00
                ]
            ],
            
            // Grupo PB
            'D7:F7' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3498db']]],
            // Grupo PCT
            'G7:I7' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2ecc71']]],
            // Grupo CMB
            'J7:L7' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'e74c3c']]],
            // Grupo AMB
            'M7:O7' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9b59b6']]],
            // Grupo AGB
            'P7:R7' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f1c40f']]],
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
                $sheet->mergeCells('A1:T1');
                $sheet->setCellValue('A1', 'REFERENCIAS ANTROPOMÉTRICAS FRISANCHO');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18)->getColor()->setRGB('2c3e50');

                $sheet->mergeCells('A2:T2');
                $sheet->setCellValue('A2', 'Patrones de Referencia para Evaluación Nutricional');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);

                $sheet->mergeCells('A3:T3');
                $sheet->setCellValue('A3', 'Tablas de Pliegues Cutáneos, Circunferencias y Áreas del Brazo');
                $sheet->getStyle('A3')->getFont()->setSize(12);

                $sheet->mergeCells('A4:T4');
                $sheet->setCellValue('A4', 'Generado por: ' . $usuarioNombre);
                $sheet->getStyle('A4')->getFont()->setItalic(true);

                $sheet->mergeCells('A5:T5');
                $sheet->setCellValue('A5', 'Fecha: ' . now()->format('d/m/Y H:i:s'));

                $sheet->mergeCells('A6:T6');
                $sheet->setCellValue('A6', 'Valores expresados en: mm (pliegues), cm (circunferencias), cm² (áreas)');
                $sheet->getStyle('A6')->getFont()->setBold(true);

                // Centrar todo el encabezado
                $sheet->getStyle('A1:T6')->getAlignment()->setHorizontal('center');

                // Añadir grupos de columnas
                $sheet->setCellValue('D6', 'Pliegue Bicipital (PB)');
                $sheet->setCellValue('G6', 'Pliegue Tricipital (PCT)');
                $sheet->setCellValue('J6', 'Circunf. Muslo Brazo (CMB)');
                $sheet->setCellValue('M6', 'Área Muscular Brazo (AMB)');
                $sheet->setCellValue('P6', 'Área Grasa Brazo (AGB)');
                
                // Estilos para los grupos
                $sheet->mergeCells('D6:F6');
                $sheet->mergeCells('G6:I6');
                $sheet->mergeCells('J6:L6');
                $sheet->mergeCells('M6:O6');
                $sheet->mergeCells('P6:R6');
                
                $groupHeaderStyle = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ];
                
                $sheet->getStyle('D6:F6')->applyFromArray(array_merge($groupHeaderStyle, 
                    ['fill' => ['startColor' => ['rgb' => '3498db']]]));
                $sheet->getStyle('G6:I6')->applyFromArray(array_merge($groupHeaderStyle,
                    ['fill' => ['startColor' => ['rgb' => '2ecc71']]]));
                $sheet->getStyle('J6:L6')->applyFromArray(array_merge($groupHeaderStyle,
                    ['fill' => ['startColor' => ['rgb' => 'e74c3c']]]));
                $sheet->getStyle('M6:O6')->applyFromArray(array_merge($groupHeaderStyle,
                    ['fill' => ['startColor' => ['rgb' => '9b59b6']]]));
                $sheet->getStyle('P6:R6')->applyFromArray(array_merge($groupHeaderStyle,
                    ['fill' => ['startColor' => ['rgb' => 'f1c40f']]]));

                // Auto filtro
                $sheet->setAutoFilter('A7:T7');

                // Congelar paneles (fila de encabezado)
                $sheet->freezePane('A8');
                
                // Ajustar ancho de columnas ID y género
                $sheet->getColumnDimension('A')->setWidth(8);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(12);
            }
        ];
    }
}