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
        Schema::create('gpdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_email');
            $table->string('employee_password');
            $table->string('gp_under_district');
            $table->string('gp_under_taluka');
            $table->string('gp_name');
            $table->string('gp_name_in_url'); 
            $table->string('gp_valid_till');
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
        Schema::dropIfExists('gpdetails');
    }
};
