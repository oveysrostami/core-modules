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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('driver')->unique();
            $table->string('label')->nullable();
            $table->foreignId('currency_id')->constrained('currencies');
            $table->json('config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('supports_installment')->default(false);
            $table->unsignedInteger('priority')->default(100);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
