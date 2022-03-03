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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at, updated_at

            $table->string('estado')->default(\App\Models\Constants::ESTADO_RECIBIDO);
            $table->timestamp('fecha_pedido')->useCurrent();

            // Referencia al cliente que ha creado el pedido
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('pedidos');
    }
};
