<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
			$table->string('imageName');
			$table->integer('imageType');
			$table->unsignedbiginteger('productID')->unsigned()->nullable();
			$table->unsignedbiginteger('category_id')->nullable();
            $table->timestamps();
			
			$table->foreign('productID')->references('id')->on('products');
			$table->foreign('category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
