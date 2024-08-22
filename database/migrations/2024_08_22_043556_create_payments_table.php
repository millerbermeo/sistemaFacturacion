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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_pedido'); // Clave foránea a orders
            $table->unsignedBigInteger('id_metodo_pago'); // Clave foránea a payment_methods
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha_pago');
            $table->timestamps();

            $table->foreign('id_pedido')->references('id_pedido')->on('orders')->onDelete('cascade');
            $table->foreign('id_metodo_pago')->references('id_metodo_pago')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
