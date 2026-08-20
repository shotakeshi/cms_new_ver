<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DefaultStatus;
use App\Enums\BlogPostStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('status', array_column(BlogPostStatus::cases(), 'value'))->default(BlogPostStatus::DRAFT->value);
            $table->tinyInteger('comment_status')->default(DefaultStatus::INACTIVE->value);
            $table->datetime('published_at')->nullable();
            $table->string('post_password')->nullable();
            $table->integer('comment_count')->default(0);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->tinyText('more')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
