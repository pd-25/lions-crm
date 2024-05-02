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
        Schema::table('register_bookings', function (Blueprint $table) {
            $table->longText('about_patient_problem')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_bookings', function (Blueprint $table) {
            $table->dropColumn('about_patient_problem');
        });
    }
};
