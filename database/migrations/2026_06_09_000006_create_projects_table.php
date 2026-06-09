<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('summary');
            $table->longText('description');
            $table->string('challenge_title')->nullable();
            $table->longText('challenge_content')->nullable();
            $table->longText('quote_text')->nullable();
            $table->string('quote_author')->nullable();
            $table->string('final_title')->nullable();
            $table->longText('final_content')->nullable();
            $table->string('image_path');
            $table->string('secondary_image_path')->nullable();
            $table->string('tertiary_image_path')->nullable();
            $table->string('overlay_image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
