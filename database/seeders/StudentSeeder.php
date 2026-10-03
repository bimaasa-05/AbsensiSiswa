<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guardian;
use App\Models\SchoolClass;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classIds = SchoolClass::pluck('id', 'name');
        $guardianIds = Guardian::pluck('id')->all();

        $students = [
            ['nis' => '2627001', 'nisn' => '0061234001', 'name' => 'Bima Pratama', 'class' => 'XII RPL 1', 'gender' => 'L'],
            ['nis' => '2627002', 'nisn' => '0061234002', 'name' => 'Andi Nugraha', 'class' => 'XII RPL 2', 'gender' => 'L'],
            ['nis' => '2627003', 'nisn' => '0061234003', 'name' => 'Sinta Maharani', 'class' => 'XI RPL 1', 'gender' => 'P'],
            ['nis' => '2627004', 'nisn' => null, 'name' => 'Rizky Ramadhan', 'class' => 'X RPL 1', 'gender' => 'L'],
            ['nis' => '2627005', 'nisn' => null, 'name' => 'Dewi Lestari', 'class' => 'X RPL 2', 'gender' => 'P'],
        ];

        foreach ($students as $index => $data) {
            Student::firstOrCreate(
                ['nis' => $data['nis']],
                [
                    'nisn' => $data['nisn'],
                    'name' => $data['name'],
                    'class_id' => $classIds[$data['class']] ?? $classIds->first(),
                    'parent_id' => $guardianIds[$index % count($guardianIds)] ?? null,
                    'gender' => $data['gender'],
                    'status' => Student::STATUS_ACTIVE,
                ]
            );
        }
    }
}
