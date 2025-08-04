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
        Schema::create('wallet_cash_out_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->double('amount');
            $table->foreignId('destination_id')->constrained('bank_accounts')->cascadeOnDelete();
            $table->enum('status', ['FAILED','PENDING','SUCCESS','REJECTED'])->default('PENDING');
            $table->json('meta')->nullable();
            $table->string('reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_out_requests');
    }
};
