<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceCorrectionController extends Controller
{
    public function edit(Attendance $attendance): View
    {
        $attendance->load(['student.schoolClass', 'corrections.user']);

        return view('admin.corrections.form', [
            'attendance' => $attendance,
            'statuses' => [
                Attendance::STATUS_PRESENT => 'Hadir',
                Attendance::STATUS_LATE => 'Terlambat',
                Attendance::STATUS_PERMISSION => 'Izin',
                Attendance::STATUS_SICK => 'Sakit',
                Attendance::STATUS_ABSENT => 'Alpha',
            ],
        ]);
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:present,late,permission,sick,absent'],
            'reason' => ['required', 'string', 'max:500'],
        ], [
            'status.required' => 'Status baru wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'reason.required' => 'Alasan koreksi wajib diisi.',
        ]);

        if ($validated['status'] === $attendance->status) {
            return back()->with('error', 'Status baru sama dengan status saat ini.');
        }

        AttendanceCorrection::create([
            'attendance_id' => $attendance->id,
            'user_id' => auth()->id(),
            'old_status' => $attendance->status,
            'new_status' => $validated['status'],
            'reason' => $validated['reason'],
        ]);

        $attendance->update(['status' => $validated['status']]);

        return redirect()->route('admin.attendances.today')
            ->with('success', 'Koreksi absensi berhasil disimpan.');
    }
}
