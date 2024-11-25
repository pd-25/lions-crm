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
        Schema::table('expenditures', function (Blueprint $table) {
            $table->string("unique_personal_doc_name")->nullable();
            $table->string("unique_personal_doc_id")->nullable();
            $table->string("id_code")->nullable();
            $table->string("section_code")->nullable();
            $table->string("name_of_donor")->nullable();
            $table->string("address_of_donor")->nullable();
            $table->string("donation_type")->nullable();
            $table->string("payment_mode")->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropColumn("unique_personal_doc_name");
            $table->dropColumn("unique_personal_doc_id");
            $table->dropColumn("id_code");
            $table->dropColumn("section_code");
            $table->dropColumn("name_of_donor");
            $table->dropColumn("address_of_donor");
            $table->dropColumn("donation_type");
            $table->dropColumn("payment_mode");
            $table->dropColumn('member_id');
        });
    }
};
