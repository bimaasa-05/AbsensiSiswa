<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'X RPL 1', 'level' => 'X', 'major' => 'RPL', 'academic_year' => '2026/2027'],
            ['name' => 'X RPL 2', 'level' => 'X', 'major' => 'RPL', 'academic_year' => '2026/2027'],
            ['name' => 'XI RPL 1', 'level' => 'XI', 'major' => 'RPL', 'academic_year' => '2026/2027'],
            ['name' => 'XII RPL 1', 'level' => 'XII', 'major' => 'RPL', 'academic_year' => '2026/2027'],
            ['name' => 'XII RPL 2', 'level' => 'XII', 'major' => 'RPL', 'academic_year' => '2026/2027'],
        ];

        foreach ($classes as $class) {
            SchoolClass::firstOrCreate(['name' => $class['name']], $class);
        }
    }
}
