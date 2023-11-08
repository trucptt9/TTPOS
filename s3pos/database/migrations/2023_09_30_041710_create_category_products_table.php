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
        Schema::create('category_products', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'blocked'])->index()->nullable()->default('blocked');
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_products');
    }
};