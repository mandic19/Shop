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
        Schema::create('variant_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('variant_id');
            $table->uuid('image_id');
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->foreign('variant_id')
                ->references('id')
                ->on('variants')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onDelete('cascade');

            $table->unique(['variant_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_images');
    }
};
