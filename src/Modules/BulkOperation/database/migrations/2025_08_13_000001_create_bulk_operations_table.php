<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulk_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files');
            $table->string('type');
            $table->enum('status', ['pending', 'processing', 'waiting_admin', 'approved', 'rejected', 'completed','failed'])->default('pending');
            $table->text('reason')->nullable();
            $table->json('result_summary')->nullable();
            $table->integer('total')->default(0);
            $table->integer('success')->default(0);
            $table->integer('failure')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulk_operations');
    }
};
