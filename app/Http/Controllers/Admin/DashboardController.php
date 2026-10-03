<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $today = today()->toDateString();

        $totalStudents = Student::where('status', Student::STATUS_ACTIVE)->count();

        $todayAttendances = Attendance::with(['student.schoolClass'])
            ->where('attendance_date', $today)
            ->orderByDesc('check_in')
            ->get();

        $present = $todayAttendances->where('status', Attendance::STATUS_PRESENT)->count();
        $late = $todayAttendances->where('status', Attendance::STATUS_LATE)->count();
        $notYet = max(0, $totalStudents - $todayAttendances->count());

        return view('admin.dashboard', [
            'today' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
            'totalStudents' => $totalStudents,
            'present' => $present,
            'late' => $late,
            'notYet' => $notYet,
            'recent' => $todayAttendances->take(10),
        ]);
    }
}
