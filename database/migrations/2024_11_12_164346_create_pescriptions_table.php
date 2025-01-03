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
        Schema::create('pescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('register_booking_id')->nullable();
            $table->foreign('register_booking_id')->references('id')->on('register_bookings')->onDelete('cascade');
            $table->string("venue");
            $table->string("guardians_name");
            $table->string("age");
            $table->string("sex");
            $table->string("doctor");
            $table->text("clinical_findings");
            $table->text("advice");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pescriptions');
    }
};
