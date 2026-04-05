<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gp_name_in_url');
            $table->enum('tax_type', ['ghar_patti', 'paani_patti', 'other']);
            $table->enum('document_type', ['view_pdf', 'payment_qr']);
            $table->string('file_path');
            $table->string('file_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_documents');
    }
};
