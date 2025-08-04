<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->enum('type',[ 'video','image','audio','text','zip','excel','pdf','doc','docx','ppt','pptx','file'])->default('video');
            $table->string('mime_type');
            $table->string('name');
            $table->string('slug');
            $table->string('path');
            $table->string('extension');
            $table->string('size');
            $table->string('disk');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
