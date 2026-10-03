<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Guardian;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $students = Student::with(['schoolClass', 'guardian'])
            ->when($request->filled('class_id'), fn ($query) => $query->where('class_id', $request->class_id))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->search.'%';
                $query->where(fn ($q) => $q->where('name', 'like', $search)->orWhere('nis', 'like', $search));
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $classes = SchoolClass::where('status', SchoolClass::STATUS_ACTIVE)->orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.students.form', [
            'classes' => SchoolClass::where('status', SchoolClass::STATUS_ACTIVE)->orderBy('name')->get(),
            'guardians' => Guardian::where('status', Guardian::STATUS_ACTIVE)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Data siswa berhasil disimpan. QR Code telah dibuat otomatis.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $student->load(['schoolClass', 'guardian']);

        return view('admin.students.qr', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        return view('admin.students.form', [
            'student' => $student,
            'classes' => SchoolClass::where('status', SchoolClass::STATUS_ACTIVE)->orderBy('name')->get(),
            'guardians' => Guardian::where('status', Guardian::STATUS_ACTIVE)->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->update(['status' => Student::STATUS_INACTIVE]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Siswa berhasil dinonaktifkan.');
    }

    public function regenerateQr(Student $student): RedirectResponse
    {
        $student->regenerateQrToken();

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'QR Code berhasil dibuat ulang.');
    }
}
