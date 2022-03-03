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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); //created_at, updated_at

            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
            $table->string('foto');//->default('placeholder_' . rand(1, 6) . '.png');
            $table->timestamp('fecha_publicacion')->useCurrent();

            // Referencia al administrador que lo ha creado
            $table->unsignedBigInteger('creado_por');
            $table->foreign('creado_por')
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
        Schema::dropIfExists('productos');
    }
};
