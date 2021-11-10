<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_units', function (Blueprint $table) {
            $table->id();
			$table->string('shipUnit_name');
			$table->string('shipUnit_address');
			$table->string('shipUnit_email');
			$table->integer('shipUnit_phone');
			$table->integer('shipUnit_status')->default(1);
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
        Schema::dropIfExists('shipping_units');
    }
}
