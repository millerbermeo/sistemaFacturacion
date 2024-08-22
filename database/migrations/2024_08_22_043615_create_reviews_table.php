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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('id_resena');
            $table->unsignedBigInteger('id_producto'); // Clave foránea a products
            $table->unsignedBigInteger('id_usuario'); // Clave foránea a users
            $table->integer('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('id_producto')->references('id_producto')->on('products')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
