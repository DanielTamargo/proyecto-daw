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
        Schema::create('categorias_productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // created_at, updated_at

            // Referencia al producto al que se le vinculará la categoría
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');

            // Referencia a la categoría a la que pertenecerá el producto
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
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
        Schema::dropIfExists('categorias_productos');
    }
};
