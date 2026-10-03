<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('Sekolah');
            $table->string('school_address')->nullable();
            $table->string('school_phone')->nullable();
            $table->time('check_in_time')->default('07:00:00');
            $table->unsignedSmallInteger('late_tolerance_minutes')->default(15);
            $table->time('check_out_time')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
