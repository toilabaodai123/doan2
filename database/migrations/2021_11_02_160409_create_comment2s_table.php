<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComment2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment2s', function (Blueprint $table) {
            $table->id();
			$table->unsignedbiginteger('user_id');
			$table->unsignedbiginteger('product_id')->nullable();
			$table->unsignedbiginteger('order_id')->nullable();
			$table->string('text');
			$table->integer('rating');
			$table->integer('type');
			$table->integer('status');
            $table->timestamps();
			
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment2s');
    }
}
