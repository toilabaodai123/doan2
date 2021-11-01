<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_bills', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('order_id');
			$table->unsignedbiginteger('admin_id');
			$table->unsignedbiginteger('shipunit_id');
			$table->integer('price');
			
			$table->foreign('admin_id')->references('id')->on('users');
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('shipunit_id')->references('id')->on('shipping_units');
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
        Schema::dropIfExists('delivery_bills');
    }
}
