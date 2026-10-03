<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class QrAttendanceService
{
    public const RESULT_SUCCESS = AttendanceService::RESULT_SUCCESS;
    public const RESULT_DUPLICATE = AttendanceService::RESULT_DUPLICATE;
    public const RESULT_NO_CHECK_IN = AttendanceService::RESULT_NO_CHECK_IN;
    public const RESULT_ALREADY_CHECKED_OUT = AttendanceService::RESULT_ALREADY_CHECKED_OUT;
    public const RESULT_INACTIVE_STUDENT = AttendanceService::RESULT_INACTIVE_STUDENT;
    public const RESULT_INVALID_QR = 'invalid_qr';

    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    /**
     * @return array{result: string, attendance: ?Attendance, student: ?Student}
     */
    public function scan(string $qrToken, string $type = 'masuk', ?Carbon $now = null): array
    {
        $student = Student::where('qr_token', trim($qrToken))->first();

        if (! $student) {
            return ['result' => self::RESULT_INVALID_QR, 'attendance' => null, 'student' => null];
        }

        $outcome = $type === 'pulang'
            ? $this->attendanceService->checkOut($student, Attendance::METHOD_QR, $now)
            : $this->attendanceService->checkIn($student, Attendance::METHOD_QR, $now);

        return [...$outcome, 'student' => $student];
    }

    public static function messageFor(string $result, string $type = 'masuk'): string
    {
        if ($result === self::RESULT_INVALID_QR) {
            return 'QR Code tidak valid atau sudah tidak aktif.';
        }

        return AttendanceService::messageFor($result, $type);
    }
}
