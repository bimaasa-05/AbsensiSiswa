<?php

namespace App\Services;

use App\Jobs\SendAttendanceWhatsAppNotification;
use App\Models\Attendance;
use App\Models\NotificationLog;
use App\Models\SchoolSetting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public const RESULT_SUCCESS = 'success';
    public const RESULT_DUPLICATE = 'duplicate';
    public const RESULT_NO_CHECK_IN = 'no_check_in';
    public const RESULT_ALREADY_CHECKED_OUT = 'already_checked_out';
    public const RESULT_INACTIVE_STUDENT = 'inactive_student';

    /**
     * Catat absensi masuk siswa.
     *
     * @return array{result: string, attendance: ?Attendance}
     */
    public function checkIn(Student $student, string $method = Attendance::METHOD_QR, ?Carbon $now = null): array
    {
        if (! $student->isActive()) {
            return ['result' => self::RESULT_INACTIVE_STUDENT, 'attendance' => null];
        }

        $now ??= now();
        $today = $now->toDateString();

        return DB::transaction(function () use ($student, $method, $now, $today) {
            $attendance = Attendance::where('student_id', $student->id)
                ->where('attendance_date', $today)
                ->lockForUpdate()
                ->first();

            if ($attendance && $attendance->hasCheckedIn()) {
                return ['result' => self::RESULT_DUPLICATE, 'attendance' => $attendance];
            }

            $settings = SchoolSetting::current();

            $attendance ??= new Attendance([
                'student_id' => $student->id,
                'attendance_date' => $today,
            ]);

            $attendance->check_in = $now->format('H:i:s');
            $attendance->method = $method;
            $attendance->status = $this->resolveStatus($now, $settings);
            $attendance->check_in_notification_status = 'pending';
            $attendance->save();

            SendAttendanceWhatsAppNotification::dispatch($attendance->id, NotificationLog::TYPE_CHECK_IN);

            return ['result' => self::RESULT_SUCCESS, 'attendance' => $attendance];
        });
    }

    /**
     * Catat absensi pulang siswa.
     *
     * @return array{result: string, attendance: ?Attendance}
     */
    public function checkOut(Student $student, string $method = Attendance::METHOD_QR, ?Carbon $now = null): array
    {
        if (! $student->isActive()) {
            return ['result' => self::RESULT_INACTIVE_STUDENT, 'attendance' => null];
        }

        $now ??= now();
        $today = $now->toDateString();

        return DB::transaction(function () use ($student, $method, $now, $today) {
            $attendance = Attendance::where('student_id', $student->id)
                ->where('attendance_date', $today)
                ->lockForUpdate()
                ->first();

            if (! $attendance || ! $attendance->hasCheckedIn()) {
                return ['result' => self::RESULT_NO_CHECK_IN, 'attendance' => null];
            }

            if ($attendance->hasCheckedOut()) {
                return ['result' => self::RESULT_ALREADY_CHECKED_OUT, 'attendance' => $attendance];
            }

            $attendance->check_out = $now->format('H:i:s');
            $attendance->check_out_notification_status = 'pending';
            $attendance->save();

            SendAttendanceWhatsAppNotification::dispatch($attendance->id, NotificationLog::TYPE_CHECK_OUT);

            return ['result' => self::RESULT_SUCCESS, 'attendance' => $attendance];
        });
    }

    protected function resolveStatus(Carbon $now, SchoolSetting $settings): string
    {
        $deadline = Carbon::parse($settings->check_in_time)
            ->addMinutes($settings->late_tolerance_minutes);

        return $now->format('H:i:s') > $deadline->format('H:i:s')
            ? Attendance::STATUS_LATE
            : Attendance::STATUS_PRESENT;
    }

    public static function messageFor(string $result, string $type = 'masuk'): string
    {
        return match ($result) {
            self::RESULT_SUCCESS => $type === 'masuk'
                ? 'Absensi masuk berhasil dicatat.'
                : 'Absensi pulang berhasil dicatat.',
            self::RESULT_DUPLICATE => 'Siswa sudah melakukan absensi masuk hari ini.',
            self::RESULT_NO_CHECK_IN => 'Siswa belum melakukan absensi masuk hari ini.',
            self::RESULT_ALREADY_CHECKED_OUT => 'Siswa sudah melakukan absensi pulang hari ini.',
            self::RESULT_INACTIVE_STUDENT => 'Data siswa tidak aktif. Silakan hubungi admin.',
            default => 'Absensi belum dapat diproses. Silakan coba kembali.',
        };
    }
}
