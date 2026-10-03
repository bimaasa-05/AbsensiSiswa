<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        if (! $user->isParent()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $children = $user->guardian
            ? $user->guardian->students()->with('schoolClass')->orderBy('name')->get()
            : collect();

        $selected = $children->firstWhere('id', (int) $request->query('anak')) ?? $children->first();

        $todayAttendance = $selected
            ? Attendance::where('student_id', $selected->id)
                ->where('attendance_date', today()->toDateString())
                ->first()
            : null;

        $history = $selected
            ? Attendance::where('student_id', $selected->id)
                ->orderByDesc('attendance_date')
                ->limit(30)
                ->get()
            : collect();

        return view('parent.dashboard', compact('children', 'selected', 'todayAttendance', 'history'));
    }
}
