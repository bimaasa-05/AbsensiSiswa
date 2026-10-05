<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $holidays = Holiday::orderBy('holiday_date')->paginate(15);

        return view('admin.holidays.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.holidays.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Holiday::create($request->validate([
            'holiday_date' => ['required', 'date', 'unique:holidays,holiday_date'],
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:national,school,weekend'],
        ], [
            'holiday_date.required' => 'Tanggal wajib diisi.',
            'holiday_date.unique' => 'Tanggal tersebut sudah terdaftar sebagai libur.',
            'name.required' => 'Nama libur wajib diisi.',
            'type.in' => 'Jenis libur tidak valid.',
        ]));

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Hari libur berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday): View
    {
        return view('admin.holidays.form', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holiday $holiday): RedirectResponse
    {
        $holiday->update($request->validate([
            'holiday_date' => ['required', 'date', 'unique:holidays,holiday_date,'.$holiday->id],
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:national,school,weekend'],
        ], [
            'holiday_date.required' => 'Tanggal wajib diisi.',
            'holiday_date.unique' => 'Tanggal tersebut sudah terdaftar sebagai libur.',
            'name.required' => 'Nama libur wajib diisi.',
            'type.in' => 'Jenis libur tidak valid.',
        ]));

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Hari libur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday): RedirectResponse
    {
        $holiday->delete();

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Hari libur berhasil dihapus.');
    }
}
