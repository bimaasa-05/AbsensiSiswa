<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) auth()->user()?->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = $this->route('student')?->id;
        $schoolId = auth()->user()?->school_id;

        return [
            'nis' => ['required', 'string', 'max:30', Rule::unique('students', 'nis')->where('school_id', $schoolId)->ignore($studentId)],
            'nisn' => ['nullable', 'string', 'max:30', Rule::unique('students', 'nisn')->where('school_id', $schoolId)->ignore($studentId)],
            'name' => ['required', 'string', 'max:100'],
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'parent_id' => ['nullable', Rule::exists('parents', 'id')->where('school_id', $schoolId)],
            'gender' => ['nullable', Rule::in([Student::GENDER_MALE, Student::GENDER_FEMALE])],
            'status' => ['required', 'in:active,inactive'],
            'fingerprint_identifier' => ['nullable', 'string', 'max:100', Rule::unique('students', 'fingerprint_identifier')->ignore($studentId)],
        ];
    }

    public function messages(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan siswa lain.',
            'nisn.unique' => 'NISN sudah digunakan siswa lain.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'class_id.required' => 'Kelas wajib dipilih.',
            'class_id.exists' => 'Kelas tidak valid.',
            'parent_id.exists' => 'Orang tua/wali tidak valid.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'status.in' => 'Status tidak valid.',
            'fingerprint_identifier.unique' => 'ID fingerprint sudah digunakan siswa lain.',
        ];
    }
}
