<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment')->nullable();
            $table->string('situation')->default('Aberto');
            $table->text('observation')->nullable();
            $table->decimal('price_services')->nullable();
            $table->decimal('total_items')->nullable();
            $table->decimal('total');
            /*** FOREIGN KEY ***/
            $table->integer('services_id')->unsigned()->nullable();
            $table->foreign('services_id')->references('id')->on('services');
            $table->integer('clients_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('clients');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropForeign('orders_clients_id_foreign');
            $table->dropForeign('orders_services_id_foreign');
        });
        Schema::dropIfExists('orders');
    }
}
