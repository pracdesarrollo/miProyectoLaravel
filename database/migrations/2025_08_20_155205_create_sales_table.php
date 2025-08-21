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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // Utiliza 'foreignId' para llaves foráneas y 'constrained' para evitar errores
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            // Define el tipo de dato para 'quantity' y 'total_price'
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamp('sale_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};