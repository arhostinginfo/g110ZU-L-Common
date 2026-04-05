<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_tips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gp_name_in_url');
            $table->string('gp_user_id');
            $table->text('tip_text');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_tips');
    }
};
