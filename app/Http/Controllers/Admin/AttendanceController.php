<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    protected function baseQuery(Request $request)
    {
        return Attendance::with(['student.schoolClass'])
            ->when($request->filled('class_id'), function ($query) use ($request) {
                $query->whereHas('student', fn ($q) => $q->where('class_id', $request->class_id));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('method'), fn ($query) => $query->where('method', $request->method));
    }

    public function today(Request $request): View
    {
        $attendances = $this->baseQuery($request)
            ->where('attendance_date', today()->toDateString())
            ->orderByDesc('check_in')
            ->paginate(20)
            ->withQueryString();

        return view('admin.attendances.today', [
            'attendances' => $attendances,
            'classes' => SchoolClass::orderBy('name')->get(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function history(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'student_id' => ['nullable', 'exists:students,id'],
        ]);

        $attendances = $this->baseQuery($request)
            ->when(! empty($validated['start_date'] ?? null) && ! empty($validated['end_date'] ?? null), function ($query) use ($validated) {
                $query->whereBetween('attendance_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->when(! empty($validated['student_id'] ?? null), fn ($query) => $query->where('student_id', $validated['student_id']))
            ->orderByDesc('attendance_date')
            ->orderByDesc('check_in')
            ->paginate(20)
            ->withQueryString();

        return view('admin.attendances.history', [
            'attendances' => $attendances,
            'classes' => SchoolClass::orderBy('name')->get(),
            'students' => Student::orderBy('name')->get(['id', 'name', 'nis']),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function recap(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'class_id' => ['nullable', 'exists:classes,id'],
        ]);

        $start = $validated['start_date'] ?? today()->startOfMonth()->toDateString();
        $end = $validated['end_date'] ?? today()->toDateString();

        $students = Student::with(['schoolClass'])
            ->when(! empty($validated['class_id'] ?? null), fn ($query) => $query->where('class_id', $validated['class_id']))
            ->where('status', Student::STATUS_ACTIVE)
            ->orderBy('name')
            ->get();

        $recap = $students->map(function (Student $student) use ($start, $end) {
            $rows = Attendance::where('student_id', $student->id)
                ->whereBetween('attendance_date', [$start, $end])
                ->pluck('status');

            return [
                'student' => $student,
                'present' => $rows->where(fn ($s) => $s === Attendance::STATUS_PRESENT)->count(),
                'late' => $rows->where(fn ($s) => $s === Attendance::STATUS_LATE)->count(),
                'permission' => $rows->where(fn ($s) => $s === Attendance::STATUS_PERMISSION)->count(),
                'sick' => $rows->where(fn ($s) => $s === Attendance::STATUS_SICK)->count(),
                'absent' => $rows->where(fn ($s) => $s === Attendance::STATUS_ABSENT)->count(),
            ];
        });

        return view('admin.attendances.recap', [
            'recap' => $recap,
            'classes' => SchoolClass::orderBy('name')->get(),
            'start' => $start,
            'end' => $end,
        ]);
    }

    protected function statusOptions(): array
    {
        return [
            Attendance::STATUS_PRESENT => 'Hadir',
            Attendance::STATUS_LATE => 'Terlambat',
            Attendance::STATUS_PERMISSION => 'Izin',
            Attendance::STATUS_SICK => 'Sakit',
            Attendance::STATUS_ABSENT => 'Alpha',
        ];
    }
}
