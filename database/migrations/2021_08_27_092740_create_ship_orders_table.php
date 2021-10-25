<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_orders', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('order_id');
			$table->unsignedbiginteger('shipUnit_id');
			$table->integer('shipOrderTotal');
			$table->date('createdDate')->nullable();
            $table->timestamps();
			
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('shipUnit_id')->references('id')->on('shipping_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_orders');
    }
}
