<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id();
                $table->string('nome', 255);
                $table->string('cpf', 11);
                $table->string('logradouro', 255);
                $table->string('cidade', 255);
                $table->string('uf', 2);
                $table->string('cep', 10);
                $table->integer('numero');
                $table->string('complemento', 255)->nullable();
                $table->string('telefone', 13)->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
