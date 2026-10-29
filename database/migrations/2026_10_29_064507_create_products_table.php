<?php

use App\Enums\ProductStatus;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('status')->default(ProductStatus::DRAFT->value);
            $table->datetime('published_at')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->nullOnDelete();
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
        Schema::dropIfExists('products');
    }
};
