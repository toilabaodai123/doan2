<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
			$table->string('ip');
			$table->unsignedbiginteger('product_id')->nullable();
			$table->unsignedbiginteger('review_id')->nullable();
			$table->unsignedbiginteger('assigned_to')->nullable();
			$table->string('text');
			$table->integer('status');
            $table->timestamps();
			
			$table->foreign('product_id')->references('id')->on('products');
			$table->foreign('review_id')->references('id')->on('comment2s');
			$table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
