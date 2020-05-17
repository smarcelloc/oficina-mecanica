<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category')->nullable();
            $table->string('name');
            $table->decimal('price')->nullable();
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('photo')->nullable();
            /*** FOREIGN KEY ***/
            $table->integer('providers_id')->unsigned()->nullable();
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('set null');
            
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
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign('products_providers_id_foreign');
        });
        Schema::dropIfExists('products');
    }
}
