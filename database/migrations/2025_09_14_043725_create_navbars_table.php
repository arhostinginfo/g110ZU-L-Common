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
        Schema::create('navbars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gp_name_in_url');
            $table->string('gp_user_id');
            $table->string('footer_desc');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email_id');
            $table->string('color'); 
            $table->string('name'); 
            $table->string('logo')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
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
        Schema::dropIfExists('navbars');
    }
};
