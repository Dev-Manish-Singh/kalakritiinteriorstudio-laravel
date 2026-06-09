<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->longText('highlights')->nullable();
            $table->longText('process_content')->nullable();
            $table->string('icon_path');
            $table->string('image_path')->nullable();
            $table->string('secondary_image_path')->nullable();
            $table->string('tertiary_image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
