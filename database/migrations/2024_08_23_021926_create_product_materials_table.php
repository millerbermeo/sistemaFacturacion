<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_material');
            $table->decimal('cantidad', 10, 2);
            $table->timestamps();

            $table->foreign('id_producto')->references('id_producto')->on('products')->onDelete('cascade');
            $table->foreign('id_material')->references('id_material')->on('materials')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_materials');
    }
};
