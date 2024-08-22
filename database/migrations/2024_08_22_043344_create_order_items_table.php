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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('id_item_pedido');
            $table->unsignedBigInteger('id_pedido'); // Clave foránea a orders
            $table->unsignedBigInteger('id_producto'); // Clave foránea a products
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->timestamps();

            $table->foreign('id_pedido')->references('id_pedido')->on('orders')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
