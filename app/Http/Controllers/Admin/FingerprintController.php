<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Services\FingerprintService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Simulasi perangkat fingerprint untuk development.
 *
 * Pada integrasi nyata, perangkat mengirim identifier ke endpoint store.
 * Halaman mock ini mensimulasikan "siswa menempelkan jari" dengan
 * memilih siswa yang identifier-nya sudah terdaftar.
 */
class FingerprintController extends Controller
{
    public function __construct(protected FingerprintService $fingerprint)
    {
    }

    public function mock(): View
    {
        $students = Student::with('schoolClass')
            ->where('status', Student::STATUS_ACTIVE)
            ->whereNotNull('fingerprint_identifier')
            ->orderBy('name')
            ->get();

        return view('admin.fingerprint.mock', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fingerprint_identifier' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:masuk,pulang'],
        ], [
            'fingerprint_identifier.required' => 'ID fingerprint wajib diisi.',
            'type.in' => 'Jenis absensi tidak valid.',
        ]);

        $outcome = $this->fingerprint->scan($validated['fingerprint_identifier'], $validated['type']);
        $success = $outcome['result'] === FingerprintService::RESULT_SUCCESS;

        if ($success && $outcome['attendance']) {
            $status = Attendance::statusLabel($outcome['attendance']->status);
            $time = $validated['type'] === 'masuk'
                ? substr((string) $outcome['attendance']->check_in, 0, 5)
                : substr((string) $outcome['attendance']->check_out, 0, 5);

            return back()->with('success', "Absensi {$validated['type']} {$outcome['student']->name} berhasil ({$time}, {$status}).");
        }

        return back()->with('error', FingerprintService::messageFor($outcome['result'], $validated['type']));
    }
}
