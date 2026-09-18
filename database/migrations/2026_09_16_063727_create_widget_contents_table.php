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
        Schema::create('widget_contents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('widget_id')
                ->constrained('widgets')
                ->cascadeOnDelete();

            $table->string('language_code', 10);

            /**
             * Widget content
             */
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();

            /**
             * Extra language-specific data
             */
            $table->json('data')->nullable();

            $table->timestamps();

            $table->unique([
                'widget_id',
                'language_code',
            ]);

            $table->index('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_contents');
    }
};
