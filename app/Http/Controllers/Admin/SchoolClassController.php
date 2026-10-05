<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolClassRequest;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $classes = SchoolClass::withCount('students')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'data' => $classes->map(fn ($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'level' => $c->level ?? '-',
                    'major' => $c->major ?? '-',
                    'academic_year' => $c->academic_year ?? '-',
                    'students' => $c->students_count,
                    'active' => $c->isActive(),
                    'edit_url' => route('admin.classes.edit', $c),
                    'delete_url' => route('admin.classes.destroy', $c),
                ])->values(),
            ]);
        }

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.classes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolClassRequest $request): RedirectResponse
    {
        SchoolClass::create($request->validated());

        return redirect()->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class): View
    {
        return view('admin.classes.form', ['class' => $class]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolClassRequest $request, SchoolClass $class): RedirectResponse
    {
        $class->update($request->validated());

        return redirect()->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class): RedirectResponse
    {
        if ($class->students()->exists()) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}
