<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\SchoolSetting;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RecapExport implements FromCollection, WithHeadings, WithEvents
{
    public function __construct(
        protected string $start,
        protected string $end,
        protected ?int $classId = null,
    ) {
    }

    public function collection(): Collection
    {
        $students = Student::with(['schoolClass'])
            ->when($this->classId, fn ($query) => $query->where('class_id', $this->classId))
            ->where('status', Student::STATUS_ACTIVE)
            ->orderBy('name')
            ->get();

        return $students->map(function (Student $student) {
            $statuses = Attendance::where('student_id', $student->id)
                ->whereBetween('attendance_date', [$this->start, $this->end])
                ->pluck('status');

            $count = fn (string $status) => $statuses->where(fn ($s) => $s === $status)->count();

            return [
                $student->name,
                $student->nis,
                $student->schoolClass->name ?? '-',
                $count(Attendance::STATUS_PRESENT),
                $count(Attendance::STATUS_LATE),
                $count(Attendance::STATUS_PERMISSION),
                $count(Attendance::STATUS_SICK),
                $count(Attendance::STATUS_ABSENT),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'NIS', 'Kelas', 'Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpha'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $settings = SchoolSetting::current();
                $className = $this->classId
                    ? (SchoolClass::find($this->classId)->name ?? '-')
                    : 'Semua Kelas';

                // Sisipkan 4 baris judul di atas data.
                $sheet->insertNewRowBefore(1, 4);
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                $sheet->setCellValue('A1', 'Rekap Absensi Siswa — '.$settings->school_name);
                $sheet->setCellValue('A2', 'Periode: '.$this->start.' sampai '.$this->end.'  •  Kelas: '.$className);
                $sheet->setCellValue('A3', 'Dicetak: '.now()->locale('id')->isoFormat('D MMMM YYYY HH:mm').'  •  Oleh: '.(auth()->user()->name ?? 'Admin'));

                $sheet->mergeCells('A1:'.$lastCol.'1');
                $sheet->mergeCells('A2:'.$lastCol.'2');
                $sheet->mergeCells('A3:'.$lastCol.'3');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E4D3B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(28);

                $sheet->getStyle('A2:A3')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '1C2B26']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Baris header kolom (sekarang baris 5).
                $sheet->getStyle('A5:'.$lastCol.'5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E4D3B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getStyle('A5:'.$lastCol.$lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D8E2DC']],
                    ],
                ]);

                foreach (range('A', $lastCol) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->freezePane('A6');
            },
        ];
    }
}
