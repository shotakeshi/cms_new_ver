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
        Schema::create('service_page_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_page_id');
            $table->string('language_code', 10);
            $table->tinyText('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->tinyText('description')->nullable();
            $table->longText('content')->nullable();
            $table->tinyText('meta_title')->nullable();
            $table->tinyText('meta_description')->nullable();
            $table->tinyText('meta_keywords')->nullable();
            $table->tinyText('meta_image')->nullable();
            $table->longText('more')->nullable();
            $table->unique(['service_page_id', 'language_code']);
            $table->unique(['language_code', 'slug']);
            $table->foreign('service_page_id')->references('id')->on('service_pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_page_contents');
    }
};
