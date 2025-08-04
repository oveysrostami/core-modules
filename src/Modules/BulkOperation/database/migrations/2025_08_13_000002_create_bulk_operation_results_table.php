<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulk_operation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulk_operation_id')->constrained('bulk_operations')->onDelete('cascade');
            $table->unsignedInteger('index');
            $table->json('row_data');
            $table->enum('status', ['success', 'error', 'skipped']);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulk_operation_results');
    }
};
