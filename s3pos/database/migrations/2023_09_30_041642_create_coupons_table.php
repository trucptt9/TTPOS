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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->string('code')->unique();
            $table->string('name');
            $table->date('start');
            $table->date('end')->nullable();
            $table->integer('value')->nullable()->default(0);
            $table->enum('type_value', ['vnd', 'percent'])->nullable()->default('percent');
            $table->integer('quantity')->nullable()->default(0);
            $table->integer('usage')->nullable()->default(0);
            $table->enum('status', ['active', 'blocked'])->index()->nullable()->default('blocked');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};