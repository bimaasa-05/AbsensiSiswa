<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolRegistrationController extends Controller
{
    public function create(): View
    {
        return view('schools.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:100'],
            'contact_person' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama sekolah wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'contact_person.required' => 'Nama penanggung jawab wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        School::create([...$validated, 'status' => School::STATUS_PENDING]);

        return redirect()->route('schools.register.success');
    }

    public function success(): View
    {
        return view('schools.register-success');
    }
}
