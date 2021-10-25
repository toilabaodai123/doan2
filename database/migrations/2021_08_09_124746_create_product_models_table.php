<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_models', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('productID');
			$table->unsignedbiginteger('sizeID');
			$table->integer('stock')->default(0);
			$table->integer('stockTemp')->default(0);
			$table->integer('productModelStatus')->default(0);
            $table->timestamps();
			
			$table->foreign('productID')->references('id')->on('products');
			$table->foreign('sizeID')->references('id')->on('product_sizes');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_models');
    }
}
