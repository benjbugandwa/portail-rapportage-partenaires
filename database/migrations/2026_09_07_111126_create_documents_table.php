<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date_publication');
            $table->string('doc_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->string('original_name');
            $table->string('doc_category')->nullable();
            $table->foreignUuid('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('doc_summary')->nullable();
            $table->integer('download_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('uploaded_by');
            $table->index('doc_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
