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
        Schema::create('notification_providers', function (Blueprint $table) {
            $table->id();
            $table->string('channel'); // email, sms, telegram
            $table->string('name'); // مثلا smtp یا kavenegar یا telegram_bot1
            $table->json('config'); // api_key یا token یا اطلاعات smtp و ...
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('weight')->default(100); // برای درصد توزیع
            $table->json('forced_for_templates')->nullable(); // template keyهایی که باید حتما با این provider برن
            $table->timestamps();

            $table->unique(['channel', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_providers');
    }
};
