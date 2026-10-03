<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\QrAttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(protected QrAttendanceService $qrAttendance)
    {
    }

    public function scanner(): View
    {
        return view('attendance.scanner');
    }

    public function scan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'qr_token' => ['required', 'string', 'max:64'],
            'type' => ['required', 'in:masuk,pulang'],
        ]);

        $outcome = $this->qrAttendance->scan($validated['qr_token'], $validated['type']);
        $success = $outcome['result'] === QrAttendanceService::RESULT_SUCCESS;

        return response()->json([
            'success' => $success,
            'message' => QrAttendanceService::messageFor($outcome['result'], $validated['type']),
            'data' => $success && $outcome['attendance'] ? [
                'name' => $outcome['student']->name,
                'class' => $outcome['student']->schoolClass->name ?? '-',
                'time' => $validated['type'] === 'masuk'
                    ? substr((string) $outcome['attendance']->check_in, 0, 5)
                    : substr((string) $outcome['attendance']->check_out, 0, 5),
                'status' => Attendance::statusLabel($outcome['attendance']->status),
                'method' => 'QR Code',
            ] : null,
        ], $success ? 200 : 422);
    }
}
