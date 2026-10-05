<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $summary = $this->summary();

        if ($request->boolean('live')) {
            return response()->json($summary);
        }

        return view('admin.dashboard', [
            'today' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
            'holiday' => Holiday::todayHoliday(),
            'trend' => $this->weeklyTrend($summary['totalStudents']),
            'perClass' => $this->perClassToday(),
            ...$summary,
        ]);
    }

    protected function summary(): array
    {
        $today = today()->toDateString();

        $totalStudents = Student::where('status', Student::STATUS_ACTIVE)->count();

        $todayAttendances = Attendance::with(['student.schoolClass'])
            ->where('attendance_date', $today)
            ->orderByDesc('check_in')
            ->get();

        $present = $todayAttendances->where('status', Attendance::STATUS_PRESENT)->count();
        $late = $todayAttendances->where('status', Attendance::STATUS_LATE)->count();
        $checkedIn = $todayAttendances->count();

        return [
            'totalStudents' => $totalStudents,
            'present' => $present,
            'late' => $late,
            'notYet' => max(0, $totalStudents - $checkedIn),
            'checkedIn' => $checkedIn,
            'recent' => $todayAttendances->take(10)->map(fn ($a) => [
                'time' => $a->check_in ? substr((string) $a->check_in, 0, 5) : '-',
                'name' => $a->student->name,
                'class' => $a->student->schoolClass->name ?? '-',
                'status' => $a->status,
                'status_label' => Attendance::statusLabel($a->status),
            ])->values(),
        ];
    }

    protected function weeklyTrend(int $totalStudents): array
    {
        $trend = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $count = Attendance::where('attendance_date', $date->toDateString())->count();

            $trend[] = [
                'label' => $date->locale('id')->isoFormat('ddd, D MMM'),
                'count' => $count,
                'percent' => $totalStudents > 0 ? (int) round($count / $totalStudents * 100) : 0,
            ];
        }

        return $trend;
    }

    protected function perClassToday(): array
    {
        $today = today()->toDateString();

        return SchoolClass::where('status', SchoolClass::STATUS_ACTIVE)
            ->withCount(['students as active_students' => fn ($q) => $q->where('status', Student::STATUS_ACTIVE)])
            ->orderBy('name')
            ->get()
            ->map(function (SchoolClass $class) use ($today) {
                $checkedIn = Attendance::where('attendance_date', $today)
                    ->whereHas('student', fn ($q) => $q->where('class_id', $class->id))
                    ->count();

                return [
                    'name' => $class->name,
                    'checked_in' => $checkedIn,
                    'total' => $class->active_students,
                    'percent' => $class->active_students > 0 ? (int) round($checkedIn / $class->active_students * 100) : 0,
                ];
            })
            ->all();
    }
}
