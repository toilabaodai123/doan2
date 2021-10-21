<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string('productName')->nullable();
			$table->string('productSlug');
			$table->unsignedbiginteger('CategoryID')->nullable();
			$table->unsignedbiginteger('CategoryID2')->nullable();
			$table->unsignedbiginteger('supplierID');
			$table->integer('productPrice')->nullable();
			$table->string('shortDesc')->nullable();
			$table->string('longDesc')->nullable();
			$table->integer('status')->default(2);
            $table->timestamps();
			
			$table->foreign('CategoryID')->references('id')->on('product_categories');
			$table->foreign('CategoryID2')->references('id')->on('level_2_product_categories');
			$table->foreign('supplierID')->references('id')->on('suppliers');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
