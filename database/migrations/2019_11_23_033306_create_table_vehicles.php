<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('brand');
            $table->string('plate');
            $table->char('year',4)->nullable();
            $table->double('km_current')->nullable();
            $table->string('color')->nullable();
            $table->string('type_fuel')->nullable();
            /*** FOREIGN KEY ***/
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
        Schema::table('vehicles', function(Blueprint $table){
            $table->dropForeign('vehicles_clients_id_foreign');
        });
        Schema::dropIfExists('vehicles');
    }
}
