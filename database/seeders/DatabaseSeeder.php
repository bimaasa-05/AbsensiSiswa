<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.sch.id',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        User::factory()->create([
            'name' => 'Orang Tua Contoh',
            'email' => 'orangtua@example.com',
            'password' => 'password',
            'role' => User::ROLE_PARENT,
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
