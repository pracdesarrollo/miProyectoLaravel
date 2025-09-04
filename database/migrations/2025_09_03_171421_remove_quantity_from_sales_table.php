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
        // El método 'up' elimina la columna 'quantity' de la tabla 'sales'
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // El método 'down' revierte el cambio, volviendo a crear la columna 'quantity'
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('quantity')->after('user_id');
        });
    }
};
