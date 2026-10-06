<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\School;
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
            SchoolSettingSeeder::class,
        ]);
        User::updateOrCreate(
            ['email' => 'superadmin@absensi.id'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
                'role' => User::ROLE_SUPERADMIN,
                'status' => User::STATUS_ACTIVE,
                'school_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'school_id' => School::first()?->id,
            ]
        );
    }
}
