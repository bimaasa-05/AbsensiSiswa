<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecapExport implements FromCollection, WithHeadings
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
}
