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
        Schema::create('contact_dakhala', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gp_name_in_url'); 
            $table->string('mobile_no');
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('print_name');
            $table->string('address');
            $table->string('certificate_type');
            $table->boolean('is_action_completed')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_dakhala');
    }
};
