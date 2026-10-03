<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolSetting;

class SchoolSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolSetting::updateOrCreate(
            ['id' => 1],
            [
                'school_name' => 'SMK Contoh',
                'school_address' => 'Jl. Pendidikan No. 1',
                'school_phone' => '0211234567',
                'check_in_time' => '07:00:00',
                'late_tolerance_minutes' => 15,
                'check_out_time' => '14:00:00',
                'timezone' => 'Asia/Jakarta',
            ]
        );
    }
}
