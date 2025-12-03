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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class UsuariosExport implements 
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
        return 'Usuarios';
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function headings(): array
    {
        return [
            'ID','Nombre','Apellido Paterno','Apellido Materno',
            'CI','Email','Teléfono','Dirección','Genero',
            'Estado','Fecha Nacimiento','Rol'
        ];
    }

    public function collection()
    {
        $q = DB::table('users as u')
            ->leftJoin('model_has_roles as mr', 'mr.model_id', '=', 'u.id')
            ->leftJoin('roles as r', 'r.id', '=', 'mr.role_id')
            ->select('u.*', 'r.name as rol');

        foreach ($this->filters as $campo => $valor) {
            if (!$valor) continue;

            if (in_array($campo, [
                'nombre','apellido_paterno','apellido_materno','ci','email',
                'telefono','direccion','genero','estado'
            ])) {
                $q->where("u.$campo", 'ilike', "%$valor%");
            }

            if ($campo === 'rol') {
                $q->where('r.name', $valor);
            }
        }

        return $q->orderBy('u.id')->get();
    }

    public function map($u): array
    {
        return [
            $u->id,
            $u->nombre,
            $u->apellido_paterno,
            $u->apellido_materno,
            $u->ci,
            $u->email,
            $u->telefono,
            $u->direccion,
            $u->genero,
            $u->estado,
            $u->fecha_nacimiento ? Carbon::parse($u->fecha_nacimiento)->format('d/m/Y') : '',
            $u->rol,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A7:L7' => [
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
                $usuarioRol = $user->roles->pluck('name')->implode(', ');

                // Encabezado
                $sheet->mergeCells('A1:L1');
                $sheet->setCellValue('A1', 'HOSPITAL MATERNO INFANTIL');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);

                $sheet->mergeCells('A2:L2');
                $sheet->setCellValue('A2', 'Reporte de Usuarios del Sistema');
                $sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);

                $sheet->mergeCells('A3:L3');
                $sheet->setCellValue('A3', 'Generado por: ' . $usuarioNombre . ' | Rol: ' . $usuarioRol);
                $sheet->getStyle('A3')->getFont()->setItalic(true);

                $sheet->mergeCells('A4:L4');
                $sheet->setCellValue('A4', 'Fecha: ' . now()->format('d/m/Y H:i:s'));

                $sheet->getStyle('A1:L4')->getAlignment()->setHorizontal('center');

                // Auto filtro
                $sheet->setAutoFilter('A7:L7');
            }
        ];
    }
}
