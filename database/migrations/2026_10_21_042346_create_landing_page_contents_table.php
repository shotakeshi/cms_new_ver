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
        Schema::create('landing_page_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landing_page_id');
            $table->string('language_code', 10);
            $table->tinyText('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->tinyText('description')->nullable();
            $table->longText('content')->nullable();
            $table->tinyText('meta_title')->nullable();
            $table->tinyText('meta_description')->nullable();
            $table->tinyText('meta_keywords')->nullable();
            $table->tinyText('meta_image')->nullable();
            $table->longText('more')->nullable();
            $table->unique(['landing_page_id', 'language_code']);
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_contents');
    }
};
