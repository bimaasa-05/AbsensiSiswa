<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (['users', 'classes', 'parents', 'students', 'holidays', 'school_settings'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->nullOnDelete();
            });
        }

        // NIS/nisn unik per sekolah, bukan global.
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['nis']);
            $table->dropUnique(['nisn']);
            $table->unique(['school_id', 'nis'], 'students_school_nis_unique');
            $table->unique(['school_id', 'nisn'], 'students_school_nisn_unique');
        });

        // Sekolah pertama untuk data existing.
        $schoolId = DB::table('schools')->insertGetId([
            'name' => 'SMK Contoh',
            'address' => 'Jl. Pendidikan No. 1',
            'phone' => '0211234567',
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (['users', 'classes', 'parents', 'students', 'holidays', 'school_settings'] as $table) {
            DB::table($table)->whereNull('school_id')->update(['school_id' => $schoolId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique('students_school_nis_unique');
            $table->dropUnique('students_school_nisn_unique');
            $table->unique('nis');
            $table->unique('nisn');
        });

        foreach (['users', 'classes', 'parents', 'students', 'holidays', 'school_settings'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropConstrainedForeignId('school_id');
            });
        }
    }
};
