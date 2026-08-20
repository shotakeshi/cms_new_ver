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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // actor
            $table->unsignedBigInteger('admin_id')->nullable();

            // action info
            $table->string('action');          // created, updated, deleted, login
            $table->string('module');          // media, product, user
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            // data snapshot
            $table->json('properties')->nullable();

            // request info
            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();

            $table->index(['module', 'action']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
