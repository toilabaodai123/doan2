<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
			$table->string('ip');
			$table->unsignedbiginteger('product_id')->nullable();
			$table->unsignedbiginteger('user_id')->nullable();
			$table->integer('view_type');
            $table->timestamps();
			
			$table->foreign('product_id')->references('id')->on('products');
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
