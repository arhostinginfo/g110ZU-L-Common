<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_demands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gp_name_in_url');
            $table->enum('tax_type', ['ghar_patti', 'paani_patti', 'other']);
            $table->integer('year');
            $table->enum('period', ['magil', 'chalu']);
            $table->decimal('demand_amount', 10, 2);
            $table->decimal('collected_amount', 10, 2);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_demands');
    }
};
