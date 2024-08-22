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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id('id_user_rol'); // ID único para la tabla role_user
            $table->unsignedBigInteger('role_id'); // Clave foránea para roles
            $table->unsignedBigInteger('user_id'); // Clave foránea para users
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('role_id')->references('id_rol')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
