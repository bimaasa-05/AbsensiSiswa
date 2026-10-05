<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
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
}
