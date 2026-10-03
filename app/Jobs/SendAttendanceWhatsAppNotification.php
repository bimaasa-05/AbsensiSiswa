<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\NotificationLog;
use App\Services\WhatsAppNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendAttendanceWhatsAppNotification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $attendanceId,
        public string $type = NotificationLog::TYPE_CHECK_IN,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppNotificationService $whatsApp): void
    {
        $attendance = Attendance::with(['student.schoolClass', 'student.guardian'])->find($this->attendanceId);

        if (! $attendance) {
            return;
        }

        $statusColumn = $this->type === NotificationLog::TYPE_CHECK_OUT
            ? 'check_out_notification_status'
            : 'check_in_notification_status';

        if ($attendance->{$statusColumn} === NotificationLog::STATUS_SENT) {
            return;
        }

        $guardian = $attendance->student->guardian;

        if (! $guardian || empty($guardian->phone)) {
            $attendance->update([$statusColumn => NotificationLog::STATUS_FAILED]);

            return;
        }

        $message = $this->buildMessage($attendance);
        $result = $whatsApp->send($guardian->phone, $message);

        NotificationLog::create([
            'student_id' => $attendance->student_id,
            'attendance_id' => $attendance->id,
            'channel' => NotificationLog::CHANNEL_WHATSAPP,
            'recipient' => $guardian->phone,
            'type' => $this->type,
            'status' => $result['success'] ? NotificationLog::STATUS_SENT : NotificationLog::STATUS_FAILED,
            'message' => $message,
            'provider_message_id' => $result['provider_message_id'],
            'sent_at' => $result['success'] ? now() : null,
            'error_message' => $result['error'],
        ]);

        $attendance->update([
            $statusColumn => $result['success'] ? NotificationLog::STATUS_SENT : NotificationLog::STATUS_FAILED,
        ]);
    }

    protected function buildMessage(Attendance $attendance): string
    {
        $student = $attendance->student;
        $guardianName = $student->guardian->name;
        $date = $attendance->attendance_date->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $class = $student->schoolClass->name ?? '-';
        $status = Attendance::statusLabel($attendance->status);

        if ($this->type === NotificationLog::TYPE_CHECK_OUT) {
            $time = $attendance->check_out ? substr((string) $attendance->check_out, 0, 5) : '-';

            return "Notifikasi Kehadiran Sekolah\n\nYth. Orang Tua/Wali {$guardianName},\n\n{$student->name} telah melakukan absensi pulang.\n\nTanggal : {$date}\nJam     : {$time} WIB\nKelas   : {$class}\n\nInformasi ini merupakan pemberitahuan otomatis dari sistem sekolah.";
        }

        $time = $attendance->check_in ? substr((string) $attendance->check_in, 0, 5) : '-';

        return "Notifikasi Kehadiran Sekolah\n\nYth. Orang Tua/Wali {$guardianName},\n\n{$student->name} telah melakukan absensi masuk.\n\nTanggal : {$date}\nJam     : {$time} WIB\nKelas   : {$class}\nStatus  : {$status}\n\nInformasi ini merupakan pemberitahuan otomatis dari sistem sekolah.";
    }
}
