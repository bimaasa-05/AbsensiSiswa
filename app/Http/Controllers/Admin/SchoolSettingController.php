<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.form', [
            'settings' => SchoolSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:100'],
            'school_address' => ['nullable', 'string', 'max:255'],
            'school_phone' => ['nullable', 'string', 'max:30'],
            'check_in_time' => ['required', 'date_format:H:i'],
            'late_tolerance_minutes' => ['required', 'integer', 'min:0', 'max:120'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'timezone' => ['required', 'timezone'],
        ], [
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'check_in_time.required' => 'Jam masuk wajib diisi.',
            'check_in_time.date_format' => 'Format jam masuk tidak valid (JJ:MM).',
            'late_tolerance_minutes.required' => 'Batas keterlambatan wajib diisi.',
            'timezone.required' => 'Zona waktu wajib dipilih.',
            'timezone.timezone' => 'Zona waktu tidak valid.',
        ]);

        SchoolSetting::current()->update($validated);

        return back()->with('success', 'Pengaturan sekolah berhasil disimpan.');
    }
}
