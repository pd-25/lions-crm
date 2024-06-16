<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('register_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_type_id')->nullable();
            $table->unsignedBigInteger('operation_scheme_id')->nullable()->comment('if booking_type is operation, the operation_scheme_id will be filled accordingly');
            $table->foreign('booking_type_id')->references('id')->on('booking_types')->onDelete('cascade');
            $table->foreign('operation_scheme_id')->references('id')->on('operation_schemes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_bookings', function (Blueprint $table) {
            $table->dropForeign(['booking_type_id']);
            $table->dropForeign(['operation_scheme_id']);
            $table->dropColumn('booking_type_id');
            $table->dropColumn('operation_scheme_id');
        });
    }
};
