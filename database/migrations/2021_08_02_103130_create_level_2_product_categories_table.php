<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevel2ProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_2_product_categories', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('lv1PCategoryID');
			$table->string('category_name');
			$table->integer('status');
            $table->timestamps();
			
			$table->foreign('lv1PCategoryID')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_2_product_categories');
    }
}
