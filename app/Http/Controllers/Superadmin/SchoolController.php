<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function index(Request $request): View
    {
        $schools = School::withCount(['students', 'users'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('superadmin.schools.index', compact('schools'));
    }

    public function show(School $school): View
    {
        $school->loadCount(['students', 'users']);

        return view('superadmin.schools.show', compact('school'));
    }

    public function approve(School $school): RedirectResponse
    {
        if (! $school->isPending()) {
            return back()->with('error', 'Hanya pengajuan yang menunggu yang dapat disetujui.');
        }

        $password = Str::random(12);

        $admin = User::withoutGlobalScope('school')->updateOrCreate(
            ['email' => 'admin@'.$school->id.'.sekolah.id'],
            [
                'name' => 'Admin '.$school->name,
                'password' => $password,
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'school_id' => $school->id,
            ]
        );

        // Jika akun sudah ada sebelumnya, samakan kredensialnya.
        if (! $admin->wasRecentlyCreated) {
            $admin->update(['password' => $password, 'status' => User::STATUS_ACTIVE]);
        }

        $school->update([
            'status' => School::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('superadmin.schools.show', $school)->with([
            'success' => 'Sekolah disetujui. Akun admin dibuat.',
            'new_admin_email' => $admin->email,
            'new_admin_password' => $password,
        ]);
    }

    public function reject(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if (! $school->isPending()) {
            return back()->with('error', 'Hanya pengajuan yang menunggu yang dapat ditolak.');
        }

        $school->update([
            'status' => School::STATUS_REJECTED,
            'approved_by' => auth()->id(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('superadmin.schools.index')
            ->with('success', 'Pengajuan sekolah ditolak.');
    }
}
