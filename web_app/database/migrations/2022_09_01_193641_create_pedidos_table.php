<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_cliente');
                $table->foreign('id_cliente')->references('id')->on('clientes');
                $table->decimal('valor_total', 10, 2);
                $table->date('data_entrega_prevista');
                $table->date('data_entrega')->nullable();
                $table->tinyInteger('status')->comment('0 - Pendente | 1 - Entregue | 2 - Em atraso | 3 - Cancelado')->default(0);
                $table->timestamps();
            });
        }
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
}
