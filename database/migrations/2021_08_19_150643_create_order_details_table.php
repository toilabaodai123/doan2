<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('order_id');
			$table->unsignedbiginteger('productModel_id');
			$table->integer('quantity');
            $table->timestamps();
			
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('productModel_id')->references('id')->on('product_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
