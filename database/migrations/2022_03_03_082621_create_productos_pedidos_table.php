<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_pedidos', function (Blueprint $table) {
            $table->id();
            //$table->timestamps(); // created_at, updated_at

            $table->integer('cantidad')->default(1);
            // Referencia al pedido sobre el que se añaden los productos comprados
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')
                ->references('id')
                ->on('pedidos')
                ->onDelete('cascade');

            // Referencia al producto que pertenece al pedido
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_pedidos');
    }
};
