<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

/**
 * Lapisan abstraksi perangkat fingerprint.
 *
 * Kode aplikasi TIDAK boleh bergantung langsung pada merek perangkat
 * tertentu. Perangkat (atau mock) hanya mengirim identifier, service ini
 * yang mencari dan memvalidasi siswa, lalu mendelegasikan pencatatan
 * ke AttendanceService.
 */
class FingerprintService
{
    public const RESULT_SUCCESS = AttendanceService::RESULT_SUCCESS;
    public const RESULT_DUPLICATE = AttendanceService::RESULT_DUPLICATE;
    public const RESULT_NO_CHECK_IN = AttendanceService::RESULT_NO_CHECK_IN;
    public const RESULT_ALREADY_CHECKED_OUT = AttendanceService::RESULT_ALREADY_CHECKED_OUT;
    public const RESULT_INACTIVE_STUDENT = AttendanceService::RESULT_INACTIVE_STUDENT;
    public const RESULT_UNKNOWN_FINGERPRINT = 'unknown_fingerprint';

    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    /**
     * Cari siswa berdasarkan identifier fingerprint dari perangkat.
     */
    public function identify(string $identifier): ?Student
    {
        return Student::where('fingerprint_identifier', trim($identifier))->first();
    }

    /**
     * @return array{result: string, attendance: ?Attendance, student: ?Student}
     */
    public function scan(string $identifier, string $type = 'masuk', ?Carbon $now = null): array
    {
        $student = $this->identify($identifier);

        if (! $student) {
            return ['result' => self::RESULT_UNKNOWN_FINGERPRINT, 'attendance' => null, 'student' => null];
        }

        $outcome = $type === 'pulang'
            ? $this->attendanceService->checkOut($student, Attendance::METHOD_FINGERPRINT, $now)
            : $this->attendanceService->checkIn($student, Attendance::METHOD_FINGERPRINT, $now);

        return [...$outcome, 'student' => $student];
    }

    public static function messageFor(string $result, string $type = 'masuk'): string
    {
        if ($result === self::RESULT_UNKNOWN_FINGERPRINT) {
            return 'Sidik jari tidak dikenal. Silakan hubungi admin.';
        }

        return AttendanceService::messageFor($result, $type);
    }
}
