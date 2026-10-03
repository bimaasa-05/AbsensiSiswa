<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardianRequest;
use App\Models\Guardian;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $guardians = Guardian::withCount('students')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.guardians.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardianRequest $request): RedirectResponse
    {
        Guardian::create($request->validated());

        return redirect()->route('admin.guardians.index')
            ->with('success', 'Data orang tua/wali berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian): View
    {
        return view('admin.guardians.form', compact('guardian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuardianRequest $request, Guardian $guardian): RedirectResponse
    {
        $guardian->update($request->validated());

        return redirect()->route('admin.guardians.index')
            ->with('success', 'Data orang tua/wali berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian): RedirectResponse
    {
        if ($guardian->students()->exists()) {
            return back()->with('error', 'Data tidak dapat dihapus karena masih memiliki siswa terkait.');
        }

        $guardian->delete();

        return redirect()->route('admin.guardians.index')
            ->with('success', 'Data orang tua/wali berhasil dihapus.');
    }
}
