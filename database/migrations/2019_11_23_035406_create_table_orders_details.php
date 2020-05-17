<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrdersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price');
            $table->integer('amount')->unsigned()->default(0);
            $table->decimal('subtotal');
            /*** FOREIGN KEY ***/
            $table->integer('products_id')->unsigned();
            $table->foreign('products_id')->references('id')->on('products');
            $table->integer('orders_id')->unsigned();
            $table->foreign('orders_id')->references('id')->on('orders');
            
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
        Schema::table('orders_details', function(Blueprint $table){
            $table->dropForeign('orders_details_products_id_foreign');
            $table->dropForeign('orders_details_orders_id_foreign');
        });
        Schema::dropIfExists('orders_details');
    }
}
