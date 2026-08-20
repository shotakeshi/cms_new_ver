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
        Schema::create('blog_post_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_post_id');
            $table->tinyText('name');
            $table->string('slug')->unique();
            $table->string('language_code', 10);
            $table->tinyText('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->tinyText('meta_title')->nullable();
            $table->tinyText('meta_description')->nullable();
            $table->tinyText('meta_keywords')->nullable();
            $table->tinyText('meta_image')->nullable();
            $table->string('image')->nullable();
            $table->unique(['blog_post_id', 'language_code']);
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_contents');
    }
};
