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
        Schema::create('blog_category_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_category_id');
            $table->tinyText('name');
            $table->string('slug')->unique();
            $table->string('language_code', 10);
            $table->tinyText('meta_title')->nullable();
            $table->tinyText('meta_description')->nullable();
            $table->tinyText('meta_keywords')->nullable();
            $table->string('image')->nullable();
            $table->unique(['blog_category_id', 'language_code']);
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category_contents');
    }
};
