<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_sale_details', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('sale_id');
			$table->unsignedbiginteger('product_model_id');
			$table->integer('amount');
			$table->integer('old_price');
			$table->integer('new_price');
			$table->integer('status');
            $table->timestamps();
			
			$table->foreign('sale_id')->references('id')->on('flash_sales');
			$table->foreign('product_model_id')->references('id')->on('product_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flash_sale_details');
    }
}
