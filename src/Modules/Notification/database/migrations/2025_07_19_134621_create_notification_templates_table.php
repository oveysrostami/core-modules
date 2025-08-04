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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('channel'); // email, sms, telegram
            $table->string('key'); // مثلاً otp_login یا order_shipped
            $table->text('content'); // می‌تونه HTML یا متن ساده یا identifier خاص باشه
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['channel', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
