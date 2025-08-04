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
        Schema::create('wallet_cash_in_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->double('amount');
            $table->foreignId('gateway_id')->nullable()->constrained('payment_gateways')->nullOnDelete();
            $table->foreignId('wallet_purchase_request_id')->nullable()->constrained('wallet_purchase_requests')->nullOnDelete();
            $table->enum('status', ['FAILED','PENDING','SUCCESS','REJECTED','PROCESSING','CANCELED'])->default('PENDING');
            $table->string('reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_withdrawable')->default(false);
            $table->string('card_number')->nullable();
            $table->string('psp_reference_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_in_requests');
    }
};
