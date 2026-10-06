<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicLookupController extends Controller
{
    public function landing(): View
    {
        return view('public.landing');
    }

    public function check(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'identifier' => ['required', 'string', 'max:30'],
        ], [
            'identifier.required' => 'NIS atau NISN wajib diisi.',
        ]);

        $identifier = trim($validated['identifier']);

        $student = Student::with(['schoolClass', 'school'])
            ->where('status', Student::STATUS_ACTIVE)
            ->where(fn ($query) => $query->where('nis', $identifier)->orWhere('nisn', $identifier))
            ->first();

        if (! $student) {
            return back()
                ->withInput()
                ->with('lookup_error', 'Data tidak ditemukan. Periksa kembali NIS/NISN yang dimasukkan.');
        }

        return redirect()->route('lookup.result', ['identifier' => $identifier]);
    }

    public function result(string $identifier): View
    {
        $student = Student::with(['schoolClass', 'school'])
            ->where('status', Student::STATUS_ACTIVE)
            ->where(fn ($query) => $query->where('nis', $identifier)->orWhere('nisn', $identifier))
            ->firstOrFail();

        $todayAttendance = Attendance::where('student_id', $student->id)
            ->where('attendance_date', today()->toDateString())
            ->first();

        $history = Attendance::where('student_id', $student->id)
            ->where('attendance_date', '<', today()->toDateString())
            ->orderByDesc('attendance_date')
            ->limit(7)
            ->get();

        return view('public.result', compact('student', 'todayAttendance', 'history'));
    }
}
