<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guardian;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardians = [
            ['name' => 'H. Bambang Sutrisno', 'phone' => '081234567801', 'email' => null],
            ['name' => 'Hj. Siti Aminah', 'phone' => '081234567802', 'email' => null],
            ['name' => 'Drs. Andi Wijaya', 'phone' => '081234567803', 'email' => null],
        ];

        foreach ($guardians as $guardian) {
            Guardian::firstOrCreate(['phone' => $guardian['phone']], $guardian);
        }
    }
}
