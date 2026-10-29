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
        Schema::create('product_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('slug');
            $table->string('language_code', 10);
            $table->string('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->longText('more')->nullable();
            $table->tinyText('meta_title')->nullable();
            $table->tinyText('meta_description')->nullable();
            $table->tinyText('meta_keywords')->nullable();
            $table->unique(['product_id', 'language_code']);
            $table->unique(['language_code', 'slug']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_contents');
    }
};
