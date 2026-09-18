<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DefaultStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            /**
             * Widget type:
             * hero
             * banner
             * text
             * image
             * button
             * blog_posts
             * gallery
             * contact
             * html
             */
            $table->string('type');
            $table->json('settings')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('status_lock')->default(false);
            $table->timestamps();
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
