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
        $this->call([
            SchoolClassSeeder::class,
            GuardianSeeder::class,
            StudentSeeder::class,
        ]);
        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ]
        );

        User::updateOrCreate(
            ['email' => 'orangtua@example.com'],
            [
                'name' => 'Orang Tua Contoh',
                'password' => 'password',
                'role' => User::ROLE_PARENT,
                'status' => User::STATUS_ACTIVE,
            ]
        );
    }
}
